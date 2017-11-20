<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserInfoRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        $startDay = date('Y-m-d', strtotime('-18 years'));
        $endDay = date('Y-m-d', strtotime('-90 years'));
        $rules = [];
        $rules['first_name'] = 'required|between:1,50';
        $rules['last_name'] = 'between:1,50';
        $rules['email'] = 'required|email|between:1,255';
        $rules['mobile_no'] = 'between:10,16';
        if (!Request::has('out_of_us')) {
            $rules['zip_code'] = 'required|digits:5';
        }
        $rules['birthday'] = 'required|date|before:' . $startDay . '|after:' . $endDay;
        $rules['gender'] = 'required|in:1,2';

        $rules['height_unit'] = 'required';
        if (Request::get('height_unit') == "0") {
            $rules['height'] = 'required|numeric|min:4|max:7';
        } else {
            $rules['height'] = 'required|numeric|min:100|max:210';
        }

        $rules['weight_unit'] = 'required';
        if (Request::get('weight_unit') == "0") {
            $rules['weight'] = 'required|numeric|min:60|max:1000';
        } else {
            $rules['weight'] = 'required|numeric|min:27|max:450';
        }
        return $rules;
    }

    public function messages() {
        if (Request::get('height_unit') == "0") {
            $heightMessage = "Sorry, our service is targeted at 4 to 7 feet";
        } else {
            $heightMessage = "Sorry, our service is targeted at 100 to 210 cm";
        }

        if (Request::get('weight_unit') == "0") {
            $weightMessage = "Sorry, our service is targeted at 60 to 1000 lbs";
        } else {
            $weightMessage = "Sorry, our service is targeted at 27 to 450 kg";
        }

        return [
            'first_name.between' => 'Please insert no more than 50 character',
            'last_name.between' => 'Please insert no more than 50 character',
            'email.required' => 'Please enter a valid email id',
            'mobile_no.between' => 'Mobile number must be in between 10 to 16 character',
            'birthday.before' => 'Sorry, our service is targeted at 18 to 90 years only',
            'height.min' => $heightMessage,
            'height.max' => $heightMessage,
            'weight.min' => $weightMessage,
            'weight.max' => $weightMessage
        ];
    }

    public function response(array $errors) {
        Request::flash();
        return $this->redirector->to($this->getRedirectUrl())->withErrors($errors, $this->errorBag);
    }

}
