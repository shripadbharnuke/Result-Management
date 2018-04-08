<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'AUTH_Controller.php';

// This POst APi logout the user remove device id
class Logout extends AUTH_Controller {
	
	function __construct() {
		
        // Construct our parent class
        parent::__construct();
		
    }
	
	public function index_post() {
		
		//log_message('error', 'Logout API Start.');
		
		$device_id = $this->access_data['device_id'];
		
		$this->devices_m->delete_access_token($device_id);
		
		$message['status'] = true;
		$message['error_code'] = 0;
		$status_code = REST_Controller::HTTP_OK;
		$message['message'] = lang('logout_successful');
		
		log_message('error', 'Logout API End for user id. '.$this->post('userid'));
		
		$this->response($message, $status_code);
	}
    
}
