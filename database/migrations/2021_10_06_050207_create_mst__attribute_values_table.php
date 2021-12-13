<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__attribute_values', function (Blueprint $table) {
            $table->bigincrements('attribute_value_id');
            $table->biginteger('attribute_group_id')->unsigned();
            $table->string('attribute_value', 150)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('attribute_group_id')->references('attribute_group_id')->on('mst__attribute_groups')
                ->onDelete('cascade')
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
        Schema::dropIfExists('mst__attribute_values');
    }
}
