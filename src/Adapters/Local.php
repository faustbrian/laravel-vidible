<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Adapters;

use DraperStudio\Vidible\Contracts\ShareableInterface;
use DraperStudio\Vidible\Models\Video;

/**
 * Class Local.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Local extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed|string
     */
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
