<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Adapters;

use DraperStudio\Vidible\Contracts\ShareableInterface;
use DraperStudio\Vidible\Models\Video;

/**
 * Class Sftp.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Sftp extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Video $video
     * @param array $filters
     */
    public function getShareableLink(Video $video, array $filters = [])
    {
        //
    }
}
