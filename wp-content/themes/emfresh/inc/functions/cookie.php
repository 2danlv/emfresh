<?php

function site_get_cookie( $name = '', $default = '' )
{
	$value = $default;

	if( isset($_COOKIE[$name]) ) {
		$value = $_COOKIE[$name];
		if( is_numeric($default) ) {
			$value = (int) $value;
		}
	}

	return $value;
}

function site_set_cookie( $name = '', $value = '' )
{
	//@setcookie($auth_cookie_name = 'Test', $auth_cookie = date('Y-m-d-H-i-s'), $expire = time() + 36600, COOKIEPATH, COOKIE_DOMAIN, $secure = '', true);

	if( $name == '' || $value == '' ) return '';

	$_COOKIE[$name] = $value;

	@setcookie($name, $value, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure = '', true  );

	return $value;
}


function site_get_cookie_array( $key = '' )
{
	$value = site_get_cookie($key, '');

	if( $value == '' )
		return array();

	if( strpos($value, '.') > -1 )
		return explode( '.', $value );
	
	return array($value);
}

function site_add_cookie_array( $key = '', $value = '' )
{
	$list = site_get_cookie_array( $key );
	
	if( in_array( $value, $list ) ) return $list;
	
	$temp = array($value);
	if( count($list) > 0 ) {
		foreach( $list as $v ){
			$temp[] = $v;
		}
	}
	$list = $temp;
	
	return site_set_cookie($key, site_convert_to_cookie_array_string($list) );
}

function site_convert_to_cookie_array_string( $value = array() )
{
	if( !is_array($value) || count($value) == 0 ) return '';

	if( count($value)>1 ) {
		return implode('.',$value);
	}

	return $value[0];
}

function site_remove_cookie_array( $key = '', $value = '' )
{
	$list = site_get_cookie_array( $key );
	
	if( count($list) > 0 ) {
		$temp = array();
		foreach( $list as $v ){
			if( $v!= $value ) {
				$temp[] = $v;
			}
		}
		$list = $temp;
	}
	
	return site_set_cookie( $key, site_convert_to_cookie_array_string( $list ) );
}