<?php

namespace App\Http\Controllers\Portal;

use Request, Response, Input, Validator;
use App\Http\Controllers\Portal\BaseController;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Direction;
use Illuminate\Support\Facades\Redirect;

class ProductController extends BaseController
{
	private $model;
	private $modelCategory;
	private $modelDirection;
	private $modelProvince;
	private $modelDistrict;

	public function __construct(Product $model, ProductCategory $modelCategory, Direction $modelDirection, Province $modelProvince, District $modelDistrict){
		$this->modelDirection = $modelDirection;
		$this->modelProvince = $modelProvince;
		$this->modelDistrict = $modelDistrict;
		parent::__construct( $modelDirection, $modelProvince, $modelDistrict);
		$this->model = $model;
		$this->modelCategory = $modelCategory;
		$this->data['path_photo'] = _upload_product;
	}

	public function index(){

	}

	public function show($cat_url_rewrite, $url_rewrite){
		$this->data['data'] = $this->model->getDetail($url_rewrite);
		$this->data['titlePage'] = $this->data['data']->title;
		return view('portal.product.show')->with($this->data);
	}

	public function search(){
		$input = Input::all();
		$products = $this->model->select('products.id', 'products.title', 'products.url_rewrite', 'products.price', 'products.acreage', 'products.rooms', 'products.address', 'products.lat', 'products.lng', 'products.description', 'products.category_id', 'products.created_at');

		if(isset($input['search_key']) && $input['search_key'] != ''){
			$products->where('products.title', 'like', '%'.$input['search_key'].'%')
					->orWhere('products.address', 'like', '%'.$input['search_key'].'%');
		}

		if(isset($input['district_id']) && $input['district_id'] != ''){
			$products->where('products.district_id', $input['district_id']);
		}

		if(isset($input['dientich']) && $input['dientich'] != ''){
			$dientich = explode('-', $input['dientich']);
			if(!isset($dientich[1])){
				$products->where('products.acreage', '>=', $dientich[0]);
			}else{
				$products->where('products.acreage', '>=', $dientich[0])->where('products.acreage', '<=', $dientich[1]);
			}
		}

		if(isset($input['price']) && $input['price'] != ''){
			$prices = explode('-', $input['price']);
			if(!isset($prices[1])){
				$products->where('products.price', '>=', $prices[0]);
			}else{
				$products->where('products.price', '>=', $prices[0])->where('products.price', '<=', $prices[1]);
			}
		}

		if(isset($input['so_phong']) && $input['so_phong'] != ''){
			$products->where('products.rooms', '>=', $input['so_phong']);
		}

		if(isset($input['huongnha_id']) && $input['huongnha_id'] != ''){
			$products->where('products.direction_id', $input['huongnha_id']);
		}

		$products->where('status', ACTIVE);
		$products->orderBy('products.id', 'desc')
                 ->groupBy('products.id');

		$products = $products->paginate(5);
		foreach ($products as $key => $value) {
			$products[$key]['photo'] = ProductImage::where('product_id',$value->id)->first();
            $products[$key]['category'] = $value->category;
		}
		$this->data['products'] = $products;
        $this->data['titlePage'] = 'Tìm kiếm';
		return view('portal.product.list')->with($this->data);
	}
}
