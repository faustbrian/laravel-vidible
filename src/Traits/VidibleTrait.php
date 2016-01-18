<?php

namespace DraperStudio\Vidible\Traits;

trait VidibleTrait
{
    public function videos()
    {
        return $this->morphMany('DraperStudio\Vidible\Models\Video', 'vidible');
    }
}
