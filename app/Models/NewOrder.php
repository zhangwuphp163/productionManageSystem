<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NewOrder extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'new_orders';

    protected $fillable = [
        'system_number',
        'status',
        'platform',
        'store',
        'site',
        'customer_remarks',
        'source',
        'order_type',
        'order_at',
        'payment_at',
        'delivery_deadline',
        'delivery_at',
        'platform_number',
        'currency',
        'total_amount',
        'total_sku_amount',
        'customer_paid_freight',
        'outbound_cost',
        'order_remarks',

        'images',
        'design_images',
        'sku',
        'sku_name',
        'm_sku',
        'asin',
        'order_sku_id',
        'sku_title',
        'variant_attribute',
        'unit_price',
        'qty',
        'sku_remarks',

        'receiver_username',
        'receiver_email',
        'receiver_remarks',
        'receiver_name',
        'receiver_phone',
        'receiver_country',
        'receiver_provider',
        'receiver_city',
        'receiver_district',
        'receiver_postcode',
        'receiver_house_number',
        'receiver_address_type',
        'receiver_company',
        'receiver_address1',
        'receiver_address2',
        'receiver_address3',

        'logistics_provider',
        'delivery_warehouse',
        'logistics_method',
        'waybill_number',
        'tracking_number',
        'shipment_images',
        'tag_number',
        'estimated_weight',
        'estimated_length',
        'estimated_width',
        'estimated_height',
        'estimated_cost_weight',
        'estimated_shipping_cost',
        'order_data',
        'specify_remarks'
    ];

    public static $statues = [
        '可生产' => '可生产',
        '开板中' => '开板中',
        '生产完成' => '生产完成',
        '可贴单' => '可贴单',
        '已发货' => '已发货',
        '已取消' => '已取消',
    ];
}
