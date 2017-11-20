<?php

namespace App\Http\Controllers;

use Request;
use URL;
use Session;
use App\Facades\PegaraConstant;


class StaticPageController extends Controller {
    
    public function getTopPage() {
        $meta['title'] = PegaraConstant::TOP_PAGE_TITLE;
        $meta['description'] = PegaraConstant::TOP_PAGE_DESCRIPTION;
        $meta['promotion_id'] = Request::fullUrl();
        $meta['referer'] = URL::previous();
        
        Session::set('promotion_id',Request::fullUrl());
        Session::set('referer',URL::previous());
        
        return view('layouts.top' , compact('meta'));
    }

    public function getReferencePage() {
        $meta['title'] = PegaraConstant::REFERENCE_PAGE_TITLE;
        $meta['description'] = PegaraConstant::REFERENCE_PAGE_DESCRIPTION;
        return view('layouts.reference' , compact('meta'));
    }

    public function getTermsAndServicePage() {
        $meta['title'] = PegaraConstant::TERMS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::TERMS_PAGE_DESCRIPTION;
        return view('layouts.terms' , compact('meta'));
    }

    public function getPrivacyPage() {
        $meta['title'] = PegaraConstant::PRIVACY_PAGE_TITLE;
        $meta['description'] = PegaraConstant::PRIVACY_PAGE_DESCRIPTION;
        return view('layouts.privacy' , compact('meta'));
    }
}
