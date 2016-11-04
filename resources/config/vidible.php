<?php

return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver' => 'BrianFaust\Vidible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver' => 'BrianFaust\Vidible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver' => 'BrianFaust\Vidible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver' => 'BrianFaust\Vidible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver' => 'BrianFaust\Vidible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'ffmpeg' => '/usr/bin/ffmpeg',

    'ffprobe' => '/usr/bin/ffprobe',

    'filters' => [

        'clip' => [
            'driver' => 'BrianFaust\Vidible\Filters\Clip',
            'config' => [
                'start' => 30,
                'duration' => 15,
            ],
        ],

        'crop' => [
            'driver' => 'BrianFaust\Vidible\Filters\Crop',
            'config' => [
                'x' => 25,
                'y' => 35,
                'width' => 200,
                'height' => 150,
            ],
        ],

        'framerate' => [
            'driver' => 'BrianFaust\Vidible\Filters\Framerate',
            'config' => [
                'framerate' => 60,
                'gop' => 12,
            ],
        ],

        'resample' => [
            'driver' => 'BrianFaust\Vidible\Filters\Resample',
            'config' => [
                'rate' => 50,
            ],
        ],

        'resize' => [
            'driver' => 'BrianFaust\Vidible\Filters\Resize',
            'config' => [
                'width' => 320,
                'height' => 240,
                'mode' => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                'useStandards' => true,
            ],
        ],

        'rotate' => [
            'driver' => 'BrianFaust\Vidible\Filters\Rotate',
            'config' => [
                'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
            ],
        ],

        'synchronize' => [
            'driver' => 'BrianFaust\Vidible\Filters\Synchronize',
        ],

        'watermark' => [
            'driver' => 'BrianFaust\Vidible\Filters\Watermark',
            'config' => [
                'watermarkPath' => storage_path('files/watermark.png'),
                'coordinates' => [
                    'position' => 'relative',
                    'bottom' => 0,
                    'right' => 10,
                ],
            ],
        ],

        'random' => [
            [
                'driver' => 'BrianFaust\Vidible\Filters\Clip',
                'config' => [
                    'start' => 3,
                    'duration' => 2,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Crop',
                'config' => [
                    'x' => 25,
                    'y' => 35,
                    'width' => 200,
                    'height' => 150,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Framerate',
                'config' => [
                    'framerate' => 60,
                    'gop' => 12,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Resample',
                'config' => [
                    'rate' => 50,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Resize',
                'config' => [
                    'width' => 320,
                    'height' => 240,
                    'mode' => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                    'useStandards' => true,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Rotate',
                'config' => [
                    'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
                ],
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Synchronize',
            ], [
                'driver' => 'BrianFaust\Vidible\Filters\Watermark',
                'config' => [
                    'watermarkPath' => storage_path('files/watermark.png'),
                    'coordinates' => [
                        'position' => 'absolute',
                        'x' => 10,
                        'y' => 5,
                    ],
                ],
            ],
        ],
    ],

    'formats' => [
        'x264' => 'FFMpeg\Format\Video\X264',
        'wmv' => 'FFMpeg\Format\Video\WMV',
        'webm' => 'FFMpeg\Format\Video\WebM',
    ],
];
