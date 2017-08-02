<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible\Filters;

use FFMpeg\Media\Video;
use FFMpeg\Coordinate\FrameRate as FFRate;
use BrianFaust\Vidible\Contracts\FilterInterface;

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
