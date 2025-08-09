<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByIntoCase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('cases', 'created_by')) {
            Schema::table('cases', function (Blueprint $table) {
                $table->string('created_by')->nullable();
            });
        }
        // $sql = [
        //     ['id'  => 3122, 'module_id' => 15, 'parent_id' => 335, 'name' => 'Remove Staff', 'route' => 'case.remove-assign-staff', 'type' => 3 ]
        // ];
        // DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
