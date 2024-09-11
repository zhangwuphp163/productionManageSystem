<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\ResignImageUpload;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;

class UploadController extends AdminController
{
    use HasUploadedFile;

    public function post($id)
    {

        /*if ($request->hasFile('_file_')) {
            try {
                // 如果有图片传入 或者 如果有文件传入
                $file=$request->file('_file_');
                $path = "images/".$file->getClientOriginalName();
                $file->store($path);

                return $this->responseUploaded($path, $path);
            } catch (\Exception $e) {
                return $this->responseErrorMessage('上传失败：' . $e->getMessage());
            }
        }
        return $this->responseErrorMessage('文件上传失败');*/
    }




}
