<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $key => $table_name) {
            $table_name = json_encode(array_values(get_object_vars($table_name)));
            $table_name = str_replace(['["', '"]'], '', $table_name);
            Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                if (!Schema::hasColumn($table_name, 'organization_id')) {
                    $table->unsignedBigInteger('organization_id')->nullable()->default(1);
                }
            });
        }

        \Modules\RolePermission\Entities\Role::withOutGlobalScope(\App\Scopes\OrganizationScope::class)->whereIn('id', [1,2])->update([
            'organization_id' => null,
        ]);

        \Modules\RolePermission\Entities\Permission::query()->update([
            'organization_id' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
