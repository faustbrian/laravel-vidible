<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Vidible;

use Artisanry\Vidible\Contracts\Adapter;
use Artisanry\Vidible\Contracts\FilterInterface;
use Artisanry\Vidible\Contracts\VideoRepository;
use Artisanry\Vidible\Contracts\Vidible;
use Artisanry\Vidible\Models\Video;
use Artisanry\Vidible\Util\Meta;
use FFMpeg\FFMpeg;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;

class VidibleService
{
    private $ffmpeg;

    protected $app;

    protected $adapter;

    protected $videos;

    private $file;

    private $model;

    private $attributes = [];

    private $filters = [];

    private $overwrite = false;

    public function __construct(VideoRepository $videos, Application $app, Adapter $adapter)
    {
        $this->videos = $videos;
        $this->app = $app;
        $this->adapter = $adapter;

        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => config('vidible.ffmpeg'),
            'ffprobe.binaries' => config('vidible.ffprobe'),
        ]);
    }

    public function commit($overwrite = false)
    {
        $file = $this->getFile();
        $model = $this->getModel();
        $attributes = $this->getAttributes();
        $filters = $this->getFilters();

        if (!empty($attributes['slot'])) {
            $record = $this->videos->getBySlot($attributes['slot'], $model);

            if (!empty($record)) {
                if ($overwrite) {
                    $this->deleteById($record->id, $filters);
                } else {
                    $id = $record->vidible_id;
                    $type = $record->vidible_type;

                    throw new InvalidArgumentException("Slot [{$attributes['slot']}] is already in use for model [$type] with the id #[$id]");
                }
            }
        }

        $video = $this->createVideoRecord($file, $attributes);

        // Believe it or not, vidibles are optional!
        if ($model) {
            $model->videos()->save($video);
        }

        $this->saveFile($file, $video, $filters);

        return $video;
    }

    public function getById($id)
    {
        return $this->videos->getById($id);
    }

    public function getBySlot($slot)
    {
        return $this->videos->getBySlot($slot, $this->getModel());
    }

    public function getShareableLink(Video $video)
    {
        $filters = $this->getFilters();

        if (!$this->getAdapter()->has($video, $filters)) {
            throw new InvalidArgumentException('File not found.');
        }

        return $this->getAdapter()->getShareableLink($video, $filters);
    }

    public function delete(Video $video)
    {
        $this->getAdapter()->delete($video, $this->getFilters());
        $video->delete();
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id), $this->getFilters());
    }

    public function deleteBySlot($slot)
    {
        return $this->delete($this->getBySlot($slot, $this->getModel()), $this->getFilters());
    }

    public function withFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    public function withModel(Vidible $model)
    {
        $this->model = $model;

        return $this;
    }

    public function withAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function withFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    protected function createVideoRecord(File $video, array $attributes)
    {
        $meta = new Meta($video, $this->ffmpeg);

        $attributes = array_merge($attributes, [
            'width'       => $meta->getWidth(),
            'height'      => $meta->getHeight(),
            'orientation' => $meta->getOrientation(),
            'mime_type'   => $video->getMimeType(),
            'extension'   => $video->guessExtension(),
        ]);

        return $this->videos->create($attributes);
    }

    protected function saveFile(File $file, Video $video, array $filters)
    {
        $videoFile = $this->runFilters($file, $video, $filters);
        $this->getAdapter()->write($videoFile, $video, $filters);
    }

    protected function runFilters(File $file, Video $video, array $filters)
    {
        $availableFilters = config('vidible.filters');

        $video = $this->ffmpeg->open($file->getRealPath());

        foreach ($filters as $key => $filter) {
            if (!array_key_exists($filter, $availableFilters)) {
                throw new InvalidArgumentException("Unsupported filter [$filter]");
            }

            $filter = $availableFilters[$filter];

            if (!isset($filter[0])) {
                $this->applyFilter($filter['driver'], $filter['config'], $video);
            } else {
                foreach ($filter as $key => $value) {
                    $config = empty($value['config']) ?: $value['config'];

                    $this->applyFilter($value['driver'], $config, $video);
                }
            }
        }

        return $video;
    }

    protected function applyFilter($driver, $config, $video)
    {
        $abstract = new $driver($config);

        if (!$abstract) {
            throw new InvalidArgumentException("Filter [$abstract] not resolvable.");
        }

        if (!$abstract instanceof FilterInterface) {
            $abstract = get_class($abstract);

            throw new InvalidArgumentException("Class [$abstract] does not implement FilterInterface.");
        }

        $abstract->applyFilter($video);
    }

    protected function getAdapter()
    {
        return $this->adapter;
    }

    protected function getFile()
    {
        return $this->file;
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function getAttributes()
    {
        return $this->attributes;
    }

    protected function getFilters()
    {
        return $this->filters;
    }
}
