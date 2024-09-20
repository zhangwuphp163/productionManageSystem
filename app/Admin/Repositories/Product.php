<?php

namespace App\Admin\Repositories;

use App\Models\Product as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Show;

class Product extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function detail($id)
    {
        return Show::make($id, new Model(['category']), function (Show $show) {
            /*$show->row(function (Show\Row $show) {
                $show->width(3)->id;
                $show->width(3)->name;
                $show->width(5)->email;
            });*/
            $show->field('category.name','品类');
            $show->field('name');
            $show->field('model');
            $show->field('norms');
            $show->field('material');
            $show->field('technology');
            $show->field('color');
            $show->field('price');
            $show->field('remarks');
            $show->field('inner_box_length');
            $show->field('inner_box_width');
            $show->field('inner_box_height');
            $show->field('inner_box_gross_weight');
            $show->field('inner_box_packing_qty');
            $show->field('outer_box_length');
            $show->field('outer_box_width');
            $show->field('outer_box_height');
            $show->field('outer_box_gross_weight');
            $show->field('outer_box_packing_qty');
            $show->field("product_images")->image();
            $show->field("size_images")->image();
            $show->field("production_detail_images")->image();
            $show->field("attachment")->image();

        });
    }
}
