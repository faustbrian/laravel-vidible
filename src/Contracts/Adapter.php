<?php

namespace BrianFaust\Vidible\Contracts;

use BrianFaust\Vidible\Models\Video;
use FFMpeg\Media\Video as FFVideo;

interface Adapter
{
    public function write(FFVideo $file, Video $video, array $filters = []);

    public function has(Video $video, array $filters = []);

    public function delete(Video $video, array $filters = []);
}
