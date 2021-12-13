<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__product_variants', function (Blueprint $table) {
            $table->bigincrements('product_variant_id');
            $table->biginteger('product_id')->unsigned()->nullable();
            $table->string('variant_name', 250)->nullable();
            $table->string('variant_name_slug', 250)->nullable();
            $table->decimal('variant_price_regular',10,2)->nullable();
            $table->decimal('variant_price_offer',10,2)->nullable();
            $table->integer('stock_count')->nullable();
            $table->biginteger('unit_id')->unsigned()->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('unit_id')->references('unit_id')->on('mst__units')->onUpdate('cascade');
            $table->timestamps();

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
        Schema::dropIfExists('mst__product_variants');
    }
}
