<?php

use App\Facades\PegaraConstant;


// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

Route::get('verify/{id}', 'Auth\AuthController@getVerifyEmail');
Route::post('verify/{id}', 'Auth\AuthController@postVerifyEmail');


$maintenance = false;
if($maintenance) {
    Route::get('/' , 'StaticPageController@getTopPage');
    Route::get('/reference' , 'StaticPageController@getReferencePage');
    Route::get('/terms' , 'StaticPageController@getTermsAndServicePage');
    Route::get('/privacy' , 'StaticPageController@getPrivacyPage');
    
    // Route::get('/rrs' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::post('/rrs/profile' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::get('/rrs/profile' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::post('/rrs/score' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::get('/rrs/score' , 'RiskReductionScoreController@getMaintenancePage');
    //
    // Route::get('/survey/form/{token}' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::post('/survey/confirm' , 'RiskReductionScoreController@getMaintenancePage');
    // Route::post('/survey/thanks' , 'RiskReductionScoreController@getMaintenancePage');
    

    ///  Design Controller ///
    Route::get('/error', function(){
        $meta['title'] = "BrainSalvation - Maintenance Page";
        $meta['description'] = "";
        return view('errors.system', compact('meta'));
    });

} else {

    /// Static Page ///
    Route::get('/' , 'StaticPageController@getTopPage');
    Route::get('/reference' , 'StaticPageController@getReferencePage');
    Route::get('/terms' , 'StaticPageController@getTermsAndServicePage');
    Route::get('/privacy' , 'StaticPageController@getPrivacyPage');


    /// Risk Reduction Score ////
    Route::get('/rrs' , 'RiskReductionScoreController@getQuestionPage');
    Route::post('/rrs/profile' , 'RiskReductionScoreController@postAnswers');
    Route::get('/rrs/profile' , 'RiskReductionScoreController@getProfilePage');
    Route::post('/rrs/score' , 'RiskReductionScoreController@postProfile');
    Route::get('/rrs/score' , 'RiskReductionScoreController@getScorePage');


    ///  Survey Controller //
    Route::get('/survey/form/{token}' , 'SurveyController@getSurveyPage');
    Route::post('/survey/confirm' , 'SurveyController@postIntoSurveyConfirmPage');
    Route::post('/survey/thanks' , 'SurveyController@postSurvey');

    ///  Design Controller ///
    Route::get('/error', function(){
        $meta['title'] = PegaraConstant::ERROR_PAGE_TITLE;
        $meta['description'] = PegaraConstant::ERROR_PAGE_DESCRIPTION;
        return view('errors.system', compact('meta'));
    });

    Route::get('/email', function(){
        return view('layouts.email_template');
    });

    Route::get('/account', 'AccountController@getAccountsDetail');    
    Route::get('/profile', 'AccountController@getProfile');    
    Route::get('/edit-profile', 'AccountController@editProfile');
    Route::get('/edit-password', 'AccountController@editPassword');
    Route::get('/password-reset', 'AccountController@resetPassword');
    Route::get('/delete-account', 'AccountController@deleteAccount');
    Route::get('/account-deleted', 'AccountController@accountDelete');
    Route::get('/account-rrs-report/{id}', 'AccountController@getRRSDetail');
    Route::get('/delate', 'AccountController@delate');

    Route::get('/login', function() {
        return view('auth.login');
    });
    Route::get('/forgot-password', function() {
        return view('auth.forgot_password');
    });
    Route::get('/reset-password', function() {
        $condition['forgot_password'] = true;
        return view('auth.reset_password', compact('condition'));
    });
    Route::get('/idcode-mismatch', function() {
        $condition['incorrect_id'] = true;
        return view('auth.reset_password', compact('condition'));
    });
    Route::get('/verify-email', function() {
        return view('auth.reset_password');
    });
    Route::get('/sign-up', function() {
        return view('auth.signup');
    });
    Route::get('/new-password', function() {
        return view('auth.new_password');
    });
}
