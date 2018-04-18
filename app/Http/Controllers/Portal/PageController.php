<?php

namespace App\Http\Controllers\Portal;

use Request, Response, Input, Validator;
use App\Http\Controllers\Portal\BaseController;
use App\Models\Page;
use App\Models\Province;
use App\Models\District;
use App\Models\Direction;

class PageController extends BaseController
{
	private $model;
	private $modelDirection;
	private $modelProvince;
	private $modelDistrict;

	public function __construct(Page $model, Direction $modelDirection, Province $modelProvince, District $modelDistrict){
		$this->modelDirection = $modelDirection;
		$this->modelProvince = $modelProvince;
		$this->modelDistrict = $modelDistrict;
		parent::__construct( $modelDirection, $modelProvince, $modelDistrict);
		$this->model = $model;
		//$this->data['path_photo'] = _upload_product;
	}

	public function index(){

	}

	public function show($url_rewrite){
		$this->data['data'] = $this->model->getDetail($url_rewrite);
		$this->data['titlePage'] = $this->data['data']->title;
		return view('portal.page.show')->with($this->data);
	}

	public function contact(){
		$this->data['titlePage'] = 'Liên hệ';
		return view('portal.page.contact')->with($this->data);
	}
}
