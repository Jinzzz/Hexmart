<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnTaxSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn__tax_splits', function (Blueprint $table) {
            $table->bigincrements('tax_split_id');
            $table->biginteger('tax_id')->unsigned();
            $table->string('tax_split_name',100)->nullable();
            $table->decimal('tax_split_value',10,2)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('tax_id')->references('tax_id')->on('mst__taxes')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn__tax_splits');
    }
}
