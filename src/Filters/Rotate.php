<?php



declare(strict_types=1);

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Media\Video;

class Rotate implements FilterInterface
{
    private $angle;

    public function __construct($config)
    {
        $this->angle = $config['angle'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->rotate($this->angle);
    }
}
