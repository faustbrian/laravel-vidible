<?php



declare(strict_types=1);

namespace BrianFaust\Vidible\Contracts;

use BrianFaust\Vidible\Models\Video;

interface ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = []);
}
