<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Api_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->load->library('ion_auth');
		$this->load->model('ion_auth_model');
		$this->lang->load('auth');
		$this->load->model('devices_m');
	}
	
	// Validate Login
	public function index_post() {

		$message['status'] = false;
		$message['error_code'] = 1;
		$status_code = REST_Controller::HTTP_BAD_REQUEST;
		
		//validate form input
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('device_id', 'Device ID', 'trim|required');
		
		$email = trim($this->post('email'));
		$password = $this->post('password');
		$device_id = trim($this->post('device_id'));
		
		log_message('error', 'Login - Details ' . $email.'------------'.$password);
		
		if (($this->form_validation->run($this) == true) && ($user_id = $this->ion_auth->login($email, $password, false))) {
			
			$user_details = $this->ion_auth->get_user($user_id)->row_array();

			if (!empty($user_details)) {

				$message['status'] = true;
				$message['error_code'] = 0;
				$status_code = REST_Controller::HTTP_OK;

				$message['message'] = strip_tags($this->ion_auth->messages());
				
				$access_data = array(
					'app_id'	=>	APP_ID,
					'user_id'	=>	$user_id,
					'device_id'	=>	$device_id
				);
				
				$message['api_access_token'] = $this->devices_m->set_access_token($access_data);
			
				$message['data'] = $user_details;

			} else {

				$message['error'] = lang('login_unsuccessful');
			}
		} else {
			
			$message['error'] = strip_tags((validation_errors() != "" ? validation_errors() : $this->ion_auth->errors()));
		}

		$this->response($message, $status_code);
	}
	
}
