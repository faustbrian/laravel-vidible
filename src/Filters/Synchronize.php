<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
