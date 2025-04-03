<?php

function site_statistic_get_customer($column = '', $where = [])
{
    global $em_customer;

    $list = [];
    $labels = [];

    if($column == 'gender') {
        $items = $em_customer->get_statistic($column, $where);
        $labels = $em_customer->get_genders();
    } else if($column == 'tag') {
        $items = $em_customer->get_statistic($column, $where);
        $labels = $em_customer->get_tags();
        
        // if($items) {
        //     foreach($items as $item) {
        //         $item['name'] = custom_ucwords_utf8($em_customer->get_tags($item['tag']));

        //         $list[] = $item;
        //     }
        // }
    } else if($column == 'status') {
        $items = $em_customer->get_statistic($column, $where);
        $labels = $em_customer->get_statuses();

        // if($items) {
        //     foreach($items as $item) {
        //         $item['name'] = custom_ucwords_utf8($em_customer->get_statuses($item['status']));

        //         $list[] = $item; 
        //     }
        // }
    }

    foreach($labels as $key => $label) {
        $total = 0;

        if($items) {
            foreach($items as $item) {
                if($item[$column] == $key) {
                    $total = (int) $item['total'];
                    break;
                }
            }
        }

        $list[] = [
            'name' => custom_ucwords_utf8($label),
            'total' => $total,
        ];
    }

    return $list;
}

function site_statistic_get_group($group_id = 0)
{
    global $em_customer_group, $em_order;

    $today = current_time('Y-m-d');

    $statistics = [];

    $customers = $em_customer_group->get_items(['group_id' => $group_id]);

    $statistics['member_total'] = count($customers);

    $order_total = 0;
    $order_status = "0";

    foreach($customers as $customer) {
        $order_total += $em_order->count(['customer_id' => $customer['id']]);

        $args = [
            'customer_id' => $customer['id'],
            'check_date_start' => $today,
            'check_date_stop' => $today
        ];

        if($order_status == 0 && $em_order->count($args) > 0) {
            $order_status = 1;
        }
    }

    $statistics['order_total'] = $order_total;
    $statistics['order_status'] = $order_status;
    $statistics['order_status_name'] = $em_order->get_statuses($order_status);

    return $statistics;
}