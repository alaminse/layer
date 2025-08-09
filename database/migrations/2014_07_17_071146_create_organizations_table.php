<?php

use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('domain')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(1)->comment("1 approved, 0 pending");
            $table->tinyInteger('created_by')->default(1);
            $table->tinyInteger('updated_by')->default(1);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        $default_lms = new Organization();
        $default_lms->name = 'Infix Advocate';
        $default_lms->description = 'Infix Advocate';
        $default_lms->address = '';
        $default_lms->subdomain = 'main';
        $default_lms->domain = config('app.url');
        $default_lms->user_id = 1;
        $default_lms->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
