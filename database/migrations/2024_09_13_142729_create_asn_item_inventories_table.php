<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnItemInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn_item_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asn_item_id')->index();
            $table->integer('sku_id')->index();
            $table->integer('inventory_id')->index();
            $table->integer('receive_qty')->default('0');
            $table->dateTime('receive_at')->index();
            $table->dateTime('confirm_at')->index()->nullable();
            $table->dateTime('put_away_at')->index()->nullable();
            $table->dateTime('location_id')->index()->nullable();
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
        Schema::dropIfExists('asn_item_inventories');
    }
}
