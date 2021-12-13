<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstOfferZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__offer_zones', function (Blueprint $table) {
            $table->bigincrements('offer_id');
            $table->biginteger('product_variant_id')->unsigned()->nullable();
            $table->integer('offer_price')->nullable();
            $table->date('date_start')->nullable();
            $table->string('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('time_end')->nullable();
            $table->text('link')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('mst__offer_zones');
    }
}
