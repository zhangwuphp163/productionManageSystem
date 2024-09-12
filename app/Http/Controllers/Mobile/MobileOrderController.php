<?php

namespace App\Http\Controllers\Mobile;

use App\Admin\Repositories\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobileOrderController
{
    function index(Request $request,Content $content)
    {
        $orderNumber = $request->get('order_number','');
        $orderNumber = trim($orderNumber);
        $order = \App\Models\Order::query()->where('order_number',$orderNumber)->first();
        if(empty($order)){
            $body = "<div style='text-align: center'>找不到订单数据</div>";
        }else{
            $body = $this->detail($order->id);
        }
        return $content
            ->title("订单详情")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($orderNumber){
                $form->text("order_number","订单号")->default($orderNumber);
                $form->button("<i class='fa fa-search'> 查 询</i>");


                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->body($body)
            ->view('mobile.order');
    }
    public function detail($id)
    {
        return Show::make($id,new \App\Models\Order(), function (Show $show) {
            $show->with(['attr']);
            $show->field('images','订单图片')->image();
            $show->field('design_images','设计图')->image();
            $show->field('order_date','订单日期');
            $show->field('order_number','订单号');
            $show->field('tracking_number','快递单号');
            $show->field('color','颜色')->as(function (){
                return  $this->attr->custom_color??'';
            });
            $show->field('shape','形状')->as(function (){
                return  $this->attr->custom_shape??'';
            });
            $show->field('size','尺寸')->as(function (){
                return  $this->attr->custom_size??'';
            });
            $show->field('delivery_date','订单打包日期');
            $show->field('receive_name','收货人');
            $show->field('receive_address','收货地址')->unescape()->as(function(){
                return str_replace("\r\n","<br/>",$this->receive_address);
            });
            $show->field('remarks','客户备注');
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->disableListButton();
        });
    }
}
