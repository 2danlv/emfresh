<?php
/**
* Template Name: About
*
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/

get_header();
// Start the Loop.
while ( have_posts() ) : the_post();
?>

<?php
endwhile;
get_footer();
