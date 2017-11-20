<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipRssQuickSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrs_quick_survey', function(Blueprint $table){
            $table->integer('rrs_assessment_id')->unsigned()->change();
            $table->foreign('rrs_assessment_id')->references('id')->on('rrs_assessment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrs_quick_survey', function(Blueprint $table){
            $table->dropForeign(['rrs_assessment_id']);
        });
    }
}
