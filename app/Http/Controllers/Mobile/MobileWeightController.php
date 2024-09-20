<?php

namespace App\Http\Controllers\Mobile;

use App\Admin\Repositories\Order;
use App\Admin\Repositories\Product;
use App\Models\Store;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MobileWeightController
{
    function index(Request $request,Content $content)
    {
        $platform_number = $request->get('platform_number','');

        return $content
            ->title("重量尺寸")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($platform_number){
                $form->text("platform_number","平台单号")->default($platform_number)->attribute(['id'=>'platform_number'])->required()->autofocus();
                $form->decimal('weight','重量（KG）')->attribute(['id'=>'weight'])->required();
                $form->multipleImage('image');
                $form->decimal('length','长（cm）')->attribute(['id'=>'length']);
                $form->decimal('width','宽（cm）')->attribute(['id'=>'width']);
                $form->decimal('height','高（cm）')->attribute(['id'=>'height']);
                $form->button("<i class='fa fa-save'> 保 存</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->view('mobile.weight')->with(['title' => '重量尺寸']);
    }
    public function weight(Request $request)
    {
        try {
            $platformNumber = $request->get('platform_number','');
            $weight = $request->get('weight','');
            $length = $request->get('length','');
            $width = $request->get('width','');
            $height = $request->get('height','');

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
