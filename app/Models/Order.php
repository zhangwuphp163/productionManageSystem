<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    protected $fillable = [
        "order_number",
        "order_date",
        "order_data",
        "quantity",
        "status",
        "images",
        "receive_name",
        "receive_phone",
        "receive_address",
        "delivery_date",
        "tracking_number",
        "remarks",
        "design_images"
    ];
    public static $statues = [
        'new' => '可生产',
        'opening_board' => '开板中',
        'production_completed' => '生产完成',
        'posted' => '可贴单',
        'shipped' => '已发货',
        'cancel' => '已取消',
    ];

}
