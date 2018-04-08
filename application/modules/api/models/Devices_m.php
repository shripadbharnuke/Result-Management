<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// This modal is for Devices details
class Devices_m extends MY_Model {

    function __construct() {
        parent::__construct();
		
    }
	
	// Generate Unique key
	public function generate_nonce() {
		$uuid=false;
		if (function_exists('com_create_guid')){
			$uuid = com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = substr($charid, 0, 8).$hyphen
				.substr($charid, 8, 4).$hyphen
				.substr($charid,12, 4).$hyphen
				.substr($charid,16, 4).$hyphen
				.substr($charid,20,12);
		}
		$api_access_token = str_replace("}",'',(str_replace("{",'',$uuid)));
		
		return $api_access_token;
	}
	
	public function register_device($db_data = array()){
		
		if(!empty($db_data)) {
			
			$this->db->insert('devices',$db_data);
			
			return $this->db->insert_id();
		}
		
		return 	false;	
	}
	
	public function update_device($device_id, $db_data = array()){
		
		if(!empty($db_data)) {
			
			$this->db->where('device_id', $device_id)->update('devices', $db_data);
			
			return $this->db->affected_rows();
		}
		
		return 	false;	
	}
	
	public function check_device($device_id){
		
		$device = $this->db->select('id')->where(array('device_id' => $device_id))->get('devices')->row_array();
		if(!empty($device)){
			return $device['id'];
		}
		return false;
	}
	
	public function get_device_by_user($user_id){
		
		$device = $this->db->select('device_id')->where(array('user_id' => $user_id))->get('app_api_access_keys')->row_array();
		return $device;
	}
	
	public function device_app_data($device_id, $device_app_data){
		
		$device_apps = $this->db->select('*')->where(array('device_id' => $device_id))->get('devices_app_details')->result_array();
		
		if(!empty($device_apps)) {
			$apps = array();
			foreach($device_apps as $app) {
				$apps[] = array(
					'app_id'	=>	$app['app_id'],
					'device_id'	=>	$app['device_id'],
					'package'	=>	$app['package'],
					'version_name'	=>	$app['version_name'],
					'version_code'	=>	$app['version_code'],
					'sdk'	=>	$app['sdk'],
					'channel'	=>	$app['channel']
				);
			}
			$tmp_app_data[] = $device_app_data;
			$common = array_intersect_2dim($tmp_app_data, $apps);
			
			if(empty($common)) {
				
				$this->db->insert('devices_app_details', $device_app_data);
				
			}
			
		} else if(empty($device_apps) && !empty($device_app_data)) {
			$this->db->insert('devices_app_details', $device_app_data);
		}
		
		return true;
	}
	
	public function device_push_data($device_id, $device_push_data){
		
		$device_tokens = $this->db->select('*')->where(array('device_id' => $device_id, 'app_id' => $device_push_data['app_id']))->get('devices_token')->result_array();
		
		if(!empty($device_tokens)) {
			
			$this->db->where('device_id', $device_id);
			$this->db->where('app_id', $device_push_data['app_id']);
			$this->db->update('devices_token', $device_push_data);
			
		} else if(empty($device_tokens) && !empty($device_push_data)) {
			$this->db->insert('devices_token', $device_push_data);
		}
		
		return true;
	}
	
	public function set_access_token($access_data = array()){
		
		if(isset($access_data['device_id']) && isset($access_data['app_id'])){
			
			$api_access_token = $this->generate_nonce();
			
			$access_data['api_access_token'] = $api_access_token;
			
			$check = $this->db->select('*')->where(array('device_id' => $access_data['device_id'], 'app_id' => $access_data['app_id']))->get('app_api_access_keys')->row_array();
			
			if(!empty($check)) {
			
				$this->db->where('id', $check['id'])->update('app_api_access_keys', $access_data);
				
			} else {
				
				$this->db->insert('app_api_access_keys', $access_data);
				
			}
			
			return 	$api_access_token;	
		}
		return false;
	}
	
	public function check_access_token($device_id, $access_token, $app_id = APP_ID){
		
		if($access_token == '' || !$access_token || $device_id == '' || !$device_id) {
			return false;
		}
		
		$this->db->select('aaak.api_access_token, devices.device_type, aaak.user_id, devices.device_id, devices.wifi_mac');
		$this->db->from('app_api_access_keys as aaak');
		$this->db->join('devices', 'devices.device_id=aaak.device_id', 'left');
		$this->db->where('aaak.device_id', $device_id);
		$this->db->where('aaak.api_access_token', $access_token);
		$this->db->where('aaak.app_id', $app_id);
		
		$query = $this->db->get();
		$access_data = $query->row_array();
		
		return $access_data;
	}
	
	public function delete_access_token($device_id = false, $app_id = APP_ID){
		if($device_id){
			$this->db->where('app_id',$app_id);
			$this->db->where('device_id',$device_id);
			$this->db->delete('app_api_access_keys');
			return $this->db->affected_rows();
		}
		return false;	
	}
	
	public function update_api_access_keys_data($params = array()){ 
		if(!empty($params) && isset($params['device_id']) && isset($params['app_id'])){
			
			$this->db->update('app_api_access_keys', $params, array('device_id' => $params['device_id'], 'app_id' => $params['app_id']));
			
			return $this->db->affected_rows();
		}
		return false;				
	}
	
	public function get_app_version_details($device_type = false, $is_current = 1, $app_version = false, $app_id = APP_ID) {
		
		$this->db->select('*');
		$this->db->from('app_version_details as avd');
		$this->db->where('avd.is_current', $is_current);
		$this->db->where('avd.app_id', $app_id);
		
		if($device_type != false) {
			$this->db->where('avd.device_type', $device_type);
		}
		
		if($app_version != false) {
			$this->db->where('avd.app_version', $app_version);
		}
		
		$query = $this->db->get();
		
		return $query;
		
	}
	
}