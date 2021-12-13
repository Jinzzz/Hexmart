<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemLevelTwoSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__item_level_two_sub_categories', function (Blueprint $table) {
            $table->bigincrements('iltsc_id');
            $table->biginteger('item_category_id')->unsigned();
            $table->biginteger('item_sub_category_id')->unsigned();
            $table->string('iltsc_name', 191)->nullable();
            $table->string('iltsc_name_slug', 191)->nullable();
            $table->string('iltsc_icon', 191)->nullable();
            $table->longText('iltsc_description')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('item_category_id')->references('item_category_id')->on('mst__item_categories')
                ->onUpdate('cascade');
            $table->foreign('item_sub_category_id')
                ->references('item_sub_category_id')->on('mst__item_sub_categories')
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
        Schema::dropIfExists('mst__item_level_two_sub_categories');
    }
}
