<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class BaseController extends Controller
{
    public $user;
	public $routeRootUser = 'user.home';
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

	        if (!$this->user->inRole('user'))
	        {
	            return redirect()->route('home');
	        }

	        $this->data['user'] = $this->user;
	        $this->data['path_default_image'] = _default_images;

	        return $next($request);
	    });
    }

    public function index(){
    	$this->data['titlePage'] = trans('user.home');
    	return view('user.index')->with($this->data);
    }
}
