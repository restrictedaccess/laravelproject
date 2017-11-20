<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrs2ndSentenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('rrs_assessment_2nd_sentence', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('category_id');
            $table->text('gif_name');
            $table->text('second_advise');
            $table->text('reason');
            $table->text('tips');
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
        Schema::drop('rrs_assessment_2nd_sentence');
    }
}
