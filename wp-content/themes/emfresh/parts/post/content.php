<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post_item clearfix'); ?>>
	<?php
	if( has_post_thumbnail() ){
		echo '<div class="post_thumb"><a href="'.get_permalink().'">';
		the_post_thumbnail('thumbnail');
		echo '</a></div>';
	}
	?>
	<div class="post_info">
		<?php
		the_title('<div class="post_title"><a href="'.get_permalink().'">','</a></div>');
		echo '<div class="post_content">';
		echo '</div>';
		?>
		<div class="readmore"><a href="<?php the_permalink();?>"> readmore </a></div>
	</div>

</article><!-- #post-## -->
