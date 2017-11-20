<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\VerifyEmailRequest;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$#%]).*$/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        mt_srand(time());
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_id' => mt_rand(100000, 999999),
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $meta['title'] = "Sign In";

        return view('auth.login', compact('meta'));
    }

    public function getVerifyEmail($id)
    {
        $meta['title'] = "Signup";
        $user = User::find($id);
        if(!$user || $user->is_verified != 0){
            abort(400);
        }

        return view('auth.verify', compact('meta','user'));
    }

    public function postVerifyEmail(VerifyEmailRequest $request, $id)
    {
        $user = User::find($id);

        if(!$user || $user->is_verified != 0){
            abort(400);
        }

        if($request->get('id_code') != $user->verification_id){
            return redirect('/verify/'.$user->id)
                ->withInput($request->only('id_code'))
                ->withErrors([
                    'id_code' => 'Invalid ID Code',
                ]);
        }

        $credentials = [
            'email' => $user->email,
            'password' => $request->get('password'),
            'verification_id' => $request->get('id_code')
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user->is_verified = 1;
            $user->save();
            return redirect('/');
        }

        else {
            return redirect('/verify/'.$user->id)
                ->withInput($request->only('id_code'))
                ->withErrors([
                    'password' => 'Invalid Password',
                ]);
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $meta['title'] = "Registration";
        return view('auth.register', compact('meta'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        Mail::send('emails.verification', ['user' => $user], function($message) use($user) {
            $message->to($user->email)
                ->subject('Pegara Email Verification');
        });

        return redirect('/verify/'.$user->id);
    }
}
