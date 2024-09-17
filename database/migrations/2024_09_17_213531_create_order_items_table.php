<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return false;
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->json('images')->nullable()->comment('订单图片');
            $table->json('design_images')->nullable()->comment('设计图');
            $table->string('sku')->nullable();
            $table->string('sku_name')->nullable()->comment('品名');
            $table->string('m_sku')->nullable()->comment('MSKU');
            $table->string('asin')->nullable()->comment('ASIN/商品Id');
            $table->string('order_sku_id')->nullable()->comment('订单商品ID');
            $table->string('sku_title')->nullable()->comment('商品标题');
            $table->string('variant_attribute')->nullable()->comment('变体属性');
            $table->decimal('unit_price',8,2)->default(0)->comment('单价');
            $table->integer('qty')->default(1)->comment('数量');
            $table->text('remarks')->nullable()->comment('商品备注');
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
        return false;
        Schema::dropIfExists('order_items');
    }
}
