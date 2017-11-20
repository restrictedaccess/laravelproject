<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrsReportDecisionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rrs_report_decision', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('category_id');
            $table->integer('score');
            $table->integer('evaluation_id');
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
    public function down() {
        Schema::drop('rrs_report_decision'); //
    }

}
