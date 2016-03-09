<?php


return [

    'default' => 'local',

    'adapters' => [

        'awss3' => [
            'driver' => 'DraperStudio\Vidible\Adapters\AwsS3',
            'connection' => 'awss3',
        ],

        'azure' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Azure',
            'connection' => 'azure',
        ],

        'copy' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Copy',
            'connection' => 'copy',
        ],

        'dropbox' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Dropbox',
            'connection' => 'dropbox',
        ],

        'ftp' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Ftp',
            'connection' => 'ftp',
        ],

        'gridfs' => [
            'driver' => 'DraperStudio\Vidible\Adapters\GridFs',
            'connection' => 'gridfs',
        ],

        'local' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Local',
            'connection' => 'local',
        ],

        'rackspace' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Rackspace',
            'connection' => 'rackspace',
        ],

        'sftp' => [
            'driver' => 'DraperStudio\Vidible\Adapters\Sftp',
            'connection' => 'sftp',
        ],

        'webdav' => [
            'driver' => 'DraperStudio\Vidible\Adapters\WebDav',
            'connection' => 'webdav',
        ],

        'zip' => [
            'driver' => 'DraperStudio\Vidible\Adapters\ZipArchive',
            'connection' => 'zip',
        ],

    ],

    'ffmpeg' => '/usr/bin/ffmpeg',

    'ffprobe' => '/usr/bin/ffprobe',

    'filters' => [

        'clip' => [
            'driver' => 'DraperStudio\Vidible\Filters\Clip',
            'config' => [
                'start' => 30,
                'duration' => 15,
            ],
        ],

        'crop' => [
            'driver' => 'DraperStudio\Vidible\Filters\Crop',
            'config' => [
                'x' => 25,
                'y' => 35,
                'width' => 200,
                'height' => 150,
            ],
        ],

        'framerate' => [
            'driver' => 'DraperStudio\Vidible\Filters\Framerate',
            'config' => [
                'framerate' => 60,
                'gop' => 12,
            ],
        ],

        'resample' => [
            'driver' => 'DraperStudio\Vidible\Filters\Resample',
            'config' => [
                'rate' => 50,
            ],
        ],

        'resize' => [
            'driver' => 'DraperStudio\Vidible\Filters\Resize',
            'config' => [
                'width' => 320,
                'height' => 240,
                'mode' => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                'useStandards' => true,
            ],
        ],

        'rotate' => [
            'driver' => 'DraperStudio\Vidible\Filters\Rotate',
            'config' => [
                'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
            ],
        ],

        'synchronize' => [
            'driver' => 'DraperStudio\Vidible\Filters\Synchronize',
        ],

        'watermark' => [
            'driver' => 'DraperStudio\Vidible\Filters\Watermark',
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
                'driver' => 'DraperStudio\Vidible\Filters\Clip',
                'config' => [
                    'start' => 3,
                    'duration' => 2,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Crop',
                'config' => [
                    'x' => 25,
                    'y' => 35,
                    'width' => 200,
                    'height' => 150,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Framerate',
                'config' => [
                    'framerate' => 60,
                    'gop' => 12,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Resample',
                'config' => [
                    'rate' => 50,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Resize',
                'config' => [
                    'width' => 320,
                    'height' => 240,
                    'mode' => FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_FIT,
                    'useStandards' => true,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Rotate',
                'config' => [
                    'angle' => FFMpeg\Filters\Video\RotateFilter::ROTATE_90,
                ],
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Synchronize',
            ], [
                'driver' => 'DraperStudio\Vidible\Filters\Watermark',
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
