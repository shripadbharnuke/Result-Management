<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class cache {



	public function clear_cache(){
		 $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
   	 $this->output->set_header("Pragma: no-cache");
	}
	
}



