<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Vidible\Filters;

use Artisanry\Vidible\Contracts\FilterInterface;
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
