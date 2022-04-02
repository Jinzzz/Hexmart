<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltcustomermobileToMstcustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst__customers', function (Blueprint $table) {
         $table->text('altcustomer_mobile')->after('customer_mobile')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst__customers', function (Blueprint $table) {
              $table->dropColumn(['altcustomer_mobile']);

        });
    }
}
