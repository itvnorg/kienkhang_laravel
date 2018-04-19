<?php

namespace App\Http\Controllers\User;

use Request, Response, Input, Validator, Sentinel;
use App\Http\Controllers\User\BaseController;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->data['path_photo'] = _upload_user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUpdateProfile()
    {
        $this->data['titlePage'] = 'Edit Profile';
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => trans('user.home'), 'link' => route('user.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        return view("user.user.update_profile")->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $input = Input::all();  // Get all input
        $rules = User::$rulesUpdateProfile;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        // Prepare datas of user
        $data = [
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'skype' => $input['skype']
        ];

        if($input['email'] == $this->user['email']){ // Same email with current email
            unset($data['email']);
        }    
        else{
            $credentials = [
            'login' => $input['email'],
            ];

            $user = Sentinel::findByCredentials($credentials);
            if($user){
                return Redirect::back()->withInput()->withErrors('This email is already taken');
            }
        }

        // If edit then check have update password
        if(isset($input['new_password'])){  // If have update password then update password
            $data['password'] = $input['new_password'];
        }

        // Handle avatar
        if (Input::hasfile('avatar') && $input['avatar'] != '') {
            User::deleteImage(
                $this->data['path_photo'],
                $this->user['id']
            );

            $img = $input['avatar'];
            $file = UploadAuto(
                'avatar',
                $this->data['path_photo'],
                $img
            );
            foreach ($file as $k => $v) {
                $data[$k] = $v;
            }
        }

        $this->user = Sentinel::update($this->user, $data);

        $mess_success = 'Your profile is updated successfull.';
        return Redirect::back()->with('success', $mess_success);
    }
}
