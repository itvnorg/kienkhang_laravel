<?php

namespace App\Http\Controllers\Portal;

use Request, Response, Input, Validator;
use App\Http\Controllers\Portal\BaseController;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\District;
use App\Models\Direction;
use Illuminate\Support\Facades\Redirect;

class ProductCategoryController extends BaseController
{
    private $model;
    private $modelDirection;
    private $modelProvince;
    private $modelDistrict;

	public function __construct(ProductCategory $model, Direction $modelDirection, Province $modelProvince, District $modelDistrict){
        $this->modelDirection = $modelDirection;
        $this->modelProvince = $modelProvince;
        $this->modelDistrict = $modelDistrict;
		parent::__construct( $modelDirection, $modelProvince, $modelDistrict);
		$this->model = $model;
		// $this->data['path_photo'] = _upload_product;
	}

	public function index(){

	}

	public function show($cat_url_rewrite){
		$this->data['data'] = $this->model->where('url_rewrite', '=', $cat_url_rewrite)->firstOrFail();
		$childCats = $this->model->where('parent_id',$this->data['data']->id)->get();
		$arr_ids = [];
		$arr_ids[] = $this->data['data']->id;
		if(count($childCats) > 0){
			foreach ($childCats as $key => $value) {
				$arr_ids[] = $value->id;
				$childCatsSecond = $this->model->where('parent_id',$value->id)->get();
				foreach ($childCatsSecond as $keySecond => $valueSecond) {
					$arr_ids[] = $valueSecond->id;
				}
			}
		}
		$this->data['products'] = Product::whereIn('category_id',$arr_ids)->paginate(5);
		
		foreach ($this->data['products'] as $key => $value) {
			$this->data['products'][$key]['photo'] = ProductImage::where('product_id',$value->id)->first();;
		}
        $this->data['titlePage'] = $this->data['data']->name;
		return view('portal.product_category.show')->with($this->data);
	}
}
