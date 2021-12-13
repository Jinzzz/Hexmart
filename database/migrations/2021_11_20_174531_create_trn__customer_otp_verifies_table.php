<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnCustomerOtpVerifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__customer_otp_verifies', function (Blueprint $table) {
            $table->bigincrements('customer_otp_id');
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->string('otp_expirytime', 45);
            $table->string('otp', 45);
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__customer_otp_verifies');
    }
}
