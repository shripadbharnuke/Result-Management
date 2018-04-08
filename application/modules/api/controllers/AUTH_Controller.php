<?php defined('BASEPATH') or exit('No direct script access allowed');

abstract class AUTH_Controller extends REST_Controller
{
	public $access_data = array();
	
    public function __construct(){
        
		parent::__construct();
		
		// load models
		$this->load->model('devices_m');
		
		$access_token = $this->input->server('HTTP_API_ACCESS_TOKEN', true); // User send In Header like this "API-ACCESS-TOKEN"
		$device_id = $this->input->server('HTTP_DEVICE_ID', true);  // User send In Header like this "DEVICE-ID"
		
		$this->access_data = $this->devices_m->check_access_token($device_id, $access_token);
		if(empty($this->access_data)){
			$api_response = array(
				'success'	=>	false,
				'status'	=>	'Invalid Access token!'
			);
			$this->response($api_response , 401);			
		}
		
		// load models
		$this->load->model('ion_auth_model');
		
		//load auth language
		$this->lang->load('auth');
	}
	
}
