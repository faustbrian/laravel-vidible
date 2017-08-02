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

namespace BrianFaust\Vidible\Filters;

use FFMpeg\Media\Video;
use FFMpeg\Coordinate\TimeCode;
use BrianFaust\Vidible\Contracts\FilterInterface;

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
