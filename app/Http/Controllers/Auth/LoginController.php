<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
     protected function validator(array $data)
     {
         return Validator::make($data, [
             'email' => ['required'],
             'password' => ['required'],
             'captcha' => ['required','captcha'],
         ]);
     }
 
     public function reloadCaptcha()
     {
         return response()->json(['captcha'=> captcha_img()]);
     }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
