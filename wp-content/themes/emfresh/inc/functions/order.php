<?php

function site_order_submit()
{
    global $em_order, $em_order_item, $em_log;

    if (!empty($_POST['save_order'])) {
        $_POST = wp_unslash($_POST);
        
        $errors = [];
    
        $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
        if($customer_id == 0) {
            $errors[] = 'No customer';
        }
    
        $update = true;

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

        $order_data = shortcode_atts([
            'ship_days' => 0,
            'ship_amount' => 0,
            'total_amount' => 0,
            'discount' => 0,
            'item_name' => '',
            'location_id' => 0,
            'order_type' => '',
            'payment_status' => 0,
            'payment_method' => '',
            'payment_amount' => 0,
        ], $_POST);
        
        if(isset($_POST['order_note'])) {
            $order_data['note'] = sanitize_text_field($_POST['order_note']);
        }

        $order_data['total'] = intval($order_data['ship_amount'] + $order_data['total_amount']);

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

                site_order_payment_history($order_id, 'Tạo đơn hàng', [
                    // $order_data['payment_amount'],
                    '+' . $order_data['total'],
                    '+' . $order_data['total'],
                ]);
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
            
            foreach($_POST['order_item'] as $i => $order_item) {
                $order_item['order_id'] = $order_id;

                $item_title = 'Sản phẩm ' . ($i + 1);

                if(!empty($order_item['id'])) {
                    if(!empty($order_item['remove'])) {
                        $response = em_api_request('order_item/delete', ['id' => $order_item['id']]);

                        if($response['code'] == 200) {
                            // Log update
                            $em_log->insert([
                                'action'        => 'Xóa',
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
                                    }

                                    $log_content[] = $label . ' ' . $value;
                                }
                            }

                            if(count($log_content) > 0) {
                                // Log update
                                $em_log->insert([
                                    'action'        => 'Cập nhật',
                                    'module'        => 'em_order',
                                    'module_id'     => $order_id,
                                    'content'       => $item_title . ' - ' . implode(', ', $log_content)
                                ]);
                            }
                        }
                    }
                } else {
                    unset($order_item['id']);
    
                    $response = em_api_request('order_item/add', $order_item);
                }
            }

            if($update) {
                $order_data['id'] = $order_id;

                $before = $em_order->get_item($order_id);

                $response = em_api_request('order/update', $order_data);

                if($response['code'] == 200) {
                    site_order_log($before, $order_data);
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
}
add_action('wp', 'site_order_submit');

function site_order_payment_history($order_id = 0, $action = '', $log_content = '')
{
    if($order_id == 0) return;

    global $em_log;

    if(is_array($log_content)) {
        $log_content = implode(',', $log_content);
    }

    // Log update
    $em_log->insert([
        'action'        => $action,
        'module'        => 'em_order_payment',
        'module_id'     => $order_id,
        'content'       => $log_content
    ]);
}

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

    if($before['payment_method'] != $after['payment_method']) {
        $action = $em_order->get_payment_methods($after['payment_method']);

        $module = 'em_order_payment';
    } else if($before['payment_status'] != $after['payment_status']) {
        $action = $em_order->get_payment_statuses($after['payment_status']);

        $module = 'em_order_payment';
    } else if($after['payment_amount'] > 0){
        // $action = 'Bổ sung đơn hàng';
    }
    
    if($action != '') {
        // Add Log 
        $em_log->insert([
            'action'        => $action,
            'module'        => $module,
            'module_id'     => $after['id'],
            'content'       => implode(', ', $log_content)
        ]);
    }
}

function site_order_add_link()
{
    return get_permalink(140);
}

function site_order_edit_link()
{
    return get_permalink(143);
}