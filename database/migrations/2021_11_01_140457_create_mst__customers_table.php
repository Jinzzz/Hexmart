<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__customers', function (Blueprint $table) {

            $table->bigincrements('customer_id');
            $table->string('customer_name', 150)->nullable();
            $table->string('customer_email', 150)->nullable();
            $table->string('customer_mobile', 30)->nullable();
            $table->string('customer_gender', 30)->nullable();
            $table->date('customer_dob')->nullable();
            $table->string('password')->nullable();

            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('place', 150)->nullable();

            $table->double('otp')->default(0);
            $table->timestamp('otp_genarated_time')->nullable();
            $table->tinyInteger('is_otp_verified')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();

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
        Schema::dropIfExists('mst__customers');
    }
}
