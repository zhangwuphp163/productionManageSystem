<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string|null $order_number
 * @property string|null $order_date
 * @property int $quantity
 * @property string $status
 * @property string|null $tracking_number
 * @property string|null $delivery_date
 * @property mixed|null $order_data
 * @property mixed|null $images
 * @property string|null $receive_name
 * @property string|null $receive_phone
 * @property string|null $receive_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remarks
 * @property string|null $specify_remarks
 * @property mixed|null $design_images
 * @property-read \App\Models\OrderAttribute|null $attr
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDesignImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiveAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiveName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        "order_number",
        "order_date",
        "order_data",
        "quantity",
        "status",
        "images",
        "receive_name",
        "receive_phone",
        "receive_address",
        "delivery_date",
        "tracking_number",
        "remarks",
        "design_images",
        "specify_remarks"
    ];
    public static $statues = [
        'new' => '可生产',
        'opening_board' => '开板中',
        'production_completed' => '生产完成',
        'posted' => '可贴单',
        'shipped' => '已发货',
        'cancel' => '已取消',
    ];

    public function attr()
    {
        return $this->hasOne(OrderAttribute::class);
    }

    public static function createOrderAttrData($order){
        $attrData = [];
        if(!empty($order->order_data)){
            $orderData = json_decode($order->order_data,true);
            foreach ($orderData['customizationData']['children'] as $row){
                if($row['type'] == "PreviewContainerCustomization"){
                    foreach ($row["children"] as $child){
                        if($child['type'] == "FlatContainerCustomization"){
                            foreach ($child["children"] as $child2){
                                if($child2['type'] == "ContainerCustomization"){
                                    $attrData['color'] = json_encode($child2["children"]);
                                }elseif ($child2['label'] == 'Light Type'){
                                    $attrData['light_type'] = json_encode($child2);
                                }elseif ($child2['label'] == 'Acrylic Board Shape'){
                                    $attrData['shape'] = json_encode($child2);
                                }elseif ($child2['label'] == 'ADD ICONS'){
                                    $attrData['icons'] = json_encode($child2);
                                }elseif ($child2['label'] == 'Special Notes'){
                                    $attrData['notes'] = json_encode($child2);
                                }elseif (strpos($child2["label"], "Sign Length") !== false){
                                    $attrData['size'] = json_encode($child2);
                                }
                            }
                        }
                    }
                }
            }
        }
        $attrData['order_id'] = $order->id;
        OrderAttribute::create($attrData);
    }

}
