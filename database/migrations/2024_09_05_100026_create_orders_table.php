<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number',64)->index()->nullable();
            $table->date('order_date')->nullable()->index();
            $table->integer('quantity')->default(1);
            $table->string('status',32)->default('new')->index();
            $table->json('order_data')->nullable();
            $table->json('images')->nullable();
            $table->index('created_at');
            $table->string('receive_name')->nullable();
            $table->string('receive_phone',32)->nullable();
            $table->text('receive_address')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
