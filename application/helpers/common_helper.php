<?php

function getDomainFromEmail($email) {
	// Get the data after the @ sign
	$domain = substr(strrchr($email, "@"), 0);
	return $domain;
}

function getusernameFromEmail($email) {
	// Get the data after the @ sign
	$username = substr($email, 0, strpos($email, "@"));
	return $username;
}

function domain_exists($domain, $record = 'MX'){
	return checkdnsrr($domain, $record);
}

function random_username($string) {
	$pattern = " ";
	$firstPart = strstr(strtolower($string), $pattern, true);
	$secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
	$nrRand = rand(0, 100);

	$username = trim($firstPart).trim($secondPart).trim($nrRand);
	return $username;
}

function isJson($string) {
	json_decode($string);
	if(json_last_error() == JSON_ERROR_NONE) {
		if(substr($string,0,1) == '[' && substr($string,-1) == ']') { return TRUE; }
		else if(substr($string,0,1) == '{' && substr($string,-1) == '}') { return TRUE; }
		else { return FALSE; }
	}
}

function file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}

function IsNullOrEmptyString($string){
    return (!isset($string) || trim($string)==='');
}

if(!function_exists("array_column"))
{

    function array_column($array,$column_name)
    {

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }

}

function array_sort($array, $on, $order=SORT_DESC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
}

function time_into_seconds($time) {
	
	$parsed = explode(':', $time);
	
	$seconds = 0;
	if(count($parsed) >= 2) {
		$seconds = $parsed[0] * 3600 + $parsed[1] * 60;
	}

	return $seconds;
}

function containsWord($str, $word) {
    return !!preg_match('#\b' . preg_quote($word, '#') . '#', $str);
}

function array_intersect_2dim($array1, $array2)
{
	$result = array_map('unserialize',array_intersect(array_map('serialize', $array1), array_map('serialize', $array2)));
	
	return $result;
}

function string_limit_words($string, $limit){
	
	$string = preg_replace(" (\[.*?\])",'',$string);
	$string = strip_tags($string);
	if(strlen($string) > $limit) {
		$string = substr($string, 0, $limit);
		$string = substr($string, 0, strripos($string, " "));
		$string = trim(preg_replace( '/\s+/', ' ', $string));
		$string = $string.'... more';
	}
	return $string;
}

function version_compare2($versions) {
	
	$max = '0.0.0';
	foreach ($versions as $version) {
	  if (isset($max)) {
		$comp = version_compare($max, $version);
		if($comp <= 0) {
			$max = $version;
		}
	  }
	}

	return $max;
}

function encode_emoji( $content ) {
	if ( function_exists( 'mb_convert_encoding' ) ) {
		$regex = '/(
		     \x23\xE2\x83\xA3               # Digits
		     [\x30-\x39]\xE2\x83\xA3
		   | \xF0\x9F[\x85-\x88][\xA6-\xBF] # Enclosed characters
		   | \xF0\x9F[\x8C-\x97][\x80-\xBF] # Misc
		   | \xF0\x9F\x98[\x80-\xBF]        # Smilies
		   | \xF0\x9F\x99[\x80-\x8F]
		   | \xF0\x9F\x9A[\x80-\xBF]        # Transport and map symbols
		)/x';

		$matches = array();
		if ( preg_match_all( $regex, $content, $matches ) ) {
			if ( ! empty( $matches[1] ) ) {
				foreach ( $matches[1] as $emoji ) {
					/*
					 * UTF-32's hex encoding is the same as HTML's hex encoding.
					 * So, by converting the emoji from UTF-8 to UTF-32, we magically
					 * get the correct hex encoding.
					 */
					$unpacked = unpack( 'H*', mb_convert_encoding( $emoji, 'UTF-32', 'UTF-8' ) );
					if ( isset( $unpacked[1] ) ) {
						$entity = '&#x' . ltrim( $unpacked[1], '0' ) . ';';
						$content = str_replace( $emoji, $entity, $content );
					}
				}
			}
		}
	}

	return $content;
}

function getStringBetween($str, $from, $to)
{
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}

function utf8_code_deep($input, $b_encode = TRUE, $b_entity_replace = TRUE)
{
	if (is_string($input))
	{
		if($b_encode)
		{
			if(mb_detect_encoding($input) != "UTF-8") {
				$input = mb_convert_encoding($input, "UTF-8");
				$input = utf8_encode($input);
			}

			//return Entities to UTF8 characters
			//important for interfaces to blackbox-pages to send the correct UTF8-Characters and not Entities.
			if($b_entity_replace)
			{
				$input = html_entity_decode($input, ENT_NOQUOTES/* | ENT_HTML5*/, 'UTF-8'); //ENT_HTML5 is a PHP 5.4 Parameter.
			}
		}
		else
		{
			//Replace NON-ISO Characters with their Entities to stop setting them to '?'-Characters.
			if($b_entity_replace)
			{
				$input = preg_replace("/([\304-\337])([\200-\277])/e", "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'", $input);
			}

			$input = utf8_decode($input);
		}
	}
	elseif (is_array($input))
	{
		foreach ($input as &$value)
		{
			$value = utf8_code_deep($value, $b_encode, $b_entity_replace);
		}
	}
	elseif (is_object($input))
	{
		$vars = array_keys(get_object_vars($input));

		if(get_class($input) == 'SimpleXMLElement')
		{
			//DOES NOT WORK!
			return '';
		}

		foreach ($vars as $var)
		{
			$input->$var = utf8_code_deep($input->$var, $b_encode, $b_entity_replace);
		}
	}

	return $input;
}

/**
 * remove_empty_tags_recursive ()
 * Remove the nested HTML empty tags from the string.
 */
function remove_empty_tags_recursive ($description, $repto = NULL)
{
    //** Return if string not given or empty.
    if (!is_string ($description) || trim ($description) == '') {
		return $description;
	}		
	
	$description = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $description);
	$description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $description);
	$description = preg_replace('#<ins(.*?)>(.*?)</ins>#is', '', $description);
	$description = preg_replace('#<noscript(.*?)>(.*?)</noscript>#is', '', $description);
	
	$description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) id=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) srcset=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-srcset=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-cfsrc=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-reactid=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-type=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-part=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) data-test-id=".*?"/i', '$1', $description);
	$description = preg_replace('/(<[^>]+) property=".*?"/i', '$1', $description);
	
    //** Recursive empty HTML tags.
    $description = preg_replace ('/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU', (!is_string ($repto) ? '' : $repto), $description);
	
	return $description;
}