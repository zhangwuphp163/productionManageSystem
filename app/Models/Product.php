<?php

namespace App\Models;

use Dcat\Admin\Admin;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    protected $fillable = [
        'name',
        'model',
        'norms',
        'material',
        'technology',
        'color',
        'price',
        'remarks',
        'inner_box_length',
        'inner_box_width',
        'inner_box_height',
        'inner_box_gross_weight',
        'inner_box_packing_qty',
        'outer_box_length',
        'outer_box_width',
        'outer_box_height',
        'outer_box_gross_weight',
        'outer_box_packing_qty',
        "product_images",
        "size_images",
        "production_detail_images",
        "attachment",
    ];

    public function getPriceAttribute($value){
        if (!empty(Admin::user()) && Admin::user()->can('product-price')){
            return $value;
        }
        return "*";
    }

}
