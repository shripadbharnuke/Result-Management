<?php

function redirect_to($fallback_url_string, $redirect = TRUE)
{
    $CI = & get_instance();

    $redirect_url = ($CI->session->userdata('redirect_to')) ? $CI->session->userdata('redirect_to') : $fallback_url_string;

    if ($redirect)
    {
        redirect($redirect_url);
    }
    return $return_url;
}

function redirect_to_set()
{
    $CI = & get_instance();
    $CI->session->set_userdata('redirect_to', $CI->uri->uri_string());
}

function full_url() {
	$CI =& get_instance();
	$url = $CI->config->site_url($CI->uri->uri_string());
	$query_string = $CI->input->server('QUERY_STRING');
	return $query_string ? $url.'?'.$query_string : $url;
}