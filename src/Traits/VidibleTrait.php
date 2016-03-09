<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Traits;

/**
 * Class VidibleTrait.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
trait VidibleTrait
{
    /**
     * @return mixed
     */
    public function videos()
    {
        return $this->morphMany('DraperStudio\Vidible\Models\Video', 'vidible');
    }
}
