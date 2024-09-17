<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return false;
        Schema::create('order_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->string('logistics_provider')->nullable()->comment('客选物流');
            $table->string('delivery_warehouse')->nullable()->comment('发货仓库');
            $table->string('logistics_method')->nullable()->comment('物流方式');
            $table->string('waybill_number')->nullable()->index()->comment('运单号');
            $table->string('tracking_number')->nullable()->index()->comment('跟踪号');
            $table->string('tag_number')->nullable()->index()->comment('标发号');
            $table->integer('estimated_weight')->default(0)->comment('预估重量(g)');
            $table->decimal('estimated_length',6,1)->default(0)->comment('预估尺寸长(cm)');
            $table->decimal('estimated_width',6,1)->default(0)->comment('预估尺寸宽(cm)');
            $table->decimal('estimated_height',6,1)->default(0)->comment('预估尺寸高(cm)');
            $table->integer('estimated_cost_weight')->default(0)->comment('预估计费重(g)');
            $table->decimal('estimated_shipping_cost',8,2)->default(0)->comment('预估运费(CNY)');
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
        Schema::dropIfExists('order_shipments');
    }
}
