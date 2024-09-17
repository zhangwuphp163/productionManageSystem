<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
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
    ];

}
