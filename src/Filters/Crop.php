<?php

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\Point;
use FFMpeg\Media\Video;

class Crop implements FilterInterface
{
    private $point;

    private $dimension;

    public function __construct($config)
    {
        $this->point = new Point($config['x'], $config['y']);
        $this->dimension = new Dimension($config['width'], $config['height']);
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->crop($this->point, $this->dimension);
    }
}
