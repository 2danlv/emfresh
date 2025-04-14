<?php


if(isset($_GET['abs'])) {
    $act = trim($_GET['abs']);

    if($act == 'add-menu' && !empty($_GET['menu-name'])) {
        $response = em_api_request('menu/add', [
            'name' => $_GET['menu-name'],
            "type" => "1",
        ]);

        die(json_encode($response));
        exit();
    } else if($act == 'update-menu') {
        $response = em_api_request('menu/update', [
            'name' => '4 - Cơm sườn bì chả trứng',
            "id" => "4",
        ]);

        die(json_encode($response));
        exit();
    }

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