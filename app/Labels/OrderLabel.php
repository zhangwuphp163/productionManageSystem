<?php

namespace App\Labels;

use App\Admin\Repositories\Order;
use App\Libraries\ClearPDF;

class OrderLabel
{
    protected $page_width = 210;
    protected $page_height = 297;
    protected $numbers;


    /** @var \TCPDF */
    protected $pdf;

    function __construct(array $params)
    {
        $this->numbers = $params['numbers'];
    }
    function generate() {
        $pdf = new ClearPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(4, 0, 4);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $fontname = \TCPDF_FONTS::addTTFfont(public_path("fonts/CN-Light.ttf"));

        $order = \App\Models\Order::query()->whereIn('id', $this->numbers)->first();
        $pdf->AddPage();
        $pdf->Line(0,15,297,15);
        $pdf->setFont($fontname, "B", 10);
        $pdf->writeHTMLCell(100,15,5,2,"订单日期");

        $pdf->writeHTMLCell(100,50,20,30,"debug");
        return $pdf;
    }

    public function extras()
    {
        return [];
    }
}
