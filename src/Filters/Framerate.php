<?php

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Coordinate\FrameRate as FFRate;
use FFMpeg\Media\Video;

class Framerate implements FilterInterface
{
    private $framerate;

    private $gop;

    public function __construct($config)
    {
        $this->framerate = new FFRate($config['framerate']);
        $this->gop = $config['gop'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->framerate($this->framerate, $this->gop);
    }
}
