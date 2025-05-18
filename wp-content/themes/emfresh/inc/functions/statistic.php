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
    } else if($column == 'status') {
        $items = $em_customer->get_statistic($column, $where);
        $labels = $em_customer->get_statuses();
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
    
    $order_total = 0;
    $order_status = "0";

    $list = $em_customer_group->get_items([
        'group_id' => $group_id,
        'orderby' => 'id ASC',
        'limit' => -1,
    ]);

    $statistics['member_total'] = count($list);

    if($statistics['member_total'] > 0) {
        foreach($list as $i => $item) {
            $order_total += $em_order->count([
                'customer_id' => $item['customer_id'],
                'order_type' => 'group',
            ]);
            
            $args = [
                'customer_id' => $item['customer_id'],
                'order_type' => 'group',
                'check_date_start' => $today,
                'check_date_stop' => $today
            ];

            $item['order_status'] = $em_order->count($args) > 0 ? "1" : "0";
            $item['order_status_name'] = $em_order->get_statuses($item['order_status']);

            if($item['order_status'] > 0) {
                $order_status = 1;
            }

            $list[$i] = $item;
        }
    }

    $statistics['customers'] = $list;
    $statistics['order_total'] = $order_total;
    $statistics['order_status'] = $order_status;
    $statistics['order_status_name'] = $em_order->get_statuses($order_status);

    return $statistics;
}

function site_statistic_menu($days = [])
{
    global $em_order_item;

    $static_date_start = $days[0];
    $static_date_stop = end($days);

    $order_items = $em_order_item->get_items(['min_date' => $static_date_start]);

    // San pham chinh
    $product_codes = site_get_product_codes();

    $statistics = [
        'dat_don' => [],
        'di_mon' => [],
        'chua_ro' => [],
        'tong' => [],
        'tong_dat_don'  => ['chinh' => 0, 'phu' => 0],
        'tong_di_mon'   => [],
        'tong_di_mon_chinh' => [],
        'tong_di_mon_dam'   => [],
        'tong_di_mon_nuoc'  => [],
        'tong_chua_ro'  => [],
    ];

    $static_days = [];

    foreach($order_items as $order_item) {
        $order_item['meal_plan_items'] = $em_order_item->get_meal_plan($order_item);
        $order_item['meal_select_items'] = $em_order_item->get_meal_select($order_item);

        if(count($order_item['meal_select_items']) > 0) {
            $parts = explode('-', $order_item['product_name']);
            $code = trim($parts[0]);

            $type = in_array($code, $product_codes) ? 'chinh' : 'phu';

            $dam_rate = site_get_dam_rate($code);

            foreach($order_item['meal_select_items'] as $day => $meal_select) {
                if($day > $static_date_stop) continue;

                if(empty($static_days[$day])) {
                    $day_data = [
                        'dam' => 0,
                        'total' => 0,
                        'menu_items' => [],
                    ];

                    $menu_items = [];
                } else {
                    $day_data = $static_days[$day];
                    
                    $menu_items = $day_data['menu_items'];
                }

                foreach($meal_select as $menu_id) {
                    if(empty($menu_items[$menu_id])) {
                        $menu_item = [
                            'products' => [],
                            'total' => 0,
                            'dam' => 0,
                        ];
                    } else {
                        $menu_item = $menu_items[$menu_id];
                    }

                    $products = $menu_item['products'];

                    if(empty($products[$code])) {
                        $products[$code] = 0;
                    }
                    
                    $products[$code]++;

                    if(in_array($code, $product_codes)) {
                        $menu_item['total']++;
                    }

                    $menu_item['dam'] += $dam_rate;

                    $menu_item['products'] = $products;

                    $menu_items[$menu_id] = $menu_item;

                    $day_data['total']++;
                }

                $day_data['menu_items'] = $menu_items;

                $static_days[$day] = $day_data;
            }

            foreach($days as $day) {
                if($day < $order_item['date_start']) {
                    $status = 'di_mon';
                    $count = array_sum($order_item['meal_plan_items']);
                } else if($day > $order_item['date_stop']) {
                    $status = 'chua_ro';
                    $count = array_sum($order_item['meal_plan_items']);
                } else {
                    $status = 'dat_don';    
                    $count = isset($order_item['meal_plan_items'][$day]) ? $order_item['meal_plan_items'][$day] : 0;
                }

                $item = $statistics[$status];

                if(empty($item[$code])) {
                    $item[$code] = [];
                }

                if(empty($item[$code][$day])) {
                    $item[$code][$day] = 0;
                }

                $item[$code][$day] += $count;

                $statistics[$status] = $item;

                if(empty($statistics['tong'][$day])) {
                    $statistics['tong'][$day] = 0;
                }

                $statistics['tong'][$day] += $count;

                $tong_name = 'tong_' . $status;

                if(empty($statistics[$tong_name][$day])) {
                    $statistics[$tong_name][$day] = 0;

                    if($status == 'di_mon') {
                        $statistics[$tong_name . '_chinh'][$day] = 0;
                        $statistics[$tong_name . '_dam'][$day] = 0;
                        $statistics[$tong_name . '_nuoc'][$day] = 0;
                    }
                }

                $statistics[$tong_name][$day] += $count;

                if($status == 'di_mon') {
                    if($type == 'chinh') {
                        $statistics[$tong_name . '_chinh'][$day] += $count;
                        $statistics[$tong_name . '_dam'][$day] += $dam_rate * $count;
                    }
                    if(in_array($code, site_get_water_codes())) {
                        $statistics[$tong_name . '_nuoc'][$day] += $count;
                    }
                }
                
                if(isset($statistics[$tong_name][$type])) {
                    $statistics[$tong_name][$type] += $count;
                }
            }
        }
    }

    $statistics['static_days'] = $static_days;

    // site_response_json($statistics);

    return $statistics;
}