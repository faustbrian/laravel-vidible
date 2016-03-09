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

use Aws\S3\S3Client;
use DraperStudio\Vidible\Contracts\ShareableInterface;
use DraperStudio\Vidible\Models\Video;
use League\Flysystem\AwsS3v2\AwsS3Adapter;
use League\Flysystem\Filesystem;

/**
 * Class AwsS3.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class AwsS3 extends AbstractAdapter implements ShareableInterface
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
        $client = S3Client::factory([
            'key' => $config['key'],
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
