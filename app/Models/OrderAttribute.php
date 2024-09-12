<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'size',
        'color',
        'shape',
        'light_type',
        'icons',
        'notes'
    ];
    public function getCustomColorAttribute($value)
    {
        $color = "";
        foreach (json_decode($this->color,true) as $item) {
            if($item['type'] == "ColorCustomization"){
                $color = $item['colorSelection']['name'];
            }
        }
        return $color;
    }
    public function getCustomShapeAttribute($value)
    {
        $shape = json_decode($this->shape,true);
        return $shape['displayValue'];
    }
    public function getCustomSizeAttribute($value)
    {
        $size = json_decode($this->size,true);
        return $size['displayValue'];
    }

}
