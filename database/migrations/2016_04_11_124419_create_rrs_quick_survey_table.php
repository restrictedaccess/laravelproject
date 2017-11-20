<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrsQuickSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('rrs_quick_survey', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('satisfaction');
            $table->text('satisfaction_why');
            $table->integer('effect_in_future');
            $table->text('effect_in_future_why');
            $table->integer('repeat_test');
            $table->text('repeat_test_why');
            $table->integer('program_want_to_try');
            $table->text('program_how_much');
            $table->text('program_why_not');
            $table->text('wearable_device');
            $table->integer('knowlage_alz01');
            $table->integer('knowlage_alz02');
            $table->integer('recommendation');
            $table->text('free_comment');
            $table->integer('is_active')->default(1);
            $table->integer('administrator_modified_by')->nullable();
            $table->integer('administrator_created_by')->default(0);
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
        Schema::drop('rrs_quick_survey'); //
    }
}
