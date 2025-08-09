<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\EmailTemplate;

class AddEmailTemplateModuleToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('email_templates', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });

        EmailTemplate::withOutGlobalScope(\App\Scopes\OrganizationScope::class)->whereNull('created_at')->update(['is_default' => true]);

        $modules = [];
        $modules[] = ['name' => 'EmailTemplate', 'details' => "This Module will allow you to add multiple email template for single event. Thanks for using.", 'created_at' => now(), 'updated_at' => now(), 'order' => 1];

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
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
        \Modules\ModuleManager\Entities\Module::where('name', 'EmailTemplate')->delete();
    }
}
