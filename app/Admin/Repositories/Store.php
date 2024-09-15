<?php

namespace App\Admin\Repositories;

use App\Models\Store as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Store extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
