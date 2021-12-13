<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnServiceAreaSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__service_area_splits', function (Blueprint $table) {
            $table->bigincrements('sas_id');
            $table->decimal('service_start', 10, 2)->nullable();
            $table->decimal('service_end', 10, 2)->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->decimal('packing_charge', 10, 2)->nullable();
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
        Schema::dropIfExists('trn__service_area_splits');
    }
}
