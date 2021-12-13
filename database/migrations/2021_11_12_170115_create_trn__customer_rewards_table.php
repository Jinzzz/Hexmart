<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnCustomerRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__customer_rewards', function (Blueprint $table) {
            $table->bigincrements('customer_reward_id');
            $table->integer('reward_points_earned')->nullable();
            $table->text('discription')->nullable();
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->biginteger('order_id')->unsigned()->nullable();
            $table->date('added_date')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
            $table->foreign('order_id')->references('order_id')->on('trn__orders')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__customer_rewards');
    }
}
