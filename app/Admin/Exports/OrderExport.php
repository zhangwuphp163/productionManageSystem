<?php

namespace App\Admin\Exports;

use App\Models\NewOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection,WithHeadings
{

    public function collection()
    {
        $orders = NewOrder::query()->select([
            "platform_number",
            "logistics_method",
            "receiver_country",
            "receiver_name",
            "receiver_provider",
            "receiver_city",
            "receiver_address1",
            "receiver_phone",
            "receiver_email",
            "m_sku",
            "sku_name",
            "estimated_length",
            "estimated_width",
            "estimated_height"
        ])->get();
        $data = [];
        /** @var NewOrder $order */
        foreach ($orders as $order) {
            $data[] = [
                $order->platform_number,
                $order->logistics_method,
                $order->receiver_country,
                $order->receiver_name,
                $order->receiver_provider,
                $order->receiver_city,
                implode(",",array_filter([$order->receiver_address1,$order->receiver_address2,$order->receiver_address3])),
                $order->receiver_phone,
                $order->receiver_email,
                "",
                "IOSS",
                "",
                $order->m_sku,
                $order->sku_name,
                "",
                "",
                "1",
                $order->estimated_length,
                $order->estimated_width,
                $order->estimated_height
                ];
        }
        return  collect($data);
    }

    public function headings(): array
    {
        return [
            "客户单号",
            "运输方式",
            "目的国家",
            "收件人姓名",
            "州,省",
            "城市",
            "联系地址",
            "收件人电话",
            "收件人邮箱",
            "重量",
            "发件人税号类型（默认填'IOSS'）",
            "发件人税号",
            "英文品名",
            "中文品名",
            "英文品名",
            "配货信息1",
            "申报价值1",
            "申报品数量1",
            "海关编码",
            "长",
            "宽",
            "高",
        ];
    }
}
