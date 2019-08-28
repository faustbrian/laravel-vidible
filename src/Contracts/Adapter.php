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

namespace Artisanry\Vidible\Contracts;

use Artisanry\Vidible\Models\Video;
use FFMpeg\Media\Video as FFVideo;

interface Adapter
{
    public function write(FFVideo $file, Video $video, array $filters = []);

    public function has(Video $video, array $filters = []);

    public function delete(Video $video, array $filters = []);
}
