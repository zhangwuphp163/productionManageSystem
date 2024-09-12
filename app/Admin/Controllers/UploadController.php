<?php

namespace App\Admin\Controllers;

use App\Labels\OrderLabel;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\HasUploadedFile;
use Psy\Util\Str;

class UploadController extends AdminController
{
    use HasUploadedFile;

    public function index(Content $content)
    {
        $label = new OrderLabel(['ids' => [5]]);

        $pdf = $label->generate();
        $labelFilename = \Illuminate\Support\Str::uuid();
        $labelFilename =  $labelFilename . ".pdf";
        $filepath = storage_path("app/public/labels/" . $labelFilename);
        $pdf->Output($filepath, 'I');
        return asset("storage/labels/" . $labelFilename);
    }


}
