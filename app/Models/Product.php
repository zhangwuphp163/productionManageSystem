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

    public function getPriceAttribute($value){
        if (!empty(Admin::user()) && Admin::user()->can('product-price')){
            return $value;
        }
        return "*";
    }

}
