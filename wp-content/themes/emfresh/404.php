<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

function page_404_wp_head()
{
	echo '<meta http-equiv="refresh" content="0; url='. home_url(). '">';
}
add_action('wp_head', 'page_404_wp_head');

get_header(); ?>

<article class="page-single post-detail">
    <div class="container text-center" style="padding-top: 50px; padding-bottom: 50px;">
		<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyseventeen' ); ?></h1>
		<div class="page-content">
			<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyseventeen' ); ?></p>
		</div>
	</div>
</article>

<?php get_footer();
