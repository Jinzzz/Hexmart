<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateAttributesubcatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('mst_attributesubcat_table', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->text('attribute_group_id')->nullable();
            $table->text('item_category_id')->nullable();
            $table->text('item_sub_category_id')->nullable();
            $table->text('iltsc_id')->nullable();
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
                Schema::dropIfExists('mst_attributesubcat_table');

    }

}
