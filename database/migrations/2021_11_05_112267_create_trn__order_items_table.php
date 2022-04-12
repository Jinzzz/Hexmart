<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__order_items', function (Blueprint $table) {
            $table->bigincrements('order_item_id');
            $table->biginteger('order_id')->unsigned()->nullable();
            $table->string('order_number', 50)->nullable();
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->biginteger('offer_id')->unsigned()->nullable();
            $table->tinyInteger('is_offer_item')->default(0);
            $table->tinyInteger('is_store_ticked')->default(0);
            $table->tinyInteger('is_db_ticked')->default(0);
            $table->text('order_status_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('trn__orders')->onUpdate('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
            $table->foreign('product_id')->references('product_id')->on('mst__products')->onUpdate('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('mst__product_variants')->onUpdate('cascade');
            $table->foreign('offer_id')->references('offer_id')->on('mst__offer_zones')->onUpdate('cascade');
            $table->timestamp('deleted_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__order_items');
    }
}
