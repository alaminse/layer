<?php

use App\Models\Cases;
use App\Scopes\OrganizationScope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastActionToCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            if(!Schema::hasColumn('cases', 'last_action')) {
                $table->timestamp('last_action')->after('created_at')->nullable();
            }

            if(!Schema::hasColumn('cases', 'serial_no')) {
                $table->unsignedBigInteger('serial_no')->after('last_action')->nullable();
            }
        });


            $cases = Cases::withOutGlobalScope(OrganizationScope::class)->get();

            foreach ($cases as $key=> $case)
            {
                $case->last_action = $case->created_at;
                $case->serial_no = $key +1;
                $case->save();


            }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $dropColumns = ['last_action', 'serial_no'];
            $table->dropColumn($dropColumns);
        });
    }
}
