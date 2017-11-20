<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrsRawAnswersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rrs_raw_answers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('phys_light')->default(0);
            $table->integer('phys_light_dur')->default(-99);
            $table->integer('phys_mod')->default(0);
            $table->integer('phys_mod_dur')->default(99);
            $table->integer('phys_vig')->default(0);
            $table->integer('phys_vig_dur')->default(99);
            $table->integer('cog_read')->default(0);
            $table->integer('cog_puzzle')->default(0);
            $table->integer('cog_games')->default(0);
            $table->integer('cog_art')->default(0);
            $table->integer('diet_fish')->default(0);
            $table->integer('diet_veg')->default(0);
            $table->integer('diet_meat')->default(0);
            $table->integer('diet_fruit')->default(0);
            $table->integer('diet_chicken')->default(0);
            $table->integer('diet_nuts')->default(0);
            $table->integer('diet_whole_grain')->default(0);
            $table->integer('diet_sugars')->default(1);
            $table->integer('diet_artificials')->default(1);
            $table->integer('diet_olive')->default(-99);
            $table->integer('smoke_ever')->default(0);
            $table->integer('smoke_now')->default(0);
            $table->integer('drink_ever')->default(0);
            $table->integer('drink_now')->default(0);
            $table->integer('drink_freq')->default(0);
            $table->integer('drink_intense')->default(-99);
            $table->integer('marital_stat')->default(1);
            $table->integer('living_alone')->default(0);
            $table->integer('living_partner')->default(0);
            $table->integer('living_family')->default(0);
            $table->integer('living_friends')->default(0);
            $table->integer('group_events')->default(1);
            $table->integer('social_events')->default(1);
            $table->integer('confidant')->default(-99);
            $table->integer('stress_freq')->default(-99);
            $table->integer('stress_when')->default(-99);
            $table->integer('sleep_dur')->default(4);
            $table->integer('sleep_qual')->default(1);
            $table->integer('sleep_interrupt')->default(0);
            $table->integer('race')->default(-99);
            $table->integer('atrial_presence')->default(0);
            $table->integer('cad_presence')->default(0);
            $table->integer('depression_presence')->default(0);
            $table->integer('diabetes_presence')->default(0);
            $table->integer('heart_attack_presence')->default(0);
            $table->integer('hypertension_presence')->default(0);
            $table->integer('hyperlipidemia_presence')->default(0);
            $table->integer('apnea_presence')->default(0);
            $table->integer('stroke_presence')->default(0);
            $table->integer('atrial_control')->nullable();
            $table->integer('cad_control')->nullable();
            $table->integer('depression_control')->nullable();
            $table->integer('diabetes_control')->nullable();
            $table->integer('heart_attack_control')->nullable();
            $table->integer('hypertension_control')->nullable();
            $table->integer('hyperlipidemia_control')->nullable();
            $table->integer('apnea_control')->nullable();
            $table->integer('stroke_control')->nullable();
            $table->integer('occupation')->default(0);
            $table->integer('edu');
            $table->decimal('height', 5, 2)->default(0);
            $table->decimal('weight', 5, 2)->default(0);
            $table->decimal('bmi', 3, 1)->default(0);
            $table->date('birthday');
            $table->integer('gender');
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
        Schema::drop('rrs_raw_answers');
    }

}
