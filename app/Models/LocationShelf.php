<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LocationShelf
 *
 * @property int $id
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationShelf withoutTrashed()
 * @mixin \Eloquent
 */
class LocationShelf extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'location_shelfs';
    protected $fillable = [
        'code'
    ];

}
