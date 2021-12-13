<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstDeliveryBoysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__delivery_boys', function (Blueprint $table) {
            $table->bigincrements('delivery_boy_id')->nullable();
            $table->string('delivery_boy_name')->nullable();
            $table->string('delivery_boy_phone')->nullable();
            $table->string('password')->nullable();
            $table->string('delivery_boy_email')->nullable();
            $table->text('delivery_boy_address')->nullable();

            $table->biginteger('state_id')->unsigned()->nullable();
            $table->biginteger('district_id')->unsigned()->nullable();
            $table->biginteger('town_id')->unsigned()->nullable();


            $table->tinyInteger('is_online')->default(0);
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
        Schema::dropIfExists('mst__delivery_boys');
    }
}
