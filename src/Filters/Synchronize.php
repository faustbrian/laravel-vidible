<?php

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Media\Video;

class Synchronize implements FilterInterface
{
    public function applyFilter(Video $video)
    {
        return $video->filters()->synchronize();
    }
}
