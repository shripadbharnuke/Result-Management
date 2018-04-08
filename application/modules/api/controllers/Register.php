<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Api_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->load->library('ion_auth');
		$this->load->model('ion_auth_model');
		$this->lang->load('auth');
		$this->load->model('devices_m');
		
		$this->user_role_id = "";
	}
	
	// Registeration API
	public function index_post() {

		$message['status'] = false;
		$message['error_code'] = 1;
		$status_code = REST_Controller::HTTP_BAD_REQUEST;

		$tables = $this->config->item('tables', 'ion_auth');

		//validate form input
		$this->form_validation->set_rules('device_id', 'Device ID', 'trim|required');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique['.$tables['users'].'.username]');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique['.$tables['users'].'.email]');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirm_password]');

		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');

		$this->form_validation->set_rules('code', 'Role', 'trim|callback_check_user_role');

		if ($this->form_validation->run($this) == true) {
			
			$device_id = trim($this->post('device_id'));
			$email = strtolower(trim($this->post('email')));
			$username = trim($this->post('username'));
			$name = trim($this->post('name'));
			$password = $this->post('password');
			$code = trim($this->post('code'));
			
			$group_ids = array(
				'group_ids' => $this->user_role_id
			);
			
			$additional_data = array(
				'first_name' => $name,
				'username' => $username,
				'active' => 1,
			);

			if ($user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group_ids)) {

				$message['status'] = true;
				$message['error_code'] = 0;
				$status_code = 200;
				$message['message'] = $this->ion_auth->messages();
				
				$user_details = $this->ion_auth->get_user($user_id)->row_array();
				
				$access_data = array(
					'app_id'	=>	APP_ID,
					'user_id'	=>	$user_id,
					'device_id'	=>	$device_id
				);
				
				$message['api_access_token'] = $this->devices_m->set_access_token($access_data);
				
				$message['data'] = $user_details;
				
			} else {

				$message['error'] = $this->ion_auth->errors();
				$status_code = 404;
			}
		} else {

			$message['error'] = $this->validation_errors();
		}
		
		$this->response($message, $status_code);
	}
	
	// Check User type Validation for b2b
	function check_user_role($code) {

		$group = $this->ion_auth->get_group_by_code($code);
		
		if (empty($group)) {

			$this->form_validation->set_message('check_user_role', 'Invalid code');

			return false;
		}
		
		$this->user_role_id = $group['id'];

		return true;
	}

}
