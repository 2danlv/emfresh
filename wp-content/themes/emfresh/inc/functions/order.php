<?php

function site_order_submit()
{
    global $em_order, $em_order_item, $em_log;

    $order_default = [
        'customer_name_2nd' => '',
        'ship_days' => 0,
        'ship_amount' => 0,
        'total_amount' => 0,
        'discount' => 0,
        'item_name' => '',
        'type_name' => '',
        'location_id' => 0,
        'order_type' => '',
        'payment_status' => 0,
        'payment_method' => '',
        'payment_amount' => 0,
        'remaining_amount' => 0,
        'paid' => 0,
        'note' => '',
    ];

    if (!empty($_POST['save_order'])) {
        $_POST = wp_unslash($_POST);
        
        $errors = [];
    
        $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
        if($customer_id == 0) {
            $errors[] = 'No customer';
        }
    
        $update = true;

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

        $order_data = shortcode_atts($order_default, $_POST);
        
        // if(isset($_POST['order_note'])) {
        //     $order_data['note'] = sanitize_text_field($_POST['order_note']);
        // }

        $order_data['total'] = intval($order_data['ship_amount'] + $order_data['total_amount']);

        if($order_data['payment_status'] == 3 && $order_data['paid'] > 0) {
            // 1 phan
            $order_data['remaining_amount'] = $order_data['total'] - $order_data['paid'];
        } else if($order_data['payment_status'] != 1) {
            // chua va 1 phan
            $order_data['remaining_amount'] = $order_data['total'];
        }

        $params = [];
        if(!empty($_POST['ship'])) {
            $list_ships = [];

            foreach($_POST['ship'] as $i => $ship) {
                if(!empty($ship['location_id']) || !empty($ship['location_name'])) {
                    $list_ships[] = $ship;
                }
            }

            $params['ship'] = $list_ships;
        }
        $order_data['params'] = count($params) > 0 ? serialize($params) : '';

        if($order_id == 0 && count($errors) == 0) {
            $update = false;

            $order_data = array_merge($order_data, [
                'customer_id' => $customer_id,
                'status' => 1,
            ]);
            
            $response = em_api_request('order/add', $order_data);
            if($response['code'] == 200) {
                $order_id = $response['data']['insert_id'];

                site_order_log($order_default, $order_data);
            } else {
                $errors = $response['errors'];
            }
        }
    
        if($order_id > 0 && count($errors) == 0 && !empty($_POST['order_item']) && count($_POST['order_item']) > 0){

            $item_labels = array(
                'type' => 'Phân loại',
                'days' => 'Số ngày ăn',
                'date_start' => 'Ngày bắt đầu',
                'product_id' => 'Tên sản phẩm',
                'quantity' => 'Số lượng',
                'auto_choose' => 'tự chọn món',
                'note' => 'Yêu cầu đặc biệt',
            );

            $date_start = '';
            $date_stop = '';
            
            foreach($_POST['order_item'] as $i => $order_item) {
                $order_item['order_id'] = $order_id;

                $item_title = 'Sản phẩm ' . ($i + 1);

                if($date_start == '' || $date_start > $order_item['date_start']) {
                    $date_start = $order_item['date_start'];
                }

                if($date_stop == '' || $date_stop < $order_item['date_stop']) {
                    $date_stop = $order_item['date_stop'];
                }
                
                $note = !empty($order_item['note']) ? $order_item['note'] : '';

                if(!empty($order_item['id'])) {
                    if(!empty($order_item['remove'])) {
                        $note = '';
                        $date_start = '';
                        $date_stop = '';

                        $response = em_api_request('order_item/delete', ['id' => $order_item['id']]);

                        if($response['code'] == 200) {
                            // Log update
                            $em_log->insert([
                                'action'        => 'Xóa - Sản phẩm',
                                'module'        => 'em_order',
                                'module_id'     => $order_id,
                                'content'       => $item_title
                            ]);
                        }
                    } else {
                        $before = $em_order_item->get_item($order_item['id']);

                        $response = em_api_request('order_item/update', $order_item);

                        if($response['code'] == 200) {
                            $log_content = [];

                            foreach($item_labels as $key => $label) {
                                if(isset($before[$key]) && isset($order_item[$key]) && $order_item[$key] != $before[$key]) {
                                    $value = $order_item[$key];

                                    if($key == 'product_id') {
                                        $value = $em_order_item->get_product($value, 'name');
                                    } else if($key == 'type'){
                                        $value = strtoupper($value);
                                    } else if($key == 'auto_choose'){
                                        $label = ($value == 1 ? 'Bật' : 'Tắt') . ' ' . $label;
                                        $value = '';
                                    }

                                    $log_content[] = $label . ' ' . $value;
                                }
                            }

                            if(count($log_content) > 0) {
                                // Log update
                                $em_log->insert([
                                    'action'        => 'Cập nhật - Sản phẩm',
                                    'module'        => 'em_order',
                                    'module_id'     => $order_id,
                                    'content'       => $item_title . ' : ' . implode(' ', $log_content)
                                ]);
                            }
                        }
                    }
                } else {
                    unset($order_item['id']);
    
                    $response = em_api_request('order_item/add', $order_item);
                }

                if($note != '' && $order_data['note'] == '') {
                    $notes = explode("\n", $note);
                    
                    $order_data['note'] = $notes[0];
                }
            }

            $order_data['id'] = $order_id;

            if($date_start != '') {
                $order_data['date_start'] = $date_start;
            }

            if($date_stop != '') {
                $order_data['date_stop'] = $date_stop;
            }

            $before = $em_order->get_item($order_id); 

            $response = em_api_request('order/update', $order_data);

            if($response['code'] == 200 && $update) {
                site_order_log($before, $order_data);

                if($before['params'] != $order_data['params']) {
                    $before_ships   = $em_order->get_ships($before);
                    $after_ships    = $em_order->get_ships($order_data);
            
                    foreach($after_ships as $i => $ship) {
                        $log_content = [];
                        
                        if(empty($before_ships[$i])) {
                            $action = 'Thêm - Giao hàng';
                            $log_content[] = 'Địa chỉ ' . $ship['location_name'];
                        } else {
                            $before_ship = $before_ships[$i];
                            if($before_ship['location_name'] != $ship['location_name']) {
                                $action = 'Cập nhật - Giao hàng';
                                $log_content[] = 'Địa chỉ ' . $ship['location_name'];
                            }
                        }

                        $em_log->insert([
                            'action'        => $action,
                            'module'        => 'em_order',
                            'module_id'     => $order_id,
                            'content'       => implode(' ', $log_content)
                        ]);
                    }
                }
            }
        }
    
        $query_args = [
            'order_id' => $order_id,
            'expires' => time() + 3,
        ];
        
        if(count($errors)>0) {
            $query_args['message'] = 'Errors';
        } else {
            $query_args['message'] = 'Success';
        }
    
        wp_redirect(add_query_arg($query_args, site_order_edit_link()));
        exit();
    }

    // Duplicate order
    $duplicate_order = !empty($_GET['duplicate_order']) ? (int) $_GET['duplicate_order'] : 0;
    $dupnonce = !empty($_GET['dupnonce']) ? trim($_GET['dupnonce']) : '';
    if ($duplicate_order > 0 && wp_verify_nonce($dupnonce, "dupnonce")) {        
        $order_id = 0;
        $errors = [];

        $order_data = $em_order->get_item($duplicate_order);
        if(!empty($order_data['id'])) {
            unset($order_data['id']);
            
            $order_data['ship_days'] = 0;
            $order_data['ship_amount'] = 0;
            $order_data['payment_status'] = 2;
            $order_data['paid'] = 0;
            $order_data['remaining_amount'] = 0;
            $order_data['discount'] = 0;
            $order_data['total'] = $order_data['total_amount'];
            $order_data['params'] = '';

            $response = em_api_request('order/add', $order_data);
            if($response['code'] == 200) {
                $order_id = $response['data']['insert_id'];

                $order_items = $em_order_item->get_items(['order_id' => $duplicate_order]);

                $today = current_time('Y-m-d');

                foreach($order_items as $order_item) {
                    unset($order_item['id']);

                    $date_stop = $order_item['date_stop'];
                    if($date_stop < $today) {
                        $date_stop = $today;
                    }

                    $order_item['date_start'] = site_order_get_date_next($date_stop);
                    $order_item['date_stop'] = site_order_get_date_value($order_item['date_start'], $order_item['days']);
                    $order_item['order_id'] = $order_id;

                    $response = em_api_request('order_item/add', $order_item);
                }
            } else {
                $errors = $response['errors'];
            }
        }

        $query_args = [
            'order_id' => $order_id,
            'expires' => time() + 3,
        ];
        
        if(count($errors)>0) {
            $query_args['message'] = 'Errors';
        } else {
            $query_args['message'] = 'Success';
        }
    
        wp_redirect(add_query_arg($query_args, site_order_edit_link()));
        exit();
    }

    // Delete order
    $delete_order = !empty($_GET['delete_order']) ? (int) $_GET['delete_order'] : 0;
    $delnonce = !empty($_GET['delnonce']) ? trim($_GET['delnonce']) : '';
    if ($delete_order > 0 && wp_verify_nonce($delnonce, "delnonce")) {
        $deleted = $em_order->delete($delete_order);
        
        $query_args = [
            'order_id' => $delete_order,
            'expires' => time() + 3,
        ];
        
        if($deleted) {
            $query_args['message'] = 'Delete-order-success';
        } else {
            $query_args['message'] = 'Delete-order-errors';
        }
    
        wp_redirect(add_query_arg($query_args, site_order_list_link()));
        exit();
    }
}
add_action('wp', 'site_order_submit');

function site_order_log($before = [], $after = [])
{
    if(empty($after['id'])) return;

    global $em_order, $em_log;

    $log_content = [];
    $action = '';
    $module = 'em_order';

    // $data = [date('Ymd-His'), $before , $after];
    // file_put_contents(ABSPATH . '/html/log-2.json', json_encode($data, JSON_UNESCAPED_UNICODE));

    if(empty($before['id'])) {
        $action = 'Tạo đơn hàng';
        $module = 'em_order_payment';

        if($after['payment_status'] == 2) {
            // chua
            $log_content[] = '+'. number_format($after['total']);
            $log_content[] = '+'. number_format($after['total']);
        } else if($after['payment_status'] == 3) {
            // 1 phan
            $log_content[] = $after['paid'] > 0 ? '-'. number_format($after['paid']) : 0;
            $log_content[] = $after['remaining_amount'] > 0 ? '+'. number_format($after['remaining_amount']) : 0;
        }
    } else if($before['remaining_amount'] != $after['remaining_amount']) {
        $action = $em_order->get_payment_methods($after['payment_method']);
        $module = 'em_order_payment';

        if($after['payment_status'] == 1) {
            // roi
            $log_content[] = '+'. number_format($after['total']);
            $log_content[] = 0;
        } else if($after['payment_status'] == 3) {
            // 1 phan
            $log_content[] = $after['paid'] > 0 ? '-'. number_format($after['paid']) : 0;
            $log_content[] = $after['remaining_amount'] > 0 ? '+'. number_format($after['remaining_amount']) : 0;
        }
    } else if($before['total'] != $after['total']) {
        $action = 'Bổ sung đơn hàng';
        $module = 'em_order_payment';

        $log_content[] = $after['remaining_amount'] > 0 ? '+'. number_format($after['remaining_amount']) : 0;
        $log_content[] = '+'. number_format($after['total'] - $before['total']);
    } else if($before['ship_days'] != $after['ship_days']) {
        $action = 'Cập nhật';
        $module = 'em_order_payment';

        $log_content[] = 'Số ngày phát sinh phí ship ' . $after['ship_days'];
        $log_content[] = 'Tổng tiền phí ship ' . number_format($after['ship_amount']);
    } else if($before['discount'] != $after['discount']) {
        $action = 'Cập nhật';
        $module = 'em_order_payment';

        $log_content[] = 'Giảm giá ' . $after['discount'];
    }
    
    if($action != '' && count($log_content) > 0) {
        if($module == 'em_order_payment') {
            $content = implode('|', $log_content);
        } else {
            $content = implode(', ', $log_content);
        }

        // Add Log 
        $em_log->insert([
            'action'        => $action,
            'module'        => $module,
            'module_id'     => $after['id'],
            'content'       => $content
        ]);
    }
}

function site_order_get_date_value($date_start = '', $days = 0)
{
    $i = 1;

    while($i < $days) {
        $time_next = strtotime($date_start) + DAY_IN_SECONDS;

        $date_start = date('Y-m-d', $time_next);

        if(in_array(date('D', $time_next), ['Sat', 'Sun'])) {
            continue;
        }

        $i++;
    }

    return $date_start;
}

function site_order_get_date_next($date_start = '')
{
    while(1) {
        $time_next = strtotime($date_start) + DAY_IN_SECONDS;

        $date_start = date('Y-m-d', $time_next);

        if(in_array(date('D', $time_next), ['Sat', 'Sun'])) {
            continue;
        }

        return $date_start;
    }

    return '';
}

function site_order_list_link()
{
    return get_permalink(134);
}

function site_order_add_link()
{
    return get_permalink(140);
}

function site_order_edit_link()
{
    return get_permalink(143);
}