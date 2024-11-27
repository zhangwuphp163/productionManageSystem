<?php

namespace App\Admin\Repositories;

use App\Models\NewOrder as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OrderNew extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
