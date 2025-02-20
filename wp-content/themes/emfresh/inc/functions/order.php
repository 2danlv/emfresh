<?php

function site_order_submit()
{
    global $em_order, $em_order_item, $em_log;

    if (!empty($_POST['save_order'])) {

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

        $_POST = wp_unslash($_POST);

        $errors = [];

        $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
        if ($customer_id == 0) {
            $errors[] = 'No customer';
        }

        $update = true;

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

        if($order_id > 0) {
            file_put_contents(ABSPATH . "/wp-content/uploads/order-{$order_id}.json", json_encode($_POST, JSON_UNESCAPED_UNICODE));
        }

        $order_data = shortcode_atts($order_default, $_POST);

        // if(isset($_POST['order_note'])) {
        //     $order_data['note'] = sanitize_text_field($_POST['order_note']);
        // }

        $order_data['total'] = intval($order_data['ship_amount'] + $order_data['total_amount']);

        $params = [];
        if (!empty($_POST['ship'])) {
            $list_ships = [];

            foreach ($_POST['ship'] as $i => $ship) {
                if (!empty($ship['location_id']) || !empty($ship['location_name'])) {
                    $list_ships[] = $ship;
                }
            }

            $params['ship'] = $list_ships;
        }
        $order_data['params'] = count($params) > 0 ? serialize($params) : '';

        if ($order_id == 0 && count($errors) == 0) {
            $update = false;

            $order_data = array_merge($order_data, [
                'customer_id' => $customer_id,
                'status' => 1,
            ]);

            $response = em_api_request('order/add', $order_data);
            if ($response['code'] == 200) {
                $order_id = $response['data']['insert_id'];

                site_order_payment_log($order_default, $order_data);
            } else {
                $errors = $response['errors'];
            }
        }

        if ($order_id > 0 && count($errors) == 0 && !empty($_POST['order_item']) && count($_POST['order_item']) > 0) {

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
            $total_quantity = 0;

            foreach ($_POST['order_item'] as $i => $order_item) {
                $order_item['order_id'] = $order_id;

                $order_item['auto_choose'] = isset($order_item['auto_choose']) ? $order_item['auto_choose'] : 0;

                $item_title = 'Sản phẩm ' . ($i + 1);

                if ($date_start == '' || $date_start > $order_item['date_start']) {
                    $date_start = $order_item['date_start'];
                }

                if ($date_stop == '' || $date_stop < $order_item['date_stop']) {
                    $date_stop = $order_item['date_stop'];
                }

                $note = !empty($order_item['note']) ? $order_item['note'] : '';

                if (!empty($order_item['id'])) {
                    if (isset($order_item['remove']) && $order_item['remove'] == 1) {
                        $note = '';
                        $date_start = '';
                        $date_stop = '';

                        $response = em_api_request('order_item/delete', ['id' => $order_item['id']]);

                        if ($response['code'] == 200) {
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

                        if ($response['code'] == 200) {
                            $log_content = [];

                            foreach ($item_labels as $key => $label) {
                                $before_value = isset($before[$key]) ? $before[$key] : '';
                                $value = isset($order_item[$key]) ? $order_item[$key] : '';
                                
                                if ($value != '' && $value != $before_value) {

                                    if ($key == 'product_id') {
                                        $value = $em_order_item->get_product($value, 'name');
                                        if($value == '') {
                                            $label = '';
                                        }
                                    } else if ($key == 'type') {
                                        $value = strtoupper($value);
                                    } else if ($key == 'date_start') {
                                        if($value == '') {
                                            $label = '';
                                        } else {
                                            $value = date('d/m/Y', strtotime($value));
                                        }
                                    } else if ($key == 'auto_choose') {
                                        $label = ($value == 1 ? 'Bật' : 'Tắt') . ' ' . $label;
                                        $value = '';
                                    }

                                    if($label != '') {
                                        $log_content[] = $label . ' ' . $value;
                                    }
                                }
                            }

                            if (count($log_content) > 0) {
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

                    if ($response['code'] == 200) {
                        // Log update
                        $em_log->insert([
                            'action'        => 'Thêm - Sản phẩm',
                            'module'        => 'em_order',
                            'module_id'     => $order_id,
                            'content'       => $item_title
                        ]);
                    }
                }

                if ($note != '' && $order_data['note'] == '') {
                    $notes = explode("\n", $note);

                    $order_data['note'] = $notes[0];
                }

                if ($date_start != '') {
                    $total_quantity += $order_item['quantity'];
                }
            }

            $order_data['id'] = $order_id;

            if ($date_start != '') {
                $order_data['date_start'] = $date_start;
            }

            if ($date_stop != '') {
                $order_data['date_stop'] = $date_stop;
            }

            $order_data['total_quantity'] = $total_quantity;

            $before = $em_order->get_item($order_id);

            // doi tinh trang thanh toan thanh 1 phan
            if ($update && $order_data['total'] > $before['total']) {
                $order_data['payment_status'] = 3;
            }
            
            if ($order_data['payment_status'] == 3) {
                // 1 phan
                $order_data['remaining_amount'] = $order_data['total'] - $order_data['paid'] - $order_data['discount'];
            } else if ($order_data['payment_status'] == 1) {
                // roi
                $order_data['remaining_amount'] = 0;
                $order_data['paid'] = $order_data['total'] - $order_data['discount'];
            }

            $response = em_api_request('order/update', $order_data);

            if ($response['code'] == 200 && $update) {
                site_order_payment_log($before, $order_data);

                site_order_log($before, $order_data);
            }
        }

        $query_args = [
            'order_id' => $order_id,
            'expires' => time() + 3,
        ];

        if (count($errors) > 0) {
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
        if (!empty($order_data['id'])) {
            unset($order_data['id']);

            $order_data['status'] = 1;
            $order_data['ship_days'] = 0;
            $order_data['ship_amount'] = 0;
            $order_data['payment_status'] = 2;
            $order_data['paid'] = 0;
            $order_data['remaining_amount'] = 0;
            $order_data['discount'] = 0;
            $order_data['total'] = 0;
            $order_data['total_amount'] = 0;
            $order_data['params'] = '';

            $response = em_api_request('order/add', $order_data);
            if ($response['code'] == 200) {
                $order_id = $response['data']['insert_id'];

                $order_items = $em_order_item->get_items(['order_id' => $duplicate_order]);

                // $today = current_time('Y-m-d');

                foreach ($order_items as $order_item) {
                    unset($order_item['id']);

                    $order_item['date_start'] = '';
                    $order_item['date_stop'] = '';
                    $order_data['meal_plan'] = '';
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
            'tab' => 'settings-product',
        ];

        if (count($errors) > 0) {
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

        if ($deleted) {
            $query_args['message'] = 'Delete-order-success';
        } else {
            $query_args['message'] = 'Delete-order-errors';
        }

        wp_redirect(add_query_arg($query_args, site_order_list_link()));
        exit();
    }
    
    if (!empty($_POST['save_meal_plan'])) {
        $_POST = wp_unslash($_POST);

        $errors = [];

        $list = isset($_POST['list_meal']) ? $_POST['list_meal'] : [];

        if(is_array($list) && count($list) > 0) {
            foreach($list as $item) {
                $order_id = !empty($item['order_id']) ? (int) $item['order_id'] : 0;
                $order_item_id = !empty($item['order_item_id']) ? (int) $item['order_item_id'] : 0;
                $meal_plan = !empty($item['meal_plan']) ? $item['meal_plan'] : [];
                
                if($order_id == 0 || $order_item_id == 0 || count($meal_plan) == 0) continue;
                                
                $order_item = $em_order_item->get_item($order_item_id);
                $my_meal_plan = json_decode($order_item['meal_plan'], true);

                if(
                    count($meal_plan) != count($my_meal_plan) ||
                    array_sum($meal_plan) != array_sum($my_meal_plan) 
                ) {
                    $errors[] = "Order $order_id - Item $order_item_id - Error.";

                    continue;
                }

                $em_order_item->update([
                    'meal_plan' => json_encode($meal_plan)
                ], ['id' => $order_item_id]);
            }
        }

        $query_args = [
            'code' => count($errors) > 0 ? 500 : 200,
            'expires' => time() + 3,
            'message' => count($errors) > 0 ? implode(' ', $errors) : 'Update+success'
        ];

        if(!empty($_POST['ajax'])) {
            echo json_encode($query_args);
            die();
        }

        wp_redirect(add_query_arg($query_args, site_order_list_link()));
        exit();
    }
}
add_action('wp', 'site_order_submit');

function site_order_log($before = [], $after = [])
{
    if (empty($after['id'])) return;

    global $em_order, $em_log;

    $payment_labels = [
        'ship_days' => 'Số ngày phát sinh phí ship',
        'discount'  => 'Giảm giá',
        'payment_status' => 'Phương thức thanh toán',
        'payment_method' => 'Trạng thái thanh toán',
        'paid' => 'Đã thanh toán',
    ];

    $log_content = [];

    foreach ($payment_labels as $key => $label) {
        $before_value = isset($before[$key]) ? $before[$key] : '';
        $value = isset($after[$key]) ? $after[$key] : '';
        
        if ($value != $before_value && $value > 0) {
            if ($key == 'payment_method') {
                $value = $em_order->get_payment_methods($value);
                if(is_string($value)) {
                    $log_content[] = $label . ' ' . $value;
                }
            } else if ($key == 'payment_status') {
                $value = $em_order->get_payment_statuses($value);
                if(is_string($value)) {
                    $log_content[] = $label . ' ' . $value;
                }
            } else if ($key == 'discount' || $key == 'paid') {
                $value = number_format($value);

                $log_content[] = $label . ' ' . $value;
            } else {
                $log_content[] = $label . ' ' . $value;
            }
        }
    }

    if (count($log_content) > 0) {
        $em_log->insert([
            'action'        => 'Cập nhật - Thanh toán',
            'module'        => 'em_order',
            'module_id'     => $after['id'],
            'content'       => implode(' ', $log_content)
        ]);
    }

    if ($before['params'] != $after['params']) {
        $before_ships   = $em_order->get_ships($before);
        $after_ships    = $em_order->get_ships($after);

        $ship_labels = [
            'calendar' => 'Đặt lịch',
            'location_name' => 'Địa chỉ giao',
            'note_shipper' => 'Note shipper theo ngày',
            'note_admin' => 'Note admin theo ngày',
        ];

        foreach ($after_ships as $i => $ship) {
            $log_content = [];

            if (empty($before_ships[$i])) {
                $action = 'Thêm';                            
                $before_ship = [];
            } else {
                $action = 'Cập nhật';
                $before_ship = $before_ships[$i];
            }

            foreach ($ship_labels as $key => $label) {
                $before_value = isset($before_ship[$key]) ? $before_ship[$key] : '';
                $value = isset($ship[$key]) ? $ship[$key] : '';

                if ($value != '' && $value != $before_value) {
                    $log_content[] = $label . ' ' . $value;
                }
            }

            $before_value = implode(', ', isset($before_ship['days']) ? (array) $before_ship['days'] : []);
            $value = implode(', ', isset($ship['days']) ? (array) $ship['days'] : []);

            if ($value != '' && $value != $before_value) {
                $log_content[] = 'Đặt lịch ' . $value;
            }

            if (count($log_content) > 0) {
                $em_log->insert([
                    'action'        => $action . ' - Giao hàng',
                    'module'        => 'em_order',
                    'module_id'     => $after['id'],
                    'content'       => implode(' ', $log_content)
                ]);
            }
        }
    }
}

function site_order_payment_log($before = [], $after = [])
{
    if (empty($after['id'])) return;

    global $em_order, $em_log;

    $log_content = [];
    $action = '';
    $module = 'em_order_payment';

    // $data = [date('Ymd-His'), $before , $after];
    // file_put_contents(ABSPATH . '/html/log-2.json', json_encode($data, JSON_UNESCAPED_UNICODE));

    if (empty($before['id'])) {
        $action = 'Tạo đơn hàng';

        if ($after['payment_status'] == 1) {
            // roi
            $log_content[] = '-' . number_format($after['total']);
            $log_content[] = 0;
        } else if ($after['payment_status'] == 2) {
            // chua
            $log_content[] = '+' . number_format($after['total']);
            $log_content[] = '+' . number_format($after['total']);
        } else if ($after['payment_status'] == 3) {
            // 1 phan
            $log_content[] = $after['paid'] > 0 ? '-' . number_format($after['paid']) : 0;
            $log_content[] = $after['remaining_amount'] > 0 ? '+' . number_format($after['remaining_amount']) : 0;
        }
    } else if ($before['total'] != $after['total']) {
        $action = 'Bổ sung đơn hàng';

        $total = $after['total'] - $before['total'];
        if($total > 0) {
            $log_content[] = '+' . number_format($total);
            $log_content[] = $after['remaining_amount'] > 0 ? '+' . number_format($after['remaining_amount']) : 0;    
        }
    } else if ($before['remaining_amount'] != $after['remaining_amount']) {
        $action = $em_order->get_payment_methods($after['payment_method']);

        if ($after['payment_status'] == 1) {
            // roi
            $log_content[] = '-' . number_format($after['total']);
            $log_content[] = 0;
        } else if ($after['payment_status'] == 3) {
            $paid = $after['paid'] - $before['paid'];
            
            // 1 phan
            $log_content[] = $paid > 0 ? '-' . number_format($paid) : 0;
            $log_content[] = $after['remaining_amount'] > 0 ? '+' . number_format($after['remaining_amount']) : 0;
        }
    }

    if ($action != '' && count($log_content) > 0) {
        if ($module == 'em_order_payment') {
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

    while ($i < $days) {
        $time_next = strtotime($date_start) + DAY_IN_SECONDS;

        $date_start = date('Y-m-d', $time_next);

        if (in_array(date('D', $time_next), ['Sat', 'Sun'])) {
            continue;
        }

        $i++;
    }

    return $date_start;
}

function site_order_get_date_next($date_start = '')
{
    while (1) {
        $time_next = strtotime($date_start) + DAY_IN_SECONDS;

        $date_start = date('Y-m-d', $time_next);

        if (in_array(date('D', $time_next), ['Sat', 'Sun'])) {
            continue;
        }

        return $date_start;
    }

    return '';
}

function site_order_get_meal_plans($args = [])
{
    global $em_order, $em_order_item;

    $args = wp_unslash($args);

    $customer_id = isset($args['customer_id']) ? intval($args['customer_id']) : 0;

    $order_detail = [];

    $data = [];

    $order_id = isset($args['order_id']) ? intval($args['order_id']) : 0;
    if($order_id > 0) {
        $order_detail = $em_order->get_item($order_id);

        if($customer_id == 0) {
            $customer_id = $order_detail['customer_id'];
        }

        $orders = [ $order_detail ];
    } else {
        $q_args = ['limit' => -1];

        if($customer_id > 0) {
            $q_args['customer_id'] = $customer_id;
        }

        $orders = $em_order->get_items($q_args);
    }

    if(count($orders) > 0) {
        $date_start = '';
        $date_stop = '';

        foreach($orders as &$order) {
            $q_args = [
                'limit' => -1,
                'order_id' => $order['id'],
            ];

            $order_items = $em_order_item->get_items($q_args);

            $order_date_stop = $order['date_stop'];

            $order_meal_plan_items = [];

            foreach($order_items as &$order_item) {
                $order_item['meal_plan_items'] = $em_order_item->get_meal_plan($order_item);

                if(count($order_item['meal_plan_items']) > 0) {
                    $keys = array_keys($order_item['meal_plan_items']);
                    $order_item_date_stop = end($keys);

                    if ($order_date_stop < $order_item_date_stop) {
                        $order_date_stop = $order_item_date_stop;
                    }

                    foreach($order_item['meal_plan_items'] as $day => $value) {
                        if(empty($order_meal_plan_items[$day])) {
                            $order_meal_plan_items[$day] = 0;
                        }

                        $order_meal_plan_items[$day] += $value;
                    }
                }
            }

            $order['order_items'] = $order_items;
            $order['meal_plan_items'] = $order_meal_plan_items;

            if ($date_start == '' || $date_start > $order['date_start']) {
                $date_start = $order['date_start'];
            }

            if ($date_stop == '' || $date_stop < $order_date_stop) {
                $date_stop = $order_date_stop;
            }
        }

        $list = [$date_start];
        
        while ($date_start < $date_stop) {
            $time_next = strtotime($date_start) + DAY_IN_SECONDS;

            $date_start = date('Y-m-d', $time_next);

            if (in_array(date('D', $time_next), ['Sun', 'Sat'])) {
                continue;
            }

            $list[] = $date_start;
        }

        $data['schedule'] = $list;
        $data['orders'] = $orders;
    }

    return $data;
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
