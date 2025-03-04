<?php

namespace App\Labels;

use App\Admin\Repositories\Order;
use App\Libraries\ClearPDF;

class StoreSkuBoxLabel
{
    protected $page_width = 50;
    protected $page_height = 30;
    protected $ids;


    /** @var \TCPDF */
    protected $pdf;

    function __construct(array $params)
    {
        $this->ids = $params['ids'];
    }
    function generate() {
        $pdf = new ClearPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(1, 0, 1);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFont("notosansuniversal", "", 10);

        $skus = \App\Models\StoreSku::query()->whereIn('id', $this->ids)->get();
        foreach ($skus as $sku){
            $pdf->AddPage("L",[$this->page_width,$this->page_height]);
            $pdf->setFontSize(18);
            $pdf->writeHTMLCell(50,12,1,3,$sku->store->name,0,0,false,true,"C");

            $pdf->setFontSize(10);
            $pdf->writeHTMLCell(35,12,2,15,$sku->product->name,0,0,false,true,"L");

            $barcode_style = array(
                //'position' => 'C',
                //'align' => 'C',
                'border' => 0,
                'vpadding' => 0,
                'hpadding' => 0,
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            $pdf->write2DBarcode(asset("mobile/sku?barcode={$sku->barcode}"), 'QRCODE,M', 36, 15, 13, '', $barcode_style, 'R',true);

        }
        return $pdf;
    }


    public function extras()
    {
        return [];
    }
}
