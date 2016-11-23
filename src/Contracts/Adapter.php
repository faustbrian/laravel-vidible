<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible\Contracts;

use BrianFaust\Vidible\Models\Video;
use FFMpeg\Media\Video as FFVideo;

interface Adapter
{
    public function write(FFVideo $file, Video $video, array $filters = []);

    public function has(Video $video, array $filters = []);

    public function delete(Video $video, array $filters = []);
}
