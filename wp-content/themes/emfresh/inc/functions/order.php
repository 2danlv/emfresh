<?php

function site_order_submit()
{
    global $em_order;

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
            'location_name' => '',
            'order_type' => '',
            'payment_status' => 0,
            'payment_method' => '',
        ], $_POST);
        
        if(isset($_POST['order_note'])) {
            $order_data['note'] = sanitize_text_field($_POST['order_note']);
        }

        if($order_id == 0 && count($errors) == 0) {
            $update = false;

            $order_data = array_merge($order_data, [
                'customer_id' => $customer_id,
                'status' => 1,
            ]);
            
            $response = em_api_request('order/add', $order_data);
            if($response['code'] == 200) {
                $order_id = $response['insert_id'];

                $log_content = [
                    intval($order_data['ship_amount'] + $order_data['total_amount']),
                ];

                site_order_payment_history($order_id, 'Tạo đơn hàng', $log_content);
            } else {
                $errors = $response['errors'];
            }
        }
    
        if($order_id > 0 && count($errors) == 0 && !empty($_POST['order_item']) && count($_POST['order_item']) > 0){

            foreach($_POST['order_item'] as $order_item) {
                $order_item['order_id'] = $order_id;

                if(!empty($order_item['id'])) {
                    if(!empty($order_item['remove'])) {
                        $response = em_api_request('order_item/delete', ['id' => $order_item['id']]);
                    } else {
                        $response = em_api_request('order_item/update', $order_item);
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
                    $after = $em_order->get_item($order_id);

                    site_order_payment_history($order_id, 'update', '');
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
    
        wp_redirect(add_query_arg($query_args, get_permalink()));
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