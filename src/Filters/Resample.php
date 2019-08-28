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
use FFMpeg\Media\Video;

class Resample implements FilterInterface
{
    private $rate;

    public function __construct($config)
    {
        $this->rate = $config['rate'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->resample($this->rate);
    }
}
