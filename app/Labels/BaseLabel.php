<?php
namespace App\Labels;

abstract class BaseLabel extends \TCPDF
{
    protected $padding_top = 5;
    protected $padding_left = 5;
    protected $padding_right = 5;
    protected $page_width = 100;
    protected $page_height = 150;
    protected $content_width;

    /** @var \TCPDF */
    protected $pdf;

    public function generate() {
        $this->padding_top = 2;
        $this->padding_left = 5;
        $this->padding_right = 5;

        $this->page_width = 150;
        $this->page_height = 100;

        $this->content_width = $this->page_width - $this->padding_left - $this->padding_right;

        /*$this->pdf = new ClearPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $this->pdf->SetMargins(0, 0, 0);
        $this->pdf->SetHeaderMargin(0);
        $this->pdf->SetFooterMargin(0);
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);*/
    }

}
