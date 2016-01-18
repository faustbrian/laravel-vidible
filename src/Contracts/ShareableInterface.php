<?php

namespace DraperStudio\Vidible\Contracts;

use DraperStudio\Vidible\Models\Video;

interface ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = []);
}
