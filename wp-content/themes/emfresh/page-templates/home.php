<?php
/**
 * Template Name: Home
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); 

// Start the Loop.
while ( have_posts() ) : the_post();

    // site_get_template_part( 'parts/section/top-slider');

    // site_get_template_part( 'parts/section/top-listcontent');

    // site_get_template_part( 'parts/section/top-doctor');

    // site_get_template_part( 'parts/section/top-space');

endwhile;

get_footer();