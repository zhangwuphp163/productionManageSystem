<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_skus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id')->index();
            $table->unsignedInteger('product_id')->index();
            $table->string('title')->nullable()->index();
            $table->string('barcode')->nullable()->index();
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
        Schema::dropIfExists('store_skus');
    }
}
