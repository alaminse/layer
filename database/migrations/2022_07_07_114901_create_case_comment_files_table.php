<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseCommentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_comment_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('filename')->nullable();
            $table->string('filepath')->nullable();
            $table->string('file_type')->nullable();
            $table->string('user_filename')->nullable();
            $table->bigInteger('case_comment_id')->nullable()->unsigned();
            $table->foreign('case_comment_id')->references('id')->on('case_comments')
            ->onDelete('cascade');
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
        Schema::dropIfExists('case_comment_files');
    }
}
