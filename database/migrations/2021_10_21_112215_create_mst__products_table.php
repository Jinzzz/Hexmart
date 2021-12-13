<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__products', function (Blueprint $table) {
            $table->bigincrements('product_id');
            $table->string('product_name', 250)->nullable();
            $table->string('product_name_slug', 250)->nullable();
            $table->string('product_code', 150)->nullable();
            $table->biginteger('item_category_id')->unsigned()->nullable();
            $table->biginteger('item_sub_category_id')->unsigned()->nullable();
            $table->biginteger('iltsc_id')->unsigned()->nullable();
            $table->biginteger('brand_id')->unsigned()->nullable();
            $table->decimal('product_price_regular', 10, 2)->nullable();
            $table->decimal('product_price_offer', 10, 2)->nullable();
            $table->longText('product_description')->nullable();
            $table->integer('min_stock')->nullable();
            $table->biginteger('tax_id')->unsigned()->nullable();

            $table->biginteger('product_type')->unsigned()->nullable();
            $table->biginteger('service_type')->unsigned()->nullable();

            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('item_category_id')->references('item_category_id')->on('mst__item_categories')->onUpdate('cascade');
            $table->foreign('iltsc_id')->references('iltsc_id')->on('mst__item_level_two_sub_categories')->onUpdate('cascade');
            $table->foreign('item_sub_category_id')->references('item_sub_category_id')->on('mst__item_sub_categories')->onUpdate('cascade');
            $table->foreign('brand_id')->references('brand_id')->on('mst__brands')->onUpdate('cascade');
            $table->foreign('tax_id')->references('tax_id')->on('mst__taxes')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst__products');
    }
}
