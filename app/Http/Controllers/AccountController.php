<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facades\PegaraConstant;

class AccountController extends Controller
{

    public function getAccountsDetail()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;
        return view('accounts.rrs-report', compact('meta'));
    }

    public function getProfile()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.profile', compact('meta'));
    }

    public function editProfile()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.edit_profile', compact('meta'));
    }

    public function editPassword()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.edit_password', compact('meta'));
    }

    public function resetPassword()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.password_reset', compact('meta'));
    }

    public function deleteAccount()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.delete_account', compact('meta'));
    }

    public function accountDelete()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.delete_thank_you', compact('meta'));
    }

    public function getRRSDetail($id)
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.rrs-detail', compact('meta'));
    }

    public function delate()
    {
        $meta['title'] = PegaraConstant::RRS_PAGE_TITLE;
        $meta['description'] = PegaraConstant::RRS_PAGE_DESCRIPTION;

        return view('accounts.delate', compact('meta'));
    }
}
