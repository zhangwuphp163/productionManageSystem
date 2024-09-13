<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Asn extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    public function items()
    {
        return $this->hasMany(AsnItem::class);
    }

}
