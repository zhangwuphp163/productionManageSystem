<?php

namespace App\Admin\Actions\Grid;

use App\Models\NewOrder;
use App\Models\Order;
use App\Services\OrderMonitor;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Modal;

class NewOrderResignImageUpload extends RowAction
{

    //protected $title = '<a href="#" class="btn btn-cyan btn-xs"><i class="fa fa-image"></i> 上传设计图</a>';
    protected $title = '<a href="#" ><i class="fa fa-image" title="上传设计图"></i></a>';
    //protected $title = '<br/><i class="fa fa-image"></i>';

    public function render()
    {
        $form = self::form($this->getKey())->edit($this->getKey())->action("new-orders/update-design-image/{$this->getKey()}");
        return Modal::make()
            ->scrollable()
            ->lg()
            ->title("上传设计图")
            ->body($form)->button($this->title);
    }

    public static function form($id): Form
    {
        return Form::make(new NewOrder(), function (Form $form) use ($id){
            $form->multipleImage("design_images","设计图片")->url("new-orders/upload-design-image/{$id}")->uniqueName()->saving(function ($paths){
                return json_encode($paths);
            })->autoUpload();
            $form->disableResetButton();
            $form->disableDeleteButton();
            $form->disableListButton();
            $form->disableViewButton();
            $form->disableEditingCheck();
            $form->disableViewCheck();
            $form->disableHeader();
            //$form->disableSubmitButton();
            $form->saving(function (Form $form) {
                $form->status = '发稿图给客人确认';
                $data = $form->input();
                if(key_exists('file',$data)){
                    OrderMonitor::orderUpdate("设计图已上传【{$form->model()->platform_number}】，订单连接：http://123.249.25.241/admin/mobile/order?order_number=".$form->model()->platform_number,"运营");
                }
            });
            $form->text('status','状态')->display(false);
        });
    }

}
