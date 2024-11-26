<?php

namespace App\Admin\Forms;

use App\Models\NewOrder;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderShipment;
use Dcat\EasyExcel\Excel;
use Dcat\Admin\Widgets\Form;
use Faker\Core\Uuid;
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

            $secondExtractPath  = 'storage/uploads/unzipped/';

            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                foreach (File::directories($extractPath) as $dir) {
                    $pathData = explode('/', $dir);
                    $systemNumber = end($pathData);

                    foreach (File::files($dir) as $file) {
                        $zip = new \ZipArchive();
                        if ($zip->open($file) === TRUE){
                            $subExtractPath = $secondExtractPath.\Ramsey\Uuid\Uuid::uuid4()->toString();
                            $zip->extractTo($subExtractPath);
                            $zip->close();
                            $images = [];
                            $skuId = "";
                            $orderData = null;
                            foreach (File::files($subExtractPath) as $subFile) {
                                $basename = basename($subFile);
                                $extension = pathinfo($basename, PATHINFO_EXTENSION);
                                if ($extension === 'json') {
                                    $skuId = pathinfo($basename, PATHINFO_FILENAME);

                                    $jsonData = json_decode(File::get($subFile), true);
                                    $orderData = json_encode($jsonData);
                                    continue;
                                }

                                if (in_array(strtolower(File::extension($subFile)), ['jpg', 'jpeg', 'png'])) {
                                    $filename = basename($subFile);
                                    $targetPath = storage_path('app/public/uploads/images/' . $filename);
                                    File::copy($subFile, $targetPath);
                                    $images[] = "images/".$filename;
                                }
                            }

                            if(!empty($images)){
                                $newOrder = NewOrder::query()->where('system_number', $systemNumber)->where("order_sku_id",$skuId)->first();
                                if(!empty($newOrder)){
                                    $newOrder->order_data = $orderData;
                                    $newOrder->images = json_encode($images);
                                    $newOrder->save();
                                }
                            }
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
