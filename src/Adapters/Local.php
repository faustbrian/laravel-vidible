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

namespace Artisanry\Vidible\Adapters;

use Artisanry\Vidible\Contracts\ShareableInterface;
use Artisanry\Vidible\Models\Video;

class Local extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();

        $path = str_replace([
            public_path(), storage_path(),
        ], null, $config['path']);

        $path = config('app.url').$path.'/'.$this->buildFileName($video, $filters);

        return $path;
    }
}
