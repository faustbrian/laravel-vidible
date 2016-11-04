<?php

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Media\Video;

class Resize implements FilterInterface
{
    private $dimension;

    private $mode;

    private $useStandards;

    public function __construct($config)
    {
        $this->dimension = new Dimension($config['width'], $config['height']);
        $this->mode = $config['mode'];
        $this->useStandards = $config['useStandards'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->resize(
            $this->dimension,
            $this->mode,
            $this->useStandards
        );
    }
}
