<?php

namespace App\Http\Controllers\Admin;

use Request, Response, Input, Validator, Sentinel;
use App\Http\Controllers\Admin\BaseController;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Handle ajax request
        if (Request::ajax()) {
            $list = User::getUserList();
            return Response::json([
                'data' => $list
            ]);
        }

        $this->data['titlePage'] = 'Users';
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        $action = [
            'title' => 'New User',
            'link' => route('admin.users.create'),
            'icon' => 'plus-circle'
        ];
        $this->data['action'] = $action;

        return view("admin.user.index")->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['titlePage'] = 'New User';
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => 'Users', 'link' => route('admin.users.index'), 'icon' => 'user' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        // Get role data
        $roles = Role::getRoleIdName();
        $this->data['roles'] = $roles;

        return view("admin.user.create")->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();  // Get all input
        $rules = User::$rules;  // Get rules of model User

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
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'address_1' => $input['address_1'],
            'address_2' => $input['address_2'],
            'skype' => $input['skype'],
            'password' => $input['password']
        ];

        if (Input::hasfile('avatar') && $input['avatar'] != '') {
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

        $user = Sentinel::registerAndActivate($data);

        // Handle add user to role
        $inputRole = $input['role'];
        foreach ($inputRole as $key => $value) {
            $role = Sentinel::findRoleById($value);
            if(!$role)
                return Redirect::back()->withInput()->withErrors('role not exists');

            $role->users()->attach($user);
        }

        return Redirect::route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Sentinel::findById($id);

        $this->data['titlePage'] = 'Edit User';
        $this->data['data'] = $user;
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => 'Users', 'link' => route('admin.users.index'), 'icon' => 'user' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        // Get role data
        $roles = Role::getRoleIdName();
        $this->data['roles'] = $roles;

        // Get roles of user
        $arrRole = $user->roles;
        $rolesOfUser = [];
        foreach ($arrRole as $key => $value) {
            $rolesOfUser[$value['id']] = $value['id'];
        }
        $this->data['rolesOfUser'] = $rolesOfUser;

        return view("admin.user.edit")->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::all();  // Get all input
        $rules = User::$rulesUpdateUser;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $user = Sentinel::findById($id);

        // Prepare datas of user
        $data = [
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'address_1' => $input['address_1'],
            'address_2' => $input['address_2'],
            'skype' => $input['skype']
        ];

        if($input['email'] == $user['email']){ // Same email with current email
            unset($data['email']);
        }    
        else{
            $credentials = [
                'login' => $input['email'],
            ];

            $tmpUser = Sentinel::findByCredentials($credentials);
            if($tmpUser){
                return Redirect::back()->withInput()->withErrors('This email is already taken');
            }
        }

        // If edit then check have update password
        if(isset($input['new_password']) && !empty($input['new_password']) ){  // If have update password then update password
            $data['password'] = $input['new_password'];
        }

        // Handle avatar
        if (Input::hasfile('avatar') && $input['avatar'] != '') {
            User::deleteImage(
                $this->data['path_photo'],
                $id
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
        
        $inputRole = $input['role'];

        User::updateRolesOfUser($user['id'], $inputRole);

        $user = Sentinel::update($user, $data);

        return Redirect::route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Handle ajax request
        if (Request::ajax()) {

            $status = User::destroyUsers($id);

            echo json_encode([
                'status' => $status
            ]);
            
        }
    }

    /**
     * Remove multi resources from storage.
     *
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        // Handle ajax request
        if (Request::ajax()) {
            $ids = Input::get('id');

            $status = User::destroyUsers($ids);

            echo json_encode([
                'status' => $status
            ]);
            
        }
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
        $breadcrumbs[] = [ 'title' => trans('admin.home'), 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        return view("admin.user.update_profile")->with($this->data);
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
            'address_1' => $input['address_1'],
            'address_2' => $input['address_2'],
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
