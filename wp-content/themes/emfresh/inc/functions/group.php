<?php

function site_group_submit()
{
    global $em_group, $em_customer_group, $em_log;

    if (!empty($_POST['save_group'])) {

        $group_default = [
            'name' => '',
            'phone' => '',
            'location_id' => 0,
            'note' => '',
        ];

        $item_labels = array(
            'name' => 'Họ tên',
            'phone' => 'Số điện thoại',
            'location_id' => 'Địa chỉ',
            'note' => 'Ghi chú',
        );

        $data = wp_unslash($_POST);

        $customers = isset($data['customers']) ? (array) $data['customers'] : [];
        
        $errors = [];

        $group_data = shortcode_atts($group_default, $data);

        $group_id = isset($data['group_id']) ? intval($data['group_id']) : 0;

        if($group_id == 0) {
            $response = em_api_request('group/add', $group_data);
            if ($response['code'] == 200) {
                $group_id = $response['data']['insert_id'];
            }
        } else {
            $before = $em_group->get_item($group_id);

            $group_data['id'] = $group_id;

            $response = em_api_request('group/update', $group_data);
            if ($response['code'] == 200) {
                $log_content = [];

                foreach ($item_labels as $key => $label) {
                    $before_value = isset($before[$key]) ? $before[$key] : '';
                    $value = isset($group_data[$key]) ? $group_data[$key] : '';
                    
                    if ($value != '' && $value != $before_value) {

                        if ($key == 'location_id') {
                            $value = $before['location_name'];
                        }

                        if($label != '') {
                            $log_content[] = $label . ' ' . $value;
                        }
                    }
                }

                if (count($log_content) > 0) {
                    // Log update
                    $em_log->insert([
                        'action'        => 'Cập nhật',
                        'module'        => 'em_group',
                        'module_id'     => $group_id,
                        'content'       => implode(' ', $log_content)
                    ]);
                }
            }
        }

        if($group_id > 0) {
            $customers = isset($data['customers']) ? (array) $data['customers'] : [];

            // Sort by order
            $n = count($customers);
            for($i = 1; $i < $n - 1; $i++) {
                for($j = 2; $j < $n; $j++) {
                    if($customers[$j]['order'] < $customers[$i]['order']) {
                        $tmp = $customers[$j];
                        $customers[$j] = $customers[$i];
                        $customers[$i] = $tmp;
                    }
                }
            }

            $customer_groups = $em_customer_group->get_items([
                'group_id' => $group_id,
                'orderby' => 'id ASC',
            ]);

            $log_content = [];
            
            $log_insert = [];

            $label = 'Thành viên';

            $count = 0;

            foreach ($customers as $customer) {
                if (empty($customer['id'])) continue;

                $customer_id = (int) $customer['id'];

                $group_data = [
                    'group_id' => $group_id,
                    'bag' => !empty($customer['bag']) ? 1 : 0,
                    'customer_id' => $customer_id,
                    'order' => $count + 1
                ];

                if (!empty($customer_groups[$count])) {
                    $before = $customer_groups[$count];

                    $group_data['id'] = $before['id'];

                    if($customer_id != $before['customer_id']) {
                        $log_update[] = $label . ' ' . $before['customer_name'];
                    }

                    $em_customer_group->update($group_data);
                } else {
                    $insert_id = $em_customer_group->insert($group_data);

                    if($insert_id > 0) {
                        $after = $em_customer_group->get_item($insert_id);

                        $log_insert[] = $label . ' ' . $after['customer_name'];
                    }
                }

                $count++;
            }

            if(count($log_content) > 0) {
                // Log update
                $em_log->insert([
                    'action'        => 'Cập nhật',
                    'module'        => 'em_group',
                    'module_id'     => $group_id,
                    'content'       => implode(' ', $log_content)
                ]);
            }
            
            if(count($log_insert) > 0) {
                // Log update
                $em_log->insert([
                    'action'        => 'Thêm',
                    'module'        => 'em_group',
                    'module_id'     => $group_id,
                    'content'       => implode(' ', $log_insert)
                ]);
            }

            $log_content = [];

            for ($i = $count; $i < count($customer_groups); $i++) {
                $before = $customer_groups[$i];

                $log_content[] = $label . ' ' . $before['customer_name'];

                $em_customer_group->delete($before['id']);
            }

            if(count($log_content) > 0) {
                // Log update
                $em_log->insert([
                    'action'        => 'Xóa',
                    'module'        => 'em_group',
                    'module_id'     => $group_id,
                    'content'       => implode(' ', $log_content)
                ]);
            }
        }

        $query_args = [
            'group_id' => $group_id,
            'expires' => time() + 3,
        ];

        if (count($errors) > 0) {
            $query_args['message'] = 'Errors';
        } else {
            $query_args['message'] = 'Success';
        }

        wp_redirect(add_query_arg($query_args, site_group_edit_link()));
        exit();
    }
}
add_action('wp', 'site_group_submit');

function site_group_list_link()
{
    return get_permalink(156);
}

function site_group_edit_link()
{
    return get_permalink(160);
}