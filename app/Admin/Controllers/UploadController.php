<?php

namespace App\Admin\Controllers;

use App\Labels\SkuLabel;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UploadController
{
    use HasUploadedFile;

    public function image(Request $request)
    {
        if ($request->hasFile('_file_')) {
            try {
                $image = $request->file('_file_');
                $uniqueName = Uuid::uuid4() . '.' . $image->getClientOriginalExtension();
                $path = Storage::disk('admin')->putFileAs('uploads/images', $image, $uniqueName);
                if(empty($path)){
                    return $this->responseErrorMessage('自定义上传请先设置path存储路径');
                }
                $url = Storage::disk('admin')->url("images/".$uniqueName);
                return $this->responseUploaded("images/".$uniqueName, $url);
            } catch (\Exception $e) {
                return $this->responseErrorMessage('上传失败：' . $e->getMessage());
            }
        }elseif($this->isDeleteRequest()){
            $this->disk('admin')->delete($request->get('key'));
            return $this->responseDeleted();
        }
        return $this->responseErrorMessage('文件上传失败');
    }

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
