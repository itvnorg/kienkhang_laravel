<?php

namespace App\Http\Controllers\Admin;

use Request, Response, Input, Validator;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Direction;
use Illuminate\Support\Facades\Redirect;

class DirectionController extends BaseController
{
    private $titleSingle = 'direction';
    private $titlePlural = 'directions';
    private $resourceRoute = 'directions';
    private $resourceView = 'direction';
    private $iconMain = 'fa fa-arrows-alt';
    private $model;

    public function __construct(Direction $model){
        parent::__construct();
        $this->model = $model;
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

        try {
            $this->model->create($input);

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

        try {
            $model->update($input);

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
