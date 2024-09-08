<?php

namespace App\Admin\Actions\Grid;

use App\Models\Order;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;

class OrderDetail extends RowAction
{

    protected $title = '<i class="fa fa-eye"></i>';

    public function render()
    {
        $form = Show::make($this->getKey(), new \App\Admin\Repositories\Order(), function (Show $show) {
            $show->field('order_number');
            $show->field("images")->image();
            $data = json_decode($show->model()->order_data,true);
            foreach ($data["customizationInfo"]["version3.0"]["surfaces"]??[] as $rows){
                foreach ($rows["areas"] as $row){
                    if($row["customizationType"] == "Options"){
                        $show->field(mb_substr($row["label"],0,64))->value($row["optionValue"]);
                        //$show->field($row["optionValue"]);
                    }elseif ($row["customizationType"] == "TextPrinting" && isset($row["fill"])){
                        $show->field(mb_substr($row["label"],0,64))->value($row["fill"]);
                    }elseif ($row["customizationType"] == "TextPrinting" && isset($row["text"])){
                        $show->field(mb_substr($row["label"],0,64))->value($row["text"]);
                    }
                }

            }
            $show->disableEditButton();
            $show->disableDeleteButton();
            $show->disableListButton();

        });
        return Modal::make()
            ->xl()
            ->title("订单详情")
            ->body($form)
            ->button($this->title);
    }
}
