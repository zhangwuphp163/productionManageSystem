<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Libraries\RouteServer;
use App\Models\Category;
use App\Models\Store;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Config;

class ProductController extends AdminController
{
    use RouteServer;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid =  Grid::make(new Product(['store']), function (Grid $grid) {
            //$grid->column('id')->sortable();
            //$grid->combine("inner",['inner_box_length','inner_box_width','inner_box_height','inner_box_packing_qty','inner_box_gross_weight']);
            //$grid->combine("outer",['outer_box_length','outer_box_width','outer_box_height','outer_box_packing_qty','outer_box_gross_weight']);
            $grid->column('store.name','店铺')->sortable()->filter();
            $grid->column('name')->sortable()->filter();
            $grid->column('model')->filter();
            $grid->column('barcode')->filter();
            $grid->column('title')->filter();
            $grid->column('product_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('size_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('norms');
            $grid->column('material');
            $grid->column('technology');
            $grid->column('color');
            $grid->column('remarks');
            $grid->column('attachment')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('production_detail_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);

            /*$grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });*/
            $grid->showColumnSelector();
        });
            $grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('store_id', '店铺', Store::query()->pluck('name','id')->toArray());
        });
            return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Product(), function (Show $show) {
            /*$show->row(function (Show\Row $show) {
                $show->width(3)->id;
                $show->width(3)->name;
                $show->width(5)->email;
            });*/
            $show->field('name');
            $show->field('store.name');
            $show->field('model');
            $show->field('barcode');
            $show->field('title');
            $show->field('norms');
            $show->field('material');
            $show->field('technology');
            $show->field('color');
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

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Product(), function (Form $form) {
            $form->column(6,function (Form $form){
                $form->select('store_id',"店铺")->options(Store::query()->pluck('name','id'))->required();
                $form->text('name')->required();
                $form->text('model')->required();
                $form->text('barcode');
                $form->text('title');
                $form->text('norms');
                $form->text('material');
                $form->text('technology');
                $form->text('color');
                $form->text('remarks');
            });
            $form->column(6,function (Form $form){
                $form->multipleImage('product_images')->autoUpload()->uniqueName()->saving(function ($paths){
                    return json_encode($paths);
                });
                $form->multipleImage('size_images')->autoUpload()->uniqueName()->saving(function ($paths){
                    return json_encode($paths);
                });
                $form->multipleImage('production_detail_images')->autoUpload()->uniqueName()->saving(function ($paths){
                    return json_encode($paths);
                });
                $form->multipleFile('attachment')->autoUpload()->uniqueName()->saving(function ($paths){
                    return json_encode($paths);
                });
            });
            $form->column(6,function (Form $form){
                $form->decimal('inner_box_length');
                $form->decimal('inner_box_width');
                $form->decimal('inner_box_height');
                $form->decimal('inner_box_gross_weight');
                $form->number('inner_box_packing_qty');
            });
            $form->column(6,function (Form $form){
                $form->decimal('outer_box_length');
                $form->decimal('outer_box_width');
                $form->decimal('outer_box_height');
                $form->decimal('outer_box_gross_weight');
                $form->number('outer_box_packing_qty');
            });
        });
    }
}
