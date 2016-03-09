<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Contracts;

use DraperStudio\Vidible\Models\Video;

/**
 * Interface ShareableInterface.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface ShareableInterface
{
    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     */
    public function getShareableLink(Video $video, array $filters = []);
}
