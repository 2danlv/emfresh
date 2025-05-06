<?php

function site_order_save_order()
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

        $today = current_time('Y-m-d');

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

        // if($order_id > 0) {
        //     file_put_contents(ABSPATH . "/wp-content/uploads/order-{$order_id}.json", json_encode($_POST, JSON_UNESCAPED_UNICODE));
        // }

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

                            $clear_meal_plan = false;

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

                                    // kiem tra cap nhat co lien quan toi meal plan
                                    if($before_value != '' && in_array($key, ['days',  'quantity'])) {
                                        $clear_meal_plan = true;
                                    }
                                }
                            }

                            if($clear_meal_plan && $before['date_start'] > $today) {
                                $em_order_item->update(['meal_plan' => ''], ['id' => $order_item['id']]);
                            }

                            if (count($log_content) > 0) {
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
}
add_action('wp', 'site_order_save_order');

function site_order_reserve_order()
{
    global $em_order, $em_order_item, $em_log;

    // Bảo lưu
    $order_id = !empty($_GET['reserve_order']) ? (int) $_GET['reserve_order'] : 0;
    $resnonce = !empty($_GET['resnonce']) ? trim($_GET['resnonce']) : '';
    if ($order_id > 0 && wp_verify_nonce($resnonce, "resnonce")) {
        $order = $em_order->get_item($order_id);

        $updated = false;

        if (!empty($order['status']) && $order['status'] == 1) {
            $order_items = $em_order_item->get_items(['order_id' => $order_id, 'orderby' => 'id ASC']);

            $count_update = 0;

            $order_meal_plan_reserve = [];

            if (count($order_items) > 0) {
                $today = current_time('Y-m-d');

                foreach ($order_items as $order_item) {
                    $meal_plan_items = $em_order_item->get_meal_plan($order_item);

                    $meal_plan_reserve = [];

                    foreach ($meal_plan_items as $day => $value) {
                        if ($day > $today) {
                            $meal_plan_reserve[$day] = $value;

                            if(empty($order_meal_plan_reserve[$day])) {
                                $order_meal_plan_reserve[$day] = 0;
                            }

                            $order_meal_plan_reserve[$day] += $value;
                        }
                    }

                    if (count($meal_plan_reserve) > 0) {
                        $data = ['meal_plan_reserve' => json_encode($meal_plan_reserve)];

                        if($order_item['meal_plan'] == '') {
                            $data['meal_plan'] = json_encode($meal_plan_items);
                        }

                        if ($em_order_item->update($data, ['id' => $order_item['id']])) {
                            $count_update++;
                        }
                    }
                }
            }

            if ($count_update > 0) {
                $updated = $em_order->update(['status' => 3], ['id' => $order['id']]);

                $days = array_keys($order_meal_plan_reserve);
                $log_count_meal = array_sum($order_meal_plan_reserve);
                $log_count_days = count($days);

                $em_log->insert([
                    'action'        => 'Bảo lưu',
                    'module'        => 'em_order_reserve',
                    'module_id'     => $order_id,
                    'content'       => $days[0] . "|Số phần ăn bảo lưu: $log_count_meal/ Số ngày giao hàng bảo lưu: $log_count_days"
                ]);
            }
        }

        $query_args = [
            'order_id' => $order_id,
            'tab' => 'reserve',
            'expires' => time() + 3,
        ];

        if ($updated) {
            $query_args['message'] = 'Reserve+order+success';
        } else {
            $query_args['message'] = 'Reserve+order+fail';
        }

        // site_response_json($query_args);

        wp_redirect(add_query_arg($query_args, site_order_edit_link()));
        exit();
    }
}
add_action('wp', 'site_order_reserve_order');

function site_order_cancel_order()
{
    global $em_order, $em_log;

    // Tiếp tục
    $order_id = !empty($_GET['cancel_order']) ? (int) $_GET['cancel_order'] : 0;
    $cancelnonce = !empty($_GET['cancelnonce']) ? trim($_GET['cancelnonce']) : '';
    if ($order_id > 0 && wp_verify_nonce($cancelnonce, "cancelnonce")) {
        $new_order = !empty($_GET['new_order']) ? (int) $_GET['new_order'] : 0;

        $order = $em_order->get_item($order_id);

        $updated = false;

        if (!empty($order['status']) && $order['status'] == 3) {
            $updated = $em_order->update_field($order['id'], 'status', 2);

            $em_log->insert([
                'action'        => 'Xử lý bảo lưu',
                'module'        => 'em_order_reserve',
                'module_id'     => $order_id,
                'content'       => $new_order ? "Tạo đơn mới #{$order['order_number']} từ phần bảo lưu" : "kết thúc đơn hàng"
            ]);
        }

        $query_args = [
            'order_id' => $order_id,
            'tab' => 'reserve',
            'expires' => time() + 3,
        ];

        if ($updated) {
            $query_args['message'] = 'Cancel+order+success';

            if($new_order > 0) {
                wp_redirect(add_query_arg(['reserve_from' => $order_id], site_order_add_link()));
                exit();
            }
        } else {
            $query_args['message'] = 'Cancel+order+fail';
        }

        // site_response_json($query_args);

        wp_redirect(add_query_arg($query_args, site_order_edit_link()));
        exit();
    }
}
add_action('wp', 'site_order_cancel_order');

function site_order_continue_order()
{
    global $em_order, $em_order_item, $em_log;
    
    // Tiếp tục
    $order_id = !empty($_POST['continue_order']) ? (int) $_POST['continue_order'] : 0;
    $continonce = !empty($_POST['continonce']) ? trim($_POST['continonce']) : '';
    if ($order_id > 0 && wp_verify_nonce($continonce, "continonce")) {
        $order = $em_order->get_item($order_id);

        $date_continue = !empty($_POST['date_continue']) ? trim($_POST['date_continue']) : '';

        $parts = explode('/', $date_continue);

        if(count($parts) == 3) {
            $date_continue = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $updated = false;

        if (!empty($order['status']) && $order['status'] == 3) {
            $order_items = $em_order_item->get_items(['order_id' => $order_id, 'orderby' => 'id ASC']);

            $count_update = 0;

            $order_date_stop = $order['date_stop'];

            if (count($order_items) > 0) {
                // $today = current_time('Y-m-d');

                foreach ($order_items as $order_item) {
                    $meal_plan_items = json_decode($order_item['meal_plan'], true);

                    $meal_plan_reserve = json_decode($order_item['meal_plan_reserve'], true);

                    $meal_plan_new = [];

                    $date_stop = $order_item['date_stop'];

                    if(count($meal_plan_reserve) > 0) {
                        // $next = site_order_get_date_next($today);
                        $next = date("Y-m-d", strtotime($date_continue));

                        foreach ($meal_plan_reserve as $day => $value) {
                            if(isset($meal_plan_items[$day])) {
                                unset($meal_plan_items[$day]);

                                $meal_plan_new[$next] = $value;

                                $date_stop = $next;

                                $next = site_order_get_date_next($next);
                            }
                        }
                    }

                    if (count($meal_plan_new) > 0) {
                        if($order_date_stop < $date_stop) {
                            $order_date_stop = $date_stop;
                        }

                        $meal_plan_items = array_merge($meal_plan_items, $meal_plan_new);

                        $data = [
                            'meal_plan' => json_encode($meal_plan_items),
                            'meal_plan_reserve' => '',
                            'date_stop' => $date_stop,
                        ];

                        if ($em_order_item->update($data, ['id' => $order_item['id']])) {
                            $count_update++;
                        }
                    }
                }
            }

            if ($count_update > 0) {
                $updated = $em_order->update([
                    'date_stop' => $order_date_stop,
                    'status' => 1
                ], ['id' => $order['id']]);

                $em_log->insert([
                    'action'        => 'Xử lý bảo lưu',
                    'module'        => 'em_order_reserve',
                    'module_id'     => $order_id,
                    'content'       => "Tiếp tục đơn hàng"
                ]);
            }
        }

        $query_args = [
            'order_id' => $order_id,
            'tab' => 'reserve',
            'expires' => time() + 3,
        ];

        if ($updated) {
            $query_args['message'] = 'Continue+order+success';
            // wp_redirect(add_query_arg($query_args, site_meal_plan_detail_link()));
        } else {
            $query_args['message'] = 'Continue+order+fail';
        }
        
        // site_response_json($query_args);
        
        wp_redirect(add_query_arg($query_args, site_order_edit_link()));
        exit();
    }
}
add_action('wp', 'site_order_continue_order');

function site_order_delete_order()
{
    global $em_order;

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
            $query_args['message'] = 'Delete+order+success';
        } else {
            $query_args['message'] = 'Delete+order+fail';
        }

        wp_redirect(add_query_arg($query_args, site_order_list_link()));
        exit();
    }
}
add_action('wp', 'site_order_delete_order');

function site_order_delete_group()
{
    global $em_group;

    // Delete group
    $delete_group = !empty($_GET['delete_group']) ? (int) $_GET['delete_group'] : 0;
    $delnonce = !empty($_GET['delnonce']) ? trim($_GET['delnonce']) : '';
    if ($delete_group > 0 && wp_verify_nonce($delnonce, "delnonce")) {
        $deleted = $em_group->delete($delete_group);

        $query_args = [
            'group_id' => $delete_group,
            'expires' => time() + 3,
        ];

        if ($deleted) {
            $query_args['message'] = 'Delete-group-success';
        } else {
            $query_args['message'] = 'Delete-group-fail';
        }

        wp_redirect(add_query_arg($query_args, get_permalink()));
        exit();
    }
}
add_action('wp', 'site_order_delete_group');

function site_order_save_meal_select()
{
    global $em_order, $em_order_item, $em_log, $em_menu;
    
    if (!empty($_POST['save_meal_select'])) {
        $data = wp_unslash($_POST);

        $errors = [];

        $list = isset($data['list_meal_select']) ? (array) $data['list_meal_select'] : [];
        $meal_select_number = isset($data['meal_select_number']) ? (int) $data['meal_select_number'] : 0;
        $order_id = isset($data['order_id']) ? (int) $data['order_id'] : 0;
        $week = isset($data['week']) ? $data['week'] : '';

        $meal_select_key = 'meal_select' . ($meal_select_number > 0 ? '_' . $meal_select_number : '');

        if(count($list) > 0) {
            $menu_select = $em_menu->get_select();

            foreach($list as $order_item_id => $order_item_data) {
                $order_item = $em_order_item->get_item($order_item_id);
                if(empty($order_item['id'])) continue;

                $meal_select = $em_order_item->get_meal_select($order_item, $meal_select_number);
                if(count($meal_select) == 0) continue;

                $log_content = [];

                $update = false;

                foreach($meal_select as $day => $values) {
                    if(empty($order_item_data[$day])) continue;

                    $meal_select_data = $order_item_data[$day];
                    
                    foreach($values as $i => $value) {
                        if(isset($meal_select_data[$i])) {
                            $new = (int) $meal_select_data[$i];

                            if($value != $new) {
                                $update = true;

                                if($value > 0) {
                                    $log_content[] = site_get_meal_week($day) . ' ' . $menu_select[$value];
                                }
                            }

                            $value = $new;
                        }

                        $values[$i] = $value;
                    }

                    $meal_select[$day] = $values;
                }

                if($update) {
                    $em_order_item->update_field($order_item_id, $meal_select_key, json_encode($meal_select));
                }
                
                if(count($log_content) > 0) {
                    $order = $em_order->get_item($order_item['order_id']);
                
                    $product_name = explode('-', $order_item['product_name']);

                    $change_label = $order['customer_name'] . ' - #'. $order['order_number'] .' - ' . $product_name[0];
                    
                    // Log update
                    $em_log->insert([
                        'action'        => 'Cập nhật',
                        'module'        => $meal_select_key,
                        'module_id'     => $order_item_id,
                        'content'       => $change_label . '|' . implode("\n", $log_content)
                    ]);
                }
            }
        }

        $query_args = [
            'week' => $week,
            'meal_select_number' => $meal_select_number,
            'order_id' => $order_id,
            'code' => count($errors) > 0 ? 500 : 200,
            'expires' => time() + 3,
            'message' => count($errors) > 0 ? implode(' ', $errors) : 'Update+meal+select+success'
        ];

        if(!empty($_POST['ajax'])) {
            echo json_encode($query_args);
            die();
        }

        wp_redirect(add_query_arg($query_args, get_permalink()));
        exit();
    }
}
add_action('wp', 'site_order_save_meal_select');

function site_order_save_meal_plan()
{
    global $em_order, $em_order_item, $em_log;
    
    if (!empty($_POST['save_meal_plan'])) {
        $data = wp_unslash($_POST);

        $errors = [];

        $list = isset($data['list_meal']) ? $data['list_meal'] : [];

        if(is_array($list) && count($list) > 0) {
            // $today = current_time('Y-m-d');

            foreach($list as $item) {
                $order_id = !empty($item['order_id']) ? (int) $item['order_id'] : 0;
                $order_item_id = !empty($item['order_item_id']) ? (int) $item['order_item_id'] : 0;
                $meal_plan = !empty($item['meal_plan']) ? $item['meal_plan'] : [];
                
                if($order_id == 0 || $order_item_id == 0 || count($meal_plan) == 0) continue;
                                
                $order_item = $em_order_item->get_item($order_item_id);
                // $my_meal_plan = json_decode($order_item['meal_plan'], true);
                $total = $order_item['meal_number'] * $order_item['days'];

                if(array_sum($meal_plan) != $total) {
                    $errors[] = "Order $order_id - Item $order_item_id - Error.";

                    continue;
                }

                $em_order_data = [
                    'meal_plan' => json_encode($meal_plan)
                ];

                $keys = array_keys($meal_plan);
                $date_stop = end($keys);
                
                if($date_stop > $order_item['date_stop']) {
                    $em_order_data['date_stop'] = $date_stop;
                }

                $updated = $em_order_item->update($em_order_data, ['id' => $order_item_id]);

                if($updated && isset($em_order_data['date_stop'])) {
                    $order = $em_order->get_item($order_id);

                    if($date_stop > $order['date_stop']) {
                        $em_order->update([
                            'date_stop' => $date_stop
                        ], ['id' => $order_id]);
                    }
                }
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
add_action('wp', 'site_order_save_meal_plan');

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

        // 'Sun', 'Sat'
        if (in_array(date('w', $time_next), [0, 6])) {
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

        // 'Sun', 'Sat'
        if (in_array(date('w', $time_next), [0, 6])) {
            continue;
        }

        return $date_start;
    }

    return '';
}

function site_order_get_meal_plans($args = [])
{
    global $em_order, $em_order_item, $em_customer_group, $em_group;

    $args = wp_unslash($args);

    $customer_id = !empty($args['customer_id']) ? intval($args['customer_id']) : 0;
    $group_id = !empty($args['group_id']) ? intval($args['group_id']) : 0;
    $groupby = !empty($args['groupby']) ? sanitize_text_field($args['groupby']) : '';
    $date_from = !empty($args['date_from']) ? trim($args['date_from']) : '';
    $meal_select_number = isset($args['meal_select_number']) ? intval($args['meal_select_number']) : 0;

    $order_detail = [];
    $data = [
        'date_stop' => '',
        'schedule' => [],
        'meal_plan_items' => [],
        'meal_select_items' => [],
        'orders' => [],
        'customers' => [],
        'statistics' => [],
    ];
    $customers_group_ids = [];

    $order_id = isset($args['order_id']) ? intval($args['order_id']) : 0;
    if($order_id > 0) {
        $order_detail = $em_order->get_item($order_id);

        if($customer_id == 0) {
            $customer_id = $order_detail['customer_id'];
        }

        $orders = [$order_detail];
    } else {
        $q_args = ['limit' => -1];

        if($customer_id > 0) {
            $q_args['customer_id'] = $customer_id;
        } else if($group_id > 0) {
            $customer_groups = $em_customer_group->get_items(['group_id' => $group_id]);

            if(count($customer_groups) > 0) {
                $q_args['customer_id'] = array_column($customer_groups, 'customer_id');
            } else {
                $q_args['customer_id'] = [];
            }
        } else if($groupby == 'group') {
            $items = $em_group->get_items();

            $customer_ids = [];

            if(count($items) > 0) {
                foreach($items as $item) {
                    $customer_groups = $em_customer_group->get_items(['group_id' => $item['id']]);
                    if(count($customer_groups) > 0) {
                        $item['customer_ids'] = array_column($customer_groups, 'customer_id');
                        $item['customers'] = $customer_groups;
    
                        $customer_ids = array_merge($customer_ids, array_diff($item['customer_ids'],$customer_ids));

                        foreach($item['customer_ids'] as $value) {
                            if(empty($customers_group_ids[$value])) {
                                $customers_group_ids[$value] = $item;
                            }
                        }
                    }
                }
            }
            
            $q_args['customer_id'] = $customer_ids;
        }

        if($date_from != '') {
            // $q_args['date_from'] = date('Y-m-d', strtotime('-45 days'));
            $q_args['date_from'] = $date_from;
        }

        $orders = $em_order->get_items($q_args);
    }

    if(count($orders) > 0) {
        $date_start = '0000-00-00';
        $date_stop = '0000-00-00';

        $schedule_meal_plan_items = [];
        $schedule_meal_select_items = [];

        $static_days = site_get_days_week_by('this-week');

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
        
        // San pham chinh
        $product_codes = site_get_product_codes();

        $today = current_time('Y-m-d');

        foreach($orders as $i => $order) {
            $q_args = [
                'limit' => -1,
                'order_id' => $order['id'],
            ];

            $order_items = $em_order_item->get_items($q_args);

            $order_date_stop = $order['date_stop'];

            $order_meal_plan_items = [];
            $order_meal_select_items = [];

            foreach($order_items as $j => $order_item) {
                $order_item['meal_plan_items'] = $em_order_item->get_meal_plan($order_item);
                $order_item['meal_select_items'] = $em_order_item->get_meal_select($order_item, $meal_select_number);

                if(count($order_item['meal_plan_items']) > 0) {
                    $keys = array_keys($order_item['meal_plan_items']);
                    $order_item['date_stop'] = end($keys);

                    if ($order_date_stop < $order_item['date_stop']) {
                        $order_date_stop = $order_item['date_stop'];
                    }

                    foreach($order_item['meal_plan_items'] as $day => $value) {
                        if(empty($order_meal_plan_items[$day])) {
                            $order_meal_plan_items[$day] = 0;
                        }

                        $order_meal_plan_items[$day] += $value;

                        if(empty($schedule_meal_plan_items[$day])) {
                            $schedule_meal_plan_items[$day] = 0;
                        }

                        $schedule_meal_plan_items[$day] += $value;
                    }

                    foreach($order_item['meal_select_items'] as $day => $meal_select) {
                        if(empty($order_meal_select_items[$day])) {
                            $order_meal_select_items[$day] = [];
                        }

                        $order_meal_select_items[$day] = array_merge($order_meal_select_items[$day], $meal_select);

                        if(empty($schedule_meal_select_items[$day])) {
                            $schedule_meal_select_items[$day] = [];
                        }

                        $schedule_meal_select_items[$day] = array_merge($schedule_meal_select_items[$day], $meal_select);
                    }

                    $parts = explode('-', $order_item['product_name']);
                    $code = trim($parts[0]);

                    $type = in_array($code, $product_codes) ? 'chinh' : 'phu';

                    $dam_rate = site_get_dam_rate($code);

                    foreach($static_days as $day) {
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

                $order_items[$j] = $order_item;
            }

            $order['order_items'] = $order_items;
            $order['meal_plan_items'] = $order_meal_plan_items;
            $order['meal_select_items'] = $order_meal_select_items;

            // Sort order status [2 => Chưa rõ, 3 => Dí món, 1 => Đặt đơn]
            if($today < $order['date_start']) {
                // $status = 'di_mon';
                $order['order_status'] = 3;
            } else if($today > $order_date_stop) {
                // $status = 'chua_ro';
                $order['order_status'] = 2;
            } else {
                // $status = 'dat_don';
                $order['order_status'] = 1;
            }

            $order['order_status_name'] = $em_order->get_order_statuses($order['order_status']);

            if ($date_start == '0000-00-00' || $date_start > $order['date_start']) {
                $date_start = $order['date_start'];
            }

            if ($date_stop == '0000-00-00' || $date_stop < $order_date_stop) {
                $date_stop = $order_date_stop;
            }

            $orders[$i] = $order;
        }

        $customers = [];

        if($groupby == 'customer' || $groupby == 'group') {
            
            foreach($orders as $i => $order) {
                $customer_id = $order['customer_id'];

                if($groupby == 'group') {
                    if(empty($customers_group_ids[$customer_id])) continue;

                    $group = $customers_group_ids[$customer_id];

                    // set group_id
                    $customer_id = $group['id'];
                    
                    $order['group_name']    = $group['name'];
                    $order['group_phone']   = $group['phone'];
                    $order['group_location_name'] = $group['location_name'];
                }

                if(isset($customers[$customer_id])) {
                    $customer = $customers[$customer_id];
                    
                    $customer['orders'][] = $order;
                } else {
                    $customer = $order;
                    $customer['id'] = $customer_id;
                    $customer['orders'] = [$order];
                    $customer['meal_plan_items'] = [];
                    $customer['meal_select_items'] = [];
                    $customer['type_name'] = '';
                    $customer['item_name'] = '';
                    
                    unset($customer["order_items"]);
                }

                $customer_meal_plan_items = isset($customer['meal_plan_items']) ? $customer['meal_plan_items'] : [];
                $customer_meal_select_items = isset($customer['meal_select_items']) ? $customer['meal_select_items'] : [];

                foreach($order['meal_plan_items'] as $day => $value) {
                    if(empty($customer_meal_plan_items[$day])) {
                        $customer_meal_plan_items[$day] = 0;
                    }

                    $customer_meal_plan_items[$day] += $value;
                }

                foreach($order['meal_select_items'] as $day => $meal_select) {
                    if(empty($customer_meal_select_items[$day])) {
                        $customer_meal_select_items[$day] = [];
                    }

                    $customer_meal_select_items[$day] = array_merge($customer_meal_select_items[$day], $meal_select);
                }

                $customer['meal_plan_items'] = $customer_meal_plan_items;
                $customer['meal_select_items'] = $customer_meal_select_items;

                if(empty($customer['count_order'])) {
                    $customer['count_order'] = 0;
                }

                $customer['count_order'] += 1;

                $order_type_name = isset($order['type_name']) ? array_map('trim', explode(',', $order['type_name'])) : [];
                $customer_type_name = isset($customer['type_name']) ? array_map('trim', explode(',', $customer['type_name'])) : [];

                foreach($order_type_name as $value) {
                    if($value != '' && !in_array($value, $customer_type_name)) {
                        $customer_type_name[] = $value;
                    }
                }

                $customer_type_name = site_order_sort_types($customer_type_name);
                
                $customer['type_name'] = implode(', ', $customer_type_name);

                $order_item_name = isset($order['item_name']) ? array_map('trim', explode(',', $order['item_name'])) : [];
                $customer_item_name = isset($customer['item_name']) ? array_map('trim', explode(',', $customer['item_name'])) : [];

                foreach($order_item_name as $value) {
                    if($value != '' && !in_array($value, $customer_item_name)) {
                        $customer_item_name[] = $value;
                    }
                }

                $customer_item_name = array_filter($customer_item_name, function($value){ return $value != ""; });

                $customer['item_name'] = implode(', ', $customer_item_name);

                // Sort order status [2 => Chưa rõ, 3 => Dí món, 1 => Đặt đơn]
                if($order['order_status'] == 3) {
                    $customer['order_status'] = 3;
                }
                $customer['order_status_name'] = $em_order->get_order_statuses($customer['order_status']);

                // Sort payment status [2 => Chưa, 3 => 1 phần, 1 => Rồi]
                if($customer['payment_status'] == 2 || $order['payment_status'] == 2) {
                    $customer['payment_status'] = 2;
                    $customer['payment_status_name'] = $order['payment_status_name'];
                } else if($customer['payment_status'] == 3 || $order['payment_status'] == 3) {
                    $customer['payment_status'] = 2;
                    $customer['payment_status_name'] = $order['payment_status_name'];
                }
                
                $customers[$customer_id] = $customer;
            }

            // nếu tất cả 
            foreach($customers as $id => $customer) {
                $order_status_count = 0;
                $payment_status_count = 0;
                $payment_methods = [];

                foreach($customer['orders'] as $order) {
                    if($order['order_status'] == 1) {
                        // 1 => "Đặt đơn",
                        $order_status_count++;
                    } else if($order['order_status'] == 3) {
                        // 3 => Dí món
                        $customer['order_status'] = 3;
                    }

                    if($order['payment_status'] == 1) {
                        // 1 => Rồi
                        $payment_status_count++;
                    } else if($order['payment_status'] == 2) {
                        // 2 => Chưa
                        $customer['payment_status'] = 2;
                    }

                    if(!in_array($order['payment_method'], $payment_methods)) {
                        $payment_methods[] = $order['payment_method'];
                    }
                }

                if($order_status_count == count($customer['orders'])) {
                    $customer['order_status'] = 1;
                } else if($customer['order_status'] != 3) {
                    $customer['order_status'] = 2; // 2 => "Chưa rõ",
                }
                $customer['order_status_name'] = $em_order->get_order_statuses($customer['order_status']);
                
                if($payment_status_count == count($customer['orders'])) {
                    $customer['payment_status'] = 1; // 1 => Rồi
                } else if($customer['order_status'] != 2) {
                    $customer['payment_status'] = 3; // 3 => 1 phần
                }
                $customer['payment_status_name'] = $em_order->get_payment_statuses($customer['payment_status']);

                $payment_methods = site_order_sort_payment_methods($payment_methods);
                $customer['payment_method'] = implode(', ', array_keys($payment_methods));
                $customer['payment_method_name'] = implode(', ', $payment_methods);

                $customers[$id] = $customer;
            }
        }

        $list = [];

        $data['date_start'] = $date_start;
        
        if($date_start != '0000-00-00' && $date_stop != '0000-00-00' && $date_start < $date_stop) {
            $list[] = $date_start;

            while ($date_start < $date_stop) {
                $time_next = strtotime($date_start) + DAY_IN_SECONDS;
    
                $date_start = date('Y-m-d', $time_next);
    
                // 'Sun', 'Sat'
                if (in_array(date('w', $time_next), [0, 6])) {
                    continue;
                }
    
                $list[] = $date_start;
            }
        }

        $data['date_stop'] = $date_stop;
        $data['schedule'] = $list;
        $data['meal_plan_items'] = $schedule_meal_plan_items;
        $data['meal_select_items'] = $schedule_meal_select_items;
        $data['orders'] = $orders;
        $data['customers'] = $customers;
        $data['statistics'] = $statistics;
    }

    return $data;
}

function site_order_sort_types($types = [])
{
    if(count($types) == 0) return $types;

    $sorts = ['M', 'W', 'D'];

    $list = [];

    $types = array_map('strtoupper', $types);

    foreach($sorts as $value) {
        if(in_array($value, $types)) {
            $list[] = $value;
        }
    }

    return $list;
}

function site_order_sort_payment_methods($methods = [])
{
    if(count($methods) == 0) return $methods;

    $sorts = [
        2 => "COD",
        1 => "Chuyển khoản",
    ];

    $list = [];

    foreach($sorts as $index => $value) {
        if(in_array($index, $methods)) {
            $list[$index] = $value;
        }
    }

    return $list;
}

function site_order_group_item_name($item_name = '')
{
    $itemList = explode(', ', $item_name);
    $groupedItems = [];
    foreach ($itemList as $item) {
        if (strpos($item, '+') !== false) {
            $combinedItems = explode('+', $item);
            foreach ($combinedItems as $subItem) {
                preg_match('/(\d+)([A-Za-z]+)/', $subItem, $matches);
                if ($matches) {
                    $quantity = (int)$matches[1];
                    $code = $matches[2];
                    if (isset($groupedItems[$code])) {
                        $groupedItems[$code] += $quantity;
                    } else {
                        $groupedItems[$code] = $quantity;
                    }
                }
            }
        } else {
            preg_match('/(\d+)([A-Za-z]+)/', $item, $matches);
            if ($matches) {
                $quantity = (int)$matches[1];
                $code = $matches[2];
                if (isset($groupedItems[$code])) {
                    $groupedItems[$code] += $quantity;
                } else {
                    $groupedItems[$code] = $quantity;
                }
            }
        }
    }

    $result = [];
    foreach ($groupedItems as $code => $quantity) {
        $result[] = $quantity . $code;
    }

    return $result;
}

function site_order_list_link()
{
    return get_permalink(134);
}

function site_meal_plan_list_link()
{
    return get_permalink(147);
}

function site_meal_plan_detail_link()
{
    return get_permalink(149);
}

function site_meal_plan_group_link()
{
    return get_permalink(181);
}

function site_order_add_link()
{
    return get_permalink(140);
}

function site_order_edit_link()
{
    return get_permalink(143);
}

function site_get_days_week_by($day = '', $format = 'Y-m-d')
{
	$days = [];

    if($day == 'this-week') {
        $time = time();
        // change Friday to Monday
        if (date('w', $time) == 5 && date('H', $time) >= 12) {
            $time += 2 * DAY_IN_SECONDS;
        }
    } else {
        $time = strtotime($day);
    }

	$w = date('w', $time);

	if ($w == 6) {
		$time += 2 * DAY_IN_SECONDS;
	} else if ($w == 0) {
		$time += DAY_IN_SECONDS;
	} else {
		$time -= ($w - 1) * DAY_IN_SECONDS;
	}

	for ($i = 0; $i < 5; $i++) {
		$days[] = date($format, $time);

		$time += DAY_IN_SECONDS;
	}

	return $days;
}

function site_get_meal_week($day = '', $new_line = ' ')
{
	$time = strtotime($day);

	$i = date('w', $time);

	return 'Thứ ' . ($i + 1) . $new_line . date('(d/m)', $time);
}

function site_generate_weekdays_list($start_date, $days_to_add = 35, $type = 1)
{
    $today = new DateTime($start_date);
    $today->modify('+1 day');
    $end_data_date = (clone $today)->modify('+' . $days_to_add . ' days');
    $list_items = '';

    while ($today <= $end_data_date) {
        if ($today->format('N') < 6) {
            $date = $today->format('Y-m-d');
            if ($type == 1) {
                $list_items .= '<li data-date="' . $date . '" class="empty">';
                $list_items .= $today->format('d') . ' <span class="hidden">' . $today->format('m') . '</span>';
                $list_items .= '</li>';
            } elseif ($type == 2) {
                $list_items .= '<li class="empty">';
                $list_items .= '<span data-date="' . $date . '"></span>';
                $list_items .= '</li>';
            } elseif ($type == 3) {
                $list_items .= '<li class="empty edit">';
                $list_items .= '<span>';
                $list_items .= '<input type="text" class="input-meal_plan empty" value="" data-date="' . $date . '" />';
                $list_items .= '</span>';
                $list_items .= '</li>';
            }
        }
        $today->modify('+1 day');
    }

    return $list_items;
}

// San pham chinh
function site_get_product_codes()
{
    return ['EM','EL','SM','SL','PM','PL'];
}

function site_get_water_codes()
{
    return ['EP','TA'];
}

function site_get_dam_rate($code)
{
    if(!in_array($code, site_get_product_codes())) {
        return 0;
    }

    // Dam : SM + EM + SL*1.5 + EL*1.5 + PM*2 + PL*2.5
    if(in_array($code, ['SL', 'EL'])) {
        $dam_rate = 1.5;
    } else if($code == 'PM') {
        $dam_rate = 2;
    } else if($code == 'PL') {
        $dam_rate = 2.5;
    } else {
        $dam_rate = 1;
    }

    return $dam_rate;
}