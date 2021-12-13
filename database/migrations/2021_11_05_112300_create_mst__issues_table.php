<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst__issues', function (Blueprint $table) {
            $table->bigincrements('issue_id');
            $table->biginteger('issue_type_id')->unsigned()->nullable();
            $table->text('issue')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('issue_type_id')->references('issue_type_id')->on('sys__issue_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst__issues');
    }
}
