<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Sentinel;

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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function getLoginView(Request $request){
        $this->data['titlePage'] = 'Sign In';
        return view('auth.login')->with($this->data);
    }

    public function login(Request $request){
        $email = ($request['email']) ? $request['email'] : '';
        $password = ($request['password']) ? $request['password'] : '';
        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        $user = Sentinel::authenticate($credentials);

        if($user){
            if($user->inRole('admin')){
                return redirect()->route('admin.home');
            }elseif($user->inRole('user')){
                return redirect()->route('user.home');
            }else{
                return redirect()->route('home');
            }
        }else{
            $mess_error = 'Email or password incorrect.';
            return redirect()->route('login.view')->with('error_invalid', $mess_error);
        }
    }

    public function logout(Request $request){
        Sentinel::logout();
        return redirect()->route('home');
    }
}
