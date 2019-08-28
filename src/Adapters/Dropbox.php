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

use Artisanry\Flysystem\Dropbox\DropboxAdapter;
use Artisanry\Flysystem\Filesystem;
use Artisanry\Vidible\Contracts\ShareableInterface;
use Artisanry\Vidible\Models\Video;
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
