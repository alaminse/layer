<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Get all table names in the current database
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $tableName) {
            // Skip migrations table and organizations table (if it exists)
            if (in_array($tableName, ['migrations', 'organizations'])) {
                continue;
            }

            // Add organization_id if it doesn't exist already
            if (!Schema::hasColumn($tableName, 'organization_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->unsignedBigInteger('organization_id')->nullable()->after('id');

                    // Optional: add foreign key if you have an organizations table
                    // $table->foreign('organization_id')
                    //       ->references('id')->on('organizations')
                    //       ->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, 'organization_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('organization_id');
                });
            }
        }
    }
};

