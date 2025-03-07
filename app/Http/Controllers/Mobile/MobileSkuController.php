<?php

namespace App\Http\Controllers\Mobile;

use App\Admin\Repositories\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;

class MobileSkuController
{
    function index(Request $request,Content $content)
    {
        $barcode = $request->get('barcode','');
        $barcode = trim($barcode);
        $sku = \App\Models\StoreSku::query()->where('barcode',$barcode)->first();
        if(empty($sku)){
            $body = "<div style='text-align: center'>找不到产品数据</div>";
        }else{
            $body = $this->detail($sku->product_id);
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
