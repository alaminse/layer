<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToClientCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_categories', function (Blueprint $table) {           
            if (!Schema::hasColumn('client_categories', 'type')) {
                $table->string('type')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
        Schema::table('client_categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
