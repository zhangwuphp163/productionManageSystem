<?php

namespace App\Admin\Repositories;

use App\Models\LocationShelf as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LocationShelf extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
