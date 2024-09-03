<?php

namespace App\Models;

use Dcat\Admin\Form;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $with = ['sku'];
    protected $fillable = [
        'sku_id',
        'qty',
        'inbound_at',
        'type'
    ];
    public function sku(){
        return $this->belongsTo(Sku::class);
    }
}
