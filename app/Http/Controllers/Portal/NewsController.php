<?php

namespace App\Http\Controllers\Portal;

use Request, Response, Input, Validator;
use App\Http\Controllers\Portal\BaseController;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Province;
use App\Models\District;
use App\Models\Direction;

class NewsController extends BaseController
{
	private $model;
	private $modelCategory;
	private $modelDirection;
	private $modelProvince;
	private $modelDistrict;

	public function __construct(News $model, NewsCategory $modelCategory, Direction $modelDirection, Province $modelProvince, District $modelDistrict){
		$this->modelDirection = $modelDirection;
		$this->modelProvince = $modelProvince;
		$this->modelDistrict = $modelDistrict;
		parent::__construct( $modelDirection, $modelProvince, $modelDistrict);
		$this->model = $model;
		$this->modelCategory = $modelCategory;
		//$this->data['path_photo'] = _upload_product;
	}

	public function index(){

	}

	public function show($cat_url_rewrite, $url_rewrite){
		$this->data['data'] = $this->model->getDetail($url_rewrite);
		$this->data['titlePage'] = $this->data['data']->title;
		return view('portal.news.show')->with($this->data);
	}
}
