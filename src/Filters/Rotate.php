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
use BrianFaust\Vidible\Contracts\FilterInterface;

class Rotate implements FilterInterface
{
    private $angle;

    public function __construct($config)
    {
        $this->angle = $config['angle'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->rotate($this->angle);
    }
}
