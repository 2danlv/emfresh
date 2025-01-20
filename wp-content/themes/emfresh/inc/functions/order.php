<?php

function site_order_submit()
{
    if (!empty($_POST['save_order'])) {
        $_POST = wp_unslash($_POST);
        
        $errors = [];
    
        $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
        if($customer_id == 0) {
            $errors[] = 'No customer';
        }
    
        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        if($order_id == 0 && count($errors) == 0) {
            $data_order = [
                'customer_id' => $customer_id,
                'status' => 1,
            ];
    
            $response = em_api_request('order/add', $data_order);
            if($response['code'] == 200) {
                $order_id = $response['insert_id'];
            } else {
                $errors = $response['errors'];
            }
        }
    
        if($order_id > 0 && count($errors) == 0 && !empty($_POST['order_item']) && count($_POST['order_item']) > 0){

            foreach($_POST['order_item'] as $order_item) {
                if(!empty($order_item['location_id'])) {
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
            }

            $update_order = shortcode_atts([
                'id' => $order_id,
                'ship_days' => 0,
                'ship_amount' => 0,
                'total_amount' => 0,
                'discount' => 0,
                'item_name' => '',
                'location_name' => '',
                'order_type' => '',
            ], $_POST);
            
            $update_order['note'] = isset($_POST['order_note']) ? $_POST['order_note'] : '';
            
            $response = em_api_request('order/update', $update_order);
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