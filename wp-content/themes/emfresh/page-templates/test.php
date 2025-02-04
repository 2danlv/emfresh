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
        global $em_order, $em_order_item;

        $orders = $em_order->get_items([
            'limit' => -1
        ]);

        foreach($orders as $order) {
            $items = $em_order_item->get_items([
                'order_id' => $order['id'],
                'limit' => -1,
            ]);

            echo $order['customer_name'] . ': ';

            $date_start = '';
            $date_stop = '';

            foreach($items as $item) {
                $days = intval($item['days']) - 1;
                
                $item['date_stop'] = $item['date_start'];

                if($days > 0) {
                    $item['date_stop'] = date('Y-m-d', strtotime($item['date_start']) + $days * DAY_IN_SECONDS);
                }

                if($date_start == '' || $date_start > $item['date_start']) {
                    $date_start = $item['date_start'];
                }

                if($date_stop == '' || $date_stop < $item['date_stop']) {
                    $date_stop = $item['date_stop'];
                }

                $em_order_item->update([
                    'date_stop' => $item['date_stop'],
                ], ['id' => $item['id']]);
            }

            echo "date_start : $date_start ; ";
            echo "date_stop : $date_stop <br>";

            // $em_order->update([
            //     'date_stop' => $date_stop,
            // ], ['id' => $order['id']]);

            // break;
        }

        // echo json_encode($items, JSON_UNESCAPED_UNICODE);

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