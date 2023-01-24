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
            // $table->string('code');
            $table->string('title'); //name of the rule
            $table->string('description'); // what the rule will do
            $table->integer('category')->nullable(); 
            $table->string('target_object'); //CUSTOMER OR TRANSACTION
            $table->string('assessment_type'); //ONLINE_MONITORING OR RETROSPECTIVE_MONITORING
            $table->text('data'); // actual rule json
            $table->string('action_type'); // (SCORE OR STATE) the action will be performed on rule failure. like whether to do scoring or change the operation state e.g. ACCEPT, REVIEW, DECLINE
            $table->integer('score')->nullable(); // (0-100) define a score for the rule if action type is score
            $table->string('state')->nullable(); // (ACCEPT, REVIEW OR DECLINE) define a following state if action type is state
            $table->boolean('is_enabled'); // (0 OR 1)
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
