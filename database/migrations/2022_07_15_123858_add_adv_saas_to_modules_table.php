<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAdvSaasToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $modules = [];
        $modules[] = ['name' => 'AdvSaas', 'details' => "This is saas module for multiple firm can run in this system at a time. Thanks for using.", 'created_at' => now(), 'updated_at' => now(), 'order' => 1];
        $modules[] = ['name' => 'Zoom', 'details' => "This is zoom module for create virtual meetings with client and lawyer, Also for automatic meeting for appointment. Thanks for using.", 'created_at' => now(), 'updated_at' => now(), 'order' => 1];

        DB::table('modules')->insert(
            $modules
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            //
        });
    }
}
