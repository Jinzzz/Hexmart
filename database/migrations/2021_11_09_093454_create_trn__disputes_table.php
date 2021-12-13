<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__disputes', function (Blueprint $table) {
            $table->bigincrements('dispute_id');
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->biginteger('issue_id')->unsigned()->nullable();
            $table->biginteger('order_id')->unsigned()->nullable();
            $table->biginteger('order_item_id')->unsigned()->nullable();
            $table->biginteger('dispute_status_id')->unsigned()->nullable();
            $table->text('dispute_discription')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
            $table->foreign('issue_id')->references('issue_id')->on('mst__issues')->onUpdate('cascade');
            $table->foreign('order_id')->references('order_id')->on('trn__orders')->onUpdate('cascade');
            $table->foreign('order_item_id')->references('order_item_id')->on('trn__order_items')->onUpdate('cascade');
            $table->foreign('dispute_status_id')->references('dispute_status_id')->on('sys__dispute_statuses')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__disputes');
    }
}
