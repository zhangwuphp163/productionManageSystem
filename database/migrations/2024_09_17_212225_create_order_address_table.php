<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return false;
        Schema::create('order_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->string('receiver_username')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_remarks')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_country')->nullable();
            $table->string('receiver_provider')->nullable();
            $table->string('receiver_city')->nullable();
            $table->string('receiver_district')->nullable();
            $table->string('receiver_postcode')->nullable();
            $table->string('receiver_house_number')->nullable();
            $table->string('receiver_address_type')->nullable();
            $table->string('receiver_company')->nullable();
            $table->string('receiver_address1')->nullable();
            $table->string('receiver_address2')->nullable();
            $table->string('receiver_address3')->nullable();
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
        Schema::dropIfExists('order_address');
    }
}
