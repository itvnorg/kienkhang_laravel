<?php

namespace App\Http\Controllers\Admin;

use Input;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Redirect;

class SystemSettingsController extends BaseController
{
    private $titleSingle = 'admin.system_setting';
    private $titlePlural = 'admin.system_settings';
    private $resourceRoute = 'settings';
    private $resourceView = 'setting';
    private $iconMain = 'fa fa-cogs';

    public function __construct(){
        parent::__construct();
	}

	public function getSettings(){
        $this->data['titlePage'] = trans($this->titlePlural);
        $breadcrumbs = array();
        $breadcrumbs[] = [ 'title' => trans('admin.home'), 'link' => route($this->routeRootAdmin), 'icon' => $this->iconDashboard ];
        $breadcrumbs[] = [ 'title' => $this->data['titlePage'], 'icon' => $this->iconMain ];
        $this->data['breadcrumbs'] = $breadcrumbs;

		$this->data['data'] = SystemSetting::getSettings();
        return view(GetViewAdminResource($this->resourceView))->with($this->data);
	}

	public function updateSettings(){
		$input = Input::all();
		unset($input['_method']);
		unset($input['_token']);
        foreach ($input as $key => $value) {
        	if($value != '')
            SystemSetting::where('key', $key)->update(['value' => $value]);
        }
        return Redirect::back()->with('success', 'Save system settings successfull');
	}
}
