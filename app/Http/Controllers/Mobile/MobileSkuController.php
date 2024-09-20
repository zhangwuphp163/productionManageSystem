<?php

namespace App\Http\Controllers\Mobile;

use App\Admin\Repositories\Order;
use App\Admin\Repositories\Product;
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
        $sku = \App\Models\Product::query()->where('model',$barcode)->first();
        if(empty($sku)){
            $body = "<div style='text-align: center'>找不到产品数据</div>";
        }else{
            $body = $this->detail($sku->id);
        }
        return $content
            ->title("产品详情")
            ->header('')
            ->description('')
            ->row(Form::make(null,function (Form $form) use ($barcode){
                $form->text("barcode","产品型号")->default($barcode)->autofocus();
                $form->button("<i class='fa fa-search'> 查 询</i>");
                $form->disableResetButton();
                $form->disableSubmitButton();
            })->disableHeader())
            ->body($body)
            ->view('mobile.sku')->with(['title' => '产品详情']);
    }
    public function detail($id)
    {
        return (new Product())->detail($id);
    }
}
