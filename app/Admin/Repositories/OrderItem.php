<?php

namespace App\Admin\Repositories;

use App\Models\OrderItem as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OrderItem extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
