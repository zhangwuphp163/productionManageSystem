<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'order_address';
    protected $fillable = [
        'order_id',
        'receiver_username',
        'receiver_email',
        'receiver_remarks',
        'receiver_name',
        'receiver_phone',
        'receiver_country',
        'receiver_provider',
        'receiver_city',
        'receiver_district',
        'receiver_postcode',
        'receiver_house_number',
        'receiver_address_type',
        'receiver_company',
        'receiver_address1',
        'receiver_address2',
        'receiver_address3',
    ];

}
