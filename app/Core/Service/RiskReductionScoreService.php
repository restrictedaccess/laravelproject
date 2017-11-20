<?php

namespace App\Core\Service;

use App\Facades\PegaraConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RiskReductionScoreService {

    
    public function calculateScore($answers , $userInfo) {
        $userInfo = $this->formatUserInfo($userInfo);
        Session::set('profile',$userInfo);
        $answers = $this->formatAnswerArray($userInfo,$answers);
        $allScoresData = $this->getCalculatedScores($answers);
        $scoreDataForView = $this->getScoreDataForView($allScoresData);
        $scoreDataForView['name'] = $userInfo['first_name'];
        $scoreDataForDB = $this->getScoreDataForDB($allScoresData);
        $score['view'] = $scoreDataForView;
        $score['db'] = $scoreDataForDB;
        return $score;
    }
    
    private function getScoreDataForDB($allScoresData) {
        foreach($allScoresData as $key=>$score){
            if(isset($score['score'])){
                unset($allScoresData[$key]['score']);
                $allScoresData[$key]= $score['csv'];
            }
        }
        return $allScoresData;
    }
    
    public function insertInfoIntoDB($answers,$userInfo, $allScore) {
        $score = $allScore['db'];
        $tokenArray = $this->insertInfoInAllTable($answers,$userInfo, $allScore);
        if(isset($tokenArray['survey_token'])){
            $this->sendEmail($tokenArray); 
        }
    }
    
    public function getRiskHedgeSectence() {
        $riskHedge = [];
        $riskStatus = Session::get('has_disease');
        if($riskStatus){
            $riskHedge['header'] = PegaraConstant::HAS_DISEASE_HEADER ;
            $riskHedge['footer'] = PegaraConstant::HAS_DISEASE_FOOTER ;
        }else{
            $riskHedge['header'] = PegaraConstant::NO_DISEASE_HEADER;
            $riskHedge['footer'] = PegaraConstant::NO_DISEASE_FOOTER ;
        }
        $riskHedge['status'] = $riskStatus ;
        return $riskHedge ;
    }
    
    public function formatUserInfoInput($userInfo){
         if (isset($userInfo['out_of_us'])) {
            $userInfo['zip_code'] = "00000";
        }
        if ($userInfo['height_unit'] == 0) {
            $inches = is_numeric($userInfo['height_inches']) ? $userInfo['height_inches'] : 0;
            $userInfo['height'] = $userInfo['height'] * 12 + $inches;
            unset($userInfo['height_inches']);
        }
        return $userInfo ;
    }
    private function insertInfoInAllTable($answers,$userInfo, $allScore) {
        $surveyToken = $this->getUniqueSurveyToken(); 
        $array = [];
        $userInfo['survey_token'] = $surveyToken ;
        $userInfo['created_at'] = date('Y-m-d H:i:s');
        $userInfo['promotion_id'] = Session::get('promotion_id');
        $userInfo['referer'] = Session::get('referer');
        unset($userInfo['height_inches']);
        $userId = DB::table('users')
              ->insertGetId($userInfo);
        $array['survey_token'] = secure_url('/') . '/survey/form/' . $surveyToken;
        $array['first_name'] = $userInfo['first_name'];
        $array['email'] = $userInfo['email'];
        
        $answers = $this->formatAnswerArrayForDB($userId , $answers , $userInfo);
        $answerId = DB::table('rrs_raw_answers')
                ->insertGetId($answers);
        $score = $this->formatAssessmentArrayForDB($userId ,$answerId, $allScore );        
        DB::table('rrs_assessment')
                ->insert($score);
       
        return $array ;
    }
    
    private function formatAnswerArrayForDB($id , $answers , $userInfo) {
        $answers['user_id'] = $id;
        $answers['height'] = $userInfo['height'];
        $answers['weight'] = $userInfo['weight'];
        $answers['bmi'] = $userInfo['bmi'];
        $answers['birthday'] = $userInfo['birthday'];
        $answers['gender'] = $userInfo['gender'];
        $answers['is_active'] = 1;
        $answers['created_at'] = date('Y-m-d H:i:s');
        return $answers ;
    }

    private function formatAssessmentArrayForDB($id , $answerId , $allScore) {
        $score = $allScore['db'];
        $score['user_id'] = $id ;
        $score['rss_raw_answers_id'] = $answerId ;
        $score['is_active'] = 1;
        $score['rss_raw_answers_id'] = $answerId ;
        $score['created_at'] = date('Y-m-d H:i:s');
        unset($score['sco_mtl']);
        unset($score['sco_good_sleep']);
        
//        foreach($score as $key=>$col){
//            if(substr($key, 0 , 4)== 'adv_'){
//                unset($score[$key]);
//            }
//        }
        
        return $score ;
    }
    
    private function formatUserInfo($userInfo) {
        unset($userInfo['_token']);
        unset($userInfo['out_of_us']);
        $userInfo['height'] = $this->getHeightInMeter($userInfo);
        $userInfo['weight'] = $this->getWeightInKg($userInfo);
        $userInfo['bmi'] = $this->calculateBMI($userInfo['height'], $userInfo['weight']);
        Session::set('bmi' , $userInfo['bmi']);
        $userInfo['news_letter_flag'] = isset($userInfo['news_letter_flag']) ? 1 : 0;
        $userInfo['is_active'] = 1;
        return $userInfo ;
    }
    private function formatAnswerArray($userInfo,$answers){
        $answers['height'] = $userInfo['height'];
        $answers['weight'] = $userInfo['weight'];
        $answers['bmi'] = $userInfo['bmi'];
        $answers['gender'] = $userInfo['gender'];
        $answers['birthday'] = $userInfo['birthday'];
        return $answers;
    }
    
    private function getHeightInMeter($userInfo) {
        $unit = $userInfo['height_unit'];
        $height = $userInfo['height'];
        if($unit==0){
            $height = $height/39.37;
        }else{
            $height = $height/100;
        }
        
        return round($height,2);
    }
    
    private function getWeightInKg($userInfo) {
        $unit = $userInfo['weight_unit'];
        $weight = $userInfo['weight'];
        if($unit==0){
            $weight = $weight/2.2;
        }
        return round($weight,2);
    }
    
    private function calculateBMI($height ,$weight ) {
        $bmi = $weight/($height*$height);
        return round($bmi,2);
    }
    
    public function mapAnswerFormat($answer) {
        
        $answers = $this->getMappedAnswers($answer);
        return $answers;
    }
    
    private function getScoreStatus($score) {
        if($score>90){
            return "excellent";
        }
        elseif($score>74){
            return "good";
        }elseif($score>49){
          return "average";   
        }elseif($score>24){
            return "fair";
        }else{
            return "poor";
        }
    }
    
    private function getScoreDataForView($allScoresData) {
        $array = [];
        $array['final_score'] = (int) $allScoresData['cat_pct_modifiable'];
        $array['final_score_status'] = $this->getScoreStatus($array['final_score']);
        $array['final_max_score'] = 100;
        $array['activity']['score'] = (int) $allScoresData['cat_pct_activity'];
        $array['activity']['score_status'] = $this->getScoreStatus($array['activity']['score']);

        $array['activity']['max_score'] = 100;
        $array['activity']['other_info']['adv_sco_bmi'] = $allScoresData['adv_sco_bmi']['score'];
        $array['activity']['other_info']['adv_sco_paf'] = $allScoresData['adv_sco_paf']['score'];
        $array['activity']['other_info']['adv_sco_mtl'] = $allScoresData['adv_sco_mtl']['score'];
        $array['activity']['other_info']['adv_sco_saf'] = $allScoresData['adv_sco_saf']['score'];

        $array['diet']['score'] = (int) $allScoresData['cat_pct_diet'];
        $array['diet']['score_status'] = $this->getScoreStatus($array['diet']['score']);
        $array['diet']['max_score'] = 100;
        $array['diet']['other_info']['adv_sco_diet_fish'] = $allScoresData['adv_sco_diet_fish']['score'];
        $array['diet']['other_info']['adv_sco_diet_veg'] = $allScoresData['adv_sco_diet_veg']['score'];
        $array['diet']['other_info']['adv_sco_diet_meat'] = $allScoresData['adv_sco_diet_meat']['score'];
        $array['diet']['other_info']['adv_sco_diet_fruit'] = $allScoresData['adv_sco_diet_fruit']['score'];
        $array['diet']['other_info']['adv_sco_diet_chicken'] = $allScoresData['adv_sco_diet_chicken']['score'];
        $array['diet']['other_info']['adv_sco_diet_nuts'] = $allScoresData['adv_sco_diet_nuts']['score'];
        $array['diet']['other_info']['adv_sco_diet_whole_grain'] = $allScoresData['adv_sco_diet_whole_grain']['score'];
        $array['diet']['other_info']['adv_sco_diet_sugars'] = $allScoresData['adv_sco_diet_sugars']['score'];
        $array['diet']['other_info']['adv_sco_diet_artificials'] = $allScoresData['adv_sco_diet_artificials']['score'];
        $array['diet']['other_info']['adv_sco_diet_olive'] = $allScoresData['adv_sco_diet_olive']['score'];

        $array['lifestyle']['score'] = (int) $allScoresData['cat_pct_lifestyle'];
        $array['lifestyle']['score_status'] = $this->getScoreStatus($array['lifestyle']['score']);
        $array['lifestyle']['max_score'] = 100;
        $array['lifestyle']['other_info']['adv_sco_smoke_now'] = $allScoresData['adv_sco_smoke_now']['score'];
        $array['lifestyle']['other_info']['adv_sco_mod_drink'] = $allScoresData['adv_sco_mod_drink']['score'];
        $array['lifestyle']['other_info']['adv_sco_stress'] = $allScoresData['adv_sco_stress']['score'];
        $array['lifestyle']['other_info']['adv_sco_good_sleep'] = $allScoresData['adv_sco_good_sleep']['score'];

        $array['medical']['score'] = (int) $allScoresData['cat_pct_medical'];
        $array['medical']['score_status'] = $this->getScoreStatus($array['medical']['score']);
        $array['medical']['max_score'] = 100;
        $array['medical']['other_info']['adv_sco_atrial_control'] = $allScoresData['adv_sco_atrial_control']['score'];
        $array['medical']['other_info']['adv_sco_cad_control'] = $allScoresData['adv_sco_cad_control']['score'];
        $array['medical']['other_info']['adv_sco_depression_control'] = $allScoresData['adv_sco_depression_control']['score'];
        $array['medical']['other_info']['adv_sco_diabetes_control'] = $allScoresData['adv_sco_diabetes_control']['score'];
        $array['medical']['other_info']['adv_sco_heart_attack_control'] = $allScoresData['adv_sco_heart_attack_control']['score'];
        $array['medical']['other_info']['adv_sco_hypertension_control'] = $allScoresData['adv_sco_hypertension_control']['score'];
        $array['medical']['other_info']['adv_sco_hyperlipidemia_control'] = $allScoresData['adv_sco_hyperlipidemia_control']['score'];
        $array['medical']['other_info']['adv_sco_apnea_control'] = $allScoresData['adv_sco_apnea_control']['score'];
        $array['medical']['other_info']['adv_sco_stroke_control'] = $allScoresData['adv_sco_stroke_control']['score'];
        
        return $array;
    }
    public function sendEmail($tokenArray) {
        Mail::send('layouts.email_template', ['data' => $tokenArray], function($message) use($tokenArray) {
            $message->to($tokenArray['email'])
                    ->subject(PegaraConstant::SURVEY_MAIL_SUBJECT);
        });
    }
    private function getUniqueSurveyToken() {
       // $token = Str::random(15);
        $token = "" ;
        while(true){
            $token = Str::random(PegaraConstant::SURVEY_TOKEN_LENGTH);
            $tokenMatch = DB::table('users')
                    ->where('survey_token' , $token)
                    ->count();
            if($tokenMatch == 0){
                break ;
            }
        }
        
        return $token ;
    }
    
    private function insertUserInfo($request) {
        $userInfo = $request->all();
        unset($userInfo['_token']);
        $userInfo['created_at'] = date('Y-m-d H:i:s');
        $userInfo['updated_at'] = date('Y-m-d H:i:s');
        //  DB::table('users')->insert($userInfo);
    }

    private function getHardCodedRawAnswers() {
        $answer = [];
        $answer['phys_light'] = 3;
        $answer['phys_light_dur'] = 30;
        $answer['phys_mod'] = 2;
        $answer['phys_mod_dur'] = 30;
        $answer['phys_vig'] = 0;
        $answer['phys_vig_dur'] = -9;
        $answer['cog_read'] = 7;
        $answer['cog_puzzle'] = 1;
        $answer['cog_games'] = 2;
        $answer['cog_art'] = 4;
        $answer['diet_fish'] = 0;
        $answer['diet_veg'] = 0;
        $answer['diet_meat'] = 2;
        $answer['diet_fruit'] = 3;
        $answer['diet_chicken'] = 4;
        $answer['diet_nuts'] = 3;
        $answer['diet_whole_grain'] = 5;
        $answer['diet_sugars'] = 2;
        $answer['diet_artificials'] = 4;
        $answer['diet_olive'] = 3;
        $answer['smoke_ever'] = 0;
        $answer['smoke_now'] = 0;
        $answer['drink_ever'] = 1;
        $answer['drink_now'] = 1;
        $answer['drink_freq'] = 4;
        $answer['drink_intense'] = 1;
        $answer['marital_stat'] = 0;
        $answer['living_alone'] = 1;
        $answer['living_partner'] = 0;
        $answer['living_family'] = 0;
        $answer['living_friends'] = 0;
        $answer['group_events'] = 2;
        $answer['social_events'] = 4;
        $answer['confidant'] = 1;
        $answer['stress_freq'] = 3;
        $answer['stress_when'] = 3;
        $answer['sleep_dur'] = 6;
        $answer['sleep_qual'] = 2;
        $answer['sleep_interrupt'] = 2;
        $answer['atrial_presence'] = 0;
        $answer['cad_presence'] = 0;
        $answer['depression_presence'] = 1;
        $answer['diabetes_presence'] = 0;
        $answer['heart_attack_presence'] = 0;
        $answer['hypertension_presence'] = 0;
        $answer['hyperlipidemia_presence'] = 0;
        $answer['apnea_presence'] = 1;
        $answer['stroke_presence'] = 0;
        $answer['atrial_control'] = null;
        $answer['cad_control'] = null;
        $answer['depression_control'] = 2;
        $answer['diabetes_control'] = null;
        $answer['heart_attack_control'] = null;
        $answer['hypertension_control'] = null;
        $answer['hyperlipidemia_control'] = null;
        $answer['apnea_control'] = 0;
        $answer['stroke_control'] = null;
        $answer['edu'] = 5;
        $answer['height'] = 1.65;
        $answer['weight'] = 72;
        $answer['bmi'] = 23.61828; //$answer['weight'] / ($answer['height'] * $answer['height']);
        $answer['gender'] = 1;
        $answer['birthday'] = "16-01-1991";
        return $answer;
    }

    private function getMappedValueForPatternOne($value) {
        if ($value == 0) {
            return 30;
        } elseif ($value == 1) {
            return 45;
        } elseif ($value == 2) {
            return 60;
        } elseif ($value == 3) {
            return 75;
        } elseif ($value == 4) {
            return 90;
        } elseif ($value == 5) {
            return -99;
        } else {
            return -9;
        }
    }

    private function getMappedValueForPatternTwo($value) {
        return $value + 1;
    }

    private function getMappedValueForPatternThree($value) {
        if ($value == 0) {
            return 3;
        } elseif ($value == 1) {
            return 2;
        } elseif ($value == 2) {
            return 1;
        } elseif ($value == 3) {
            return 0;
        } elseif ($value == 4) {
            return -99;
        } elseif ($value == 5) {
            return -9;
        } else {
            return -9;
        }
    }

    private function getMappedValueForPatternFour($value) {
        if ($value == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    private function getMappedValueForPatternFive($value) {
        if ($value == 6) {
            return -99;
        } else {
            return $value + 1;
        }
    }

    private function getMappedValueForPatternSix($value) {
        if ($value == 0) {
            return 1;
        } elseif ($value == 1) {
            return 0;
        } else {
            return -99;
        }
    }

    private function getMappedValueForPatternSeven($value) {
        return $value + 4;
    }

    private function getMappedValueForPatternEight($value) {
        if ($value == 3) {
            return 0;
        } elseif ($value == 4) {
            return -99;
        } else {
            return $value + 1;
        }
    }
    
    private function getMappedValueForPatternNine($value) {
        if ($value == 3) {
            return -99;
        } else {
            return $value + 1;
        }
    }
    private function getMappedValueForPatternTen($value) {
        if($value==7){
            return -99;
        }else{
            return $value+1 ;
        }
    }

    private function getMappedAnswers($rawAnswer) {
        // $answer = $rawAnswer[];
        $answer['phys_light'] = $rawAnswer['physical_light_day'];
        if (isset($rawAnswer['physical_light_time'])) {
            $answer['phys_light_dur'] = $this->getMappedValueForPatternOne($rawAnswer['physical_light_time']);
        } else {
            $answer['phys_light_dur'] = -9;
        }

        $answer['phys_mod'] = $rawAnswer['physical_moderate_day'];
        if (isset($rawAnswer['physical_moderate_time'])) {
            $answer['phys_mod_dur'] = $this->getMappedValueForPatternOne($rawAnswer['physical_moderate_time']);
        } else {
            $answer['phys_mod_dur'] = -9;
        }

        $answer['phys_vig'] = $rawAnswer['physical_vigorous_day'];
        if (isset($rawAnswer['physical_vigorous_time'])) {
            $answer['phys_vig_dur'] = $this->getMappedValueForPatternOne($rawAnswer['physical_vigorous_time']);
        } else {
            $answer['phys_vig_dur'] = -9;
        }
        //$answer['phys_vig_dur'] = -9;
        $answer['cog_read'] = $rawAnswer['cognitive_reading'];
        $answer['cog_puzzle'] = $rawAnswer['cognitive_puzzles'];
        $answer['cog_games'] = $rawAnswer['cognitive_games'];
        $answer['cog_art'] = $rawAnswer['cognitive_art'];
        $answer['diet_fish'] = $rawAnswer['diet_non_fried_fish'];
        $answer['diet_veg'] = $rawAnswer['diet_vegetable'];
        $answer['diet_meat'] = $rawAnswer['diet_red_meat'];
        $answer['diet_fruit'] = $rawAnswer['diet_fruit'];
        $answer['diet_chicken'] = $rawAnswer['diet_chicken'];
        $answer['diet_nuts'] = $rawAnswer['diet_nuts'];
        $answer['diet_whole_grain'] = $rawAnswer['diet_high_carb_foods'];
        $answer['diet_sugars'] = $this->getMappedValueForPatternTwo($rawAnswer['diet_natural_sugars']);
        $answer['diet_artificials'] = $this->getMappedValueForPatternTwo($rawAnswer['diet_artificial_sweeteners']);
        $answer['diet_olive'] = $this->getMappedValueForPatternThree($rawAnswer['diet_olive_oil_use']);
        $answer['smoke_ever'] = $this->getMappedValueForPatternFour($rawAnswer['smoking_ever']);
        if (isset($rawAnswer['smoking_current'])) {
            $answer['smoke_now'] = $this->getMappedValueForPatternFour($rawAnswer['smoking_current']);
        } else {
            $answer['smoke_now'] = 0;
        }
        // $answer['smoke_now'] =  
        $answer['drink_ever'] = $this->getMappedValueForPatternFour($rawAnswer['drinking_ever']);
        if (isset($rawAnswer['drinking_current'])) {
            $answer['drink_now'] = $this->getMappedValueForPatternFour($rawAnswer['drinking_current']);
        } else {
            $answer['drink_now'] = 0;
        }
        if (isset($rawAnswer['drinking_frequency'])) {
            $answer['drink_freq'] = $rawAnswer['drinking_frequency'];
        } else {
            $answer['drink_freq'] = 0;
        }

        if (isset($rawAnswer['drinking_intensity'])) {
            $answer['drink_intense'] = $this->getMappedValueForPatternFive($rawAnswer['drinking_intensity']);
        } else {
            $answer['drink_intense'] = -99;
        }

        //  $answer['drink_intense'] = 1;
        $answer['marital_stat'] = $this->getMappedValueForPatternTwo($rawAnswer['social_marital_status']);
        $answer['living_alone'] = 0;
        $answer['living_partner'] = 0;
        $answer['living_family'] = 0;
        $answer['living_friends'] = 0;
        foreach ($rawAnswer['social_lving_arrangement'] as $key => $value) {
            if ($value == 0) {
                $answer['living_alone'] = 1;
            } elseif ($value == 1) {
                $answer['living_partner'] = 1;
            } elseif ($value == 2) {
                $answer['living_family'] = 1;
            } elseif ($value == 3) {
                $answer['living_friends'] = 1;
            }
        }

        $answer['group_events'] = $this->getMappedValueForPatternTwo($rawAnswer['social_group_activity_participation']);
        $answer['social_events'] = $this->getMappedValueForPatternTwo($rawAnswer['social_event_attendance']);
        $answer['confidant'] = $this->getMappedValueForPatternSix($rawAnswer['social_close_relationship']);
        if ($rawAnswer['stress_frequency'] == 0) {
            $answer['stress_freq'] = $this->getMappedValueForPatternTwo($rawAnswer['stress_timeframe']);
        } elseif ($rawAnswer['stress_frequency'] == 1) {
            $answer['stress_freq'] = 0;
        } elseif ($rawAnswer['stress_frequency'] == 2) {
            $answer['stress_freq'] = -99;
        }

        //  $answer['stress_freq'] = 3;
        if(isset($rawAnswer['stress_when'])){
           $answer['stress_when']= $this->getMappedValueForPatternNine($rawAnswer['stress_when']);
        }else{
           $answer['stress_when']= -99;
        }



        $answer['sleep_dur'] = $this->getMappedValueForPatternSeven($rawAnswer['sleep_hours']);
        $answer['sleep_qual'] = $this->getMappedValueForPatternTwo($rawAnswer['sleep_quality']);
        $answer['sleep_interrupt'] = $rawAnswer['sleep_interruptions'];
        $answer['race'] = $this->getMappedValueForPatternTen($rawAnswer['ethnicity']);

        $answer['atrial_presence'] = 0;
        $answer['cad_presence'] = 0;
        $answer['depression_presence'] = 0;
        $answer['diabetes_presence'] = 0;
        $answer['heart_attack_presence'] = 0;
        $answer['hypertension_presence'] = 0;
        $answer['hyperlipidemia_presence'] = 0;
        $answer['apnea_presence'] = 0;
        $answer['stroke_presence'] = 0;
        $answer['atrial_control'] = null;
        $answer['cad_control'] = null;
        $answer['depression_control'] = null;
        $answer['diabetes_control'] = null;
        $answer['heart_attack_control'] = null;
        $answer['hypertension_control'] = null;
        $answer['hyperlipidemia_control'] = null;
        $answer['apnea_control'] = null;
        $answer['stroke_control'] = null;
        if(isset($rawAnswer['medical_depression'])){
        foreach ($rawAnswer['medical_depression'] as $key => $value) {
            if ($value == 0) {
                $answer['atrial_presence'] = 1;
                $answer['atrial_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_0']);
            } elseif ($value == 1) {
                $answer['cad_presence'] = 1;
                $answer['cad_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_1']);
            } elseif ($value == 2) {
                $answer['depression_presence'] = 1;
                $answer['depression_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_2']);
            } elseif ($value == 3) {
                $answer['diabetes_presence'] = 1;
                $answer['diabetes_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_3']);
            } elseif ($value == 4) {
                $answer['heart_attack_presence'] = 1;
                $answer['heart_attack_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_4']);
            } elseif ($value == 5) {
                $answer['hypertension_presence'] = 1;
                $answer['hypertension_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_5']);
            } elseif ($value == 6) {
                $answer['hyperlipidemia_presence'] = 1;
                $answer['hyperlipidemia_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_6']);
            } elseif ($value == 7) {
                $answer['apnea_presence'] = 1;
                $answer['apnea_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_7']);
            } elseif ($value == 8) {
                $answer['stroke_presence'] = 1;
                $answer['stroke_control'] = $this->getMappedValueForPatternEight($rawAnswer['medical_depression_inherit_8']);
            }
        }
        }
        $answer['occupation'] = $rawAnswer['primary_occupation'] ;
        $answer['edu'] = $this->getMappedValueForPatternTwo($rawAnswer['education_level']);
        return $answer;
    }

    private function getCalculatedScores($answers) {
        $array = [];
        $array['paf'] = $this->calculatePaf($answers);
        $array['saf'] = $this->calculateSaf($answers); // need to check later
        $array['sf'] = $this->calculateSf($answers);
        $array['daf'] = $this->calculateDaf($answers);
        $array['sco_bmi'] = $this->calculateScoBmi($answers);
        $array['sco_paf'] = $this->calculateScoPaf($array['paf']);
        $array['sco_cog_read'] = $this->calculateScoCogRead($answers);
        $array['sco_cog_puzzle'] = $this->calculateScoCogPuzzle($answers);
        $array['sco_cog_games'] = $this->calculateScoCogGames($answers);
        $array['sco_cog_art'] = $this->calculateScoCogArt($answers);

        $array['sco_mtl'] = $this->calculateScoMtl($array);

        $array['sco_saf'] = $this->calculateScoSaf($array['saf']); // check
        $array['sco_diet_fish'] = $this->calculateScoDietFish($answers);
        $array['sco_diet_veg'] = $this->calculateScoDietVeg($answers);
        $array['sco_diet_meat'] = $this->calculateScoDietMeat($answers);
        $array['sco_diet_fruit'] = $this->calculateScoDietFruit($answers);
        $array['sco_diet_chicken'] = $this->calculateScoDietChicken($answers);
        $array['sco_diet_nuts'] = $this->calculateScoDietNuts($answers);
        $array['sco_diet_whole_grain'] = $this->calculateScoDietWholeGrain($answers);
        $array['sco_diet_sugars'] = $this->calculateScoDietSugars($answers);
        $array['sco_diet_artificials'] = $this->calculateScoDietArtificials($answers);
        $array['sco_diet_olive'] = $this->calculateScoDietOlive($answers);
        $array['sco_smoke_now'] = $this->calculateScoSmokeNow($answers);
        $array['sco_daf'] = $this->calculateScoDaf($array['daf']); // check     
        $array['sco_sf'] = $this->calculateScoSf($array['sf']);
        $array['sco_sleep_dur'] = $this->calculateScoSleepDur($answers);
        $array['sco_sleep_qual'] = $this->calculateScoSleepQual($answers);
        $array['sco_sleep_interrupt'] = $this->calculateScoSleepInterrupt($answers);
        $array['sco_good_sleep'] = $array['sco_sleep_dur'] + $array['sco_sleep_qual'] + $array['sco_sleep_interrupt'];
        $array['sco_atrial_control'] = $this->calculateScoAtrialControl($answers);
        $array['sco_cad_control'] = $this->calculateScoCadControl($answers);
        $array['sco_depression_control'] = $this->calculateScoDepressionControl($answers);
        $array['sco_diabetes_control'] = $this->calculateScoDiabetsControl($answers);
        $array['sco_heart_attack_control'] = $this->calculateScoHeartAttackControl($answers);
        $array['sco_hypertension_control'] = $this->calculateScoHypertensionControl($answers);
        $array['sco_hyperlipidemia_control'] = $this->calculateScoHyperlipidemiaControl($answers);
        $array['sco_apnea_control'] = $this->calculateScoApneaControl($answers);
        $array['sco_stroke_control'] = $this->calculateScoStrokeControll($answers);


        $array['sco_asf'] = $this->calculateScoAsf($answers);
        $array['sco_edu'] = $this->calculateScoEdu($answers);
        $array['sco_smoke_ever'] = $this->calculateScoSmokeEver($answers);
        $array['cat_sco_activity'] = $this->calculateCatScoActivity($array); // check
        $array['cat_sco_diet'] = $this->calculateCatScoDiet($array);
        $array['cat_sco_lifestyle'] = $this->calculateScoLifeStyle($array);
        $array['cat_sco_medical'] = $this->calculateScoMedical($array);
        $array['cat_sco_background'] = $this->calculateCatScoBackground($array);
        $array['cat_sco_modifiable'] = $this->calculateScoModifiable($array); // check
        $array['cat_max_activity'] = $this->calculateCatMaxActivity($array); // check
        $array['cat_max_diet'] = $this->calculateCatMaxDiet($array); // check
        $array['cat_max_lifestyle'] = $this->calculateCatMaxLifeStyle($array); // check
        $array['cat_max_medical'] = $this->calculateCatMaxMedical($array); //check
        $array['cat_max_background'] = $this->calculateCatMaxBackground($array, $answers); // check
        $array['cat_max_modifiable'] = $this->calculateCatMaxModifiable($array);
        $array['cat_pct_activity'] = $this->calculateCatPctActivity($array);
        $array['cat_pct_diet'] = $this->calculateCatPctDiet($array);
        $array['cat_pct_lifestyle'] = $this->calculateCatPctLifeStyle($array);
        $array['cat_pct_medical'] = $this->calculateCatPctMedical($array);
        $array['cat_pct_background'] = $this->calculateCatPctBackground($array);
        $array['cat_pct_modifiable'] = $this->calculateCatPctModifiable($array);
        $array = $this->constructAdviceUsingScore($array,$answers);
        return $array ;
///////////////////// calculate later ///////////////////////
    }

    private function calculateScoMtl($scoreArray) {
        //'ScoCogRead+ScoCogPuzzle+ScoCogGames+ScoCogArt [0-2(Poor)3-5(Fair) 6-8(Avg) 9-11(Good) 12(Exc)] see advise_system
        return $scoreArray['sco_cog_read'] + $scoreArray['sco_cog_puzzle'] + $scoreArray['sco_cog_games'] + $scoreArray['sco_cog_art'];
    }

    private function getDecisionInfoFromDB() {
        $query = "SELECT 
                    d.group_id , 
                    d.category_id , 
                    d.score, 
                    d.evaluation_id,
                    fs.evaluation_str,
                    fs.first_advise,
                    fs.gif_name as first_sentence_gif_name,
                    ss.gif_name as second_sentence_gif_name,
                    ss.second_advise,
                    ss.reason,
                    ss.tips
                    FROM 
                    rrs_report_decision d 
                    left join
                    rrs_assessment_1st_sentence fs
                    on 
                    d.evaluation_id = fs.evaluation_id 
                    left join 
                    rrs_assessment_2nd_sentence ss 
                    on 
                    d.category_id = ss.category_id";
        $decisionObj = DB::select(DB::raw($query));
        $decisionArray = [];
        foreach ($decisionObj as $key => $obj) {
            $decisionArray[$obj->category_id][$obj->score]['evaluation_str'] = $obj->evaluation_str;
            $decisionArray[$obj->category_id][$obj->score]['first_advise'] = $obj->first_advise;
            $decisionArray[$obj->category_id][$obj->score]['first_sentence_gif_name'] = $obj->first_sentence_gif_name;
            $decisionArray[$obj->category_id][$obj->score]['second_sentence_gif_name'] = $obj->second_sentence_gif_name;
            $decisionArray[$obj->category_id][$obj->score]['second_advise'] = $obj->second_advise;
            $decisionArray[$obj->category_id][$obj->score]['reason'] = $obj->reason;
            $decisionArray[$obj->category_id][$obj->score]['tips'] = $obj->tips;
        }
        return $decisionArray;
    }

    private function constructAdviceUsingScore($scoreArray,$answers) {
        $decisionArray = $this->getDecisionInfoFromDB();
        $scoreArray['adv_sco_bmi'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_bmi'], PegaraConstant::SCO_BMI_CATEGORY_ID);
        $scoreArray['adv_sco_paf'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_paf'], PegaraConstant::SCO_PAF_CATEGORY_ID);
        $scoreArray['adv_sco_mtl'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_mtl'], PegaraConstant::SCO_MTL_CATEGORY_ID);
        $scoreArray['adv_sco_saf'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_saf'], PegaraConstant::SCO_SAF_CATEGORY_ID);

        $scoreArray['adv_sco_diet_fish'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_fish'], PegaraConstant::SCO_DIET_FISH_CATEGORY_ID);
        $scoreArray['adv_sco_diet_veg'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_veg'], PegaraConstant::SCO_DIET_VEG_CATEGORY_ID);
        $scoreArray['adv_sco_diet_meat'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_meat'], PegaraConstant::SCO_DIET_MEAT_CATEGORY_ID);
        $scoreArray['adv_sco_diet_fruit'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_fruit'], PegaraConstant::SCO_DIET_FRUIT_CATEGORY_ID);
        $scoreArray['adv_sco_diet_chicken'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_chicken'], PegaraConstant::SCO_DIET_CHICKEN_CATEGORY_ID);
        $scoreArray['adv_sco_diet_nuts'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_nuts'], PegaraConstant::SCO_DIET_NUTS_CATEGORY_ID);
        $scoreArray['adv_sco_diet_whole_grain'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_whole_grain'], PegaraConstant::SCO_DIET_WHOLE_GRAIN_CATEGORY_ID);
        $scoreArray['adv_sco_diet_sugars'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_sugars'], PegaraConstant::SCO_DIET_SUGAR_CATEGORY_ID);
        $scoreArray['adv_sco_diet_artificials'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_artificials'], PegaraConstant::SCO_DIET_ARTIFICIALS_CATEGORY_ID);
        $scoreArray['adv_sco_diet_olive'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diet_olive'], PegaraConstant::SCO_DIET_OLIVE_CATEGORY_ID);

        $scoreArray['adv_sco_smoke_now'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_smoke_now'], PegaraConstant::SCO_SMOKE_NOW_CATEGORY_ID);
        $scoreArray['adv_sco_mod_drink'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_daf'], PegaraConstant::SCO_DAF_CATEGORY_ID);
        $scoreArray['adv_sco_stress'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_sf'], PegaraConstant::SCO_SF_CATEGORY_ID);
        $scoreArray['adv_sco_good_sleep'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_good_sleep'], PegaraConstant::SCO_GOOD_SLEEP_CATEGORY_ID);

        $scoreArray['adv_sco_atrial_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_atrial_control'], PegaraConstant::SCO_ATRIAL_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_cad_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_cad_control'], PegaraConstant::SCO_CAD_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_depression_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_depression_control'], PegaraConstant::SCO_DEPRESSION_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_diabetes_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_diabetes_control'], PegaraConstant::SCO_DIABETES_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_heart_attack_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_heart_attack_control'], PegaraConstant::SCO_HEART_ATTACK_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_hypertension_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_hypertension_control'], PegaraConstant::SCO_HYPERTENSION_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_hyperlipidemia_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_hyperlipidemia_control'], PegaraConstant::SCO_HYPERLIPIDEMIA_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_apnea_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_apnea_control'], PegaraConstant::SCO_APNEA_CONTROL_CATEGORY_ID);
        $scoreArray['adv_sco_stroke_control'] = $this->getCSVFormattedAdviceString($decisionArray, $scoreArray['sco_stroke_control'], PegaraConstant::SCO_STROKE_CONTROL_CATEGORY_ID);


        $scoreArray['adv_sco_atrial_control']['score']['display'] = $answers['atrial_presence'];
        $scoreArray['adv_sco_cad_control']['score']['display'] = $answers['cad_presence'];
        $scoreArray['adv_sco_depression_control']['score']['display'] = $answers['depression_presence'];
        $scoreArray['adv_sco_diabetes_control']['score']['display'] = $answers['diabetes_presence'];
        $scoreArray['adv_sco_heart_attack_control']['score']['display'] = $answers['heart_attack_presence'];
        $scoreArray['adv_sco_hypertension_control']['score']['display'] = $answers['hypertension_presence'];
        $scoreArray['adv_sco_hyperlipidemia_control']['score']['display'] = $answers['hyperlipidemia_presence'];
        $scoreArray['adv_sco_apnea_control']['score']['display'] = $answers['apnea_presence'];
        $scoreArray['adv_sco_stroke_control']['score']['display'] = $answers['stroke_presence'];
        
        

        return $scoreArray;
    }

    private function formatStringForCSV($string) {
        $string = str_replace('"', '', $string);
        $string = '"' . $string . '"';
        return $string;
    }

    private function getCSVFormattedAdviceString($decisionArray, $score, $categoryId) {
        $array=[];
        $csvString = '';
        $array2=[];
//        if (!is_numeric($score) || $score == -9) {
//            if($categoryId>400 && $categoryId<500){
//                $score = 3;
//            }else{
//              $score = 0;    
//            }
//        }
        if (isset($decisionArray[$categoryId][$score])) {
            $decision = $decisionArray[$categoryId][$score];
            $firstGif = $this->formatStringForCSV($decision['first_sentence_gif_name']);
            $evaluationGif = $this->formatStringForCSV($decision['second_sentence_gif_name']);
            $firstSentence = $this->formatStringForCSV($decision['first_advise']);
            $secondSentence = $this->formatStringForCSV($decision['second_advise']);
            $reason = $this->formatStringForCSV($decision['reason']);
            $tips = $this->formatStringForCSV($decision['tips']);
            $csvString = $firstGif . "," . $evaluationGif . "," . $firstSentence . "," . $secondSentence . "," . $reason . "," . $tips;
            $array2 = $decision;
        }
        $array2['display'] = 1;
        $array['csv'] = $csvString;
        $array['score'] = $array2 ; 
        return $array;
    }

    private function calculateCatPctModifiable($scoreArray) {
        $score = 0;
        //'(CatScoModifiable/CatScoModifiable)*100
        $score = ($scoreArray['cat_sco_modifiable'] / $scoreArray['cat_max_modifiable']) * 100;
        return $score;
    }

    private function calculateCatPctBackground($scoreArray) {
        $score = 0;
        //''(CatScoBackground/CatScoBackground)*100
        $score = ($scoreArray['cat_sco_background'] / $scoreArray['cat_max_background']) * 100;
        return $score;
    }

    private function calculateCatPctMedical($scoreArray) {
        $score = 0;
        //'(CatScoMedical/CatMaxMedical)*100
        if($scoreArray['cat_max_medical'] == 0){
            $score = 100 ;
        }else{
            $score = ($scoreArray['cat_sco_medical'] / $scoreArray['cat_max_medical']) * 100; 
        }
        return $score;
    }

    private function calculateCatPctLifeStyle($scoreArray) {
        $score = 0;
        //'(CatScoLifestyle/CatMaxLifestyle)*100
        $score = ($scoreArray['cat_sco_lifestyle'] / $scoreArray['cat_max_lifestyle']) * 100;
        return $score;
    }

    private function calculateCatPctDiet($scoreArray) {
        $score = 0;
        //'(CatScoDiet/CatMaxDiet)*100
        $score = ($scoreArray['cat_sco_diet'] / $scoreArray['cat_max_diet']) * 100;
        return $score;
    }

    private function calculateCatPctActivity($scoreArray) {
        $score = 0;
        //'(CatScoActivity/CatMaxActivity)*100
        $score = ($scoreArray['cat_sco_activity'] / $scoreArray['cat_max_activity']) * 100;
        return $score;
    }

    private function calculateCatMaxModifiable($scoreArray) {
        $score = 0;
        //'SUM(CatMaxActivity,CatMaxDiet,CatMaxLifestyle,CatMaxMedical)
        $score = $scoreArray['cat_max_activity'] +
                $scoreArray['cat_max_diet'] +
                $scoreArray['cat_max_lifestyle'] +
                $scoreArray['cat_max_medical'];
        return $score;
    }

    private function calculateCatMaxBackground($scoreArray, $answers) {
        $score = 0;
        //'SUM(IF(ScoASF="",0,IF(Gender=1,41,IF(Gender=2,38,""))),IF(ScoEdu="",0,6),IF(ScoSmokeEver="",0,3))
        if ($scoreArray['sco_asf'] !== "") {
            if ($answers['gender'] == 1) {
                $score+=41;
            } elseif ($answers['gender'] == 2) {
                $score+=38;
            }
        }
        if ($scoreArray['sco_edu'] !== "") {
            $score+=6;
        }
        if ($scoreArray['sco_smoke_ever'] !== "") {
            $score+=3;
        }

        return $score;
    }

    private function calculateCatMaxMedical($scoreArray) {
        $score = 0;
        //'SUM(IF(ScoAtrialControl=-9,0,3),IF(ScoCADControl=-9,0,3),IF(ScoDepressionControl=-9,0,3),IF(ScoDiabetesControl=-9,0,3),IF(ScoHeartAttackControl=-9,0,3),IF(ScoHypertensionControl=-9,0,3),IF(ScoHyperlipidemiaControl=-9,0,3),IF(ScoApneaControl=-9,0,3),IF(ScoStrokeControl=-9,0,3))
        if ($scoreArray['sco_atrial_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_cad_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_depression_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_diabetes_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_heart_attack_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_hypertension_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_hyperlipidemia_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_apnea_control'] != -9) {
            $score+=3;
        }
        if ($scoreArray['sco_stroke_control'] != -9) {
            $score+=3;
        }
        return $score;
    }

    private function calculateCatMaxLifeStyle($scoreArray) {
//        $score = 0;
//        //'SUM(IF(ScoSmokeNow="",0,1),IF(ScoDAF="",0,3),IF(ScoSF="",0,3),IF(ScoSleepDur="",0,2),IF(ScoSleepQual="",0,1),IF(ScoSleepInterrupt="",0,1))
//        if ($scoreArray['sco_smoke_now'] !== "") {
//            $score+=1;
//        }
//        if ($scoreArray['sco_daf'] !== "") {
//            $score+=3;
//        }
//        if ($scoreArray['sco_sf'] !== "") {
//            $score+=3;
//        }
//        if ($scoreArray['sco_sleep_dur'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_sleep_qual'] !== "") {
//            $score+=1;
//        }
//        if ($scoreArray['sco_sleep_interrupt'] !== "") {
//            $score+=1;
//        }
        return 11;
    }

    private function calculateCatMaxDiet($scoreArray) {
//        $score = 0;
//        //'SUM(IF(ScoDietFish="",0,5),IF(ScoDietVeg="",0,4),IF(ScoDietMeat="",0,3),IF(ScoDietFruit="",0,2),IF(ScoDietChicken="",0,2),IF(ScoDietNuts="",0,2),IF(ScoDietWholeGrain="",0,2),IF(ScoDietSugars="",0,2),IF(ScoDietArtificials="",0,2),IF(ScoDietOlive="",0,2))
//        if ($scoreArray['sco_diet_fish'] !== "") {
//            $score+=5;
//        }
//        if ($scoreArray['sco_diet_veg'] !== "") {
//            $score+=4;
//        }
//        if ($scoreArray['sco_diet_meat'] !== "") {
//            $score+=3;
//        }
//        if ($scoreArray['sco_diet_fruit'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_chicken'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_nuts'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_whole_grain'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_sugars'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_artificials'] !== "") {
//            $score+=2;
//        }
//        if ($scoreArray['sco_diet_olive'] !== "") {
//            $score+=2;
//        }
        return 26;
    }

    private function calculateCatMaxActivity($scoreArray) {
//        $score = 0;
//        //'SUM(IF(ScoBMI="",0,5),IF(ScoPAF="",0,9),IF(ScoCogRead="",0,4),IF(ScoCogPuzzle="",0,4),IF(ScoCogGames="",0,3),IF(ScoCogArt="",0,1),IF(ScoSAF="",0,6)))
//        if ($scoreArray['sco_bmi'] !== "") {
//            $score+=5;
//        }
//        if ($scoreArray['sco_paf'] !== "") {
//            $score+=9;
//        }
//        if ($scoreArray['sco_cog_read'] !== "") {
//            $score+=4;
//        }
//        if ($scoreArray['sco_cog_puzzle'] !== "") {
//            $score+=4;
//        }
//        if ($scoreArray['sco_cog_games'] !== "") {
//            $score+=3;
//        }
//        if ($scoreArray['sco_cog_art'] !== "") {
//            $score+=1;
//        }
//        if ($scoreArray['sco_saf'] !== "") {
//            $score+=6;
//        }
        return 32;
    }

    private function calculateScoModifiable($scoreArray) {
        $score = 0;
        //'sum(CatScoActivity,CatScoDiet,CatScoLifestyle,CatScoMedical)
        $score = $this->formatScore($scoreArray['cat_sco_activity']) +
                $this->formatScore($scoreArray['cat_sco_diet']) +
                $this->formatScore($scoreArray['cat_sco_lifestyle']) +
                $this->formatScore($scoreArray['cat_sco_medical']);
        return $score;
    }

    private function calculateCatScoBackground($scoreArray) {
        $score = 0;
        //'sum(ScoASF,ScoEdu,ScoSmokeEver)
        $score = $this->formatScore($scoreArray['sco_asf']) +
                $this->formatScore($scoreArray['sco_edu']) +
                $this->formatScore($scoreArray['sco_smoke_ever']);
        return $score;
    }

    private function calculateScoMedical($scoreArray) {
        $score = 0;
//        'sum(
                //    IF(ScoAtrialControl=-9,0,ScoAtrialControl),
                //    IF(ScoCADControl=-9,0,ScoCADControl),
                //    IF(ScoDepressionControl=-9,0,ScoDepressionControl),
                //    IF(ScoDiabetesControl=-9,0,ScoDiabetesControl),
                //    IF(ScoHeartAttackControl=-9,0,ScoHeartAttackControl),
                //    IF(ScoHypertensionControl=-9,0,ScoHypertensionControl),
                //    IF(ScoHyperlipidemiaControl=-9,0,ScoHyperlipidemiaControl),
                //    IF(ScoApneaControl=-9,0,ScoApneaControl),
                //    IF(ScoStrokeControl=-9,0,ScoStrokeControl)
             //)
        
        
        $score =$this->formatScore($scoreArray['sco_atrial_control']) +
                $this->formatScore($scoreArray['sco_cad_control']) +
                $this->formatScore($scoreArray['sco_depression_control']) +
                $this->formatScore($scoreArray['sco_diabetes_control']) +
                $this->formatScore($scoreArray['sco_heart_attack_control']) +
                $this->formatScore($scoreArray['sco_hypertension_control']) +
                $this->formatScore($scoreArray['sco_hyperlipidemia_control']) +
                $this->formatScore($scoreArray['sco_apnea_control']) +
                $this->formatScore($scoreArray['sco_stroke_control']);
        return $score;
    }

    private function formatScore($score) {
        $score = $score == -9  ? 0 : $score;
        return $score;
    }

    private function calculateScoLifeStyle($scoreArray) {
        $score = 0;
        //'sum(ScoSmokeNow,ScoDAF,ScoSF,ScoSleepDur,ScoSleepQual,ScoSleepInterrupt)
        $score = $this->formatScore($scoreArray['sco_smoke_now']) +
                $this->formatScore($scoreArray['sco_daf']) +
                $this->formatScore($scoreArray['sco_sf']) +
                $this->formatScore($scoreArray['sco_sleep_dur']) +
                $this->formatScore($scoreArray['sco_sleep_qual']) +
                $this->formatScore($scoreArray['sco_sleep_interrupt']);
        return $score;
    }

    private function calculateCatScoDiet($scoreArray) {
        $score = 0;
        //'sum(ScoDietFish,ScoDietVeg,ScoDietMeat,ScoDietFruit,ScoDietChicken,ScoDietNuts,ScoDietWholeGrain,ScoDietSugars,ScoDietArtificials,ScoDietOlive)
        $score = $this->formatScore($scoreArray['sco_diet_fish']) +
                $this->formatScore($scoreArray['sco_diet_veg']) +
                $this->formatScore($scoreArray['sco_diet_meat']) +
                $this->formatScore($scoreArray['sco_diet_fruit']) +
                $this->formatScore($scoreArray['sco_diet_chicken']) +
                $this->formatScore($scoreArray['sco_diet_nuts']) +
                $this->formatScore($scoreArray['sco_diet_whole_grain']) +
                $this->formatScore($scoreArray['sco_diet_sugars']) +
                $this->formatScore($scoreArray['sco_diet_artificials']) +
                $this->formatScore($scoreArray['sco_diet_olive']);
        return $score;
    }

    private function calculateCatScoActivity($scoreArray) {
        $score = 0;
        //'sum(ScoBMI,ScoPAF,ScoCogRead,ScoCogPuzzle,ScoCogGames,ScoCogArt,ScoSAF)
        $score = $this->formatScore($scoreArray['sco_bmi']) +
                $this->formatScore($scoreArray['sco_paf']) +
                $this->formatScore($scoreArray['sco_cog_read']) +
                $this->formatScore($scoreArray['sco_cog_puzzle']) +
                $this->formatScore($scoreArray['sco_cog_games']) +
                $this->formatScore($scoreArray['sco_cog_art']) +
                $this->formatScore($scoreArray['sco_saf']);
        return $score;
    }

    private function calculateScoSmokeEver($answers) {
        $score = 0;
        //'IF(SmokeEver=0,3,IF(SmokeEver=1,0,""))
        $smokeEver = $answers['smoke_ever'];
        if ($smokeEver == 0) {
            $score = 3;
        }
        return $score;
    }

    private function calculateScoEdu($answers) {
        $score = 0;
        //'IF(Edu=1,0,IF(Edu=2,3,IF(Edu>2,6,"")))
        $edu = $answers['edu'];
        if ($edu == 2) {
            $score = 3;
        } elseif ($edu > 2) {
            $score = 6;
        }
        return $score;
    }

    private function calculateScoAsf($answers) {
        $score = 0;
        $birthDate = $answers['birthday'];
        $gender = $answers['gender'];
        $ageObj = date_diff(date_create($birthDate), date_create('now'));
        $ageInYear = $ageObj->y;
        //'IF(GENDER=1,IF(AGE<65,41,IF(AGE<70,35,IF(AGE<75,29,IF(AGE<80,21,IF(AGE<85,14,IF(AGE<90,5,0)))))),IF(GENDER=2,IF(AGE<65,38,IF(AGE<70,33,IF(AGE<75,26,IF(AGE<80,16,IF(AGE<85,12,IF(AGE<90,1,0)))))),""))
        if ($gender == 1) {
            if ($ageInYear < 65) {
                $score = 41;
            } elseif ($ageInYear < 70) {
                $score = 35;
            } elseif ($ageInYear < 75) {
                $score = 29;
            } elseif ($ageInYear < 80) {
                $score = 21;
            } elseif ($ageInYear < 85) {
                $score = 14;
            } elseif ($ageInYear < 90) {
                $score = 5;
            }
        } else {
            if ($ageInYear < 65) {
                $score = 38;
            } elseif ($ageInYear < 70) {
                $score = 33;
            } elseif ($ageInYear < 75) {
                $score = 26;
            } elseif ($ageInYear < 80) {
                $score = 16;
            } elseif ($ageInYear < 85) {
                $score = 12;
            } elseif ($ageInYear < 90) {
                $score = 1;
            }
        }
        return $score;
    }

    private function calculateScoStrokeControll($answers) {
        $score = 0;
        //'IF(OR(StrokeControl=null,StrokeControl=-99),-9,IF(StrokeControl=0,0,IF(OR(StrokeControl=1,StrokeControl=2,StrokeControl=3),3,-9)))
        $strokeControl = $answers['stroke_control'];
        if ($strokeControl == -99 || $strokeControl === null) {
            $score = -9;
        } elseif ($strokeControl == 0) {
            $score = 0;
        } elseif ($strokeControl >= 1 && $strokeControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoApneaControl($answers) {
        $score = 0;
        //'IF(OR(ApneaControl=null,ApneaControl=-99),-9,IF(ApneaControl=0,0,IF(OR(ApneaControl=1,ApneaControl=2,ApneaControl=3),3,-9)))
        $apneaControl = $answers['apnea_control'];
        if ($apneaControl == -99 || $apneaControl === null) {
            $score = -9;
        } elseif ($apneaControl == 0) {
            $score = 0;
        } elseif ($apneaControl >= 1 && $apneaControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoHyperlipidemiaControl($answers) {
        $score = 0;
        // IF(OR(HyperlipidemiaControl=null,HyperlipidemiaControl=-99),-9,IF(HyperlipidemiaControl=0,0,IF(OR(HyperlipidemiaControl=1,HyperlipidemiaControl=2,HyperlipidemiaControl=3),3,-9)))
        $hyperlipidemiaControl = $answers['hyperlipidemia_control'];
        if ($hyperlipidemiaControl == -99 || $hyperlipidemiaControl === null) {
            $score = -9;
        } elseif ($hyperlipidemiaControl == 0) {
            $score = 0;
        } elseif ($hyperlipidemiaControl >= 1 && $hyperlipidemiaControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoHypertensionControl($answers) {
        $score = 0;
        //IF(OR(HypertensionControl=null,HypertensionControl=-99),-9,IF(HypertensionControl=0,0,IF(OR(HypertensionControl=1,HypertensionControl=2,HypertensionControl=3),3,-9)))
        $hypertensionControl = $answers['hypertension_control'];
        if ($hypertensionControl == -99 || $hypertensionControl === null) {
            $score = -9;
        } elseif ($hypertensionControl == 0) {
            $score = 0;
        } elseif ($hypertensionControl >= 1 && $hypertensionControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoHeartAttackControl($answers) {
        $score = 0;
        //IF(OR(HeartAttackControl=null,HeartAttackControl=-99),-9,IF(HeartAttackControl=0,0,IF(OR(HeartAttackControl=1,HeartAttackControl=2,HeartAttackControl=3),3,-9)))
        $heartAttackControl = $answers['heart_attack_control'];
        if ($heartAttackControl == -99 || $heartAttackControl === null) {
            $score = -9;
        } elseif ($heartAttackControl == 0) {
            $score = 0;
        } elseif ($heartAttackControl >= 1 && $heartAttackControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoDiabetsControl($answer) {
        $score = 0;
      //IF(OR(DiabetesControl=null,DiabetesControl=-99),-9,IF(DiabetesControl=0,0,IF(OR(DiabetesControl=1,DiabetesControl=2,DiabetesControl=3),3,-9)))
        $diabetsControl = $answer['diabetes_control'];
        if ($diabetsControl == -99 || $diabetsControl === null) {
            $score = -9;
        } elseif ($diabetsControl == 0) {
            $score = 0;
        } elseif ($diabetsControl >= 1 && $diabetsControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoDepressionControl($answers) {
        $score = 0;
       //'IF(OR(DepressionControl=null,DepressionControl=-99),-9,IF(DepressionControl=0,0,IF(OR(DepressionControl=1,DepressionControl=2,DepressionControl=3),3,-9)))
        $depressionControl = $answers['depression_control'];
        if ($depressionControl == -99 || $depressionControl === null) {
            $score = -9;
        } elseif ($depressionControl == 0) {
            $score = 0;
        } elseif ($depressionControl >= 1 && $depressionControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoCadControl($answers) {
        $score = 0;
    //   'IF(OR(CADControl=null,CADControl=-99),-9,IF(CADControl=0,0,IF(OR(CADControl=1,CADControl=2,CADControl=3),3,-9)))
        $cadControl = $answers['cad_control'];
        if ($cadControl == -99 || $cadControl === null) {
            $score = -9;
        } elseif ($cadControl == 0) {
            $score = 0;
        } elseif ($cadControl >= 1 && $cadControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoAtrialControl($answers) {
        $score = 0;
        //'IF(OR(AtrialControl=null,AtrialControl=-99),-9,IF(AtrialControl=0,0,IF(OR(AtrialControl=1,AtrialControl=2,AtrialControl=3),3,-9)))
        $atrialControl = $answers['atrial_control'];
        if ($atrialControl == -99 || $atrialControl === null) {
            $score = -9;
        } elseif ($atrialControl == 0) {
            $score = 0;
        } elseif ($atrialControl >= 1 && $atrialControl <= 3) {
            $score = 3;
        } else {
            $score = -9;
        }
        return $score;
    }

    private function calculateScoSleepInterrupt($answers) {
        $score = 0;
        //'IF(SleepInterrupt=0,1,IF(SleepInterrupt>0,0,""))
        $sleepInterrupt = $answers['sleep_interrupt'];
        if ($sleepInterrupt == 0) {
            $score = 1;
        } elseif ($sleepInterrupt > 0) {
            $score = 0;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoSleepQual($answers) {
        $score = 0;
        //'IF(SleepQual=1,0,IF(SleepQual>1,1,""))
        $sleepQual = $answers['sleep_qual'];
        if ($sleepQual == 1) {
            $score = 0;
        } elseif ($sleepQual > 1) {
            $score = 1;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoSleepDur($answers) {
        $score = 0;
        $sleepDur = $answers['sleep_dur'];
        //'IF(AND(SleepDur>=7,SleepDur<=8),2,0)
        if ($sleepDur >= 7 && $sleepDur <= 8) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoSf($sf) {
        $score = 0;
        //'IF(SF=0,3,0)
        if ($sf == 0) {
            $score = 3;
        }
        return $score;
    }

    private function calculateScoDaf($daf) {
        $score = 0;
        //'IF(DAF3=1,3,0)
        if ($daf == 1) {
            $score = 3;
        }
        return $score;
    }

    private function calculateScoSmokeNow($answers) {
        $score = 0;
        //'IF(SmokeNow=0,1,IF(SmokeNow=1,0,""))
        $smokeNow = $answers['smoke_now'];
        if ($smokeNow == 0) {
            $score = 1;
        } elseif ($smokeNow == 1) {
            $score = 0;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoDietOlive($answers) {
        $score = 0;
        //'IF(OR(DietOlive=-9,DietOlive=-99),0,IF(DietOlive=0,0,IF(DietOlive=1,1,IF(DietOlive=2,2,IF(DietOlive=3,2,"")))))
        $dietOlive = $answers['diet_olive'];
        if ($dietOlive == -9 || $dietOlive == -99 || $dietOlive == 0) {
            $score = 0;
        } elseif ($dietOlive == 1) {
            $score = 1;
        } elseif ($dietOlive >= 2) {
            $score = 2;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoDietArtificials($answers) {
        $score = 0;
        //'IF(DietArtificials=1,2,IF(DietArtificials=2,1,IF(DietArtificials>2,0,"")))
        $dietArtificials = $answers['diet_artificials'];
        if ($dietArtificials == 1) {
            $score = 2;
        } elseif ($dietArtificials == 2) {
            $score = 1;
        } elseif ($dietArtificials > 2) {
            $score = 0;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoDietSugars($answers) {
        $score = 0;
        $dietSugars = $answers['diet_sugars'];
        //'IF(DietSugars<4,2,IF(DietSugars=4,1,IF(DietSugars=5,0,"")))
        if ($dietSugars < 4) {
            $score = 2;
        } elseif ($dietSugars == 4) {
            $score = 1;
        } elseif ($dietSugars == 5) {
            $score = 0;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoDietWholeGrain($answers) {
        $score = 0;
        //'IF(DietWholeGrain<4,0,IF(DietWholeGrain<=6,1,IF(DietWholeGrain=7,2,"")))
        $dietWholeGrain = $answers['diet_whole_grain'];
        if ($dietWholeGrain < 4) {
            $score = 0;
        } elseif ($dietWholeGrain <= 6) {
            $score = 1;
        } elseif ($dietWholeGrain == 7) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoDietNuts($answers) {
        $score = 0;
        $dietNuts = $answers['diet_nuts'];
        //'IF(DietNuts=0,0,IF(DietNuts<=4,1,IF(DietNuts>4,2,"")))
        if ($dietNuts == 0) {
            $score = 0;
        } elseif ($dietNuts <= 4) {
            $score = 1;
        } elseif ($dietNuts > 4) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoDietChicken($answers) {
        $score = 0;
        //'IF(DietChicken=0,0,IF(DietChicken=1,1,IF(DietChicken>1,2,"")))
        $dietChicken = $answers['diet_chicken'];
        if ($dietChicken == 1) {
            $score = 1;
        } elseif ($dietChicken > 1) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoDietFruit($answers) {
        $score = 0;
        //'IF(DietFruit<1,0,IF(DietFruit<=2,1,IF(DietFruit>2,2,"")))
        $dietFruit = $answers['diet_fruit'];
        if ($dietFruit < 1) {
            $score = 0;
        } elseif ($dietFruit <= 2) {
            $score = 1;
        } elseif ($dietFruit > 2) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoDietMeat($answers) {
        $score = 0;
        //'IF(DietMeat<4,3,IF(DietMeat<7,2,IF(DietMeat=7,0,"")))
        $dietMeat = $answers['diet_meat'];
        if ($dietMeat < 4) {
            $score = 3;
        } elseif ($dietMeat < 7) {
            $score = 2;
        } elseif ($dietMeat == 7) {
            $score = 0;
        }
        return $score;
    }

    private function calculateScoDietVeg($answers) {
        //'IF(DietVeg=0,0,IF(DietVeg=1,1,IF(DietVeg<7,3,IF(DietVeg=7,4,""))))
        $score = 0;
        $dietVeg = $answers['diet_veg'];
        if ($dietVeg == 0) {
            $score = 0;
        } elseif ($dietVeg == 1) {
            $score = 1;
        } elseif ($dietVeg < 7) {
            $score = 3;
        } elseif ($dietVeg == 7) {
            $score = 4;
        }
        return $score;
    }

    private function calculateScoDietFish($answers) {
        // 'IF(DietFish=0,0,IF(DietFish=1,3,IF(DietFish<=4,4,IF(DietFish>4,5,""))))
        $score = 0;
        $dietFish = $answers['diet_fish'];
        if($dietFish == 0){
            $score = 0 ;
        }
        elseif ($dietFish == 1) {
            $score = 3;
        } elseif ($dietFish <= 4) {
            $score = 4;
        } elseif ($dietFish > 4) {
            $score = 5;
        }
        return $score;
    }

    private function calculateScoSaf($saf) {
        $score = 0;
        //'IF(SAF<3,1,IF(SAF<5,4,IF(SAF=5,6,"")))
        if ($saf < 3) {
            $score = 1;
        } elseif ($saf < 5) {
            $score = 4;
        } elseif ($saf == 5) {
            $score = 6;
        }
        return $score;
    }

    private function calculateScoCogArt($answers) {
        $score = 0;
        //'IF(CogArt<4,0,IF(CogArt>=4,1,""))
        $cogArt = $answers['cog_art'];
        if ($cogArt >= 4) {
            $score = 1;
        }
        return $score;
    }

    private function calculateScoCogGames($answers) {
        $score = 0;
        //   'IF(CogGames<4,0,IF(CogGames>=4,3,""))
        $cogGames = $answers['cog_games'];
        if ($cogGames >= 4) {
            $score = 3;
        }
        return $score;
    }

    private function calculatePaf($answers) {
      //  PhysLight * IF(PhysLightDur>0,PhysLightDur, 30) * 3 + PhysMod * IF(PhysModDur>0,PhysModDur, 30) * 5 + PhysVig * IF(PhysVigDur>0, PhysVigDur, 30) *9    // correct
        $score = 0;
        $physLight = $answers['phys_light'];
        $physLightDur = $answers['phys_light_dur'];
        $physMod = $answers['phys_mod'];
        $physModDur = $answers['phys_mod_dur'];
        $physVig = $answers['phys_vig'];
        $physVigDur = $answers['phys_vig_dur'];
        if($physLightDur>0){
            $score+= $physLight*$physLightDur * 3 ;
        }else{
            $score+= $physLight*30*3 ;
        }
        if($physModDur > 0){
            $score += $physMod*$physModDur*5 ;
        }else{
            $score += $physMod*30*5 ;
        }
        
        if($physVigDur > 0 ){
            $score += $physVig*$physVigDur*9 ;  
        }else{
            $score += $physVig*30*9 ;
        }
        return $score;
    }

    private function calculateSaf($answers) {
       
        // SUM(IF(MaritalStat=2,1,IF(MaritalStat=3,1,0)),IF(LivingFamily=1,1,IF(LivingFriend=1,1,0)),IF(GroupEvents>3,1,0),IF(SocialEvents>3,1,0),IF(Confidant=1,1,0)) // correct
        $score = 0;
        $maritalStatus = $answers['marital_stat'];
        $livingFamily = $answers['living_family'];
        $livingFriend = $answers['living_friends'];
        $groupEvents = $answers['group_events'];
        $socialEvents = $answers['social_events'];
        $confidant = $answers['confidant'];
        if ($maritalStatus == 2 || $maritalStatus == 3) {
            $score+=1;
        }
        if ($livingFamily == 1 || $livingFriend == 1) {
            $score+=1;
        }
        if ($groupEvents > 3) {
            $score+=1;
        }
        if ($socialEvents > 3) {
            $score+=1;
        }
        if ($confidant == 1) {
            $score+=1;
        }
        return $score;
    }

    private function calculateSf($answers) {
        //  'IF(OR(StressFreq="",StressWhen="",StressFreq=-99,StressWhen=-99),0,IF(StressFreq=3,IF(StressWhen=2,1,IF(StressWhen=3,1,0)),0))
        $score = 0;
        $stressFreq = $answers['stress_freq'];
        $stressWhen = $answers['stress_when'];
        if ($stressFreq == 3) {
            if ($stressWhen == 2 || $stressWhen == 3) {
                $score+=1;
            }
        }
        return $score;
    }

    private function calculateDaf($answers) {
        //'IF(OR((DrinkFreq=""),(DrinkIntense=""),(DrinkFreq=-99),(DrinkIntense=-99)),0,IF(DrinkFreq>=4,IF(OR(DrinkIntense=1,DrinkIntense=2),1,0),0))
        $score = 0;
        $drinkFreq = $answers['drink_freq'];
        $drinkIntense = $answers['drink_intense'];
        if ($drinkFreq >= 4) {
            if ($drinkIntense == 1 || $drinkIntense == 2) {
                $score = 1;
            }
        }
        return $score;
    }

    private function calculateScoBmi($answers) {
        // 'IF(BMI<25,5,IF(BMI<30,2,0))
        $score = 0;
        $bmi = $answers['bmi'];
        if ($bmi < 25) {
            $score = 5;
        } else if ($bmi < 30) {
            $score = 2;
        }
        return $score;
    }

    private function calculateScoPaf($paf) {
        //'IF(PAF<200,0,IF(PAF<700,6,IF(PAF>=700,9,"")))
        $score = 0;
        if ($paf < 200) {
            $score = 0;
        } elseif ($paf < 700) {
            $score = 6;
        } elseif ($paf >= 700) {
            $score = 9;
        } else {
            $score = "";
        }
        return $score;
    }

    private function calculateScoCogRead($answers) {
        $cogRead = $answers['cog_read'];
        $score = 0;
        // 'IF(CogRead<4,0,IF(CogRead>=4,4,""))
        if ($cogRead >= 4) {
            $score = 4;
        }
        return $score;
    }

    private function calculateScoCogPuzzle($answers) {
        $score = 0;
        $cogPuzzle = $answers['cog_puzzle'];
        //  'IF(CogPuzzle<4,0,IF(CogPuzzle>=4,4,""))
        if ($cogPuzzle >= 4) {
            $score = 4;
        }
        return $score;
    }

}
