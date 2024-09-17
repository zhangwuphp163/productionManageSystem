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
        'remarks',

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
        'tag_number',
        'estimated_weight',
        'estimated_length',
        'estimated_width',
        'estimated_height',
        'estimated_cost_weight',
        'estimated_shipping_cost',
    ];
}
