<?php

namespace App\Admin\Forms;

use App\Models\NewOrder;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderShipment;
use Dcat\EasyExcel\Excel;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;

class OrderImportForm extends Form
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
            DB::beginTransaction();
            $file_path = storage_path('app/public/' . $input['import_file']);
            $data = Excel::import($file_path)->toArray();

            $ordersData = [];
            foreach ($data['sheet1'] as $row){
                $data = self::generateOrder($row);
                $skus = $ordersData[$data['order_number']]['skus']??[];

                if(!empty($data['order']['system_number'])){
                    $ordersData[$data['order_number']] = $data['order'];
                }
                if(empty($skus)){
                    $skus = [$data['sku']];
                }else{
                    array_push($skus,$data['sku']);
                }
                $ordersData[$data['order_number']]['skus'] = $skus;
            }
            foreach ($ordersData as $order){
                foreach ($order['skus'] as  $sku){
                    $createOrderData =  array_merge($order,$sku);
                    unset($createOrderData['skus']);
                    NewOrder::create($createOrderData);
                }
            }
            DB::commit();
            return $this->response()->success('ok')->refresh();
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->response()->error($exception->getMessage())->refresh();
        }

    }

    private static function generateOrder($row){
        $orderData = [
            'system_number' => $row['系统单号']??null,
            'platform' => $row['平台']??null,
            'store' => $row['店铺']??null,
            'site' => $row['站点']??null,
            'customer_remarks' => $row['客服备注']??null,
            'order_at' => !empty($row['订购时间'])?$row['订购时间']:null,
            'payment_at' => !empty($row['付款时间'])?$row['付款时间']:null,
            'delivery_deadline' => !empty($row['发货时限'])?$row['发货时限']:null,
            'delivery_at' => !empty($row['发货时间'])?$row['发货时间']:null,
            'platform_number' => $row['平台单号']??null,
            'currency' => $row['订单币种']??null,
            'total_amount' => !empty($row['订单总金额'])?$row['订单总金额']:0,
            'total_sku_amount' => !empty($row['订单商品金额'])?$row['订单商品金额']:0,
            'customer_paid_freight' => !empty($row['客付运费'])?$row['客付运费']:0,
            'outbound_cost' => !empty($row['订单出库成本(CNY)'])?$row['订单出库成本(CNY)']:0,

            'receiver_username' => $row['买家姓名']??null,
            'receiver_email' => $row['买家邮箱']??null,
            'receiver_remarks' => $row['买家留言']??null,
            'receiver_name' => $row['收件人']??null,
            'receiver_phone' => $row['电话']??null,
            'receiver_country' => $row['国家/地区']??null,
            'receiver_provider' => $row['省/州']??null,
            'receiver_city' => $row['城市']??null,
            'receiver_district' => $row['区/县']??null,
            'receiver_postcode' => $row['邮编']??null,
            'receiver_house_number' => $row['门牌号']??null,
            'receiver_address_type' => $row['地址类型']??null,
            'receiver_company' => $row['公司名']??null,
            'receiver_address1' => $row['地址行1']??null,
            'receiver_address2' => $row['地址行2']??null,
            'receiver_address3' => $row['地址行3']??null,

            'logistics_provider' => $row["客选物流"]??null,
            'delivery_warehouse' => $row["发货仓库"]??null,
            'logistics_method' => $row["物流方式"]??null,
            'waybill_number' => $row["运单号"]??null,
            'tracking_number' => $row["跟踪号"]??null,
            'tag_number' => $row["标发号"]??null,
            'estimated_weight' => !empty($row["预估重量(g)"])?$row["预估重量(g)"]:0,
            'estimated_length' => !empty($row["预估尺寸长(cm)"])?$row["预估尺寸长(cm)"]:0,
            'estimated_width' => !empty($row["预估尺寸宽(cm)"])?$row["预估尺寸宽(cm)"]:0,
            'estimated_height' => !empty($row["预估尺寸高(cm)"])?$row["预估尺寸高(cm)"]:0,
            'estimated_cost_weight' => !empty($row["预估计费重(g)"])?$row["预估计费重(g)"]:0,
            'estimated_shipping_cost' => !empty($row["预估运费(CNY)"])?$row["预估运费(CNY)"]:0,
        ];
        $sku = [
            'sku' => $row['SKU']??null,
            'sku_name' => $row['品名']??null,
            'm_sku' => $row['MSKU']??null,
            'asin' => $row['ASIN/商品Id']??null,
            'order_sku_id' => $row['订单商品ID']??null,
            'sku_title' => $row['商品标题']??null,
            'variant_attribute' => $row['变体属性']??null,
            'unit_price' => !empty($row['单价'])?$row['单价']:null,
            'qty' => !empty($row['数量'])?$row['数量']:1,
            'remarks' => $row['商品备注']??null
        ];
        return ['order' => $orderData,'sku' => $sku,'order_number' => $orderData['platform_number']];
        //return NewOrder::create($orderData);
    }
    private static function generateOrderItem($order,$row){
        $itemData = [
            'order_id' => $order->id??null,
            'sku' => $row['SKU']??null,
            'sku_name' => $row['品名']??null,
            'm_sku' => $row['MSKU']??null,
            'asin' => $row['ASIN/商品Id']??null,
            'order_sku_id' => $row['订单商品ID']??null,
            'sku_title' => $row['商品标题']??null,
            'variant_attribute' => $row['变体属性']??null,
            'unit_price' => $row['单价']??null,
            'qty' => $row['数量']??1,
            'remarks' => $row['商品备注']??null,
        ];
        OrderItem::create($itemData);
    }
    private static function generateOrderAddress($order,$row){
        $addressData = [
            'order_id' => $order->id??null,
            'receiver_username' => $row['买家姓名']??null,
            'receiver_email' => $row['买家邮箱']??null,
            'receiver_remarks' => $row['买家留言']??null,
            'receiver_name' => $row['收件人']??null,
            'receiver_phone' => $row['电话']??null,
            'receiver_country' => $row['国家/地区']??null,
            'receiver_provider' => $row['省/州']??null,
            'receiver_city' => $row['城市']??null,
            'receiver_district' => $row['区/县']??null,
            'receiver_postcode' => $row['邮编']??null,
            'receiver_house_number' => $row['门牌号']??null,
            'receiver_address_type' => $row['地址类型']??null,
            'receiver_company' => $row['公司名']??null,
            'receiver_address1' => $row['地址行1']??null,
            'receiver_address2' => $row['地址行2']??null,
            'receiver_address3' => $row['地址行3']??null,

        ];
        return OrderAddress::create($addressData);
    }
    private static function generateOrderShipment($order,$row){
        $shipmentData = [
            'order_id' => $order->id??null,
            'logistics_provider' => $row["客选物流"]??null,
            'delivery_warehouse' => $row["发货仓库"]??null,
            'logistics_method' => $row["物流方式"]??null,
            'waybill_number' => $row["运单号"]??null,
            'tracking_number' => $row["跟踪号"]??null,
            'tag_number' => $row["标发号"]??null,
            'estimated_weight' => $row["预估重量(g)"]??0,
            'estimated_length' => $row["预估尺寸长(cm)"]??0,
            'estimated_width' => $row["预估尺寸宽(cm)"]??0,
            'estimated_height' => $row["预估尺寸高(cm)"]??0,
            'estimated_cost_weight' => $row["预估计费重(g)"]??0,
            'estimated_shipping_cost' => $row["预估运费(CNY)"]??0,
        ];
        return OrderShipment::create($shipmentData);
    }
    /**
     * Build a form here.
     */
    public function form()
    {
        // 禁用重置表单按钮
        $this->disableResetButton();

        // 文件上传
        $this->file('import_file', ' ')
            ->disk('public')
            ->accept('xls,xlsx,csv')
            ->uniqueName()
            ->autoUpload()
            ->move('/import')
            ->help('支持xls,xlsx,csv');
    }
}
