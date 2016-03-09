<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Adapters;

use DraperStudio\Vidible\Contracts\Adapter;
use DraperStudio\Vidible\Models\Video;
use FFMpeg\Media\Video as FFVideo;
use GrahamCampbell\Flysystem\FlysystemManager;
use League\Flysystem\Filesystem;

/**
 * Class AbstractAdapter.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
abstract class AbstractAdapter implements Adapter
{
    /**
     * @var FlysystemManager
     */
    protected $flysystem;

    /**
     * @var
     */
    protected $connection;

    /**
     * AbstractAdapter constructor.
     *
     * @param FlysystemManager $flysystem
     */
    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
    }

    /**
     * @param FFVideo $file
     * @param Video   $video
     * @param array   $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
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

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function has(Video $video, array $filters = [])
    {
        return $this->getConnection()->has(
            $this->buildFileName($video, $filters)
        );
    }

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function delete(Video $video, array $filters = [])
    {
        if ($this->has($video, $filters)) {
            return $this->getConnection()->delete(
                $this->buildFileName($video, $filters)
            );
        }
    }

    /**
     * @return mixed
     */
    public function loadFlysystemConfig()
    {
        $adapterKey = config('vidible.default');
        $adapterKey = config('vidible.adapters.'.$adapterKey.'.connection');

        return config('flysystem.connections.'.$adapterKey);
    }

    /**
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getConnection()
    {
        $connection = $this->connection;

        if (!$connection instanceof Filesystem) {
            $connection = get_class($connection);
            throw new InvalidArgumentException("Class [$connection] does not implement Filesystem.");
        }

        return $connection;
    }

    /**
     * @param $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $this->flysystem->connection($this->connection);
    }

    /**
     * @param $file
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
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

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return string
     */
    protected function buildFileName(Video $video, array $filters = [])
    {
        return sprintf('%s-%s.%s',
            $video->getKey(),
            $this->buildHash($video, $filters),
            $video->extension
        );
    }

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return string
     */
    protected function buildHash(Video $video, array $filters = [])
    {
        $state = [
            'id' => (string) $video->getKey(),
            'filters' => $filters,
        ];

        $state = $this->recursiveKeySort($state);

        return md5(json_encode($state));
    }

    /**
     * @param array $array
     *
     * @return array
     */
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
