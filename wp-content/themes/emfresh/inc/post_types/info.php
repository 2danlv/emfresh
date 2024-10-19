<?php

/**
 * Register a Info post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function site_custom_info_init()
{
	$labels = array(
		'name'               => _x( 'Info', 'post type general name', 'site' ),
		'singular_name'      => _x( 'Info', 'post type singular name', 'site' ),
		'menu_name'          => _x( 'Info', 'admin menu', 'site' ),
		'name_admin_bar'     => _x( 'Info', 'add new on admin bar', 'site' ),
		'add_new'            => _x( 'Add New', 'Info', 'site' ),
		'add_new_item'       => __( 'Add New Info', 'site' ),
		'new_item'           => __( 'New Info', 'site' ),
		'edit_item'          => __( 'Edit Info', 'site' ),
		'view_item'          => __( 'View Info', 'site' ),
		'all_items'          => __( 'All Info', 'site' ),
		'search_items'       => __( 'Search Info', 'site' ),
		'parent_item_colon'  => __( 'Parent Info:', 'site' ),
		'not_found'          => __( 'No Info found.', 'site' ),
		'not_found_in_trash' => __( 'No Info found in Trash.', 'site' )
	);

	$args = array(
		'labels'             	=> $labels,
		'description'        	=> __( 'Description', 'site' ),
		'public'             	=> false,
		'publicly_queryable' 	=> false,
		'show_ui'            	=> true,
		'show_in_menu'       	=> true,
		'query_var'          	=> true,
		'rewrite'            	=> false,
		'taxonomies'    	 		=> array(),
		'capability_type'    	=> 'post',
		'has_archive'        	=> false,
		'hierarchical'       	=> false,
    'menu_position'      	=> 20,  // 20: below Pages
    'menu_icon'    				=> 'dashicons-format-aside', // https://developer.wordpress.org/resource/dashicons/#megaphone
		'supports'           	=> array( 'title', 'editor' )
	);

	register_post_type( 'info', $args );
}
add_action( 'init', 'site_custom_info_init' );
