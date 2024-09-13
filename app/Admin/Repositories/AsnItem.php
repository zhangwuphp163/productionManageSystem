<?php

namespace App\Admin\Repositories;

use App\Models\AsnItem as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AsnItem extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
