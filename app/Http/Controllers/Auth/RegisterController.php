<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Request, Response, Input, Validator, Sentinel;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getRegisterView(){
        $this->data['titlePage'] = 'Register';
        return view('auth.register')->with($this->data);
    }

    public function register(){
        $input = Input::all();  // Get all input
        $rules = User::$rules_register;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $credentials = [
            'login' => $input['email'],
        ];

        $user = Sentinel::findByCredentials($credentials);
        if($user){
            return Redirect::back()->withInput()->withErrors('This email is already taken');
        }

        // Prepare datas of user
        $data = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        $user = Sentinel::registerAndActivate($data);

        $role = Sentinel::findRoleBySlug('user');
        $role->users()->attach($user);

        $mess_success = 'Your account is created successfull, please login to continue';
        return Redirect::route('login.view')->with('success', $mess_success);
    }
}
