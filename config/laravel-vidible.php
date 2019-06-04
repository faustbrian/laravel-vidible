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

return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver'     => 'Artisanry\Vidible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver'     => 'Artisanry\Vidible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver'     => 'Artisanry\Vidible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver'     => 'Artisanry\Vidible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver'     => 'Artisanry\Vidible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'ffmpeg' => '/usr/bin/ffmpeg',

    'ffprobe' => '/usr/bin/ffprobe',

    'filters' => [

        'clip' => [
            'driver' => 'Artisanry\Vidible\Filters\Clip',
            'config' => [
                'start'    => 30,
                'duration' => 15,
            ],
        ],

        'crop' => [
            'driver' => 'Artisanry\Vidible\Filters\Crop',
            'config' => [
                'x'      => 25,
                'y'      => 35,
                'width'  => 200,
                'height' => 150,
            ],
        ],

        'framerate' => [
            'driver' => 'Artisanry\Vidible\Filters\Framerate',
            'config' => [
                'framerate' => 60,
                'gop'       => 12,
            ],
        ],

        'resample' => [
            'driver' => 'Artisanry\Vidible\Filters\Resample',
            'config' => [
                'rate' => 50,
            ],
        ],

        'resize' => [
            'driver' => 'Artisanry\Vidible\Filters\Resize',
            'config' => [
                'width'        => 320,
                'height'       => 240,
                'mode'         => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                'useStandards' => true,
            ],
        ],

        'rotate' => [
            'driver' => 'Artisanry\Vidible\Filters\Rotate',
            'config' => [
                'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
            ],
        ],

        'synchronize' => [
            'driver' => 'Artisanry\Vidible\Filters\Synchronize',
        ],

        'watermark' => [
            'driver' => 'Artisanry\Vidible\Filters\Watermark',
            'config' => [
                'watermarkPath' => storage_path('files/watermark.png'),
                'coordinates'   => [
                    'position' => 'relative',
                    'bottom'   => 0,
                    'right'    => 10,
                ],
            ],
        ],

        'random' => [
            [
                'driver' => 'Artisanry\Vidible\Filters\Clip',
                'config' => [
                    'start'    => 3,
                    'duration' => 2,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Crop',
                'config' => [
                    'x'      => 25,
                    'y'      => 35,
                    'width'  => 200,
                    'height' => 150,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Framerate',
                'config' => [
                    'framerate' => 60,
                    'gop'       => 12,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Resample',
                'config' => [
                    'rate' => 50,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Resize',
                'config' => [
                    'width'        => 320,
                    'height'       => 240,
                    'mode'         => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                    'useStandards' => true,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Rotate',
                'config' => [
                    'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
                ],
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Synchronize',
            ], [
                'driver' => 'Artisanry\Vidible\Filters\Watermark',
                'config' => [
                    'watermarkPath' => storage_path('files/watermark.png'),
                    'coordinates'   => [
                        'position' => 'absolute',
                        'x'        => 10,
                        'y'        => 5,
                    ],
                ],
            ],
        ],
    ],

    'formats' => [
        'x264' => 'FFMpeg\Format\Video\X264',
        'wmv'  => 'FFMpeg\Format\Video\WMV',
        'webm' => 'FFMpeg\Format\Video\WebM',
    ],
];
