<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_name')->nullable();
            $table->string('gateway_username')->nullable();
            $table->string('gateway_password')->nullable();
            $table->string('gateway_signature')->nullable();
            $table->string('gateway_client_id')->nullable();
            $table->string('gateway_mode')->nullable();
            $table->string('gateway_secret_key')->nullable();
            $table->string('gateway_secret_word')->nullable();
            $table->string('gateway_publisher_key')->nullable();
            $table->string('gateway_private_key')->nullable();
            $table->tinyInteger('active_status')->default(0);

            $table->text('bank_details')->nullable();
            $table->text('cheque_details')->nullable();

            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('organization_id')->nullable()->default(1)->unsigned();
            $table->timestamps();
        });

        DB::table('payment_gateway_settings')->insert([
            [
                'gateway_name'          => 'PayPal',
                'gateway_username'      => 'demo@paypal.com',
                'gateway_password'      => '12334589',
                'gateway_client_id'     => 'AaCPtpoUHZEXCa3v006nbYhYfD0HIX-dlgYWlsb0fdoFqpVToATuUbT43VuUE6pAxgvSbPTspKBqAF0x',
                'gateway_secret_key'    => 'EJ6q4h8w0OanYO1WKtNbo9o8suDg6PKUkHNKv-T6F4APDiq2e19OZf7DfpL5uOlEzJ_AMgeE0L2PtTEj',
                'created_at' => date('Y-m-d h:i:s'),

            ]
        ]);

        DB::table('payment_gateway_settings')->insert([
            [
                'gateway_name'          => 'Stripe',
                'gateway_username'      => 'demo@strip.com',
                'gateway_password'      => '12334589',
                'gateway_client_id'     => '',
                'gateway_secret_key'    => 'AVZdghanegaOjiL6DPXd0XwjMGEQ2aXc58z1-isWmBFnw1h2j',
                'gateway_secret_word'   => 'AVZdghanegaOjiL6DPXd0XwjMGEQ2aXc58z1',
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
        Schema::dropIfExists('payment_gateway_settings');
    }
}
