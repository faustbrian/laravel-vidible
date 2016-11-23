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

class Resample implements FilterInterface
{
    private $rate;

    public function __construct($config)
    {
        $this->rate = $config['rate'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->resample($this->rate);
    }
}
