<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\NewOrderResignImageUpload;
use App\Admin\Exports\OrderExport;
use App\Admin\Forms\OrderImageImportForm;
use App\Admin\Forms\OrderImportForm;
use App\Admin\Repositories\Order;
use App\Labels\NewOrderLabel;
use App\Labels\OrderLabel;
use App\Libraries\RouteServer;
use App\Models\NewOrder;
use App\Services\OrderMonitor;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Traits\HasUploadedFile;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;

class NewOrderController extends AdminController
{
    use HasUploadedFile;
    use RouteServer;
    protected $hideColumns = [];
    public function index(Content $content)
    {
        $params = $_GET;
        $key = "new_order".Auth::id();
        if(!empty($params['_columns_'])){
            Cache::forever($key,$params['_columns_']);
        }else{
            $cacheColumns = Cache::get($key);

            $inUseColumns = explode(",",$cacheColumns);
            $columns = explode(',',"addresses,amount,design_images,images,order_at,order_remarks,package,platform,platform_number,receiver,sender,shipment_images,sku_id,specify_remarks,status");
            $diff = array_diff($columns,$inUseColumns);
            $this->hideColumns = $diff;
        }

        return $content
            ->translation($this->translation())
            ->title($this->title())
            //->description("列表")
            ->body($this->grid())
            ->view("admin.order.new_order");
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new \App\Models\NewOrder(), function (Grid $grid) {
            $grid->model()->orderBy('order_at','desc');
            //$grid->model()->resetOrderBy();
            //$grid->column('id')->sortable();
            $grid->column('platform_number','平台/系统单号')->display(function(){
                return $this->platform_number."<br/>".$this->system_number;
            })->filter();//->sortable();
            $grid->column('images',"订单图片")->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);
            $grid->column('design_images',"设计图片")->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);
            /*$grid->column('status',"订单进度")->sortable()->select(\App\Models\NewOrder::$statues,true)->filter(
                Grid\Column\Filter\In::make(\App\Models\NewOrder::$statues)
            )->display(function ($status) {
                return $status;
            });*/
            $grid->column('status',"订单进度")->editable(true)->filter(Grid\Column\Filter\Like::make());
            $grid->column('platform','平台/店铺/站点')->display(function(){
                return $this->platform.'<br/>'.$this->store.'<br/>'.$this->site;
            });
            $grid->column('tracking_number',"快递单号")->editable(true)->display(function ($row){
                return $row." &nbsp;<button class='btn btn-sm btn-search-track' title='17track 查询' data-href='https://t.17track.net/zh-cn#nums={$this->tracking_number}'><i class='fa fa-search'></i></button>";
            });
            $grid->column('specify_remarks',"特殊要求")->editable(true);
            $grid->column('order_remarks',"订单备注")->editable(true);
            $grid->column('order_at','订单操作时间')->display(function(){
                return "订购：".$this->order_at."<br/>".
                    "付款：".$this->payment_at."<br/>".
                    "时限：".$this->delivery_deadline."<br/>";
            });//->sortable();

            $grid->column('amount','订单金额')->display(function(){
                return "币种：".$this->currency."<br/>".
                "订单总金额：".$this->total_amount."<br/>".
                "订单商品金额：".$this->total_sku_amount."<br/>".
                "客付运费：".$this->customer_paid_freight."<br/>".
                "订单出库成本：".$this->outbound_cost."<br/>";
            });
            $grid->column('sku_id','商品ID')->display(function(){
                return "".$this->asin."<br/>".
                    "".$this->order_sku_id;
            });


            $grid->column('receiver','买家信息')->display(function(){
                return "买家姓名：".$this->receiver_username."<br/>".
                    "买家邮箱：".$this->receiver_email."<br/>".
                    "收件人：".$this->receiver_name."<br/>".
                    "收件人电话：".$this->receiver_phone."<br/>".
                    "买家留言：".$this->receiver_remarks;
            });

            $grid->column('addresses','地址信息')->display(function(){
                return "国家：".$this->receiver_country."<br/>".
                    "省/州：".$this->receiver_provider."<br/>".
                    "城市：".$this->receiver_city."<br/>".
                    "区/县：".$this->receiver_district."<br/>".
                    "邮编：".$this->receiver_postcode."<br/>".
                    "门牌号：".$this->receiver_house_number."<br/>".
                    "地址类型：".$this->receiver_address_type."<br/>".
                    "地址行123：".implode("/",[$this->receiver_address1,$this->receiver_address2,$this->receiver_address3])."<br/>".
                    "公司名：".$this->receiver_remarks;
            });
            $grid->column('sender','发货信息')->display(function(){
                return '物流渠道：'.$this->logistics_provider."<br/>".
                    '发货仓库：'.$this->estimated_weight."<br/>".
                    '物流方式：'.implode("*",[$this->estimated_length,$this->estimated_width,$this->estimated_height])."<br/>".
                    '运单号：'.$this->waybill_number."<br/>".
                    '跟踪号：'.$this->tracking_number."<br/>".
                    '标发号：'.$this->tag_number;

            });
            $grid->column('package','包裹信息')->display(function(){
                return '重量：'.$this->estimated_weight."<br/>".
                    '尺寸：'.implode("*",[$this->estimated_length,$this->estimated_width,$this->estimated_height])."<br/>".
                    '预估计费重：'.$this->estimated_cost_weight."<br/>".
                    '预估运费：'.$this->estimated_shipping_cost;

            });
            $grid->column('shipment_images',"包裹称重图片")->display(function ($pictures){
                return $pictures?\GuzzleHttp\json_decode($pictures, true):[];
            })->image('',80,80);



            $grid->showColumnSelector();
            // 设置默认隐藏字段
            //$grid->hideColumns(['field1', ...]);

            //$grid->disableCreateButton();
            if (!Admin::user()->can('order-edit')){
                $grid->disableRowSelector();
            }


            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand(false);
                $filter->panel();

                $filter->like('platform_number', '平台单号')->width(3); // 这里的标签可以自定义
                $filter->like('system_number', '系统单号')->width(3); // 这里的标签可以自定义
                $filter->like('status', '订单状态')->width(3); // 这里的标签可以自定义
                $filter->like('order_sku_id', '订单商品ID')->width(3); // 这里的标签可以自定义
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append("<br/>");
                $actions->append(new \App\Admin\Actions\Grid\NewOrderDetail());
                $actions->append("<br/>");
                $actions->append(new \App\Admin\Actions\Grid\NewOrderResignImageUpload());
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
            /*$grid->tools(function (Grid\Tools $tools) {
                $tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary batch-print" data-batch-type="inbound" data-title="批量打印出库单">&nbsp;&nbsp;&nbsp;<i class="fa fa-print"></i> 批量打印出库单&nbsp;&nbsp;&nbsp;</a>');
            });*/
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(Modal::make()
                    // 大号弹窗
                    ->lg()
                    // 弹窗标题
                    ->title('上传订单')
                    // 按钮
                    ->button('<button class="btn btn-warning"><i class="feather icon-upload"></i> 导入订单</button>')
                    // 弹窗内容
                    ->body(OrderImportForm::make()));
                $tools->append(Modal::make()
                    // 大号弹窗
                    ->lg()
                    // 弹窗标题
                    ->title('导入订单图片')
                    // 按钮
                    ->button('<button class="btn btn-success"><i class="feather icon-image"></i> 导入订单图片</button>')
                    // 弹窗内容
                    ->body(OrderImageImportForm::make()));

                //$tools->append('<a href="javascript:void(0);" class="btn btn-outline-primary btn-export" data-batch-type="inbound" data-title="导出数据">&nbsp;&nbsp;&nbsp;<i class="fa fa-download"></i> 导出数据&nbsp;&nbsp;&nbsp;</a>');

                // $tools->append(DownloadOrderTemplate::make()->setKey('test_question'));
                $tools->append('<button class="btn btn-danger btn-export" >&nbsp;&nbsp;&nbsp;<i class="fa fa-download"></i> 导出勾选的订单&nbsp;&nbsp;&nbsp;</button>');
                $tools->append('<a href="javascript:void(0);" class="btn btn-info batch-print" data-batch-type="inbound" data-title="批量打印出库单">&nbsp;&nbsp;&nbsp;<i class="fa fa-print"></i> 批量打印出库单&nbsp;&nbsp;&nbsp;</a>');
                $tools->append('<a href="javascript:void(0);" class="btn btn-cyan batch-copy" data-title="批量复制订单">&nbsp;&nbsp;&nbsp;<i class="fa fa-copy"></i> 批量复制订单&nbsp;&nbsp;&nbsp;</a>');

            });

            //$grid->option("quick_edit_button",'编辑');
            $grid->scrollbarX();
            $grid->fixColumns(0,-1);
            $grid->toolsWithOutline(false);
            $grid->paginate(6);
            //$grid->withBorder();
            //$grid->tableCollapse();
            //$grid->addTableClass(['table-text-center']);
            //$grid->enableDialogCreate();
            //$grid->setDialogFormDimensions('50%', '50%');

            $grid->hideColumns($this->hideColumns);

        });

    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    /*protected function detail($id)
    {
        return Show::make($id, new NewOrder(), function (Show $show) {
            $show->field('id');
            $show->field('images');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }*/

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new NewOrder(), function (Form $form) {
            $form->tab('订单信息', function (Form $form) {
                $form->text('system_number','系统单号')->default(time())->required();
                $form->text('platform_number','平台单号')->required();
                $form->text('platform','平台')->default('Manual')->readOnly();
                $form->text('store','店铺');
                $form->text('site','站点');
                $form->multipleImage("images","订单图片")->uniqueName()->saving(function ($paths){
                    return json_encode($paths);
                })->autoUpload();
                $form->text("status","生产进度")->required();
                //$form->select("status","生产进度")->options(NewOrder::$statues)->default($form->model()->status);

                $form->datetime("order_at","订购日期")->required();
                $form->datetime("payment_at","付款时间");
                $form->datetime("delivery_deadline","订单时限");
                $form->datetime("delivery_at","发货日期");
                $form->text("order_remarks","订单备注");
                $form->text("specify_remarks","特殊要求");
            });
       /*     `receiver_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '买家姓名',
  `receiver_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '买家邮件',
  `receiver_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '买家留言',
  `receiver_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '收件人',
  `receiver_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '电话',
  `receiver_country`*/
            $form->tab('地址信息', function (Form $form) {
                $form->text("receiver_username","买家姓名");
                $form->text("receiver_email","买家邮件");
                $form->text("receiver_name","收件人");
                $form->text("receiver_country","国家/地区");
                $form->text("receiver_provider","省/州");
                $form->text("receiver_city","城市");
                $form->text("receiver_district","区/县");
                $form->text("receiver_postcode","邮编");
                $form->text("receiver_house_number","门牌号");
                $form->text("receiver_phone","电话");
                $form->text("receiver_address1","地址");
            });
            $form->tab('订单金额', function (Form $form) {
                $form->text("currency","币种");
                $form->number("total_amount","订单总金额");
                $form->number("total_sku_amount","订单商品金额");
                $form->number("customer_paid_freight","客付运费");
                $form->number("outbound_cost","订单出库成本");
            });
            $form->tab('订单发货信息', function (Form $form) {
                $form->text("tracking_number","发货单号");
            });
            if(!$form->model()->exists || ($form->model()->exists && $form->model()->platform =='Manual')){
                $form->tab('定制内容', function (Form $form) {
                    $form->keyValue('order_data',"定制内容")->default([
                        "Sign Length" => "",
                        "Color of Sign" => "",
                        "1 Line Text" => "",
                        "2 or 3 Lines Sign Text" => "",
                        "Acrylic Board Shape" => "",
                        "Light Type" => "",
                        "Extra Operating" => "",
                    ])->saving(function ($v) {
                        return json_encode($v);
                    })->setKeyLabel("名称")->setValueLabel("备注");
                });
            }
        })->saving(function (Form $form){
            if(!empty($form->model())){
                $status = $form->model()->getOriginal("status");
                $currentStatus = $form->input('status');
                if($status != $currentStatus){
                    if(strpos($currentStatus, "补发") !== false){
                        OrderMonitor::orderUpdate("订单补发【{$form->model()->platform_number}】，订单链接：http://123.249.25.241/admin/mobile/order?order_number=".$form->model()->platform_number,"跟单");
                    }elseif (strpos($currentStatus, "改图") !== false){
                        OrderMonitor::orderUpdate("订单改图【{$form->model()->platform_number}】，订单链接：http://123.249.25.241/admin/mobile/order?order_number=".$form->model()->platform_number,"设计");
                    }elseif ($currentStatus == '可生产'){
                        OrderMonitor::orderUpdate("订单可生产【{$form->model()->platform_number}】，订单链接：http://123.249.25.241/admin/mobile/order?order_number=".$form->model()->platform_number,"跟单");
                    }
                }

            }
        })->saved(function(Form $form){
            $data = $form->updates();
            if($form->isCreating()){
                //设计
                OrderMonitor::orderUpdate("订单创建【{$data["platform_number"]}】，订单链接：http://123.249.25.241/admin/mobile/order?order_number=".$data["platform_number"],"设计");
            }
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
            $order = \App\Models\Order::create($orderData);
            \App\Models\Order::createOrderAttrData($order);
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

    public function printLabel(Request $request)
    {
        $label = new NewOrderLabel(['ids' => $request->get('ids')]);
        $pdf = $label->generate();
        $labelFilename = \Illuminate\Support\Str::uuid();
        $labelFilename =  $labelFilename . ".pdf";
        $filepath = storage_path("app/public/labels/" . $labelFilename);
        $pdf->Output($filepath, 'F');
        return [
            'status' => 0,
            'msg' => 'success',
            'url' => asset("storage/labels/" . $labelFilename)
        ];
    }

    public function batchCopy(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $orders = \App\Models\NewOrder::query()->whereIn('id',$ids)->get();
            foreach ($orders as $order){
                $newOrder = $order->replicate([
                    'system_number'
                ]);
                $newOrder->system_number = time().rand(0,10000);
                $newOrder->save();
            }
            return [
                'status' => 0,
                'msg' => 'success'
            ];
        }catch (\Exception $exception){
            return [
                'status' => 1,
                'msg' => $exception->getMessage()
            ];
        }
    }

    public function uploadDesignImage($id)
    {
        return NewOrderResignImageUpload::form($id)->update($id);
    }
    public function updateDesignImage($id)
    {
        return NewOrderResignImageUpload::form($id)->update($id,null,"new-orders");
    }

    public function export(Request $request)
    {
        $ids = $request->get("ids");
        $ids = explode(",", $ids);
        return \Maatwebsite\Excel\Facades\Excel::download(new OrderExport($ids), date("Ymdhis").'-order.xlsx');
    }
}
