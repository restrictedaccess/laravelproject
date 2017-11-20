<?php

namespace App\Http\Controllers;

use App\Core\Service\RiskReductionScoreService;
use App\Http\Requests\UserInfoRequest;
use Exception;
use Intervention\Image\ImageManager as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Facades\PegaraConstant;

class RiskReductionScoreController extends Controller {

    protected $riskReductionScoreService;

    public function __construct(RiskReductionScoreService $service) {
        $this->riskReductionScoreService = $service;
    }

    public function getQuestionPage() {
        Session::forget('answer');
        Session::forget('score');
        Session::forget('has_disease');
        Session::forget('bmi');
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;
        return view('layouts.question', compact('meta'));
    }

    public function postAnswers(Request $request) {
        $rawAnswer = $request->all();
        $answer = $this->riskReductionScoreService->mapAnswerFormat($rawAnswer);
        $hasDisease = isset($rawAnswer['medical_depression']);
        Session::set('answer', $answer);
        Session::set('has_disease' , $hasDisease);
        return Redirect::to('/rrs/profile');
    }

    public function getProfilePage() {
        if (Session::has('answer')) {
            $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
            $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;
            return view('layouts.profile', compact('meta'));
        } else {
            return Redirect::to('/error');
        }
    }

    public function postProfile(UserInfoRequest $request) {
        $userInfo = $request->all();
        $userInfo = $this->riskReductionScoreService->formatUserInfoInput($userInfo);
        $answers = Session::get('answer');
        $scores = $this->riskReductionScoreService->calculateScore($answers, $userInfo);

        Session::set('score', $scores);
        return Redirect::to('/rrs/score');
    }

    public function getScorePage(Image $image)
    {
        if (Session::has('score') && Session::has('profile')) {
            $userInfo = Session::pull('profile');
            $allScore = Session::get('score');
            $answers = Session::get('answer');
            $score = $allScore['view'];

            try {
                DB::beginTransaction();
                $this->riskReductionScoreService->insertInfoIntoDB($answers, $userInfo, $allScore);
                DB::commit();
                $header = $this->riskReductionScoreService->getRiskHedgeSectence() ;
                $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
                $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;
                $bmi = Session::get('bmi');

                $share_img = $this->generateScoreImage($image, $score);
                return view('layouts.score', compact('score', 'meta' , 'header' , 'bmi', 'share_img'));
            } catch (Exception $e) {
                DB::rollback();
                Session::set('profile', $userInfo);
                return Redirect::to('/error');
            }
        } else if (Session::has('score')) {
            $allScore = Session::get('score');
            $score = $allScore['view'];

            $header = $this->riskReductionScoreService->getRiskHedgeSectence() ;
            $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
            $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;
            $bmi = Session::get('bmi');

            $share_img = $this->generateScoreImage($image, $score);
            return view('layouts.score', compact('score','meta' , 'header' , 'bmi', 'share_img'));
        } else {
            return Redirect::to('/error');
        }
    }


    private function generateScoreImage($image, $score)
    {
        $img = $image->canvas(1200,630, "#fff");
        $img->insert(public_path().'/images/base/base-'.$score['final_score_status'].'.png', 'center');
        $img->text($score['name']."'s", 600, 100, function($font) {
            $font->file(public_path().'/fonts/sourcesanspro-regular.ttf');
            $font->size(38);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });

        $img->text($score['final_score'], 450, 330, function($font) {
            $font->file(public_path().'/fonts/sourcesanspro-semibold.ttf');
            $font->size(150);
            $font->color('#0072cf');
            //$font->align('center');
            $font->valign('top');
        });

        $img->text('/100', 600, 390, function($font) {
            $font->file(public_path().'/fonts/sourcesanspro-semibold.ttf');
            $font->size(46);
            $font->color('#0072cf');
            //$font->align('center');
            $font->valign('top');
        });

        $filename = time().'.jpg';

        $img->save(public_path().'/images/scores/'.$filename);
        return $filename;
    }

}
