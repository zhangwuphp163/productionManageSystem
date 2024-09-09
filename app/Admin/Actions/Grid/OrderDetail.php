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
            /*foreach ($data["customizationInfo"]["version3.0"]["surfaces"]??[] as $rows){
                foreach ($rows["areas"] as $row){
                    if($row["customizationType"] == "Options"){
                        $show->field(mb_substr($row["label"],0,64))->value($row["optionValue"]);
                        //$show->field($row["optionValue"]);
                    }elseif ($row["customizationType"] == "TextPrinting" && isset($row["fill"])){
                        $show->field(mb_substr($row["label"],0,64))->value($row["fill"])->unescape()->as(function ($avatar) {

                            return "<div style='background: {$avatar};width:20px;height:20px;'></div>{$avatar}";

                        });
                    }elseif ($row["customizationType"] == "TextPrinting" && isset($row["text"])){
                        $show->field(mb_substr($row["label"],0,64))->value($row["text"]);
                    }
                }

            }*/
//dd($data["customizationData"]["children"][0]['children'][0]['children']);
            foreach ($data["customizationData"]["children"][0]['children'][0]['children']??[] as $row){
                if($row["type"] == "OptionCustomization"){
                    if(!empty($row["optionSelection"])){
                        $show->field(mb_substr($row["label"],0,64))->value($row["optionSelection"]["label"].($row["optionSelection"]['additionalCost']['amount']?(" $".$row["optionSelection"]['additionalCost']['amount']):""));
                    }else{
                        $show->field(mb_substr($row["label"],0,64))->value($row["displayValue"]);
                    }
                    //$show->field($row["optionValue"]);
                }elseif ($row["type"] == "TextPrinting" && isset($row["text"])){
                    $show->field(mb_substr($row["label"],0,64))->value($row["text"]);
                }elseif ($row["type"] == "ContainerCustomization" ){
                    if(!empty($row['children']) && is_array($row['children'])){
                        foreach ($row['children'] as $c){
                            if($c['type'] == "ColorCustomization"){

                                $show->field(mb_substr($c["label"],0,64))->unescape()->as(function ($avatar) use($c){

                                    $hex = str_replace("#", "", $c["colorSelection"]['value']);

                                    // 检查是否为3位简写颜色代码
                                    if (strlen($hex) == 3) {
                                        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                                        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                                        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                                    } else {
                                        $r = hexdec(substr($hex, 0, 2));
                                        $g = hexdec(substr($hex, 2, 2));
                                        $b = hexdec(substr($hex, 4, 2));
                                    }

                                    $rgb = array($r, $g, $b);

                                    $rgb =  implode('/', $rgb);
                                    return "<div style='background: {$c["colorSelection"]['value']};width:20px;height:20px;'></div>{$c["colorSelection"]['name']}({$c["colorSelection"]['value']} or RGB {$rgb})";

                                });//->value($c["colorSelection"]['name']."(".$c["colorSelection"]['value'].")");




                            }elseif($c['type'] == 'ContainerCustomization'){
                                foreach ($c['children'] as $c1){
                                    if($c1['type'] == "PlacementContainerCustomization"){
                                        foreach ($c1['children'] as $c2){
                                            $show->field($c2['label'])->value($c2["inputValue"]);
                                        }
                                    }
                                }
                            }

                        }
                    }else{
                        $show->field(mb_substr($row["label"],0,64))->value($row["displayValue"]);
                    }
                }elseif ($row["type"] == "TextCustomization"){
                    $show->field(mb_substr($row["label"],0,64))->value($row["inputValue"]);
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
