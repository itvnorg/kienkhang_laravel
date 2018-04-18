<?php

namespace App\Http\Controllers\Admin;

use Request, Response, Input, Validator;
use App\Http\Controllers\Admin\BaseController;
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
    private $titleSingle = 'product';
    private $titlePlural = 'products';
    private $resourceRoute = 'products';
    private $resourceView = 'product';
    private $iconMain = 'fa fa-arrows-alt';
    private $model;
    private $modelCategory;
    private $modelProvince;
    private $modelDistrict;
    private $modelWard;
    private $modelDirection;

    public function __construct(Product $model, ProductCategory $modelCategory, Province $modelProvince, District $modelDistrict, Ward $modelWard, Direction $modelDirection){
        parent::__construct();
        $this->model = $model;
        $this->modelCategory = $modelCategory;
        $this->modelProvince = $modelProvince;
        $this->modelDistrict = $modelDistrict;
        $this->modelWard = $modelWard;
        $this->modelDirection = $modelDirection;
        $this->data['path_photo'] = _upload_product;
    }

    private function getModelArray($model){
        $obj = $model->get();
        $list = BuildOptionList($obj);
        return $list;
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
            $input = Input::all();
            $list = $this->model->getList($input);
            $total = $this->model->countTotal($input);
            return Response::json([
                'data' => $list,
                'input' => $input,
                'total' => $total
            ]);
        }

        $this->data['titlePage'] = trans('admin.'.$this->titlePlural);
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => trans('admin.home'), 'link' => route($this->routeRootAdmin), 'icon' => $this->iconDashboard ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'], 'icon' => $this->iconMain ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        $action = [
            'title' => trans('admin.obj_new',['obj' => trans('admin.'.$this->titleSingle)]),
            'link' => route(GetRouteAdminResource($this->resourceRoute, 'create')),
            'icon' => $this->iconNew
        ];
        $this->data['action'] = $action;

        return view(GetViewAdminResource($this->resourceView))->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['titlePage'] = trans('admin.obj_new',['obj' => trans('admin.'.$this->titleSingle)]);
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => trans('admin.home'), 'link' => route($this->routeRootAdmin), 'icon' => $this->iconDashboard ];
        $breadcrumbs[] = [ 'title' => trans('admin.'.$this->titlePlural), 'link' => route(GetRouteAdminResource($this->resourceRoute)), 'icon' => $this->iconMain ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'], 'icon' => $this->iconNew ];
        $this->data['breadcrumbs'] = $breadcrumbs;
        $this->data['category'] = $this->getModelArray($this->modelCategory);
        $this->data['province'] = $this->getModelArray($this->modelProvince);
        $this->data['district'] = $this->getModelArray($this->modelDistrict);
        $this->data['ward'] = $this->getModelArray($this->modelWard);
        $this->data['direction'] = $this->getModelArray($this->modelDirection);

        return view(GetViewAdminResource($this->resourceView, 'create'))->with($this->data);
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
        $rules = $this->model->rules;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        // Parse name to url_rewrite
        $input['url_rewrite'] = to_url($input['title']);
        $input['created_by'] = $this->user->id;

        try {
            $model = $this->model->create($input);

            // Handle images
            if (Input::hasfile('photo') && ! empty($input['photo'])) {
                foreach ($input['photo'] as $item) {
                    $img = $item;
                    $file = UploadAuto(
                        'photo',
                        $this->data['path_photo'],
                        $img
                    );
                    foreach ($file as $k => $v) {
                        $dataPhoto[$k] = $v;
                    }
                    $dataPhoto['product_id'] = $model->id;
                    ProductImage::create($dataPhoto);
                }
            }

            return Redirect::route(GetRouteAdminResource($this->resourceRoute))->with('success', __('admin.msgSuccessStore', ['resource' => $this->titleSingle]));
        } catch (Exception $e) {
            return Redirect::back()->withInput()->withErrors('error', $e->getMessage());
        }
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
        $this->data['titlePage'] = trans('admin.obj_edit',['obj' => trans('admin.'.$this->titleSingle)]);
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => trans('admin.home'), 'link' => route($this->routeRootAdmin), 'icon' => $this->iconDashboard ];
        $breadcrumbs[] = [ 'title' => trans('admin.'.$this->titlePlural), 'link' => route(GetRouteAdminResource($this->resourceRoute)), 'icon' => $this->iconMain ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'], 'icon' => $this->iconEdit ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        $this->data['data'] = $this->model->find($id);
        $this->data['category'] = $this->getModelArray($this->modelCategory);
        $this->data['province'] = $this->getModelArray($this->modelProvince);
        $this->data['district'] = $this->getModelArray($this->modelDistrict);
        $this->data['ward'] = $this->getModelArray($this->modelWard);
        $this->data['direction'] = $this->getModelArray($this->modelDirection);
        $this->data['photos'] = ProductImage::where('product_id', $id)->get();

        return view(GetViewAdminResource($this->resourceView, 'edit'))->with($this->data);
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
        $model = $this->model->find($id);
        if(!$model){
            return Redirect::back()->withInput()->withErrors(__('admin.msgErrModelNotExists', ['resource' => $this->titleSingle]));
        }

        $input = Input::all();  // Get all input
        $rules = $this->model->rules;  // Get rules of model User

        $valid = Validator::make($input, $rules);   // Validate all input with rules

        if (! $valid->passes()) {   // If validate fail
            return Redirect::back()->withInput()->withErrors($valid);   // Return back to page with errors
        }

        $input['updated_by'] = $this->user->id;

        try {
            $model->update($input);

            // Handle images
            if (! empty($input['photo'])) {
                foreach ($input['photo'] as $item) {
                    $img = $item;
                    $file = UploadAuto(
                        'photo',
                        $this->data['path_photo'],
                        $img
                    );
                    foreach ($file as $k => $v) {
                        $dataPhoto[$k] = $v;
                    }
                    $dataPhoto['product_id'] = $model->id;
                    ProductImage::create($dataPhoto);
                }
            }

            return Redirect::route(GetRouteAdminResource($this->resourceRoute))->with('success', __('admin.msgSuccessUpdate', ['resource' => $this->titleSingle]));
        } catch (Exception $e) {
            return Redirect::back()->withInput()->withErrors('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->model->destroy($id);

            echo json_encode([
                'status' => 'success',
                'message' => __('admin.msgSuccessDestroy', ['resource' => $this->titleSingle, 'id' => $id])
            ]); 
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
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

            try {
                $this->model->destroy($ids);

                echo json_encode([
                    'status' => 'success',
                    'message' => __('admin.msgSuccessDestroy', ['resource' => $this->titleSingle, 'id' => implode(', 9', $ids)])
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
            
        }
    }
}
