<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__orders', function (Blueprint $table) {
            $table->bigincrements('order_id');
            $table->string('order_number', 50)->nullable();
            $table->biginteger('order_status_id')->unsigned()->nullable();
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->biginteger('time_slot_id')->unsigned()->nullable();
            $table->decimal('order_total_amount', 10, 2)->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->decimal('packing_charge', 10, 2)->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->biginteger('payment_type_id')->unsigned()->nullable();
            $table->biginteger('customer_address_id')->unsigned()->nullable();
            $table->biginteger('payment_status_id')->unsigned()->nullable();
            $table->biginteger('delivery_boy_id')->unsigned()->nullable();
            $table->biginteger('delivery_status_id')->unsigned()->nullable();
            $table->tinyInteger('db_accept_status')->default(0);
            $table->text('order_note')->nullable();
            $table->biginteger('order_type_id')->unsigned()->nullable();
            $table->biginteger('coupon_id')->unsigned()->nullable();
            $table->decimal('amount_reduced_by_coupon', 10, 2)->nullable();
            $table->integer('reward_points_used')->nullable();
            $table->decimal('amount_reduced_by_rp', 10, 2)->nullable();
            $table->string('transaction_id')->nullable();

            $table->foreign('order_status_id')->references('order_status_id')
                ->on('sys__order_statuses')->onUpdate('cascade');

            $table->foreign('customer_id')->references('customer_id')
                ->on('mst__customers')->onUpdate('cascade');

            $table->foreign('time_slot_id')->references('time_slot_id')
                ->on('mst__time_slots')->onUpdate('cascade');

            $table->foreign('payment_type_id')->references('payment_type_id')
                ->on('sys__payment_types')->onUpdate('cascade');

            $table->foreign('customer_address_id')->references('customer_address_id')
                ->on('trn__customer_addresses')->onUpdate('cascade');

            $table->foreign('payment_status_id')->references('payment_status_id')
                ->on('sys__payment_statuses')->onUpdate('cascade');

            $table->foreign('delivery_boy_id')->references('delivery_boy_id')
                ->on('mst__delivery_boys')->onUpdate('cascade');

            $table->foreign('delivery_status_id')->references('delivery_status_id')
                ->on('sys__delivery_statuses')->onUpdate('cascade');

            $table->foreign('order_type_id')->references('order_type_id')
                ->on('sys__order_types')->onUpdate('cascade');

            $table->foreign('coupon_id')->references('coupon_id')
                ->on('mst__coupons')->onUpdate('cascade');

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
        Schema::dropIfExists('trn__orders');
    }
}
