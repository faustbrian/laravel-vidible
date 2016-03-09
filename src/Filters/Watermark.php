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
use FFMpeg\Media\Video;

/**
 * Class Watermark.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Watermark implements FilterInterface
{
    /**
     * @var
     */
    private $watermarkPath;

    /**
     * @var
     */
    private $coordinates;

    /**
     * Watermark constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->watermarkPath = $config['watermarkPath'];
        $this->coordinates = $config['coordinates'];
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->watermark(
            $this->watermarkPath,
            $this->coordinates
        );
    }
}
