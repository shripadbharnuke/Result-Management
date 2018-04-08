<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
|  Email Server Configuration.
|--------------------------------------------------------------------------
|
| This will override the system email config file 
|
|
*/
$config['protocol']		= 'smtp';
$config['smtp_crypto'] 	= 'tls';
$config['smtp_host'] 	= '';
$config['smtp_port']	= '587';
$config['smtp_user'] 	= '';
$config['smtp_pass'] 	= '';
$config['from']			= '';
$config['from_name'] 	= '';
$config['cc']			= '';
$config['bcc']			= '';
$config['reply_to'] 	= array();
$config['mailtype'] 	= 'html';
/* End of file email.php */
/* Location: ./application/config/email.php */
