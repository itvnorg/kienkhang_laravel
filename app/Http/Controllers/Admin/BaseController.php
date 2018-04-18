<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class BaseController extends Controller
{
	public $user;
	public $routeRootAdmin = 'admin.home';
    public $iconDashboard = 'fa fa-dashboard';
    public $iconNew = 'fa fa-plus-circle';
    public $iconEdit = 'fa fa-edit';

    public function __construct(){
        parent::__construct();
    	$this->middleware(function ($request, $next) {
	        $this->user = Sentinel::check();

	        if (!$this->user)
	        {
	            return redirect()->route('login.view');
	        }

	        if (!$this->user->inRole('admin'))
	        {
	            return redirect()->route('home');
	        }

	        $this->data['user'] = $this->user;
	        $this->data['path_default_image'] = _default_images;

	        $this->data['status'] = [
	        	INACTIVE	=>	trans('admin.inactive'),
	        	ACTIVE 		=>	trans('admin.active'),
	        	HOT 		=>	trans('admin.hot'),
	        ];

	        return $next($request);
	    });
    }

    public function getHome(){
    	return view('admin.welcome');
    }
}
