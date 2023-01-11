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
        Schema::create('customer_kyc', function (Blueprint $table) {
            $table->id();
            $table->string('communication_number');
            $table->string('paywho_reference_id');
//            $table->integer('customer_id');
            $table->string('customer_type'); //individual or corporate user
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('birth_country');
            $table->string('mobile_number');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('monthly_transaction_amount');
            $table->string('customer_status');
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
        Schema::dropIfExists('customer_kyc');
    }
};
