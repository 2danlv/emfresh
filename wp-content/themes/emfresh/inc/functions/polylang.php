<?php

/*
 * Polylang - Function reference
 * https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
 *
 * pll_register_string($name, $string, $group, $multiline);
 * pll__($string);
 * pll_e($string);
 * pll_translate_string($string, $lang);
 *
 */

// wp-admin
// Go to url: wp-admin/admin.php?page=mlang_strings

if( function_exists('pll_register_string') ):

	$poli_languages = array(
                'Appointment',
                'Inquiry',
                'Read more',
								'Hotline',
								'Opening Hours',
								'Address',
								'Fax',
								'Tel',
								'Contact',
								'INTRODUCTION OF DOCTORS',
								'DOCTOR',
								'Book Reservation',
								'Categories',
								'Detail',
								'Price',
								'Show more',
								'Show less',
								'Filter',
							);

	if(count($poli_languages)){
		foreach($poli_languages as $name => $string){

			$multiline = ( $string == 'multiline' );
			if( $multiline ) {
				$string = $name;
			}

			if( is_string($name) ){
				$name = ucwords($name);
			} else {
				$name = 'Text '.($name+1);
			}

			// $multiline = strpos( $string, "\n" )>-1;

			pll_register_string($name, $string, $group = 'Site Theme', $multiline);
		}

	}

endif;

function site_text( $string = '', $echo = true )
{
	if( function_exists('pll__') ) {
		$string = pll__( $string );
	}

	if( $echo ) {
		echo $string;
	}

	return $string;
}

function site_get_post( $id = 0, $type = '' )
{
	if( function_exists('pll_get_post') ) {
		if( pll_current_language('slug')!=pll_default_language('slug')  ) {
			$new = (int) pll_get_post( $id, pll_current_language('slug') );
			if( $new!=$id ) {
				$id = $new;
			}
		}
	}

	if( $type == 'link' ) {
		return get_permalink( $id );
	} else if( $type == 'title' ) {
		return get_the_title( $id );
	} else if( $type == 'id' ) {
		return $id;
	}

	return get_post( $id );
}

function site_get_permalink( $id = 0 )
{
	return site_get_post( $id, 'link' );
}

function site_the_permalink( $id = 0 )
{
	echo site_get_post( $id, 'link' );
}

function site_get_the_title( $id = 0 )
{
	return site_get_post( $id, 'title' );
}

function site_the_title( $id = 0 )
{
	echo site_get_post( $id, 'title' );
}

function site_get_category( $id = 0, $type = '' )
{
	if( function_exists('pll_get_term') ) {
		if( pll_current_language('slug')!=pll_default_language('slug')  ) {
			$new = (int) pll_get_term( $id, pll_current_language('slug') );
			if( $new!=$id ) {
				$id = $new;
			}
		}
	}

	if( $type == 'link' ) {
		return get_category_link( $id );
	}

	return get_category( $id );
}

function site_get_category_link( $id = 0 )
{
	return site_get_category( $id, 'link' );
}

function site_the_category_link( $id = 0 )
{
	echo site_get_category( $id, 'link' );
}

function site_pll_the_languages( $args = array() )
{
	if( function_exists('pll_the_languages') )
	{
		return pll_the_languages($args);
	}

	return array();
}

function site_poly_check_post_lang( $id, $slug = '' )
{
	if( function_exists('pll_get_post') ) {
		if( intval(pll_get_post( $id, $slug )) == $id ) {
			return true;
		}
	}
	return false;
}
