<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header();

$cat_ID 		= (int)get_query_var('cat');
$columns 		= 3;
$tp_name 		= 'news';//get_term_meta($cat_ID, 'template_part_name', $single = true);

?>
<section class="section section-bg-sup section-page section-category category-layout-default max-w1600">
	<div class="main-width">
		<div class="section-title page-title">
			<div class="section-title-top"><?php //site_text('Our latest news'); ?>&nbsp;</div>
            <h1 class="heading-01"><?php single_cat_title(); ?></h1>
            <div class="section-title-sup"><?php single_cat_title(); ?></div>
        </div>
		<?php
		if ( have_posts() ) : 
			// If has more than one columns 
			echo '<div class="list-posts">';
				global $posts;
				$count 	= count($posts);
				$i 		= 0;
				$row 	= 1;
				
				echo '<div class="list-posts-row list-posts-row-1 clearfix">';
				
				// Start the Loop.
				while ( have_posts() ) : the_post();
					$j = $i+1;
					
					echo '<div class=list-posts-item list-posts-item-'.($i%$columns+1).'">';
						get_template_part( 'parts/post/content', $tp_name );
					echo '</div>';
					
					if( $j%$columns==0 && $j<$count )
						echo '</div><div class="list-posts-row list-posts-row-'.(++$row).' clearfix">';
					
					$i++;
				endwhile;
				
				echo '</div>';
			
			echo '</div>';
			
			// custom.php
			site_category_pagination();
			
		else :
			// If no content, include the "No posts found" template.
			// get_template_part( 'content', 'none' );

		endif;
		?>
	</div>
</section>
<?php

get_footer(); 