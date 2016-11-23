<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible\Adapters;

use BrianFaust\Vidible\Contracts\ShareableInterface;
use BrianFaust\Vidible\Models\Video;

class WebDav extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = [])
    {
    }
}
