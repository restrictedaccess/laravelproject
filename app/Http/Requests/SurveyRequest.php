<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

class SurveyRequest extends Request{
      public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        $rules =[];
        $rules['satisfaction'] = 'required';
        $rules['satisfaction_why'] = 'max:3000';
        $rules['program_want_to_try'] = 'required|in:1,0';
        $rules['free_comment'] = 'max:3000';
        return $rules ;
    }
    public function messages() 
    {
        return [
            'required'  =>  'This field is required',
             'max'=>'Maximum input length is :max',
        ];
    }
    
    public function response(array $errors) {
        $userId = Request::get('userId');
        Request::flash();
         return $this->redirector->to($this->getRedirectUrl())->withErrors($errors, $this->errorBag)->with('userId');
    }
}
