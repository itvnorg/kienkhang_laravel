<?php

namespace App\Models;

use Sentinel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Cartalyst\Sentinel\Roles\EloquentRole
{
	use SoftDeletes;
    protected $guarded = array();

    public static $rules = array(
        'slug' => 'required|unique:roles',
        'name' => 'required',
    );

    public static function getRoleList(){
        $list = Role::get();
        return $list;
    }

    public static function getRoleIdName(){
        $role = Role::get();
        $arrRole = [];
        foreach ($role as $key => $value) {
            $arrRole[$value['id']] = $value['name'];
        }
        return $arrRole;
    }

    public static function getRoleByID($id){
        $Role = Role::where('id','=',$id)
        ->first();
        return $Role;
    }

    public static function destroyRoles($id){
        if(is_array($id)){
            try {
                foreach ($id as $key => $value) {
                    $Role = Role::where('id','=',$value)
                    ->first();
                    $Role->deleteRole();
                }

                return 'success';
            } catch (Exception $e) {
                return 'error';
            }
            
        }
        
        try {
            $Role = Role::where('id','=',$id)
            ->first();
            $Role->deleteRole();

            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }

    public function deleteRole(){
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        
        return parent::delete();
    }
}
