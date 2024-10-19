<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();
$tag_ID         = get_queried_object();

// $cat_image = get_field('img_cat',  $tag_ID);
// if($cat_image):
//   $bg = $cat_image;
// else:
  $bg = site_get_placeimage_url(1920,700,'fff','fff');
// endif
 ?>
 <div class="l-banner l-background" style="background-image:url(<?php echo $bg; ?>)">
 <img class="op" src="<?php echo site_get_placeimage_url(1920,700,'fff','fff') ?>" alt=""> 
 <div class="section-title">
    <div class="l-content page-title">
        <h1 class="archive-title"><?php printf( __( 'Tag: %s', '2margin' ), single_tag_title( '', false ) ); ?></h1>
    </div>
 </div>
</div>
<div class="section l-content section-bg-sup  tag-list">
  <div class="container">
    <div class="c-cat">
        <ul>
        <?php 
        $tags = get_tags();
        foreach ( $tags as $tag ) {
            $tag_link = get_tag_link( $tag->term_id );
            $html .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
            $html .= "{$tag->name}</a></li>";
        }
        echo $html;
      ?>
      </ul>
    </div>
            <?php if ( have_posts() ) : ?>
            <div class="list-posts tag-news c-grid c-grid-3-item">
                
            <?php
                $counter = 1; //Starts counter for post column lay out

                // Start the Loop.
                while ( have_posts() ) : the_post();

                $permalink = get_the_permalink();
                $featured_img_url = get_the_post_thumbnail_url($post->ID, 'large'); 

                if( has_post_thumbnail() ){
                    echo '<div class="list-posts-item c-grid-item"><div class="post_thumb"><a href="'.get_permalink().'">';?>
                    <div class="picture" style="background-image:url(<?php echo $featured_img_url ?>)">
                       <img class="op" src="<?php echo site_get_placeimage_url() ?>" alt="">
                   </div>
                 <?php echo '</a></div>';
                 }
                 ?>
                 <div class="post_info">
                    <p><small><i><?php echo get_the_date(); ?></i></small></p>
                    <?php
                    the_title('<h4 class="post_title"><a href="'.get_permalink().'">','</a></h4>');
                    echo '<div class="post_content">';
                    echo '</div></div>';
                    ?>
                </div>  

            <?php   

            $counter++; //Update the counter

            endwhile;

        

        else :
                    // If no content, include the "No posts found" template.
                get_template_part( 'content', 'none' );

                endif;
            ?>
  
        </div>
        <?php site_category_pagination(); ?>
        </div>
</div>
<?php

get_footer();