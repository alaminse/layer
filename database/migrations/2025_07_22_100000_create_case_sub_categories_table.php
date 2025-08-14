<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('case_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_sub_categories');
    }
}
