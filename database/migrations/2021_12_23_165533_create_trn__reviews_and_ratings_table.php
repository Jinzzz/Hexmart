<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnReviewsAndRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__reviews_and_ratings', function (Blueprint $table) {
            $table->bigincrements('rar_id');
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->decimal('rating', 8, 2)->nullable();
            $table->text('review')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('mst__product_variants')->onUpdate('cascade');
            $table->foreign('product_id')->references('product_id')->on('mst__products')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__reviews_and_ratings');
    }
}
