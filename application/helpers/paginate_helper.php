<?php

function paginate() {
	$config['per_page'] = 10;
	$config['uri_segment'] = 4;
	$config["num_links"] = 1;
	$config['use_page_numbers'] = TRUE;
	$config['first_url'] = '1';
	$config['cur_tag_open'] = '<li class="active"><a>';
	$config['cur_tag_close'] = '</a></li>';
	$config['next_link'] = 'Next';
	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = 'Previous';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	
	return $config;
}