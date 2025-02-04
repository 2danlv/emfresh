<?php

function site_order_submit()
{
    global $em_order, $em_order_item, $em_log;

    $order_default = [
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
            $params['ship'] = $_POST['ship'];
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
                'days' => 'Số ngày dùng',
                'product_id' => 'Tên sản phẩm',
                'date_start' => 'Ngày bắt đầu',
                'quantity' => 'Số lượng',
                'auto_choose' => 'Tự chọn món',
                'note' => 'Ghi chú',
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
                                'action'        => 'Sản phẩm',
                                'module'        => 'em_order',
                                'module_id'     => $order_id,
                                'content'       => 'Xóa ' . $item_title
                            ]);
                        }
                    } else {
                        $before = $em_order_item->get_item($order_item['id']);

                        $response = em_api_request('order_item/update', $order_item);

                        if($response['code'] == 200) {
                            $log_content = [];

                            foreach($item_labels as $key => $label) {
                                if(isset($before[$key]) && isset($order_item[$key]) && $order_item[$key] != $before[$key]) {
                                    $value = $before[$key];

                                    if($key == 'product_id') {
                                        $value = $em_order_item->get_product($value, 'name');
                                    }

                                    $log_content[] = $label . ' ' . $value;
                                }
                            }

                            if(count($log_content) > 0) {
                                // Log update
                                $em_log->insert([
                                    'action'        => 'Sản phẩm',
                                    'module'        => 'em_order',
                                    'module_id'     => $order_id,
                                    'content'       => $item_title . ' ' . implode(' ', $log_content)
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

            $response = em_api_request('order/add', $order_data);
            if($response['code'] == 200) {
                $order_id = $response['data']['insert_id'];

                site_order_log($order_default, $order_data);

                $order_items = $em_order_item->get_items(['order_id' => $duplicate_order]);

                foreach($order_items as $order_item) {
                    unset($order_item['id']);
                    
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

    $labels = array(
        // 'status'        => 0,
        // 'ship_days'     => 0,
        // 'ship_amount'   => 0,
        // 'total_amount'  => 0,
        // 'discount'      => 0,
        // 'note'          => '',
        'payment_method' => 'Phương thức thanh toán',
        'payment_status' => 'Tình trạng thanh toán',
        'order_status'  => 'Tình trạng đơn hàng',
        'order_type'    => 'Loại đơn hàng',
    );

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
    } else if($before['total'] < $after['total']) {
        $action = 'Bổ sung đơn hàng';
        $module = 'em_order_payment';

        $log_content[] = $after['remaining_amount'] > 0 ? '+'. number_format($after['remaining_amount']) : 0;
        $log_content[] = '+'. number_format($after['total'] - $before['total']);
    } else if($before['location_id'] < $after['location_id']) {
        $action = 'Địa chỉ';

        $log_content[] = $before['location_name'];
    }
    
    if($action != '') {
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