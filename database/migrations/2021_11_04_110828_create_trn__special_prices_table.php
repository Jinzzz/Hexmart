<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnSpecialPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__special_prices', function (Blueprint $table) {
            $table->bigincrements('special_price_id');
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->biginteger('customer_group_id')->unsigned()->nullable();
            $table->decimal('special_price',10,2)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('product_id')->on('mst__products')->onUpdate('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('mst__product_variants')->onUpdate('cascade');
            $table->foreign('customer_group_id')->references('customer_group_id')->on('mst__customer_groups')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__special_prices');
    }
}
