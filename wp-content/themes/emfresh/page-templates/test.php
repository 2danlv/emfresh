<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(isset($_GET['abs'])) {
    if(intval($_GET['abs']) > 10000) {
        global $em_log;

        // $items = $em_log->get_items([
        //     'limit' => -1
        // ]);
    
        // var_dump($items);

        // foreach($items as $item) {

        // }

        $data = json_decode('
{"action":"C\u1eadp nh\u1eadt s\u1ea3n ph\u1ea7m","module":"em_order","module_id":1,"content":"S\u1ea3n ph\u1ea9m 1","insert":0}', true);

        // Add Log 
        $insert = $em_log->insert($data);

        $data['insert'] = $insert;

        var_dump($data);

    } else {
        echo time();
    }
    
    exit();
}

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
            get_template_part( 'parts/test/order', 'form' );
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>