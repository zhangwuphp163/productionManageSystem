<?php

namespace App\Labels;

use App\Admin\Repositories\Order;
use App\Libraries\ClearPDF;

class SkuLabel
{
    protected $page_width = 40;
    protected $page_height = 20;
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
        $pdf->setFont("notosansuniversal", "", 10);

        $skus = \App\Models\Sku::query()->whereIn('id', $this->ids)->get();
        foreach ($skus as $sku){
            $pdf->AddPage("L",[$this->page_width,$this->page_height]);
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
                'fontsize' => 12,
                'stretchtext' => 1,
                'label' => $sku->barcode
            );
            $pdf->write1DBarcode($sku->barcode, 'C128', 0, 1, 42, 15, '', $barcode_style,'C');
            //$pdf->te(40,8,0,10,'123',0,0,false,false,"C");
            $pdf->Text(0,15,$sku->name,0,false,true,0,0,'C');

        }
        return $pdf;
    }


    public function extras()
    {
        return [];
    }
}
