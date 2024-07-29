<?php

namespace App\Repositories;

use App\Models\Action;

class ActionRepository extends BaseRepository
{
    public function __construct(Action $entity)
    {
        $this->entity = $entity;
    }
}
