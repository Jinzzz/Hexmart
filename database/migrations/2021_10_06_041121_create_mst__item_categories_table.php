<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__item_categories', function (Blueprint $table) {
            $table->bigincrements('item_category_id');
            $table->string('category_name',191)->nullable();
            $table->string('category_name_slug',191)->nullable();     
            $table->string('category_icon',191)->nullable();
            $table->longText('category_description')->nullable();
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
        Schema::dropIfExists('mst__item_categories');
    }
}
