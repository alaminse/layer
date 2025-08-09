<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable();
            $table->longText('comments')->nullable();
            $table->bigInteger('case_id')->nullable()->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade'); 
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
        Schema::dropIfExists('case_comments');
    }
}
