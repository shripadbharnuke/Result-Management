<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function date_formats()
{
    return array(
        'm/d/Y' => array(
            'setting'    => 'm/d/Y',
            'datepicker' => 'mm/dd/yyyy'
        ),
        'm-d-Y' => array(
            'setting'    => 'm-d-Y',
            'datepicker' => 'mm-dd-yyyy'
        ),
        'm.d.Y' => array(
            'setting'    => 'm.d.Y',
            'datepicker' => 'mm.dd.yyyy'
        ),
        'Y/m/d' => array(
            'setting'    => 'Y/m/d',
            'datepicker' => 'yyyy/mm/dd'
        ),
        'Y-m-d' => array(
            'setting'    => 'Y-m-d',
            'datepicker' => 'yyyy-mm-dd'
        ),
        'Y.m.d' => array(
            'setting'    => 'Y.m.d',
            'datepicker' => 'yyyy.mm.dd'
        ),
        'd/m/Y' => array(
            'setting'    => 'd/m/Y',
            'datepicker' => 'dd/mm/yyyy'
        ),
        'd-m-Y' => array(
            'setting'    => 'd-m-Y',
            'datepicker' => 'dd-mm-yyyy'
        ),
        'd-M-Y' => array(
            'setting'    => 'd-M-Y',
            'datepicker' => 'dd-M-yyyy'
        ),
        'd.m.Y' => array(
            'setting'    => 'd.m.Y',
            'datepicker' => 'dd.mm.yyyy'
        )
    );
}

function date_from_mysql($date, $ignore_post_check = FALSE)
{
    if ($date <> '0000-00-00')
    {
        if (!$_POST or $ignore_post_check)
        {
            $CI = & get_instance();

            $date = DateTime::createFromFormat('Y-m-d', $date);
            return $date->format($date_format);
        }
        return $date;
    }
    return '';
}

function date_from_timestamp($timestamp)
{
    $CI = & get_instance();

    $date = new DateTime();
    $date->setTimestamp($timestamp);
    return $date->format($date_format);
}

function date_to_mysql($date)
{
    $CI = & get_instance();

    $date = DateTime::createFromFormat($date_format, $date);
    return $date->format('Y-m-d');
}

function date_format_setting()
{
    $CI = & get_instance();

    $date_format = $date_format;

    $date_formats = date_formats();

    return $date_formats[$date_format]['setting'];
}

function date_format_datepicker()
{
    $CI = & get_instance();

    $date_format = $date_format;

    $date_formats = date_formats();

    return $date_formats[$date_format]['datepicker'];
}

/**
 * Adds interval to user formatted date and returns user formatted date
 * To be used when date is being output back to user
 * @param $date - user formatted date
 * @param $increment - interval (1D, 2M, 1Y, etc)
 * @return user formatted date
 */
function increment_user_date($date, $increment)
{
    $CI = & get_instance();

    $mysql_date = date_to_mysql($date);

    $new_date = new DateTime($mysql_date);
    $new_date->add(new DateInterval('P' . $increment));

    return $new_date->format($date_format);
}

/**
 * Adds interval to yyyy-mm-dd date and returns in same format
 * @param $date
 * @param $increment
 * @return date
 */
function increment_date($date, $increment)
{
    $new_date = new DateTime($date);
    $new_date->add(new DateInterval('P' . $increment));
    return $new_date->format('Y-m-d');
}

function validDate($date, $format = 'd/m/Y H:i') {
    $d = DateTime::createFromFormat($format, $date);
	$valid = DateTime::getLastErrors();
	if($valid['warning_count']==0 && $valid['error_count']==0) {
		return true;
	} else {
		return false;
	}
}

function createDate($date, $from_format = 'd/m/Y H:i', $create_format = 'Y-m-d H:i:s') {
	$d = date_create_from_format($from_format, $date);
	$valid = DateTime::getLastErrors();
	if($valid['warning_count']==0 && $valid['error_count']==0) {
		return date_format($d, $create_format);
	} else {
		return '0000-00-00 00:00:00';
	}
}

// Converting timestamp to time ago in PHP e.g 1 day ago, 2 days ago…
function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";

}
