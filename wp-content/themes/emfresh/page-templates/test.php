<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_template_part( 'parts/test/head' );


?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo strip_tags(get_the_title()); ?> | <?php echo get_bloginfo( 'name' ); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="site container mt-3">
        <?php 
            // get_template_part( 'parts/test/order', 'form' );

            get_template_part( 'parts/test/meal', 'plan' );
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>