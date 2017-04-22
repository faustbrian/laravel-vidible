<?php



declare(strict_types=1);

namespace BrianFaust\Vidible\Adapters;

use BrianFaust\Vidible\Contracts\ShareableInterface;
use BrianFaust\Vidible\Models\Video;

class Ftp extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Video $video, array $filters = [])
    {
    }
}
