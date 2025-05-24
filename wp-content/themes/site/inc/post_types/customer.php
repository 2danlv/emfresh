<?php

/**
 * Register a Product post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function site_custom_customer_init()
{

	// register_taxonomy( 'customer-category', 'customer', array(
	// 	'hierarchical' 			=> true,
	// 	'labels' => array(
	// 		'name'                       => _x( 'customer Categories', 'taxonomy general name' ),
	// 		'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
	// 		'search_items'               => __( 'Search Categories' ),
	// 		'popular_items'              => __( 'Popular Categories' ),
	// 		'all_items'                  => __( 'All Categories' ),
	// 		'parent_item'                => null,
	// 		'parent_item_colon'          => null,
	// 		'edit_item'                  => __( 'Edit Category' ),
	// 		'update_item'                => __( 'Update Category' ),
	// 		'add_new_item'               => __( 'Add New Category' ),
	// 		'new_item_name'              => __( 'New Category Name' ),
	// 		'separate_items_with_commas' => __( 'Separate categories with commas' ),
	// 		'add_or_remove_items'        => __( 'Add or remove categories' ),
	// 		'choose_from_most_used'      => __( 'Choose from the most used categories' ),
	// 		'not_found'                  => __( 'No categories found.' ),
	// 		'menu_name'                  => __( 'Categories' ),
	// 	),
	// 	'show_ui'               => true,
	// 	'show_admin_column'     => true,
	// 	'update_count_callback' => '_update_post_term_count',
	// 	'query_var'             => false,
	// 	'rewrite'               => false,
	// ) );

	// register_taxonomy( 'range', 'product', array(
	// 	'hierarchical' 			=> true,
	// 	'labels' => array(
	// 		'name'                       => _x( 'Range', 'taxonomy general name' ),
	// 		'singular_name'              => _x( 'Range', 'taxonomy singular name' ),
	// 		'search_items'               => __( 'Search Range' ),
	// 		'popular_items'              => __( 'Popular Range' ),
	// 		'all_items'                  => __( 'All Ranges' ),
	// 		'parent_item'                => null,
	// 		'parent_item_colon'          => null,
	// 		'edit_item'                  => __( 'Edit Range' ),
	// 		'update_item'                => __( 'Update Range' ),
	// 		'add_new_item'               => __( 'Add New Range' ),
	// 		'new_item_name'              => __( 'New Range Name' ),
	// 		'separate_items_with_commas' => __( 'Separate Range with commas' ),
	// 		'add_or_remove_items'        => __( 'Add or remove Range' ),
	// 		'choose_from_most_used'      => __( 'Choose from the most used Range' ),
	// 		'not_found'                  => __( 'No Range found.' ),
	// 		'menu_name'                  => __( 'Ranges' ),
	// 	),
	// 	'show_ui'               => true,
	// 	'show_admin_column'     => true,
	// 	'update_count_callback' => '_update_post_term_count',
	// 	'query_var'             => false,
	// 	'rewrite'               => false,
	// ) );

	$labels = array(
		'name'               => _x( 'Customers', 'post type general name', 'site' ),
		'singular_name'      => _x( 'Customer', 'post type singular name', 'site' ),
		'menu_name'          => _x( 'Customers', 'admin menu', 'site' ),
		'name_admin_bar'     => _x( 'Customer', 'add new on admin bar', 'site' ),
		'add_new'            => _x( 'Add New', 'customer', 'site' ),
		'add_new_item'       => __( 'Add New customer', 'site' ),
		'new_item'           => __( 'New customer', 'site' ),
		'edit_item'          => __( 'Edit customer', 'site' ),
		'view_item'          => __( 'View customer', 'site' ),
		'all_items'          => __( 'All customers', 'site' ),
		'search_items'       => __( 'Search customers', 'site' ),
		'parent_item_colon'  => __( 'Parent customers:', 'site' ),
		'not_found'          => __( 'No customers found.', 'site' ),
		'not_found_in_trash' => __( 'No customers found in Trash.', 'site' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description', 'site' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		// 'taxonomies'    	 => array( 'customer-category', 'range' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
        'menu_position'      => 20,  // 20: below Pages
        'menu_icon'      	 => 'dashicons-money', // https://developer.wordpress.org/resource/dashicons/#megaphone
		'supports'           => array( 'title', 'editor', 'revisions', 'thumbnail' )
	);

	register_post_type( 'customer', $args );
}
add_action( 'init', 'site_custom_customer_init' );
