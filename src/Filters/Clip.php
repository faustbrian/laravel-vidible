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
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Media\Video;

/**
 * Class Clip.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Clip implements FilterInterface
{
    /**
     * @var
     */
    private $start;

    /**
     * @var
     */
    private $duration;

    /**
     * Clip constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->start = TimeCode::fromSeconds($config['start']);
        $this->duration = TimeCode::fromSeconds($config['duration']);
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->clip($this->start, $this->duration);
    }
}
