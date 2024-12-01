<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Admin\Repositories\StoreSku;
use App\Labels\StoreSkuBoxLabel;
use App\Labels\StoreSkuLabel;
use App\Libraries\RouteServer;
use App\Models\Store;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreSkuController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->body($this->grid())
            ->view("admin.store-sku.index");
    }
    use RouteServer;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new StoreSku(['store','product']), function (Grid $grid) {
            //$grid->column('id')->sortable();
            $grid->column('store.name','店铺')->sortable()->width("80");
            $grid->column('title',trans('product.fields.title'))->editable()->width(120);
            $grid->column('barcode',trans('product.fields.barcode'))->editable()->width(120);
            $grid->column('product.name',trans('product.fields.name'))->copyable()->filter()->width(120);
            $grid->column('product.model',trans('product.fields.model'))->filter()->width(120);
            $grid->column('product.product_images',trans('product.fields.product_images'))->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);;
            $grid->column('product.size_images',trans('product.fields.size_images'))->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);;
            $grid->column('product.norms',trans('product.fields.norms'))->display(function ($norms){
                return str_replace("\r\n","<br/>",$norms);
            })->width("120");
            $grid->column('product.material',trans('product.fields.material'))->width(80);
            $grid->column('product.technology',trans('product.fields.technology'))->width(80);
            $grid->column('product.color',trans('product.fields.color'))->width(80);
            $grid->column('product.price',trans('product.fields.price'))->width(80);
            $grid->column('product.remarks',trans('product.fields.remarks'))->width(80);
            /*$grid->column('attachment')->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);*/
            $grid->column('inner_box','内箱')->display(function(){
                return "长*宽*高:".implode("*",[$this->product->inner_box_length,$this->product->inner_box_width,$this->product->inner_box_height])."<br/>装箱数(支):{$this->product->inner_box_packing_qty}<br/>毛重(kg):{$this->product->inner_box_gross_weight}";
            })->width("120");
            $grid->column('outer_box','外箱')->display(function(){
                return "长*宽*高:".implode("*",[$this->product->outer_box_length,$this->product->outer_box_width,$this->product->outer_box_height])."<br/>装箱数(支):{$this->product->outer_box_packing_qty}<br/>毛重(kg):{$this->product->outer_box_gross_weight}";
            })->width("120");
            $grid->column('product.production_detail_images',trans('product.fields.production_detail_images'))->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);

            /*$grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });*/
            $grid->showColumnSelector();
            /*$grid->column('created_at');
            $grid->column('updated_at')->sortable();*/

            $grid->filter(function (Grid\Filter $filter) {
                //$filter->expand(false);
                $filter->panel();
                $filter->like('title')->width(3);
                $filter->equal('barcode')->width(3);

            });
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('store_id', '店铺', \App\Models\Store::query()->pluck('name','id')->toArray());
            });
            $grid->enableDialogCreate();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
                $actions->quickEdit();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if(!empty($this->product->attachment)){
                    $attachment = json_decode($this->product->attachment,true);
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
                $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-print" data-title="批量打印条码" data-type="barcode">&nbsp;&nbsp;&nbsp;<i class="fa fa-print"></i> 批量打印条码&nbsp;&nbsp;&nbsp;</a>');
                $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-print" data-title="批量打印装箱码" data-type="box">&nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i> 批量打印装箱码&nbsp;&nbsp;&nbsp;</a>');
            });
            $grid->scrollbarX();
            $grid->toolsWithOutline(false);
            //$grid->fixColumns(1);
        });
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
        return Show::make($id, new StoreSku(['store','product']), function (Show $show) {
            $show->model()->with("product");
            $show->field('store.name','店铺');
            $show->field('product.name','产品名称');
            $show->field('title','标题');
            $show->field('barcode','条码');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new StoreSku(['store']), function (Form $form) {
            //$form->display('id');
            $form->select('store_id',"店铺")->options(\App\Models\Store::query()->pluck('name','id'))->required();
            $form->select('product_id',"产品")->options(\App\Models\Product::query()->pluck('name','id'))->required();
            $form->text('title','标题');
            $form->text('barcode','条码');

            /*$form->display('created_at');
            $form->display('updated_at');*/
        });
    }

    public function printLabel(Request $request)
    {
        $ids = $request->get('ids');
        $type = $request->get('type','barcode');
        if($type == 'barcode'){
            $label = new StoreSkuLabel(['ids' => $ids]);
        }else{
            $label = new StoreSkuBoxLabel(['ids' => $ids]);
        }
        $pdf = $label->generate();
        $labelFilename = Str::uuid();
        $labelFilename =  $labelFilename . ".pdf";
        $filepath = storage_path("app/public/labels/" . $labelFilename);
        $pdf->Output($filepath, 'F');
        return [
            'status' => 0,
            'msg' => 'success',
            'url' => asset("storage/labels/" . $labelFilename)
        ];
    }
    public function batchAddProduct(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $store_id = $request->get('store_id','');
            DB::beginTransaction();
            $store = Store::query()->whereId($store_id)->first();
            $products = \App\Models\Product::query()->whereIn('id',$ids)->get();
            foreach ($products as $product){
                $storeSku = \App\Models\StoreSku::query()->where('product_id',$product->id)->where('store_id',$store_id)->first();
                if($storeSku){
                    throw new \Exception("店铺【{$store->name}】已经添加了产品【{$product->name}】");
                }
                \App\Models\StoreSku::create([
                    'store_id' => $store->id,
                    'product_id' => $product->id
                ]);
            }
            DB::commit();

            return [
                'status' => 0,
                'msg' => 'success'
            ];
        }catch (\Exception $exception){
            DB::rollBack();
            return [
                'status' => 1,
                'msg' => $exception->getMessage()
            ];
        }
    }

}
