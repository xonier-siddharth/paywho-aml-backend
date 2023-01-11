<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitor_transactions', function (Blueprint $table) {
            $table->id();//defaults to 11 length
            $table->string('communication_number');
            $table->string('paywho_reference_id'); //defaults to 11 length
            $table->integer('customer_id');
            $table->string('customer_type'); //individual or corporate user
            $table->string('amount');//defaults to 11 length
            $table->string('financial_flow_direction');
            $table->string('source_county');
            $table->string('destination_county');
            $table->string('source_currency');
            $table->string('destination_currency');
            $table->string('sender_account_number');
            $table->string('sender_first_name');
            $table->string('sender_last_name');
            $table->string('sender_bic'); //bank identifier code
            $table->string('sender_bank_title');
            $table->string('receiver_account_number');
            $table->string('receiver_bic');
            $table->string('receiver_first_name');
            $table->string('receiver_last_name');
            $table->string('receiver_bank_title');
            $table->string('payment_mode');
            $table->string('sender_ip_address');
            $table->string('payment_description');
            $table->integer('risk_score');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitor_transactions');
    }
};
