<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sku_id')->index();
            $table->integer('asn_id')->index();
            $table->integer('asn_item_id')->index();
            $table->integer('order_id')->index()->nullable();
            $table->integer('location_id')->index()->nullable();
            $table->string('condition')->index()->default('GOOD');
            $table->dateTime('receive_at')->index();
            $table->dateTime('put_away_at')->index()->nullable();
            $table->dateTime('confirm_at')->index()->nullable();
            $table->dateTime('allocate_at')->index()->nullable();
            $table->dateTime('pick_wave_at')->index()->nullable();
            $table->dateTime('pick_at')->index()->nullable();
            $table->dateTime('pack_at')->index()->nullable();
            $table->dateTime('sorting_at')->index()->nullable();
            $table->dateTime('second_sort_at')->index()->nullable();
            $table->dateTime('handover_at')->index()->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
