<?php

namespace App\Admin\Repositories;

use App\Models\Asn as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Asn extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
