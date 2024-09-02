<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\InboundForm;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class Inbound extends RowAction
{

    protected $title = '库存操作';

    public function render()
    {
        $form = InboundForm::make()->payload(['id' => $this->getKey(),'name' => $this->row("name")]);
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }
}
