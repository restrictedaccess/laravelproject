<?php

namespace App\Http\Controllers;

use App\Core\Service\SurveyService;
use App\Http\Requests\SurveyRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Facades\PegaraConstant;

class SurveyController extends Controller {

    protected $surveyService ;
    
    public function __construct(SurveyService $service) {
        $this->surveyService = $service ;
    }
    
    public function getSurveyPage($token) {
        $userId = 0;
        $isInvalid = $this->surveyService->isInvalid($token , $userId);
        if($isInvalid){
            return Redirect::to('/error');
        }
        Session::set('token', $token);
        $data = $this->surveyService->getSurveyEnumData();
        $meta['title'] = PegaraConstant::SURVEY_PAGE_TITLE;
        $meta['description'] = PegaraConstant::SURVEY_PAGE_DESCRIPTION;
        return view('layouts.survey_input' , compact('data','userId','meta'));
    }

    public function postIntoSurveyConfirmPage(SurveyRequest $request) {
        if(!Session::has('token')){
           return Redirect::to('/error'); 
        }
        $surveyInfo = $request->all();
        unset($surveyInfo['_token']);

        $data = $this->surveyService->getSurveyConfirmData($surveyInfo);
        $request->flashExcept('token');
        Session::set('survey_info' , $surveyInfo);
        $meta['title'] = PegaraConstant::SURVEY_PAGE_TITLE;
        $meta['description'] = PegaraConstant::SURVEY_PAGE_DESCRIPTION;
        return view('layouts.survey_confirm', compact('data','meta'));
    }

    public function postSurvey(Request $request) {
        if (Session::has('survey_info') && Session::has('token')) {
            $surveyInfo = Session::pull('survey_info');

            $assessment = $this->surveyService->getAssessment(Session::pull('token'));

            try {
                DB::beginTransaction();
                $surveyInfo['rrs_assessment_id'] = $assessment->id;
                $this->surveyService->insertSurveyInfo($surveyInfo);
                DB::commit();
                Session::flush();
                $meta['title'] = PegaraConstant::SURVEY_PAGE_TITLE;
                $meta['description'] = PegaraConstant::SURVEY_PAGE_DESCRIPTION;
                return view('layouts.survey_thanks', compact('meta'));
            } catch (Exception $e) {
                DB::rollback();
                return Redirect::to('/error');
            }
        } else {
            return Redirect::to('/error');
        }
    }
    

}
