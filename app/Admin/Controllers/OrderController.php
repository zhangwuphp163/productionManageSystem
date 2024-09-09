<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Auth\Permission;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Support\Zip;
use Dcat\Admin\Traits\HasUploadedFile;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrderController extends AdminController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new \App\Models\Order(), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('order_number',"订单号")->sortable()->filter();
            $grid->column('order_date',"订单日期")->sortable()->filter(Grid\Column\Filter\Equal::make()->date());
            $grid->column('tracking_number',"发货单号")->sortable()->filter();
            $grid->column('delivery_date',"发货日期")->sortable()->filter(Grid\Column\Filter\Equal::make()->date());
            $grid->column('quantity',"数量")->sortable()->filter();
            $grid->column('receive_name',"收货人")->filter();
            $grid->column('images',"订单图片")->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',100,100);
            $grid->column('created_at')->sortable()->filter(Grid\Column\Filter\Between::make()->date());
            $grid->column('updated_at')->sortable()->filter(Grid\Column\Filter\Gt::make()->datetime());
            //$grid->enableDialogCreate();
            $grid->disableCreateButton();
            if (!Admin::user()->can('order-edit')){
                $grid->disableRowSelector();
            }

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append(new \App\Admin\Actions\Grid\OrderDetail());
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableDelete();
                $actions->disableEdit();
                //dd(Permission::check('order-edit'));
                if (Admin::user()->can('order-edit')){
                    $actions->quickEdit();
                }
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('images');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->date("order_date","订单日期");
            $form->text("receive_name","收货人");
            $form->text("receive_phone","收货人电话");
            $form->textarea("receive_address","收货地址");
            $form->text("tracking_number","发货单号");
            $form->date("delivery_date","发货日期");
        });
    }
    public function upload(Request $request)
    {
        $zipFile = $request->file('_file_');
        $extractTo = storage_path('app/public/uploads/unzipped/'.md5($zipFile->getClientOriginalName()));

        // 确保解压目录存在
        File::ensureDirectoryExists($extractTo);
        $zip = new \ZipArchive();
        if ($zip->open($zipFile->getRealPath()) === TRUE) {

            $zip->extractTo($extractTo);
            $zip->close();

            // 遍历解压后的目录
            $this->processUnzippedFiles($extractTo);
            // 清理：你可以在这里选择删除ZIP文件或保留它
            // Storage::disk('local')->delete($zipFile->storeAs('temp', $zipFile->hashName()));
            return  JsonResponse::make(['message'=>"订单创建成功"])->status(true)->statusCode(400);
        } else {
            return  JsonResponse::make(['message'=>"读取数据失败"])->status(false)->statusCode(400);
        }


        //

    }

    protected function processUnzippedFiles($extractTo)
    {
        $images = [];
        foreach (File::files($extractTo) as $file) {
            // 检查文件扩展名是否为图片格式
            //if (in_array(strtolower(File::extension($file)), ['jpg', 'jpeg', 'png', 'gif', 'bmp','svg'])) {
            if (in_array(strtolower(File::extension($file)), ['jpg', 'jpeg', 'png'])) {
                $filename = basename($file);
                $targetPath = storage_path('app/public/uploads/images/' . $filename);
                File::copy($file, $targetPath);
                $images[] = "images/".$filename;
            }
        }
        // 查找并读取JSON文件
        foreach (File::glob($extractTo . '/*.json') as $jsonFile) {
            //读取jsonData 数据，添加到订单表
            $jsonData = json_decode(File::get($jsonFile), true);
            $orderData = [
                'order_number' => $jsonData["orderId"],
                'quantity' => $jsonData['quantity'],
                'order_data' => json_encode($jsonData),
                'images' => json_encode($images)
            ];
            \App\Models\Order::create($orderData);
        }
    }

    public function batchUploadForm(): Form
    {
        return Form::make(new Order(), function (Form $form) {
            $form->title("批量上传订单");
            $form->display('id');
            $form->multipleFile('zip',"仅支持zip文件格式")->url("orders/upload")->accept('zip')->uniqueName()->autoUpload();
            $form->disableSubmitButton();
            $form->disableResetButton();
        });
    }
    public function batch(Content $content): Content
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->batchUploadForm());
    }
}
