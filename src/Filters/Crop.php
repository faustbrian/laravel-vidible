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
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\Point;
use FFMpeg\Media\Video;

/**
 * Class Crop.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Crop implements FilterInterface
{
    /**
     * @var Point
     */
    private $point;

    /**
     * @var Dimension
     */
    private $dimension;

    /**
     * Crop constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->point = new Point($config['x'], $config['y']);
        $this->dimension = new Dimension($config['width'], $config['height']);
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->crop($this->point, $this->dimension);
    }
}
