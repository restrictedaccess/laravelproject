<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrs1stSentenceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rrs_assessment_1st_sentence', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id');
            $table->text('evaluation_str');
            $table->text('first_advise');
            $table->text('gif_name');
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
        Schema::drop('rrs_assessment_1st_sentence');
    }

}
