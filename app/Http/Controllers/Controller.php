<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\SystemSetting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $settings;

	public function __construct() {		
		$this->settings = SystemSetting::getSettingsKeyValue();
		$this->data['settings'] = $this->settings;

        $config = array(
            'driver' => $this->settings['driver_mailer'],
            'host' => $this->settings['host_mailer'],
            'port' => $this->settings['port_mailer'],
            'encryption' => $this->settings['encryption_mailer'],
            'from' => array('address' => $this->settings['account_mailer'], 'name' => $this->settings['site_name']),
            'username' => $this->settings['account_mailer'],
            'password' => $this->settings['password_mailer']
        );

        \Config::set('mail',$config);
	}
}
