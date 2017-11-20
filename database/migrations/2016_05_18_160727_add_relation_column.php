<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `users` ADD COLUMN `referer` VARCHAR(256);');
        DB::statement('ALTER TABLE `users` ADD COLUMN `promotion_id` VARCHAR(256);');
        DB::statement('ALTER TABLE `rrs_quick_survey` ADD COLUMN `rrs_assessment_id` INT(11);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        DB::statement('ALTER TABLE `users` DROP `referer`;');
        DB::statement('ALTER TABLE `users` DROP `promotion_id`;');
        DB::statement('ALTER TABLE `rrs_quick_survey` DROP `rrs_assessment_id`;');
    }
}
