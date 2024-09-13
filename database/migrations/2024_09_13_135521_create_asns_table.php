<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asn_number')->unique()->default('');
            $table->string('status')->index()->default('pending');
            $table->date('eta_at')->index()->nullable();
            $table->date('ata_at')->index()->nullable();
            $table->string('remarks')->nullable();
            $table->dateTime('sign_in_at')->index()->nullable();
            $table->dateTime('start_receive_at')->index()->nullable();
            $table->string('invoice_tax_number')->nullable();
            $table->dateTime('confirm_at')->index()->nullable();
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
        Schema::dropIfExists('asns');
    }
}
