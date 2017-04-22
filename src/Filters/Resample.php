<?php



declare(strict_types=1);

namespace BrianFaust\Vidible\Filters;

use BrianFaust\Vidible\Contracts\FilterInterface;
use FFMpeg\Media\Video;

class Resample implements FilterInterface
{
    private $rate;

    public function __construct($config)
    {
        $this->rate = $config['rate'];
    }

    public function applyFilter(Video $video)
    {
        return $video->filters()->resample($this->rate);
    }
}
