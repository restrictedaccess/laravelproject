<?php
namespace App\Core\Service;

use App\Core\Util\Enum\SatisfactionType;
use App\Core\Util\Enum\SurveyWhyNotWillingToUse;
use App\Core\Util\Enum\SurveyWillingToPayAmount;
use App\Core\Util\Enum\SurveyYesNo;
use App\Facades\PegaraConstant;
use Illuminate\Support\Facades\DB;

class SurveyService {
    
    public function isInvalid($token, &$userId){
        $isInValid = false;
        
        if(strlen($token)!=PegaraConstant::SURVEY_TOKEN_LENGTH){
            $isInValid = true;
        }
        if($this->isInValidSurveyToken($token , $userId )){
            $isInValid = true;
        }
        return $isInValid ;
    }
    public function getSurveyConfirmData($surveyInfo) {
       $surveyInfo['satisfaction'] = $this->getTextFromEnumForSurveyConfirmPage(SatisfactionType::getOrderedEnums() , $surveyInfo['satisfaction']);
       $surveyInfo['program_want_to_try'] = $this->getTextFromEnumForSurveyConfirmPage(SurveyYesNo::getOrderedEnums() , $surveyInfo['program_want_to_try']);
       return $surveyInfo;
    }
    
    public function insertSurveyInfo($surveyInfo) {
        $surveyInfoArray = $this->getSurveyInfoArray($surveyInfo);
        DB::table('rrs_quick_survey')
            ->insert($surveyInfoArray);
        $this->removeTokenFromUserTable($surveyInfoArray['user_id']);
    }
    
    private function removeTokenFromUserTable($userId) {
        DB::table('users')
                ->where('id', '=', $userId)
                ->update(array('survey_token'=>''));
    }
    private function getSurveyInfoArray($surveyInfo) {
        $surveyInfo['user_id'] = $surveyInfo['userId'];
        unset($surveyInfo['userId']);
        if ($surveyInfo['program_want_to_try'] == 1) {
            $surveyInfo['program_why_not'] = "";
        } else {
            $surveyInfo['program_how_much'] = "";
            $surveyInfo['program_why_not'] = implode(',', $surveyInfo['program_why_not']);
            if (isset($surveyInfo['other_specify'])) {
                $surveyInfo['program_why_not'].= ' , ' . $surveyInfo['other_specify'];
            }
        }
        if (isset($surveyInfo['other_specify'])) {
            unset($surveyInfo['other_specify']);
        }
        $surveyInfo['is_active'] = 1;
        $surveyInfo['created_at'] = date('Y-m-d H:i:s');
        return $surveyInfo;
    }

    private function getTextFromEnumForSurveyConfirmPage($obj , $value) {
        foreach($obj as $key=>$enum){
            if($value == $enum->value){
                return $enum->name ;
            }
        }
        return "";
    }
    public function getSurveyEnumData() {
       $array['satisfaction'] = SatisfactionType::getOrderedEnums();
       $array['yes_no'] = SurveyYesNo::getOrderedEnums();
       $array['willing_to_pay'] = SurveyWillingToPayAmount::getOrderedEnums();
       $array['not_willing_to_use'] = SurveyWhyNotWillingToUse::getOrderedEnums();
       return $array;
    }
    
    private function isInValidSurveyToken($token , &$userId) {
        $user = DB::table('users')
                ->where('survey_token', $token)
                ->get(['id']);
        if(count($user)==0){
            return true ;
        }
        $userId = $user[0]->id;
        return false;
    }

    public function getAssessment($token) {
        $user = DB::table('users')
            ->where('survey_token', $token)
            ->first();

        $assessment = DB::table('rrs_assessment')
            ->where('user_id', $user->id)
            ->first();

        return $assessment;
    }
}
