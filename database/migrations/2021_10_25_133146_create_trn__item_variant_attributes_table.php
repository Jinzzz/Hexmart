<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnItemVariantAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__item_variant_attributes', function (Blueprint $table) {
            $table->bigincrements('variant_attribute_id');
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->biginteger('attribute_group_id')->unsigned()->nullable();
            $table->biginteger('attribute_value_id')->unsigned()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('product_id')->references('product_id')->on('mst__products')->onUpdate('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('mst__product_variants')->onUpdate('cascade');
            $table->foreign('attribute_group_id')->references('attribute_group_id')->on('mst__attribute_groups')->onUpdate('cascade');
            $table->foreign('attribute_value_id')->references('attribute_value_id')->on('mst__attribute_values')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__item_variant_attributes');
    }
}
