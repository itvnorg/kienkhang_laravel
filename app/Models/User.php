<?php

namespace App\Models;
use Sentinel, File;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \Cartalyst\Sentinel\Users\EloquentUser
{
    // use SoftDeletes;

    const MALE = 1;    
    const FEMALE = 0;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'gender',
        'phone',
        'address',
        'avatar',
        'permissions'
    ];

    public static $rules_register = array(
        'email' => 'required|unique:users',
        'password' => 'required|confirmed',
        'confirm_password' => 'confirmed'
    ); 

    public static $rules = array(
        'email' => 'required',
        'password' => 'required|confirmed',
        'new_password' => 'confirmed',
        'role' => 'required'
    ); 

    public static $rulesUpdateUser = array(
        'email' => 'required',
        'password' => 'confirmed',
        'new_password' => 'confirmed',
        'role' => 'required'
    ); 

    public static $rulesUpdateProfile = array(
        'email' => 'required',
        'password' => 'required|confirmed',
        'new_password' => 'confirmed'
    ); 

    public static $rulesForgotPassword = array(
        'email' => 'required'
    );   

    public static $rulesUpdatePassword = array(
        'id' => 'required',
        'code' => 'required',
        'password' => 'required|confirmed'
    );  

    public static function updateRolesOfUser($user_id, $input_roles){
        $user = Sentinel::findById($user_id);

        // Handle remove roles out of user
        $arrRole = Role::getRoleIdName();

        foreach ($arrRole as $key => $value) {
            $role = Sentinel::findRoleById($key);
            $role->users()->detach($user);
        }

        // Handle add user to role

        foreach ($input_roles as $key => $value) {
            $role = Sentinel::findRoleById($value);
            if(!$role)
                return Redirect::back()->withInput()->withErrors('role not exists');

            $role->users()->attach($user);
        }
    }

    public static function getUserList(){
        $list = User::get();
        return $list;
    }

    public static function destroyUsers($id){
        if(is_array($id)){
            try {
                foreach ($id as $key => $value) {
                    $user = Sentinel::findById($value);
                    $user->deleteUser();
                }

                return 'success';
            } catch (Exception $e) {
                return 'error';
            }
            
        }
        
        try {
            $user = Sentinel::findById($id);
            $user->deleteUser();

            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }

    public static function deleteImage($path, $id)
    {
        $user = Sentinel::findById($id);
        if (! empty($user->avatar)) {
            File::delete($path . '/' . $user->avatar);
        }

    }

    public function deleteUser(){
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if(!$isSoftDeleted){
            if (! empty($this->avatar)) {
                File::delete(_upload_user . '/' . $this->avatar);
            }
        }
        
        return parent::delete();
    }
}
