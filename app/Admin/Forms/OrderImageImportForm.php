<?php

namespace App\Admin\Forms;

use App\Models\NewOrder;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderShipment;
use Dcat\EasyExcel\Excel;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderImageImportForm extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function handle(array $input)
    {
        try {
            $dirname = md5($input['file']);
            $zipFilePath = storage_path('app/public/' . $input['file']);
            $extractPath  = 'storage/uploads/unzipped/'.$dirname;
            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                foreach (File::directories($extractPath) as $dir) {
                    $pathData = explode('/', $dir);
                    $systemNumber = end($pathData);
                    $newOrder = NewOrder::query()->where('system_number', $systemNumber)->first();
                    dd($newOrder);
                    if(!empty($newOrder)){
                        $images = [];
                        foreach (File::files($dir) as $file) {
                            if (in_array(strtolower(File::extension($file)), ['jpg', 'jpeg', 'png'])) {
                                $filename = basename($file);
                                $targetPath = storage_path('app/public/uploads/images/' . $filename);
                                File::copy($file, $targetPath);
                                $images[] = "images/".$filename;
                            }
                        }
                        dd($images);
                        if(!empty($images)){
                            $newOrder->images = json_encode($images);
                            $newOrder->save();
                        }
                    }
                }
            } else {
                return $this->response()->error('无法打开zip文件');
            }

            return $this->response()->success('更新订单图片成功')->refresh();
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->response()->error($exception->getMessage())->refresh();
        }
    }



    /**
     * Build a form here.
     */
    public function form()
    {
        // 禁用重置表单按钮
        $this->disableResetButton();

        // 文件上传
        $this->file('file', ' ')
            ->disk('public')
            ->accept('zip')
            ->uniqueName()
            ->autoUpload()
            ->move('/import')
            ->help('支持zip');
    }
}
