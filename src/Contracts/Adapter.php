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
use FFMpeg\Media\Video as FFVideo;

/**
 * Interface Adapter.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface Adapter
{
    /**
     * @param FFVideo $file
     * @param Video   $video
     * @param array   $filters
     *
     * @return mixed
     */
    public function write(FFVideo $file, Video $video, array $filters = []);

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     */
    public function has(Video $video, array $filters = []);

    /**
     * @param Video $video
     * @param array $filters
     *
     * @return mixed
     */
    public function delete(Video $video, array $filters = []);
}
