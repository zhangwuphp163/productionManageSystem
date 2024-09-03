<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\InboundForm;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class Inbound extends RowAction
{

    protected $title = '<button class="btn btn-info"><i class="fa fa-tag"></i> 库存操作</button>';

    public function render()
    {
        $form = InboundForm::make()->payload(['id' => $this->getKey(),'name' => $this->row("name")]);
        return Modal::make()
            ->lg()
            ->title("库存操作")
            ->body($form)
            ->button($this->title);
    }
}
