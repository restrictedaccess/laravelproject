<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrsAssessmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rrs_assessment', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('rss_raw_answers_id');
            $table->integer('paf');
            $table->integer('saf');
            $table->integer('sf');
            $table->integer('daf');
            $table->integer('sco_bmi');
            $table->integer('sco_paf');
            $table->integer('sco_cog_read');
            $table->integer('sco_cog_puzzle');
            $table->integer('sco_cog_games');
            $table->integer('sco_cog_art');
            $table->integer('sco_saf');
            $table->integer('sco_diet_fish');
            $table->integer('sco_diet_veg');
            $table->integer('sco_diet_meat');
            $table->integer('sco_diet_fruit');
            $table->integer('sco_diet_chicken');
            $table->integer('sco_diet_nuts');
            $table->integer('sco_diet_whole_grain');
            $table->integer('sco_diet_sugars');
            $table->integer('sco_diet_artificials');
            $table->integer('sco_diet_olive');
            $table->integer('sco_smoke_now');
            $table->integer('sco_daf');
            $table->integer('sco_sf');
            $table->integer('sco_sleep_dur');
            $table->integer('sco_sleep_qual');
            $table->integer('sco_sleep_interrupt');
            $table->integer('sco_atrial_control');
            $table->integer('sco_cad_control');
            $table->integer('sco_depression_control');
            $table->integer('sco_diabetes_control');
            $table->integer('sco_heart_attack_control');
            $table->integer('sco_hypertension_control');
            $table->integer('sco_hyperlipidemia_control');
            $table->integer('sco_apnea_control');
            $table->integer('sco_stroke_control');
            $table->integer('sco_asf');
            $table->integer('sco_edu');
            $table->integer('sco_smoke_ever');
            $table->integer('cat_sco_activity');
            $table->integer('cat_sco_diet');
            $table->integer('cat_sco_lifestyle');
            $table->integer('cat_sco_medical');
            $table->integer('cat_sco_background');
            $table->integer('cat_sco_modifiable');
            $table->integer('cat_max_activity');
            $table->integer('cat_max_diet');
            $table->integer('cat_max_lifestyle');
            $table->integer('cat_max_medical');
            $table->integer('cat_max_background');
            $table->integer('cat_max_modifiable');
            $table->integer('cat_pct_activity');
            $table->integer('cat_pct_diet');
            $table->integer('cat_pct_lifestyle');
            $table->integer('cat_pct_medical');
            $table->integer('cat_pct_background');
            $table->integer('cat_pct_modifiable');
            $table->longtext('adv_sco_bmi');
            $table->longtext('adv_sco_paf');
            $table->longtext('adv_sco_mtl');
            $table->longtext('adv_sco_saf');
            $table->longtext('adv_sco_diet_fish');
            $table->longtext('adv_sco_diet_veg');
            $table->longtext('adv_sco_diet_meat');
            $table->longtext('adv_sco_diet_fruit');
            $table->longtext('adv_sco_diet_chicken');
            $table->longtext('adv_sco_diet_nuts');
            $table->longtext('adv_sco_diet_whole_grain');
            $table->longtext('adv_sco_diet_sugars');
            $table->longtext('adv_sco_diet_artificials');
            $table->longtext('adv_sco_diet_olive');
            $table->longtext('adv_sco_smoke_now');
            $table->longtext('adv_sco_mod_drink');
            $table->longtext('adv_sco_stress');
            $table->longtext('adv_sco_good_sleep');
            $table->longtext('adv_sco_atrial_control')->nullable();
            $table->longtext('adv_sco_cad_control')->nullable();
            $table->longtext('adv_sco_depression_control')->nullable();
            $table->longtext('adv_sco_diabetes_control')->nullable();
            $table->longtext('adv_sco_heart_attack_control')->nullable();
            $table->longtext('adv_sco_hypertension_control')->nullable();
            $table->longtext('adv_sco_hyperlipidemia_control')->nullable();
            $table->longtext('adv_sco_apnea_control')->nullable();
            $table->longtext('adv_sco_stroke_control')->nullable();
            $table->longtext('adv_sco_asf');
            $table->longtext('adv_sco_edu');
            $table->longtext('adv_sco_smoke_ever');
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
        Schema::drop('rrs_assessment');
    }

}
