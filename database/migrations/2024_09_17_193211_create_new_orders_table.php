<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_orders', function (Blueprint $table) {
            $table->id();
            $table->string('system_number')->index()->comment('系统单号');
            $table->string('status')->index()->default("可生产")->nullable();
            $table->string('platform')->index()->default("Amazon")->comment('平台');
            $table->string('store')->index()->nullable()->comment('店铺');
            $table->string('site')->index()->nullable()->comment('站点');
            $table->string('customer_remarks')->nullable()->comment('客服备注');
            $table->string('source')->nullable()->default('online')->comment('订单来源');
            $table->string('order_type')->default("single")->comment('订单类型');
            $table->timestamp('order_at')->nullable()->index()->comment('订购时间');
            $table->timestamp('payment_at')->nullable()->comment('付款时间')->index();
            $table->timestamp('delivery_deadline')->nullable()->comment('发货时限');
            $table->timestamp('delivery_at')->nullable()->comment('发货时间')->index();
            $table->string('platform_number')->index()->comment('平台订单号');
            $table->string('currency')->nullable()->comment('币种');
            $table->decimal('total_amount',8,2)->default(0)->comment('订单总金额')->nullable();
            $table->decimal('total_sku_amount',8,2)->default(0)->comment('订单商品金额')->nullable();
            $table->decimal('customer_paid_freight',8,2)->default(0)->comment('客付运费')->nullable();
            $table->decimal('outbound_cost',8,2)->default(0)->comment('订单出库成本')->nullable();
            $table->text('order_remarks')->nullable()->comment('订单备注');
            $table->json('images')->nullable()->comment('订单图片');
            $table->json('design_images')->nullable()->comment('设计图');
            $table->string('sku')->nullable();
            $table->string('sku_name')->nullable()->comment('品名');
            $table->string('m_sku')->nullable()->comment('MSKU');
            $table->string('asin')->nullable()->comment('ASIN/商品Id');
            $table->string('order_sku_id')->nullable()->comment('订单商品ID');
            $table->string('sku_title')->nullable()->comment('商品标题');
            $table->string('variant_attribute')->nullable()->comment('变体属性');
            $table->decimal('unit_price',8,2)->default(0)->comment('单价')->nullable();
            $table->integer('qty')->default(1)->comment('数量')->nullable();
            $table->text('sku_remarks')->nullable()->comment('商品备注');
            $table->string('receiver_username')->nullable()->comment('买家姓名');
            $table->string('receiver_email')->nullable()->comment('买家邮件');
            $table->string('receiver_remarks')->nullable()->comment('买家留言');
            $table->string('receiver_name')->nullable()->comment('收件人');
            $table->string('receiver_phone')->nullable()->comment('电话');
            $table->string('receiver_country')->nullable()->comment('国家/地区');
            $table->string('receiver_provider')->nullable()->comment('省/州');
            $table->string('receiver_city')->nullable()->comment('城市');
            $table->string('receiver_district')->nullable()->comment('区/县');
            $table->string('receiver_postcode')->nullable()->comment('邮编');
            $table->string('receiver_house_number')->nullable()->comment('门牌号');
            $table->string('receiver_address_type')->nullable()->comment('地址类型');
            $table->string('receiver_company')->nullable()->comment('公司名');
            $table->string('receiver_address1')->nullable()->comment('地址行1');
            $table->string('receiver_address2')->nullable()->comment('地址行2');
            $table->string('receiver_address3')->nullable()->comment('地址行3');
            $table->string('logistics_provider')->nullable()->comment('客选物流');
            $table->string('delivery_warehouse')->nullable()->comment('发货仓库');
            $table->string('logistics_method')->nullable()->comment('物流方式');
            $table->string('waybill_number')->nullable()->index()->comment('运单号');
            $table->string('tracking_number')->nullable()->index()->comment('跟踪号');
            $table->string('tag_number')->nullable()->index()->comment('标发号');
            $table->integer('estimated_weight')->default(0)->comment('预估重量(g)')->nullable();
            $table->decimal('estimated_length',6,1)->default(0)->comment('预估尺寸长(cm)')->nullable();
            $table->decimal('estimated_width',6,1)->default(0)->comment('预估尺寸宽(cm)')->nullable();
            $table->decimal('estimated_height',6,1)->default(0)->comment('预估尺寸高(cm)')->nullable();
            $table->integer('estimated_cost_weight')->default(0)->comment('预估计费重(g)')->nullable();
            $table->decimal('estimated_shipping_cost',8,2)->default(0)->comment('预估运费(CNY)')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_orders');
    }
}
