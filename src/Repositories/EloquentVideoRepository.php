<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Vidible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Vidible\Repositories;

use Artisanry\Vidible\Contracts\VideoRepository;
use Artisanry\Vidible\Contracts\Vidible;
use Artisanry\Vidible\Models\Video;

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
