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
 * Class Resample.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Resample implements FilterInterface
{
    /**
     * @var
     */
    private $rate;

    /**
     * Resample constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->rate = $config['rate'];
    }

    /**
     * @param Video $video
     *
     * @return mixed
     */
    public function applyFilter(Video $video)
    {
        return $video->filters()->resample($this->rate);
    }
}
