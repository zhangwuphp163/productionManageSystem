<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Modal;

class NewOrderDetail extends RowAction
{

    protected $title = '<a href="javascript:void(0)"><i class="fa fa-info"></i> 详情</a>';
    //protected $title = '<i class="fa fa-info"></i>';

    public function render()
    {
        $form = Show::make(/**
         * @param Show $show
         * @return void
         */ $this->getKey(), new \App\Admin\Repositories\OrderNew(), function (Show $show) {
            $show->field('platform_number','平台订单号');
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
            if($show->model()->platform == 'Manual'){

                foreach ($data??[] as $key => $value){
                    $show->field($key)->value($value);
                }
            }else{
                foreach ($data["customizationData"]["children"][0]['children'][0]['children']??[] as $row){
                    if($row["type"] == "OptionCustomization"){
                        if(!empty($row["optionSelection"])){
                            $show->field(mb_substr($row["label"],0,64)."\r\n".$row["name"])->value($row["optionSelection"]["label"].($row["optionSelection"]['additionalCost']['amount']?(" $".$row["optionSelection"]['additionalCost']['amount']):""));
                        }else{
                            $show->field(mb_substr($row["label"],0,64)."\r\n".$row["name"])->value($row["displayValue"]);
                        }
                        //$show->field($row["optionValue"]);
                    }elseif ($row["type"] == "TextPrinting" && isset($row["text"])){
                        $show->field(mb_substr($row["label"],0,64)."\r\n".$row["name"])->value($row["text"]);
                    }elseif ($row["type"] == "ContainerCustomization" ){
                        if(!empty($row['children']) && is_array($row['children'])){
                            foreach ($row['children'] as $c){
                                if($c['type'] == "ColorCustomization"){
                                    if(!empty($c['name'])){
                                        $show->field(mb_substr($c["label"],0,64)."\r\n".$c["name"])->unescape()->as(function ($avatar) use($c){

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

                                    }

                                }elseif($c['type'] == 'ContainerCustomization'){
                                    foreach ($c['children'] as $c1){
                                        if($c1['type'] == "PlacementContainerCustomization"){
                                            foreach ($c1['children'] as $c2){
                                                foreach ($c2['children']??[] as $c3){
                                                    if(!empty($c3['label'])){
                                                        $show->field($c3['label']."\r\n".($c3["name"]??''))->value($c3["inputValue"]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }else{
                            $show->field(mb_substr($row["label"],0,64)."\r\n".$row["name"])->value($row["displayValue"]);
                        }
                    }elseif ($row["type"] == "TextCustomization"){
                        $show->field(mb_substr($row["label"],0,64)."\r\n".$row['name'])->value($row["inputValue"]);
                    }elseif ($row['type'] == 'FlatRatePriceDeltaContainerCustomization'){
                        $show->field($row['children'][0]["label"]."\r\n".($row['children'][0]["name"]??""))->value($row['children'][0]["inputValue"]);
                    }
                }
            }

            $show->disableEditButton();
            $show->disableDeleteButton();
            $show->disableListButton();

        });
        return Modal::make()
            ->scrollable()
            ->xl()
            ->title("订单详情")
            ->body($form)
            ->button($this->title);
    }

}
