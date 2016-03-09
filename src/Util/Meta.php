<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Util;

use FFMpeg\FFMpeg;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Meta.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Meta
{
    /**
     * @var
     */
    protected $video;

    /**
     * Meta constructor.
     *
     * @param File   $file
     * @param FFMpeg $ffmpeg
     */
    public function __construct(File $file, FFMpeg $ffmpeg)
    {
        $this->video = $ffmpeg->open($file->getRealPath());
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->video->getStreams()->first()->get('width');
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->video->getStreams()->first()->get('height');
    }

    /**
     * @return string
     */
    public function getOrientation()
    {
        return ($this->getWidth() > $this->getHeight()) ? 'landscape' : 'portrait';
    }
}
