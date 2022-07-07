<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__customer_addresses', function (Blueprint $table) {
            $table->bigincrements('customer_address_id');
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->string('pincode')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('house')->nullable();
            $table->string('street')->nullable();
            $table->string('landmark')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->tinyInteger('is_home_address')->default(0);
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')
                ->on('mst__customers')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__customer_addresses');
    }
}
