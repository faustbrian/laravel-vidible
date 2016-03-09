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

/**
 * Interface VideoRepository.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface VideoRepository
{
    /**
     * @param $attributes
     *
     * @return mixed
     */
    public function create($attributes);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $slot
     * @param Vidible|null $vidible
     *
     * @return mixed
     */
    public function getBySlot($slot, Vidible $vidible = null);
}
