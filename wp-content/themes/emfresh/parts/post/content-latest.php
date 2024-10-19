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

$thumbnail_url 	= get_the_post_thumbnail_url( get_the_ID(), $size = 'medium' );

// inc/functions/custom.php
// site_post_link
// add_filter( 'post_link', 'site_post_link', 10, 99 );
$external_url 	= get_field('external_url');

?><article class="post post-news post-<?php the_ID();?>">
    <a href="<?php the_permalink();?>" <?php echo ($external_url != ''?'target="_blank"':'');?> >
        <span class="post_thumbnail"  style="background-image: url('<?php echo $thumbnail_url?>');">
            <img class="opacity-0" src="<?php echo site_get_template_directory_assets('images/img-w270-h184.png');?>" alt="" />
        </span>
        <?php the_title('<span class="post_title">','</span>');?>
    </a>
</article>