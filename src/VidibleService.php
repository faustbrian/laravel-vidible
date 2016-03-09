<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible;

use DraperStudio\Vidible\Contracts\Adapter;
use DraperStudio\Vidible\Contracts\FilterInterface;
use DraperStudio\Vidible\Contracts\VideoRepository;
use DraperStudio\Vidible\Contracts\Vidible;
use DraperStudio\Vidible\Models\Video;
use DraperStudio\Vidible\Util\Meta;
use FFMpeg\FFMpeg;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class VidibleService.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class VidibleService
{
    /**
     * @var
     */
    private $ffmpeg;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var VideoRepository
     */
    protected $videos;

    /**
     * @var
     */
    private $file;

    /**
     * @var
     */
    private $model;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var bool
     */
    private $overwrite = false;

    /**
     * VidibleService constructor.
     *
     * @param VideoRepository $videos
     * @param Application     $app
     * @param Adapter         $adapter
     */
    public function __construct(VideoRepository $videos, Application $app, Adapter $adapter)
    {
        $this->videos = $videos;
        $this->app = $app;
        $this->adapter = $adapter;

        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => config('vidible.ffmpeg'),
            'ffprobe.binaries' => config('vidible.ffprobe'),
        ]);
    }

    /**
     * @param bool $overwrite
     *
     * @return mixed
     */
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

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->videos->getById($id);
    }

    /**
     * @param $slot
     *
     * @return mixed
     */
    public function getBySlot($slot)
    {
        return $this->videos->getBySlot($slot, $this->getModel());
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function getShareableLink(Video $video)
    {
        $filters = $this->getFilters();

        if (!$this->getAdapter()->has($video, $filters)) {
            throw new InvalidArgumentException('File not found.');
        }

        return $this->getAdapter()->getShareableLink($video, $filters);
    }

    /**
     * @param Video $video
     *
     * @throws \Exception
     */
    public function delete(Video $video)
    {
        $this->getAdapter()->delete($video, $this->getFilters());
        $video->delete();
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id), $this->getFilters());
    }

    /**
     * @param $slot
     */
    public function deleteBySlot($slot)
    {
        return $this->delete($this->getBySlot($slot, $this->getModel()), $this->getFilters());
    }

    /**
     * @param File $file
     *
     * @return $this
     */
    public function withFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @param Vidible $model
     *
     * @return $this
     */
    public function withModel(Vidible $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function withAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $filters
     *
     * @return $this
     */
    public function withFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param File  $video
     * @param array $attributes
     *
     * @return mixed
     */
    protected function createVideoRecord(File $video, array $attributes)
    {
        $meta = new Meta($video, $this->ffmpeg);

        $attributes = array_merge($attributes, [
            'width' => $meta->getWidth(),
            'height' => $meta->getHeight(),
            'orientation' => $meta->getOrientation(),
            'mime_type' => $video->getMimeType(),
            'extension' => $video->guessExtension(),
        ]);

        return $this->videos->create($attributes);
    }

    /**
     * @param File  $file
     * @param Video $video
     * @param array $filters
     */
    protected function saveFile(File $file, Video $video, array $filters)
    {
        $videoFile = $this->runFilters($file, $video, $filters);
        $this->getAdapter()->write($videoFile, $video, $filters);
    }

    /**
     * @param File  $file
     * @param Video $video
     * @param array $filters
     *
     * @return Video
     */
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

    /**
     * @param $driver
     * @param $config
     * @param $video
     */
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

    /**
     * @return Adapter
     */
    protected function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return mixed
     */
    protected function getFile()
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @return array
     */
    protected function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        return $this->filters;
    }
}
