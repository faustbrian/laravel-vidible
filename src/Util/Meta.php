<?php

namespace DraperStudio\Vidible\Util;

use FFMpeg\FFMpeg;
use Symfony\Component\HttpFoundation\File\File;

class Meta
{
    protected $video;

    public function __construct(File $file, FFMpeg $ffmpeg)
    {
        $this->video = $ffmpeg->open($file->getRealPath());
    }

    public function getWidth()
    {
        return $this->video->getStreams()->first()->get('width');
    }

    public function getHeight()
    {
        return $this->video->getStreams()->first()->get('height');
    }

    public function getOrientation()
    {
        return ($this->getWidth() > $this->getHeight()) ? 'landscape' : 'portrait';
    }
}
