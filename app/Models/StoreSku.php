<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StoreSku extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'store_skus';

    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
