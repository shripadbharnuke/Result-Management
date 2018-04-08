<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
|  Android, iOS push notification Configuration.
|--------------------------------------------------------------------------|
*/
// For Android
$config['GCM_PROJECT_ID'] 		= '';	// GCM Project Id
$config['GCM_API_ACCESS_KEY']	= '';	// (Android)API access key from Google API's Console.
$config['GCM_URL']	= 'https://gcm-http.googleapis.com/gcm/send';	// (Android)API URL from Google API's Console.

// For IOS
$config['IOS_SSL_CERT']	= '';	// (iOS Certificate File)
$config['IOS_PVT_KEY'] 	= '';	// (iOS) Private key's passphrase.
$config['IOS_PUSH_URL'] 	= 'ssl://gateway.sandbox.push.apple.com:2195';	// (iOS) url.

/* End of file push.php */
/* Location: ./application/config/push.php */
