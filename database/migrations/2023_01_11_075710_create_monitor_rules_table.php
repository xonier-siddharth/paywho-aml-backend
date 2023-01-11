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
        Schema::create('monitor_rules', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->string('target_object'); //CUSTOMER OR TRANSACTION
            $table->string('assessment_type'); //ONLINE_MONITORING OR RETROSPECTIVE_MONITORING
            $table->text('data');
            $table->boolean('is_enabled');
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
        Schema::dropIfExists('monitor_rules');
    }
};
