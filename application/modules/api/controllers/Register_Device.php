<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_Device extends Api_Controller {
	
	function __construct() {
		
        // Construct our parent class
        parent::__construct();
		
		$this->load->model('devices_m');
		
    }
	
	function index_get() {
		
		$api_response['status'] = false;
		$status_code = 400;
		
		$device_id = trim($this->get('device_id'));
		
		$device_type = strtolower(trim($this->get('device_type')));
		$device_name = trim($this->get('device_name'));
		$imsi = trim($this->get('imsi'));
		$vendor = trim($this->get('vendor'));
		$width = trim($this->get('width'));
		$height = trim($this->get('height'));
		$locale = trim($this->get('locale'));
		$wifi_mac = trim($this->get('wifi_mac'));
		$display_resolution = trim($this->get('display_resolution'));
		$display_size = trim($this->get('display_size'));
		$device_memory = trim($this->get('device_memory'));
		
		$device_token = trim($this->get('device_token'));
		
		$package = trim($this->get('package'));
		$version_name = trim($this->get('version_name'));
		$version_code = trim($this->get('version_code'));
		$sdk = trim($this->get('sdk'));
		$channel = trim($this->get('channel'));
		
		if($device_id == '') {
			
			$api_response['error'] = 'Invalid Device!';
			
		} else if(strlen($device_id) > 36) {
			
			$api_response['error'] = 'Invalid Device!';
			
		} else if(!in_array($device_type, array('android', 'ios')) || $device_name == '') {
			
			$api_response['error'] = 'Invalid Device!';
			
		} else if(($device_type == 'android' && strlen($device_id) > 15) || ($device_type == 'ios' && strlen($device_id) != 36)) {
			
			$api_response['error'] = 'Invalid Device!';
			
		} else if ($device_type == 'ios' && $device_token != '' && !preg_match('~^[a-f0-9]{64}$~i', $device_token)) {
			
			$api_response['error'] = 'Invalid Device!';
			
		} else {
			
			$device_data = array(
				'device_id'	=>	$device_id,
				'device_type'	=>	$device_type,
				'device_name'	=>	$device_name,
				'imsi'	=>	$imsi,
				'vendor'	=>	$vendor,
				'width'	=>  $width,
				'height'	=>	$height,
				'locale'	=>	$locale,
				'wifi_mac'	=>	$wifi_mac,
				'display_resolution'	=>	$display_resolution,
				'display_size'	=>	$display_size,
				'device_memory'	=>	$device_memory,
			);
			
			$check = $this->devices_m->check_device($device_id);
			
			$api_response['status'] = true;
			$status_code = 200;
			
			if($package != '' || $version_name != '' || $version_code != '' || $sdk != '' || $channel != '') {
				$device_app_data = array(
					'app_id'	=>	APP_ID,
					'device_id'	=>	$device_id,
					'package'	=>	$package,
					'version_name'	=>	$version_name,
					'version_code'	=>	$version_code,
					'sdk'	=>	$sdk,
					'channel'	=>	$channel
				);
				
				$this->devices_m->device_app_data($device_id, $device_app_data);
			}
			
			if($device_token != '') {
				
				$device_push_data = array(
					'app_id'	=>	APP_ID,
					'device_id'	=>	$device_id,
					'device_type'	=>	$device_type,
					'push_identifier'	=>	$device_token
				);
				
				$this->devices_m->device_push_data($device_id, $device_push_data);
			}
			
			if($check) {
				
				$this->devices_m->update_device($device_id, $device_data);
				
			} else {
				
				$this->devices_m->register_device($device_data);
				
			}
			
			$access_data = array(
				'app_id'	=>	APP_ID,
				'device_id'	=>	$device_id
			);
			
			$api_response['api_access_token'] = $this->devices_m->set_access_token($access_data);
		}
		
		$this->response($api_response, $status_code);
	}
	
}