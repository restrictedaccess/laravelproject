<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nick_name', 255)->nullable();
            $table->string('first_name', 255);
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255);
            $table->string('password', 255)->nullable();
            $table->string('mobile_no', 16)->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 12)->nullable();
            $table->integer('gender');
            $table->decimal('height', 5, 2);
            $table->integer('height_unit')->default(0);
            $table->decimal('weight', 5, 2);
            $table->integer('weight_unit')->default(1);
            $table->decimal('bmi', 3, 1);
            $table->date('birthday');
            $table->string('survey_token', 50)->nullable();
            $table->integer('news_letter_flag')->default(1);
            $table->integer('is_active')->default(1);
            $table->integer('administrator_modified_by')->nullable();
            $table->integer('administrator_created_by')->default(0);;
            $table->rememberToken();
            $table->timestamps();
        });
    }

    
    public function down() {
        Schema::drop('users');
    }

}
