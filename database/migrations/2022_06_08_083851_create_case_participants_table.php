<?php

use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_participants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('advocate')->nullable();
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
        Schema::dropIfExists('case_participants');
    }
}
