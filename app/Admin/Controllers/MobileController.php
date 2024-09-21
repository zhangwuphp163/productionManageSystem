<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\NewOrder;
use App\Admin\Repositories\Product;
use App\Libraries\CustomFile;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileController
{
    function order(Request $request,Content $content)
    {
        $orderNumber = $request->get('order_number','');
        $orderNumber = trim($orderNumber);
        $order = \App\Models\NewOrder::query()->where('platform_number',$orderNumber)->first();
        if(empty($order)){
            $body = "<div style='text-align: center'>找不到订单数据</div>";
        }else{
            $body = (new NewOrder())->detail($order->id);
        }
        return $content
            ->title("订单详情")
            ->translation("new-order")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($orderNumber){
                $form->text("order_number","平台单号")->default($orderNumber)->autofocus();
                $form->button("<i class='fa fa-search'> 查 询</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->body($body)
            ->view('admin.mobile.order')->with(['title' => '订单详情']);
    }

    function sku(Request $request,Content $content)
    {
        $barcode = $request->get('barcode','');
        $barcode = trim($barcode);
        $sku = \App\Models\Product::query()->where('model',$barcode)->first();
        if(empty($sku)){
            $body = "<div style='text-align: center'>找不到产品数据</div>";
        }else{
            $body = (new Product())->detail($sku->id);
        }
        return $content
            ->title("产品详情")
            ->header('')
            ->description('')
            ->row(Form::make(new \App\Models\NewOrder(),function (Form $form) use ($barcode){
                $form->text("barcode","产品型号")->default($barcode)->autofocus();
                $form->button("<i class='fa fa-search'> 查 询</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->body($body)
            ->view('admin.mobile.sku')->with(['title' => '产品详情']);
    }

    function weight(Request $request,Content $content)
    {
        $platform_number = $request->get('platform_number','');
        return $content
            ->title("重量尺寸")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($platform_number){
                $form->text("platform_number","平台单号")->default($platform_number)->attribute(['id'=>'platform_number'])->required()->autofocus();
                $form->decimal('weight','重量（KG）')->attribute(['id'=>'weight'])->required();
                $form->multipleFile('images')->uniqueName()->url("upload/image")->autoUpload();
                $form->decimal('length','长（cm）')->attribute(['id'=>'length']);
                $form->decimal('width','宽（cm）')->attribute(['id'=>'width']);
                $form->decimal('height','高（cm）')->attribute(['id'=>'height']);
                $form->button("<i class='fa fa-save'> 保 存</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->view('admin.mobile.weight')->with(['title' => '重量尺寸']);
    }
    public function weightSave(Request $request)
    {
        try {
            $platformNumber = $request->get('platform_number','');
            $weight = $request->get('weight','');
            $length = $request->get('length','');
            $width = $request->get('width','');
            $height = $request->get('height',"");
            $images = $request->get('images','');

            DB::beginTransaction();
            $order = \App\Models\NewOrder::query()->where('platform_number',$platformNumber)->first();
            if(empty($order)) throw new \Exception("找不到平台订单【{$platformNumber}】");

            if(!empty($weight)){
                $order->estimated_weight = $weight;
            }
            if(!empty($length)){
                $order->estimated_length = $length;
            }
            if(!empty($width)){
                $order->estimated_width = $width;
            }
            if(!empty($height)){
                $order->estimated_height = $height;
            }
            if(!empty($images)){
                $images = explode(",",$images);
                $originalImages = [];
                if(!empty($order->shipment_images)){
                    $originalImages = json_decode($order->shipment_images,true);
                }
                $order->shipment_images = json_encode(array_merge($images,$originalImages));
            }
            $order->save();
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
