<?php

namespace App\Admin\Repositories;

use App\Models\Inventory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Inventory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
