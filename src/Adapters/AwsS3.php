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

use Aws\S3\S3Client;
use BrianFaust\Flysystem\Filesystem;
use BrianFaust\Vidible\Models\Video;
use BrianFaust\Flysystem\AwsS3v2\AwsS3Adapter;
use BrianFaust\Vidible\Contracts\ShareableInterface;

class AwsS3 extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();
        $client = S3Client::factory([
            'key'    => $config['key'],
            'secret' => $config['secret'],
            'region' => isset($config['region']) ? $config['region'] : null,
        ]);

        $adapter = new AwsS3Adapter($client, $config['bucket']);
        $filesystem = new Filesystem($adapter);

        $key = $this->buildFileName($video, $filters);

        return $filesystem->getAdapter()
                            ->getClient()
                            ->getObjectUrl($config['bucket'], $key);
    }
}
