<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Admin\Repositories\StoreSku;
use App\Labels\OrderLabel;
use App\Labels\ProductLabel;
use App\Libraries\RouteServer;
use App\Models\Category;
use App\Models\Store;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Ramsey\Uuid\Uuid;

class ProductController extends AdminController
{
    use RouteServer;
    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->body($this->grid())
            ->view("admin.product.index");
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid =  Grid::make(new Product(['category']), function (Grid $grid) {
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('category_id', '品类', \App\Models\Category::query()->pluck('name','id')->toArray());
            });
            $grid->column('category.name','品类');
            $grid->column('name')->editable()->width("80");
            $grid->column('band-stores','已绑的店铺')->display(function (){
                $storeIds = \App\Models\StoreSku::query()->where('product_id',$this->id)->pluck('store_id')->toArray();
                return Store::query()->whereIn('id',$storeIds)->get()->implode("name","<br/>");
            });
            $grid->column('model')->editable()->width("100");
            $grid->column('product_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('size_images')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);;
            $grid->column('norms')->textarea()->width("150");
               /* ->display(function ($norms){
                return str_replace("\r\n","<br/>",$norms);
            })*/
            $grid->column('material')->editable()->width("80");
            $grid->column('technology')->editable()->width("80");
            $grid->column('color')->editable()->width("80");
            $grid->column('price')->editable()->width("80");
            $grid->column('remarks')->editable()->width("80");
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

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand(false);
                $filter->panel();
                $filter->equal('name')->width(3);
                $filter->equal('model')->width(3);
            });
            $grid->showColumnSelector();
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
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-copy" data-title="批量复制产品">&nbsp;&nbsp;&nbsp;<i class="fa fa-print"></i> 批量复制产品&nbsp;&nbsp;&nbsp;</a>');
            $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-add-store" data-title="批量添加到店铺">&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i> 批量添加到店铺&nbsp;&nbsp;&nbsp;</a>');
        });
        $grid->scrollbarX();
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
        return Show::make($id, new Product(['category']), function (Show $show) {
            /*$show->row(function (Show\Row $show) {
                $show->width(3)->id;
                $show->width(3)->name;
                $show->width(5)->email;
            });*/
            $show->field('category.name');
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

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Product(), function (Form $form) {
            $form->tab('基本信息',function (Form $form){
                $form->column(6,function (Form $form){
                    $form->select('category_id',"品类")->options(\App\Models\Category::query()->pluck('name','id'))->required();
                    $form->text('name')->required();
                    $form->text('model')->required();
                    $form->textarea('norms');
                });
                $form->column(6,function (Form $form){
                    $form->text('material');
                    $form->text('technology');
                    $form->text('color');
                    $form->decimal('price');
                    $form->text('remarks');
                });


            });
            $form->tab('图片',function (Form $form){
                $form->column(6,function (Form $form){
                    $form->multipleImage('product_images')->autoUpload()->uniqueName()->saving(function ($paths){
                        return json_encode($paths);
                    });
                    $form->multipleImage('size_images')->autoUpload()->uniqueName()->saving(function ($paths){
                        return json_encode($paths);
                    });
                });
                $form->column(6,function (Form $form){
                    $form->multipleImage('production_detail_images')->autoUpload()->uniqueName()->saving(function ($paths){
                        return json_encode($paths);
                    });
                    $form->multipleFile('attachment')->accept('pdf')->autoUpload()->uniqueName()->saving(function ($paths){
                        return json_encode($paths);
                    });
                });


            });
            $form->tab('重量尺寸',function (Form $form){
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


        });
    }

    public function batchCopy(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $products = \App\Models\Product::query()->whereIn('id',$ids)->get();
            foreach ($products as $product){
                $newProduct = $product->replicate([
                    'product_images',
                    'size_images',
                    'attachment',
                    'production_detail_images'
                ]);
                $newProduct->save();
            }
            return [
                'status' => 0,
                'msg' => 'success'
            ];
        }catch (\Exception $exception){
            return [
                'status' => 1,
                'msg' => $exception->getMessage()
            ];
        }
    }
}
