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
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Media\Video;

class Resize implements FilterInterface
{
    private $dimension;

    private $mode;

    private $useStandards;

    public function __construct($config)
    {
        $this->dimension = new Dimension($config['width'], $config['height']);
        $this->mode = $config['mode'];
        $this->useStandards = $config['useStandards'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->resize(
            $this->dimension,
            $this->mode,
            $this->useStandards
        );
    }
}
