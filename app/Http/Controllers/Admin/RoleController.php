<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Request, Response, Input, Validator, Sentinel;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class RoleController extends BaseController
{
    public function __construct(){
        parent::__construct();
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
            $list = Role::getRoleList();

            return Response::json([
                'data' => $list
            ]);
        }

        $this->data['titlePage'] = 'Roles';
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        $action = [
            'title' => 'New Role',
            'link' => route('admin.roles.create'),
            'icon' => 'plus-circle'
        ];
        $this->data['action'] = $action;

        return view("admin.role.index")->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['titlePage'] = 'New Role';
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => 'Roles', 'link' => route('admin.roles.index'), 'icon' => 'user' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        return view("admin.role.create")->with($this->data);
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
        $rules = Role::$rules;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        // Prepare datas of user
        $data = [
            'slug' => $input['slug'],
            'name' => $input['name'],
        ];

        $role = Role::create($data);

        return Redirect::route('admin.roles.index');
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
        $role = Role::getRoleByID($id);

        $this->data['titlePage'] = 'Edit Role';
        $this->data['data'] = $role;
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => 'Home', 'link' => route('admin.home'), 'icon' => 'dashboard' ];
        $breadcrumbs[] = [ 'title' => 'Role', 'link' => route('admin.roles.index'), 'icon' => 'user' ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'] ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        return view("admin.role.edit")->with($this->data);
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
        $rules = Role::$rules;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $role = Role::getRoleByID($id);
        $role['slug'] = $input['slug'];
        $role['name'] = $input['name'];

        $result = $role->save();

        return Redirect::route('admin.roles.index');
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

            $status = Role::destroyRoles($id);

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

            $status = Role::destroyRoles($ids);

            echo json_encode([
                'status' => $status
            ]);
            
        }
    }
}
