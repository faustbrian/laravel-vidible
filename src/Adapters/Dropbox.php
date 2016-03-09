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
use Dropbox\Client;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

/**
 * Class Dropbox.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Dropbox extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     */
    public function getShareableLink(Video $video, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();
        $client = new Client($config['token'], $config['app']);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter);

        $path = $this->buildFileName($video, $filters);

        return $filesystem->getAdapter()
                            ->getClient()
                            ->createShareableLink($path);
    }
}
