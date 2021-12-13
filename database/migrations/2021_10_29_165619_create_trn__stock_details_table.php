<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__stock_details', function (Blueprint $table) {
            $table->bigincrements('stock_detail_id');
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->integer('added_stock')->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('prev_stock')->nullable();
            $table->tinyInteger('is_added')->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('product_id')->on('mst__products')->onUpdate('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('mst__product_variants')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__stock_details');
    }
}
