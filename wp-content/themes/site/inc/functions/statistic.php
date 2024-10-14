<?php

function site_statistic_get_customer($column = '', $where = [])
{
    global $em_customer;

    $list = [];

    if($column == 'gender') {
        $items = $em_customer->get_statistic($column, $where);
        
        if($items) {
            foreach($items as $item) {
                $item['name'] = $em_customer->get_genders($item['gender']);

                $list[] = $item; 
            }
        }
    } else if($column == 'tag') {
        $items = $em_customer->get_statistic($column, $where);
        
        if($items) {
            foreach($items as $item) {
                $item['name'] = $em_customer->get_tags($item['tag']);

                $list[] = $item;
            }
        }
    } else if($column == 'status') {
        $items = $em_customer->get_statistic($column, $where);
        
        if($items) {
            foreach($items as $item) {
                $item['name'] = $em_customer->get_statuses($item['status']);

                $list[] = $item; 
            }
        }
    }

    return $list;
}
