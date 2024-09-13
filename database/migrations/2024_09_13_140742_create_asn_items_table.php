<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asn_id')->index();
            $table->integer('sku_id')->index();
            $table->string('batch')->nullable();
            $table->integer('estimated_qty')->default('0');
            $table->integer('received_qty')->default('0');
            $table->integer('put_away_qty')->default('0');
            $table->dateTime('receive_at')->index()->nullable();
            $table->dateTime('put_away_at')->index()->nullable();
            $table->dateTime('confirm_at')->index()->nullable();
            $table->string('uuid')->index()->default('');
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
        Schema::dropIfExists('asn_items');
    }
}
