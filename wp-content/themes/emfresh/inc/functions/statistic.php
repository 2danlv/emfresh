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
