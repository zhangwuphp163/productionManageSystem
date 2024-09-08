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
    ];

}
