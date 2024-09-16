<?php

namespace App\Admin\Controllers;

use App\Labels\OrderLabel;
use App\Labels\ProductLabel;
use App\Labels\SkuLabel;
use App\Labels\StoreSkuBoxLabel;
use App\Models\Product;
use App\Models\Sku;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\HasUploadedFile;
use Faker\Core\Uuid;
use Psy\Util\Str;

class UploadController extends AdminController
{
    use HasUploadedFile;

    public function index(Content $content)
    {
        //$label = new OrderLabel(['ids' => [5]]);
        //$label = new ProductLabel(['ids' => [1]]);
        //$label = new StoreSkuBoxLabel(['ids' => [1]]);
        $label = new SkuLabel(['ids' => [1]]);

        $pdf = $label->generate();

        $labelFilename = \Illuminate\Support\Str::uuid();
        $labelFilename =  $labelFilename . ".pdf";
        $filepath = storage_path("app/public/labels/" . $labelFilename);
        $pdf->Output($filepath, 'I');
        return asset("storage/labels/" . $labelFilename);
    }


}
