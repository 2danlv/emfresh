<?php
defined('ABSPATH') or die();

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site',
		'menu_title'	=> 'Site',
		'menu_slug' 	=> 'site-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

function dym_settings() {
    // Add tag metabox to page
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action( 'init', 'dym_settings' );

function site_get_options( $key = '' )
{
	$defaults = array(
		'facebook_url'		=> '',
		'youtube_url'		=> '',
		'twitter_url'		=> '',
		'linkedin_url'		=> '',
		'contact_page_id'	=> 0,
	);

	// Using ACF for themes setting
	if( function_exists('get_field') ) {
		foreach ($defaults as $k => $v) {
			$defaults[$k] = get_field( $k, 'option' );
			if( $key!='' && $key == $k )
			{
				return $defaults[$k];
			}
		}
	}

	return $defaults;
}

function site_disable_status_css()
{
	wp_enqueue_style( 'site-disable-status-style', get_template_directory_uri(). '/assets/admin/css/disable.css' );
}
// add_action( 'admin_enqueue_scripts', 'site_disable_status_css' );
