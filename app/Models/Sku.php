<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;
    protected $with = ['category'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
