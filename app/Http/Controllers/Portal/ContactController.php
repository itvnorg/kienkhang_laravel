<?php

namespace App\Http\Controllers\Portal;

use Request, Response, Input, Validator, Mail;
use App\Http\Controllers\Portal\BaseController;
use App\Models\Province;
use App\Models\District;
use App\Models\Direction;
use Illuminate\Support\Facades\Redirect;

class ContactController extends BaseController
{
	private $modelDirection;
	private $modelProvince;
	private $modelDistrict;

	public function __construct(Direction $modelDirection, Province $modelProvince, District $modelDistrict){
		$this->modelDirection = $modelDirection;
		$this->modelProvince = $modelProvince;
		$this->modelDistrict = $modelDistrict;
		parent::__construct( $modelDirection, $modelProvince, $modelDistrict);
	}

	public function send(){
		$status = 'error';
        $msg = 'Truy cập không hợp lệ';
        $title = 'Lỗi';

        $input = Input::all();

	   	$rules = [
	    	'email',
	    	'name',
	    	'address',
	    	'phone',
	    	'content'
	    ]; 
        $valid = Validator::make($input, $rules);
        if ($valid->passes()) {

			
            $dataEmail = [
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'name' => $input['name'],
                'content' => $input['content'],
                'subject' => 'Thông tin liên hệ',
                'settings' => $this->settings
                // 'status'    => Contact::STATUS_PENDING
            ];
        //     // Contact::create($data);

            $dataEmail['to_email'] = $this->settings['company_email'];
            $dataEmail['email'] = $input['email'];

	        try {
	            Mail::send("portal.email_template.send_contact", $dataEmail, function($message) use ($dataEmail) {
	                $message->to($dataEmail["to_email"], $dataEmail["name"]);
	                $message->subject("Thông tin liên hệ");
	            });

	            $status = 'success';
	            $msg = 'Gửi thông tin liên hệ thành công';
	            $title = 'Thành công';
	        } catch (Exception $e) {
				$status = 'error';
		        $msg = 'Truy cập không hợp lệ';
		        $title = 'Lỗi';
	            return Redirect::back()->withInput()->withErrors('Have error when send reset password mail');
	        }
        }
	}
}
