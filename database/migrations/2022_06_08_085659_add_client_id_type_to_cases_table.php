<?php

use App\Models\Cases;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientIdTypeToCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            if(!Schema::hasColumn('cases', 'client_id')){
                $table->integer('client_id')->nullable();
            }
            if(!Schema::hasColumn('cases', 'client_type')){
                $table->string('client_type')->nullable();
            }
            if(!Schema::hasColumn('cases', 'layout')){
                $table->integer('layout')->nullable();
            }

        });
        
        // $sql = [
        //     ['id'  => 3120, 'module_id' => 15, 'parent_id' => 335, 'name' => 'View All Case', 'route' => 'all-case', 'type' => 3 ],

        //     ['id'  => 3121, 'module_id' => 15, 'parent_id' => 335, 'name' => 'Assign Case', 'route' => 'case.assign-case', 'type' => 3 ],

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
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'client_type']);
        });
    }
}
