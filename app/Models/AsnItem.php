<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AsnItem extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'asn_items';

    protected $fillable = [
        'sku_id',
        'asn_id',
        'batch',
        'estimated_qty',
        'received_qty',
        'put_away_qty',
        'receive_at',
        'put_away_at',
        'confirm_at',
        'uuid'
    ];


}
