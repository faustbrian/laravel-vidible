<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Vidible\Adapters;

use BrianFaust\Flysystem\Dropbox\DropboxAdapter;
use BrianFaust\Flysystem\Filesystem;
use BrianFaust\Vidible\Contracts\ShareableInterface;
use BrianFaust\Vidible\Models\Video;
use Dropbox\Client;

class Dropbox extends AbstractAdapter implements ShareableInterface
{
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
