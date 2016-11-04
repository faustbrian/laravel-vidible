<?php

namespace BrianFaust\Vidible\Traits;

trait VidibleTrait
{
    public function videos()
    {
        return $this->morphMany('BrianFaust\Vidible\Models\Video', 'vidible');
    }
}
