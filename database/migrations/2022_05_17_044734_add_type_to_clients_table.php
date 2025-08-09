<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            if(!Schema::hasColumn('clients', 'type')) {
                $table->string('type')->nullable()->default('personal');
            }
            if(!Schema::hasColumn('clients', 'status')) {
                $table->string('status')->nullable();
            }
        });
        Client::withOutGlobalScope(\App\Scopes\OrganizationScope::class)->whereNull('status')->update([
            'status'=>'active',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('status');
        });
    }
}
