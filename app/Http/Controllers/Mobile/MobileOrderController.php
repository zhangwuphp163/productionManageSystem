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
            ->row(Form::make(null,function (Form $form){
                $form->text("order_number");
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
            $show->field('images')->image()->label('订单图片');
            $show->field('design_images')->image()->label('设计图');
            $show->field('order_date')->label('订单日期')->as(function (){
                return $this->order_date;
            });
            $show->field('order_number')->label('订单号')->as(function (){
                return $this->order_number;
            });;
            $show->field('tracking_number')->label('快递单号')->as(function (){
                return $this->tracking_number;
            });;
            $show->field('color')->label('颜色')->as(function (){
                return  $this->attr->custom_color;
            });
            $show->field('shape')->label('形状')->as(function (){
                return  $this->attr->custom_shape;
            });
            $show->field('size')->label('尺寸')->as(function (){
                return  $this->attr->custom_size;
            });
            $show->field('delivery_date')->label('订单打包日期')->as(function (){
                return $this->delivery_date;
            });;
            $show->field('receive_name')->label('收货人')->as(function (){
                return $this->receive_name;
            });;
            $show->field('receive_address')->label('收货地址')->as(function (){
                return $this->receive_address;
            });;
            $show->field('remarks')->label('客户备注')->as(function (){
                return $this->remarks;
            });;
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->disableListButton();
        });
    }
}
