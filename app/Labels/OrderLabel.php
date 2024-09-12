<?php

namespace App\Labels;

use App\Admin\Repositories\Order;
use App\Libraries\ClearPDF;

class OrderLabel
{
    protected $page_width = 210;
    protected $page_height = 297;
    protected $ids;


    /** @var \TCPDF */
    protected $pdf;

    function __construct(array $params)
    {
        $this->ids = $params['ids'];
    }
    function generate() {
        $pdf = new ClearPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(4, 0, 4);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFont("notosansuniversal", "", 15);

        $orders = \App\Models\Order::query()->with('attr')->whereIn('id', $this->ids)->get();
        foreach ($orders as $order){
            $pdf->AddPage("P");
            $this->setContents($pdf,$order);
        }
        return $pdf;
    }

    public function setContents(\TCPDF &$pdf,$order)
    {
        $data = self::getAttributes($order);

        $pdf->writeHTMLCell(45,15,0,5,"订单日期",0,0,false,true,"C");
        $pdf->writeHTMLCell(90,15,120,5,"设计图",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,20,"亚马逊订单号",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,35,"电压",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,50,"颜色",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,65,"适配器",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,80,"安装配件",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,95,"特殊要求",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,110,"形状",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,125,"硅胶",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,140,"产品尺寸",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,155,"打包完成日期",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,170,"收货人",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,185,"电话",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,200,"收货地址",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,245,"客户备注",0,0,false,true,"C");
        $pdf->writeHTMLCell(45,15,0,260,"快递单号",0,0,false,true,"C");

        $pdf->writeHTMLCell(75,15,45,35,"6V",0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,65,"USB",0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,80,"标准安装包",0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,95,"邀评卡（暂无）",0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,125,"6MM",0,0,false,true,"C");

        $pdf->writeHTMLCell(75,15,45,5,$order->order_date,0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,20,$order->order_number,0,0,false,true,"C");
        $pdf->writeHTMLCell(165,15,45,155,$order->delivery_date,0,0,false,true,"C");
        $pdf->writeHTMLCell(165,15,45,170,$order->receive_name,0,0,false,true,"C");
        $pdf->writeHTMLCell(165,15,45,185,$order->receive_phone,0,0,false,true,"C");
        $address = str_replace("\r\n","<br>",$order->receive_address);
        $pdf->writeHTMLCell(165,15,45,195,$address,0,0,false,true,"C");
        $pdf->writeHTMLCell(165,15,45,245,$order->remarks,0,0,false,true,"C");

        $pdf->writeHTMLCell(75,15,45,50,$data['color'],0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,140,$data['size'],0,0,false,true,"C");
        $pdf->writeHTMLCell(75,15,45,110,$data['shape'],0,0,false,true,"C");

        if(!empty($order->design_images)){
            $images = json_decode($order->design_images);
            if(isset($images[0])){
                $pdf->Image(asset("storage/uploads/{$images[0]}"), $x = 125, $y = 20, $w = 80, $h = 0, $type = '', $link = '', $align = 'C');
            }
        }

        $barcode_style = array(
            'position' => 'C',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => false,
            'cellfitalign' => '',
            'border' => 0,
            'hpadding' => 'auto',
            'vpadding' => '0',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'notosansuniversal',
            'fontsize' => 14,
            'stretchtext' => 6,
            'label' => $order->tracking_number
        );
        $pdf->writeHTMLCell(165,15,60,260,$order->tracking_number,0,0,false,true,"L");
        $pdf->write1DBarcode($order->tracking_number, 'C128', 100, 270, 140, 25, '', $barcode_style,'C');

        $barcode_style = array(
            //'position' => 'C',
            //'align' => 'C',
            'border' => 0,
            'vpadding' => 0,
            'hpadding' => 0,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1.55, // width of a single module in points
            'module_height' => 1.55 // height of a single module in points
        );
        $pdf->write2DBarcode(asset("mobile/order?order_number={$order->order_number}"), 'QRCODE,M', 150, 100, 30, 30, $barcode_style, 'L');

        $pdf->Line(0,15,297,15);
        $pdf->Line(45,0,45,297);
        $pdf->Line(120,0,120,135);
        $pdf->Line(0,30,120,30);
        $pdf->Line(0,45,120,45);
        $pdf->Line(0,60,120,60);
        $pdf->Line(0,75,120,75);
        $pdf->Line(0,90,120,90);
        $pdf->Line(0,105,120,105);
        $pdf->Line(0,120,120,120);
        $pdf->Line(0,135,210,135);
        $pdf->Line(0,150,210,150);
        $pdf->Line(0,165,210,165);
        $pdf->Line(0,180,210,180);
        $pdf->Line(0,195,210,195);
        $pdf->Line(0,240,210,240);
        $pdf->Line(0,255,210,255);
        return $pdf;
    }

    public static function getAttributes($order)
    {
        $data = [
            'size' => '',
            'shape' => '',
            'color' => '',
        ];
        if(empty($order->attr)){
            if(!empty($order->order_data)){
                $orderData = json_decode($order->order_data,true);
                foreach ($orderData['customizationInfo']['version3.0']['surfaces'][0]['areas'] as $row) {
                    if(isset($row['label'])){
                        if (strpos($row["label"], "Sign Length") !== false){
                            $data['size'] = $row["optionValue"]??"";
                        }elseif ($row["label"] == "Acrylic Board Shape"){
                            $data['shape'] = $row["optionValue"]??"";
                        }elseif (isset($row['fill'])){
                            $data['color'] = $row["colorName"]??"";
                        }
                    }
                }
            }
        }else{
            foreach (json_decode($order->attr->color,true) as $color) {
                if($color['type'] == "ColorCustomization"){
                    $data['color'] = $color['colorSelection']['name'];
                }
            }
            $shape = json_decode($order->attr->shape,true);
            $data['shape'] = $shape['displayValue'];
            $size = json_decode($order->attr->size,true);
            $data['size'] = $size['displayValue'];

        }

        return $data;
    }

    public function extras()
    {
        return [];
    }
}
