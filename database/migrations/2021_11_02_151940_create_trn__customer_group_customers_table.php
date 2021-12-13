<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnCustomerGroupCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__customer_group_customers', function (Blueprint $table) {
            $table->bigincrements('cgc_id', 150)->nullable();
            $table->biginteger('customer_group_id')->unsigned()->nullable();
            $table->biginteger('customer_id')->unsigned()->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('customer_group_id')->references('customer_group_id')->on('mst__customer_groups')->onUpdate('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('mst__customers')->onUpdate('cascade');
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
        Schema::dropIfExists('trn__customer_group_customers');
    }
}
