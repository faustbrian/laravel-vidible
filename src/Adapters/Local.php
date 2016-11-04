<?php

namespace BrianFaust\Vidible\Adapters;

use BrianFaust\Vidible\Contracts\ShareableInterface;
use BrianFaust\Vidible\Models\Video;

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
