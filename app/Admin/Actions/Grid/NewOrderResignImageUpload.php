<?php

namespace App\Admin\Actions\Grid;

use App\Models\NewOrder;
use App\Models\Order;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Modal;

class NewOrderResignImageUpload extends RowAction
{

    protected $title = '<a href="#" class="btn btn-cyan btn-xs"><i class="fa fa-image"></i> 上传设计图</a>';
    //protected $title = '<br/><i class="fa fa-image"></i>';

    public function render()
    {
        $form = self::form($this->getKey())->edit($this->getKey())->action("new-orders/update-design-image/{$this->getKey()}");
        return Modal::make()
            ->scrollable()
            ->xl()
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
        });
    }

}
