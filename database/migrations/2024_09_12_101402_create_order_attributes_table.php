<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->unique();
            $table->json('size')->nullable()->comment("尺寸");
            $table->json('color')->nullable()->comment("颜色");
            $table->json('shape')->nullable()->comment("形状");
            $table->json('light_type')->nullable()->comment("灯光类型");
            $table->json('icons')->nullable()->comment("图标");
            $table->json('notes')->nullable()->comment("其他行文本");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_attibutes');
    }
}
