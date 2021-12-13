<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__coupons', function (Blueprint $table) {
            $table->bigincrements('coupon_id')->nullable();
            $table->string('coupon_code', 200)->nullable();
            $table->integer('coupon_type')->nullable();
            $table->decimal('min_purchase_amt', 8, 2)->nullable();
            $table->integer('discount_type')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->tinyInteger('coupon_status')->default(0)->nullable();
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
        Schema::dropIfExists('mst__coupons');
    }
}
