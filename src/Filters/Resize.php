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
use FFMpeg\Media\Video;

/**
 * Class Resize.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Resize implements FilterInterface
{
    /**
     * @var Dimension
     */
    private $dimension;

    /**
     * @var
     */
    private $mode;

    /**
     * @var
     */
    private $useStandards;

    /**
     * Resize constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->dimension = new Dimension($config['width'], $config['height']);
        $this->mode = $config['mode'];
        $this->useStandards = $config['useStandards'];
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->resize(
            $this->dimension,
            $this->mode,
            $this->useStandards
        );
    }
}
