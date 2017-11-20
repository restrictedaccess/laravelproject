<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('administrators', function(Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255);
            $table->string('password', 255);
            $table->integer('is_active')->default(1);
            $table->integer('authority')->default(1);
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
        Schema::drop('administrators'); //
    }

}
