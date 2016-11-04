<?php

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Media\Video;

class Watermark implements FilterInterface
{
    private $watermarkPath;

    private $coordinates;

    public function __construct($config)
    {
        $this->watermarkPath = $config['watermarkPath'];
        $this->coordinates = $config['coordinates'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->watermark(
            $this->watermarkPath,
            $this->coordinates
        );
    }
}
