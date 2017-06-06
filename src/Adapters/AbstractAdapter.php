<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible\Adapters;

use BrianFaust\Flysystem\Filesystem;
use BrianFaust\Vidible\Contracts\Adapter;
use BrianFaust\Vidible\Models\Video;
use FFMpeg\Media\Video as FFVideo;
use GrahamCampbell\Flysystem\FlysystemManager;

abstract class AbstractAdapter implements Adapter
{
    protected $flysystem;

    protected $connection;

    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
    }

    public function write(FFVideo $file, Video $video, array $filters = [])
    {
        $filename = $this->buildFileName($video, $filters);
        $targetPath = 'files/'.$filename;
        $tempFile = storage_path($targetPath.'.tmp');

        $formatDriver = $this->determineFormat($file);
        $file->save(new $formatDriver(), $tempFile);

        $result = $this->getConnection()->write(
            $filename,
            \File::get($tempFile)
        );

        unlink($tempFile);

        return $result;
    }

    public function has(Video $video, array $filters = [])
    {
        return $this->getConnection()->has(
            $this->buildFileName($video, $filters)
        );
    }

    public function delete(Video $video, array $filters = [])
    {
        if ($this->has($video, $filters)) {
            return $this->getConnection()->delete(
                $this->buildFileName($video, $filters)
            );
        }
    }

    public function loadFlysystemConfig()
    {
        $adapterKey = config('vidible.default');
        $adapterKey = config('vidible.adapters.'.$adapterKey.'.connection');

        return config('flysystem.connections.'.$adapterKey);
    }

    public function getConnection()
    {
        $connection = $this->connection;

        if (!$connection instanceof Filesystem) {
            $connection = get_class($connection);
            throw new InvalidArgumentException("Class [$connection] does not implement Filesystem.");
        }

        return $connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $this->flysystem->connection($this->connection);
    }

    protected function determineFormat($file)
    {
        $codec = $file->getFormat()->get('format_name');

        if (str_contains($codec, 'webm')) {
            return config('vidible.formats.webm');
        } elseif (str_contains($codec, 'x264')) {
            return config('vidible.formats.x264');
        } elseif (str_contains($codec, 'wmv')) {
            return config('vidible.formats.wmv');
        } else {
            throw new InvalidArgumentException('Unsupported format.');
        }
    }

    protected function buildFileName(Video $video, array $filters = [])
    {
        return sprintf('%s-%s.%s',
            $video->getKey(),
            $this->buildHash($video, $filters),
            $video->extension
        );
    }

    protected function buildHash(Video $video, array $filters = [])
    {
        $state = [
            'id' => (string) $video->getKey(),
            'filters' => $filters,
        ];

        $state = $this->recursiveKeySort($state);

        return md5(json_encode($state));
    }

    protected function recursiveKeySort(array $array)
    {
        ksort($array);

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->recursiveKeySort($value);
            }
        }

        return $array;
    }
}
