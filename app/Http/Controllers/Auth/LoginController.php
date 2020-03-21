<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    //Goto This file and fix after logged out user can't be access dashboard
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //check Authenticated User and Redirect to Dashboard with his role and selected dashboard
        // (note::different dashboard for different roles)
        if (Auth::check() && Auth::user()->role->id==1){
            $this->redirectTo = route('admin.dashboard');
        }else {
            $this->redirectTo = route('author.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }
}
