<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->default('')->nullable();
            $table->string('model')->index()->default('')->nullable();
            $table->string('barcode')->index()->default('')->nullable();
            $table->string('title')->index()->default('')->nullable();
            $table->json('product_images')->nullable();
            $table->json('size_images')->nullable();
            $table->text("norms")->nullable();
            $table->string('material')->nullable();
            $table->string('technology')->nullable();
            $table->string('color')->nullable();
            $table->decimal('inner_box_length',6,2)->nullable();
            $table->decimal('inner_box_width',6,2)->nullable();
            $table->decimal('inner_box_height',6,2)->nullable();
            $table->decimal('inner_box_gross_weight',8,3)->nullable();
            $table->integer('inner_box_packing_qty')->nullable();
            $table->decimal('outer_box_length',6,2)->nullable();
            $table->decimal('outer_box_width',6,2)->nullable();
            $table->decimal('outer_box_height',6,2)->nullable();
            $table->decimal('outer_box_gross_weight',8,3)->nullable();
            $table->integer('outer_box_packing_qty')->nullable();
            $table->text('remarks')->nullable();
            $table->json('attachment')->nullable();
            $table->json('production_detail_images')->nullable();
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
        Schema::dropIfExists('products');
    }
}
