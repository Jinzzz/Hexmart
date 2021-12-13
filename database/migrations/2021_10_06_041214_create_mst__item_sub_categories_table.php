<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__item_sub_categories', function (Blueprint $table) {
            $table->bigincrements('item_sub_category_id');
            $table->biginteger('item_category_id')->unsigned();
            $table->string('sub_category_name',191)->nullable();
            $table->string('sub_category_name_slug',191)->nullable();     
            $table->string('sub_category_icon',191)->nullable();
            $table->longText('sub_category_description')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('item_category_id')->references('item_category_id')->on('mst__item_categories')
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
        Schema::dropIfExists('mst__item_sub_categories');
    }
}
