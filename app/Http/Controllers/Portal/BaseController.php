<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\ProductCategory;
use App\Models\NewsCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Direction;
use App\Models\File;
use App\Models\Page;

class BaseController extends Controller
{
    private $modelDirection;
    private $modelProvince;
    private $modelDistrict;

	public function __construct(Direction $modelDirection, Province $modelProvince, District $modelDistrict){
		parent::__construct();
        $this->modelDirection = $modelDirection;
        $this->modelProvince = $modelProvince;
        $this->modelDistrict = $modelDistrict;

        $this->getSelectSearchBox();
        $this->getHeaderMenu();
        $this->getFooterMenu();
	}

    public function getHome(){
        $this->data['titlePage'] = 'Home';
        $this->getSlider();
        $this->getProducts();
        $this->getHotProducts();
    	return view('portal.index')->with($this->data);
    }

    protected function getProducts(){
    	$products = Product::orderBy('updated_at', 'desc')->get();
    	foreach ($products as $key => $value) {
    		$products[$key]['photo'] = ProductImage::where('product_id',$value->id)->first();
            $products[$key]['category'] = $value->category;
    	}
    	$this->data['products'] = $products;
    }

    protected function getHotProducts(){
    	$products = Product::where('status', HOT)->orderBy('views', 'desc')->get();
    	foreach ($products as $key => $value) {
    		$products[$key]['photo'] = ProductImage::where('product_id',$value->id)->first();
            $products[$key]['category'] = $value->category;
    	}
    	$this->data['hot_products'] = $products;
    }

    protected function getSlider(){
    	$this->data['sliders'] = File::join('file_categories', function($join){
    		$join->on('files.category_id','=','file_categories.id')
    			->where('file_categories.name','Slider');
    	})->get();
    }

    protected function getSelectSearchBox(){
        // Lay tong so tin dang trong ngay
        $now = new \DateTime();
        $yesterday = $now->sub(new DateInterval('P1D'));
        $this->data['totalInDay'] = Product::whereIn('status', [ACTIVE, HOT])
                    ->where('created_at', '>' ,$yesterday)
                    ->count();
        // Loai giao dich
        $typeTransaction = ProductCategory::select('name','id')
                                ->where('parent_id',0)
                                ->get();
        $this->data['typeTransaction'] = '';
        foreach ($typeTransaction as $item) {
            $this->data['typeTransaction'] .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
        }
        // Loai nha dat tab 1
        $typeProducts = ProductCategory::select('name','id')
                                ->where('parent_id',1)
                                ->get();
        $this->data['typeProducts'] = BuildOptionList($typeProducts);
        // foreach ($typeProducts as $item) {
        //     $this->data['typeProducts'] .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
        // }
        // Loai nha dat tab 2
        $typeProducts2 = ProductCategory::select('name','id')
                                ->where('parent_id',2)
                                ->get();
        $this->data['typeProducts2'] = BuildOptionList($typeProducts2);
        // foreach ($typeProducts2 as $item) {
        //     $this->data['typeProducts2'] .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
        // }
        // tinh thanh pho
        $this->data['province'] = $this->getModelArray($this->modelProvince);
        $this->data['district'] = $this->getModelArray($this->modelDistrict);
        // dien tich
        $acreages = [
            '0-30' => 'Từ 0 - 30m2',
            '30-50' => 'Từ 30m2 - 50m2',
            '50-100' => 'Từ 50m2 - 100m2',
            '100-200' => 'Từ 100m2 - 200m2',
            '200-300' => 'Từ 200m2 - 300m2',
            '300-500' => 'Từ 300m2 - 500m2',
            '500' => 'Từ 500m2 trở lên'
        ];
        $this->data['acreages'] = '';
        foreach ($acreages as $key => $value) {
            $this->data['acreages'] .= '<option value="'.$key.'">'.$value.'</option>';
        }
        // muc gia
        $prices = [
            '0-50000000' => 'Từ 0 - 50 triệu',
            '50000000-100000000' => 'Từ 50 triệu - 100 triệu',
            '100000000-500000000' => 'Từ 100 triệu - 500 triệu',
            '500000000-1000000000' => 'Từ 500 triệu - 1 tỷ',
            '1000000000-10000000000' => 'Từ 1 tỷ - 10 tỷ',
            '10000000000-5000000000' => 'Từ 10 tỷ - 50 tỷ',
            '5000000000' => 'Hơn 50 tỷ'
        ];
        $this->data['prices'] = '';
        foreach ($prices as $key => $value) {
            $this->data['prices'] .= '<option value="'.$key.'">'.$value.'</option>';
        }
        // so phong ngu
        $rooms = [
            '1' => '1+',
            '3' => '3+',
            '5' => '5+',
            '7' => '7+',
            '9' => '9+'
        ];
        $this->data['rooms'] = '';
        foreach ($rooms as $key => $value) {
            $this->data['rooms'] .= '<option value="'.$key.'">'.$value.'</option>';
        }
        // huong nha
        
        $this->data['direction'] = $this->getModelArray($this->modelDirection);
        // du an
        // $duan = Duan::select('name','id')
        //                         ->get();
        // $this->data['duan_list'] = '';
        // foreach ($duan as $item) {
        //     $this->data['duan_list'] .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
        // }
    }

    public function getHeaderMenu(){
        // Title - url
        $menu = [];

        $productCategory = ProductCategory::where('parent_id',null)->orderBy('index', 'asc')->limit(2)->get();
        foreach ($productCategory as $key => $value) {
            $menu[$value->url_rewrite] = [
                'title' => $value->name,
                'url' => route('portal.product_categories.show', [ 'cat_url_rewrite' => $value->url_rewrite])
            ];
            $subItem = ProductCategory::where('parent_id',$value->id)->orderBy('index', 'asc')->get();
            if(isset($subItem)){
                foreach ($subItem as $subKey => $subValue) {
                    $menu[$value->url_rewrite]['sub_item'][$subValue->url_rewrite] = [
                        'title' => $subValue->name,
                        'url' => route('portal.product_categories.show', [ 'cat_url_rewrite' => $subValue->url_rewrite])
                    ];
                    $subItemLevel2 = ProductCategory::where('parent_id',$subValue->id)->orderBy('index', 'asc')->get();
                    if(isset($subItemLevel2)){
                        foreach ($subItemLevel2 as $sub2Key => $sub2Value) {
                            $menu[$value->url_rewrite]['sub_item'][$subValue->url_rewrite]['sub_item'][$sub2Value->url_rewrite] = [
                                'title' => $sub2Value->name,
                                'url' => route('portal.product_categories.show', [ 'cat_url_rewrite' => $sub2Value->url_rewrite])
                            ];
                        }
                    }
                }
            }
        }

        $newsCategory = NewsCategory::where('parent_id',null)->orderBy('index', 'asc')->limit(4)->get();
        foreach ($newsCategory as $key => $value) {
            $menu[$value->url_rewrite] = [
                'title' => $value->name,
                'url' => route('portal.news_categories.show', [ 'cat_url_rewrite' => $value->url_rewrite])
            ];
            $subItem = NewsCategory::where('parent_id',$value->id)->orderBy('index', 'asc')->get();
            if(isset($subItem)){
                foreach ($subItem as $subKey => $subValue) {
                    $menu[$value->url_rewrite]['sub_item'][$subValue->url_rewrite] = [
                        'title' => $subValue->name,
                        'url' => route('portal.news_categories.show', [ 'cat_url_rewrite' => $subValue->url_rewrite])
                    ];
                    $subItemLevel2 = NewsCategory::where('parent_id',$subValue->id)->orderBy('index', 'asc')->get();
                    if(isset($subItemLevel2)){
                        foreach ($subItemLevel2 as $sub2Key => $sub2Value) {
                            $menu[$value->url_rewrite]['sub_item'][$subValue->url_rewrite]['sub_item'][$sub2Value->url_rewrite] = [
                                'title' => $sub2Value->name,
                                'url' => route('portal.news_categories.show', [ 'cat_url_rewrite' => $sub2Value->url_rewrite])
                            ];
                        }
                    }
                }
            }
        }

        $this->data['menu_header'] = $menu;
    }

    public function getFooterMenu(){
        // Title - url
        $menu = [];

        $pageCategory = Page::orderBy('index', 'asc')->limit(3)->get();
        foreach ($pageCategory as $key => $value) {
            $menu[$value->url_rewrite] = [
                'title' => $value->title,
                'url' => route('portal.pages.show', [ 'url_rewrite' => $value->url_rewrite])
            ];
        }

        $newsCategory = NewsCategory::where('parent_id',null)->orderBy('index', 'asc')->limit(3)->get();
        foreach ($newsCategory as $key => $value) {
            $menu[$value->url_rewrite] = [
                'title' => $value->name,
                'url' => route('portal.news_categories.show', [ 'cat_url_rewrite' => $value->url_rewrite])
            ];
        }

        $this->data['menu_footer'] = $menu;
    }

    private function getModelArray($model){
        $obj = $model->get();
        $list = BuildOptionList($obj);
        return $list;
    }
}
