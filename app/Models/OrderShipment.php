<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'order_shipments';
    protected $fillable = [
        'order_id',
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
