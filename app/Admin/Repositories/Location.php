<?php

namespace App\Admin\Repositories;

use App\Models\Location as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Location extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
