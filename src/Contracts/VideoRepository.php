<?php

namespace DraperStudio\Vidible\Contracts;

interface VideoRepository
{
    public function create($attributes);

    public function getById($id);

    public function getBySlot($slot, Vidible $vidible = null);
}
