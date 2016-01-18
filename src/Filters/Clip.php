<?php

namespace DraperStudio\Vidible\Filters;

use DraperStudio\Vidible\Contracts\FilterInterface;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Media\Video;

class Clip implements FilterInterface
{
    private $start;

    private $duration;

    public function __construct($config)
    {
        $this->start = TimeCode::fromSeconds($config['start']);
        $this->duration = TimeCode::fromSeconds($config['duration']);
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->clip($this->start, $this->duration);
    }
}
