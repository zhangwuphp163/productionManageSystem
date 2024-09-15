<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Libraries\RouteServer;
use App\Models\Category;
use App\Models\Store;
use Dcat\Admin\Admin;
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
            $grid->column('store.name','店铺')->sortable()->width("80");//->filter();
            $grid->column('name')->copyable()->filter()->width("80");
            $grid->column('model')->filter()->width("100");
            $grid->column('barcode')->copyable()->filter()->width("80");
            $grid->column('title')->filter()->width("100");
            $grid->column('product_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('size_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('norms')->display(function ($norms){
                return str_replace("\r\n","<br/>",$norms);
            })->width("120");
            $grid->column('material')->width("80");
            $grid->column('technology')->width("80");
            $grid->column('color')->width("80");
            $grid->column('remarks')->width("80");
            /*$grid->column('attachment')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);*/
            $grid->column('inner_box','内箱')->display(function(){
                return "长*宽*高:".implode("*",[$this->inner_box_length,$this->inner_box_width,$this->inner_box_height])."<br/>装箱数(支):{$this->inner_box_packing_qty}<br/>毛重(kg):{$this->inner_box_gross_weight}";
            })->width("120");
            $grid->column('outer_box','外箱')->display(function(){
                return "长*宽*高:".implode("*",[$this->outer_box_length,$this->outer_box_width,$this->outer_box_height])."<br/>装箱数(支):{$this->outer_box_packing_qty}<br/>毛重(kg):{$this->outer_box_gross_weight}";
            })->width("120");
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
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if(!empty($this->attachment)){
                $attachment = json_decode($this->attachment,true);
                if(!empty($attachment)){
                    $url = asset("/storage/uploads/{$attachment[0]}");
                    $actions->append("<a href='".$url."' target='_blank'><i class='fa fa-book'></i> 说明书</a>");
                }
            }


            /*if (Admin::user()->can('order-edit')){
                $actions->quickEdit();
            }*/
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
                $form->textarea('norms');
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
                $form->multipleFile('attachment')->accept('pdf')->autoUpload()->uniqueName()->saving(function ($paths){
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
