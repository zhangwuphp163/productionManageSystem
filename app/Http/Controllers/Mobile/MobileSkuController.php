<?php

namespace App\Http\Controllers\Mobile;

use App\Admin\Repositories\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobileSkuController
{
    function index(Request $request,Content $content)
    {
        $barcode = $request->get('barcode','');
        $barcode = trim($barcode);
        $sku = \App\Models\StoreSku::query()->where('barcode',$barcode)->first();
        if(empty($sku)){
            $body = "<div style='text-align: center'>找不到商品数据</div>";
        }else{
            $body = $this->detail($sku->id);
        }
        return $content
            ->title("商品详情")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($barcode){
                $form->text("barcode","商品条码")->default($barcode);
                $form->button("<i class='fa fa-search'> 查 询</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->body($body)
            ->view('mobile.sku');
    }
    public function detail($id)
    {
        return Show::make($id,new \App\Models\StoreSku(), function (Show $show) {
            $show->model()->with(['store','product']);
            $product = $show->model()->product;
            $store = $show->model()->store;
            $show->field('store.name','店铺');
            $show->field('title','标题');
            $show->field('barcode','商品条码');
            $show->field('product.name',trans('product.fields.name'));
            $show->field('product.model',trans('product.fields.model'));
            $show->field('product.norms',trans('product.fields.norms'));
            $show->field('product.material',trans('product.fields.material'));
            $show->field('product.technology',trans('product.fields.technology'));
            $show->field('product.color',trans('product.fields.color'));
            $show->field('product.remarks',trans('product.fields.remarks'));
            $show->field('内箱')->unescape()->as(function() use ($product){
                return "长*宽*高:".implode("*",[$product->inner_box_length,$product->inner_box_width,$product->inner_box_height])."<br/>装箱数(支):{$product->inner_box_packing_qty}<br/>毛重(kg):{$product->inner_box_gross_weight}";
            });
            $show->field('外箱')->unescape()->as(function() use ($product){
                return "长*宽*高:".implode("*",[$product->outer_box_length,$product->outer_box_width,$product->outer_box_height])."<br/>装箱数(支):{$product->outer_box_packing_qty}<br/>毛重(kg):{$product->outer_box_gross_weight}";
            });
            $show->field('product.product_images')->image();
            $show->field('product.size_images')->image();
            $show->field('product.production_detail_images')->image();
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->disableListButton();
        });
    }
}
