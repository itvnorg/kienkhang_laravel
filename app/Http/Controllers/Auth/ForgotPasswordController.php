<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Sentinel, Validator, Reminder, Config, Mail;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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

    public function getForgotPasswordView(Request $request){
        $this->data['titlePage'] = 'Forgot Password';
        return view('auth.forgot_password')->with($this->data);
    }

    public function forgotPassword(Request $request){
        $rules = User::$rulesForgotPassword;  // Get rules of model User

        $valid = Validator::make($request->all(), $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $credentials = [
            'login' => $request['email'],
        ];

        $user = Sentinel::findByCredentials($credentials);
        if(!$user){
            $mess_error = 'This account does not exists.';
            
            return Redirect::back()->with('error_invalid', $mess_error);
        }

        $reminder = Reminder::create($user);

        $dataEmail = array(
            "code" => $reminder->code,
            "id" => $user->id,
            "name" => $user->first_name . ' ' . $user->last_name,
            "email" => $user->email,
            "sitename" => $this->settings['site_name']
        );

        try {
            Mail::send("auth.email_template.forgot_password", $dataEmail, function($message) use ($dataEmail) {
                $message->to($dataEmail["email"], $dataEmail["name"]);
                $message->subject(trans('admin.titleMailResetPassword') . $dataEmail["sitename"]);
            });
        } catch (Exception $e) {
            return Redirect::back()->withInput()->withErrors(trans('admin.msgErrSendResetPasswordMail'));
        }

        $mess_success = trans('admin.msgSuccessSendResetPasswordMail');
        return Redirect::route('login.view')->with('success', $mess_success);
    }

    public function getUpdatePasswordView($id, $code){
        $this->data['id'] = $id;
        $this->data['code'] = $code;
        $this->data['titlePage'] = trans('admin.update_password');
        return view('auth.update_password')->with($this->data);
    }

    public function updatePassword(Request $request){
        $rules = User::$rulesUpdatePassword;  // Get rules of model User

        $valid = Validator::make($request->all(), $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $user = Sentinel::findById($request['id']);

        if ($reminder = Reminder::complete($user, $request['code'], $request['password']))
        {
            $mess_success = trans('admin.msgSuccessUpdatePassword');
            return Redirect::route('login.view')->with('success', $mess_success);
        }
        else
        {
            return Redirect::back()->withInput()->withErrors(trans('admin.msgErrUpdatePassword'));
        }
    }
}
