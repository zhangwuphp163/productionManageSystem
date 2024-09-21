<?php

namespace App\Admin\Repositories;

use App\Models\NewOrder as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Show;
use Illuminate\Contracts\Support\Arrayable;

class NewOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function detail($id)
    {
        return Show::make($id, new \App\Models\NewOrder(), function (Show $show) {

            $show->field('system_number');
            $show->field('platform_number');
            /*
             * $show->field('platform');
            $show->field('store');
            $show->field('site');
            $show->field('source');
            $show->field('customer_remarks');
            $show->field('order_type');
            $show->field('order_at');
            $show->field('payment_at');
            $show->field('delivery_deadline');
            $show->field('delivery_at');
            $show->field('currency');
            $show->field('total_amount');
            $show->field('total_sku_amount');
            $show->field('customer_paid_freight');
            $show->field('outbound_cost');
            $show->field('sku');
            $show->field('sku_name');
            $show->field('m_sku');
            $show->field('asin');
            $show->field('order_sku_id');
            $show->field('sku_title');
            $show->field('variant_attribute');
            $show->field('unit_price');
            $show->field('unit_price');
            $show->field('sku_remarks');
            */
            $show->field('status');
            $show->field('order_remarks');
            $show->field('images')->image();
            $show->field('design_images')->image();
            $show->field('shipment_images','包裹图片')->image();
            $show->field('qty');
            $show->field('receiver_username');
            $show->field('receiver_email');
            $show->field('receiver_remarks');
            $show->field('receiver_name');
            $show->field('receiver_phone');
            $show->field('receiver_country');
            $show->field('receiver_provider');
            $show->field('receiver_city');
            $show->field('receiver_district');
            $show->field('receiver_postcode');
            $show->field('receiver_house_number');
            $show->field('receiver_address_type');
            $show->field('receiver_company');
            $show->field('receiver_address1');
            $show->field('receiver_address2');
            $show->field('receiver_address3');
            $show->field('logistics_provider');
            $show->field('delivery_warehouse');
            $show->field('logistics_method');
            $show->field('waybill_number');
            $show->field('tracking_number');
            $show->field('tag_number');
            $show->field('estimated_weight');
            $show->field('estimated_length');
            $show->field('estimated_width');
            $show->field('estimated_height');
            $show->field('estimated_cost_weight');
            $show->field('estimated_shipping_cost');
            $show->disableListButton();
            $show->disableDeleteButton();
            $show->disableEditButton();
        });
    }
}
