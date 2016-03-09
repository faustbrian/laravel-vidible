<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Repositories;

use DraperStudio\Vidible\Contracts\VideoRepository;
use DraperStudio\Vidible\Contracts\Vidible;
use DraperStudio\Vidible\Models\Video;

/**
 * Class EloquentVideoRepository.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class EloquentVideoRepository implements VideoRepository
{
    /**
     * @var Video
     */
    protected $model;

    /**
     * EloquentVideoRepository constructor.
     *
     * @param Video $model
     */
    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    /**
     * @param $attributes
     *
     * @return static
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $slot
     * @param Vidible|null $vidible
     *
     * @return mixed
     */
    public function getBySlot($slot, Vidible $vidible = null)
    {
        if ($vidible) {
            $query = $this->model->forVidible(get_class($vidible), $vidible->getKey());
        } else {
            $query = $this->model->unattached();
        }

        return $query->inSlot($slot)->first();
    }
}
