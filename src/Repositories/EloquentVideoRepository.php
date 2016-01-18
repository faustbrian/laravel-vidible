<?php

namespace DraperStudio\Vidible\Repositories;

use DraperStudio\Vidible\Contracts\VideoRepository;
use DraperStudio\Vidible\Contracts\Vidible;
use DraperStudio\Vidible\Models\Video;

class EloquentVideoRepository implements VideoRepository
{
    protected $model;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

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
