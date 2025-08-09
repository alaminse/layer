<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method', 255);
            $table->string('type')->nullable();
            $table->tinyInteger('active_status')->default(1);

            $table->foreignId('gateway_id')->nullable()->constrained('payment_gateway_settings', 'id')->cascadeOnDelete();

            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->integer('organization_id')->nullable()->default(1)->unsigned();
            $table->timestamps();
        });

        DB::table('payment_methods')->insert([
            [
                'method' => 'PayPal',
                'type' => 'System',
                'created_at' => date('Y-m-d h:i:s'),
            ],
            [
                'method' => 'Stripe',
                'type' => 'System',
                'created_at' => date('Y-m-d h:i:s'),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
