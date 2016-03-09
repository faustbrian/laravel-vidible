<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Filters;

use DraperStudio\Vidible\Contracts\FilterInterface;
use FFMpeg\Coordinate\FrameRate as FFRate;
use FFMpeg\Media\Video;

/**
 * Class Framerate.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Framerate implements FilterInterface
{
    /**
     * @var FFRate
     */
    private $framerate;

    /**
     * @var
     */
    private $gop;

    /**
     * Framerate constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->framerate = new FFRate($config['framerate']);
        $this->gop = $config['gop'];
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->framerate($this->framerate, $this->gop);
    }
}
