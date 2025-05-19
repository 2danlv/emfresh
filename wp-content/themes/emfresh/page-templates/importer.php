<?php

function site_importer_action()
{
    if (empty($_POST['importoken']) || ! wp_verify_nonce($_POST['importoken'], 'importoken')) {
        return;
    }

    $response = [];

    $export = isset($_POST['export']) ? trim($_POST['export']) : '';
    $import = isset($_POST['import']) ? trim($_POST['import']) : '';
    if ($export == 'customer') {
        $response = site_importer_export_customer();
    } else if ($import == 'customer') {
        $response = site_importer_import_customer();
    }

    if (count($response) > 0) {
        header('Content-type: application/json');
        echo wp_json_encode($response);
        exit();
    }
}
add_action('wp', 'site_importer_action');

function site_importer_get_customer_labels($key = null)
{
    $list = [
        'customer_name' => 'Tên khách hàng',
        'fullname'      => 'Tên thật',
        'nickname'      => 'Tên tài khoản',
        'phone'         => 'Số điện thoại',
        'status_name'   => 'Tình trạng',
        'gender_name'   => 'Giới tính',
        'tag_name'      => 'Phân loại',
        'address'       => 'Địa chỉ',
        'point'         => 'Điểm tích lũy',
        // 'note'          => 'Ghi chú',
    ];

    if ($key != null) {
        return isset($list[$key]) ? $list[$key] : '';
    }

    return $list;
}

function site_importer_export_customer()
{
    global $em_customer_tag;
    
    $response = em_api_request('customer/list', [
        'limit' => -1
    ]);

    if ($response['code'] == 200 && count($response['data']) > 0) {
        $customer_labels = site_importer_get_customer_labels();

        $location_fields = [
            "address",
            "ward",
            "district",
            "city"
        ];

        $items = $response['data'];

        foreach ($items as $i => $customer) {
            $customer_id = (int) $customer['id'];

            $res = em_api_request('location/list', [
                'customer_id' => $customer_id,
                'limit' => 5
            ]);

            if ($res['code'] == 200) {
                $addresses = [];

                foreach ($res['data'] as $location) {
                    $columns = [];

                    foreach ($location_fields as $field) {
                        $columns[] = isset($location[$field]) ? $location[$field] : '';
                    }

                    $addresses[] = implode(", ", $columns);
                }

                $customer['address'] = implode("\n", $addresses);
            }

            $rows = [];

            foreach ($customer_labels as $field => $label) {
                if($field == 'tag_name') {
                    $customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
                    $tag_names = [];

                    foreach($customer_tags as $item) {
                        $tag_names[] = $item['name'];
                    }

                    $rows[$label] = implode(", ", $tag_names);
                } else {
                    $rows[$label] = isset($customer[$field]) ? $customer[$field] : '';
                }
            }

            $items[$i] = $rows;
        }

        $response['data'] = $items;
    }

    return $response;
}

function site_importer_import_customer()
{
    global $em_customer, $em_customer_tag, $em_log;

    $response = ['code' => 200, 'message' => 'Import success'];

    $post_data = isset($_POST['data']) ? (array) $_POST['data'] : [];
    if (count($post_data) > 1) {
        $res_errors = [];
        $res_data = [];

        $customer_fields = [
            'customer_name' => '',
            'fullname'      => '',
            'nickname'      => '',
            'phone'         => '',
            'status'        => 'get_statuses',
            'gender'        => 'get_genders',
            'tag'           => '',
            'address'       => '',
			'address1'      => '',
            'point'         => '',
            // 'note'          => '',
        ];

        $location_fields = [
            "address"   => '',
            "ward"      => '',
            "district"  => '',
            "city"      => '79',
        ];

        unset($post_data[0]);

        foreach ($post_data as $row => $columns) {
            $customer = [];
            $address = '';
            $tag = '';
            $empty_count = 0;

            $i = 0;
            foreach ($customer_fields as $field => $get) {
                $value = '';

                if ($get != '') {
                    if (method_exists($em_customer, $get)) {
                        $list = $em_customer->$get();
                        if (is_array($list)) {
                            $list   = array_map('sanitize_title', $list);
                            $search = sanitize_title($columns[$i]);

                            $value = (int) array_search($search, $list);
                        }
                    }
                } else {
                    $value = $columns[$i];
                }

                if($value == '') {
                    $empty_count ++;
                }

                if ($field == 'address') {
                    $address = $value;
                } else if ($field == 'tag') {
                    $tag = $value;
                } else if ($field == 'address1') {
                    $address1 = $value;
                } else {
                    if($field == 'phone') {
                        if(substr($value,0,1) != '0' && strlen($value) == 9) {
                            $value = '0' . $value;
                        }
                    }

                    $customer[$field] = $value;
                }

                $i++;
            }

            if($empty_count == count($customer_fields)) continue;

            $customer['modified'] = current_time('mysql');

            $customer_res = em_api_request('customer/add', $customer);
            if ($customer_res['code'] == 200) {
                $customer_id = (int) $customer_res['data']['insert_id'];

                $em_log->insert([
                    'action'        => 'Tạo',
                    'module'        => 'em_customer',
                    'module_id'     => $customer_id,
                    'content'       => $customer['customer_name']
                ]);

                if ($address != '') {
                    $lines = explode("\n", $address);
                    $active_id = 0;
                    foreach ($lines as $i => $line) {
                        $list = array_map('trim', explode(',', trim($line)));
                        $n = count($list);
                        
                        if($n < 3) continue;
    
                        $location = $location_fields;
                        
                        $location["customer_id"] = $customer_id;
                        $location["active"]     = $active_id == 0 ? 1 : 0;
                        $location["district"]   = $list[$n - 1];
                        unset($list[$n - 1]);
                        $location["ward"] = $list[$n - 2];
                        unset($list[$n - 2]);
                        $location["address"] = implode(', ', $list);
                        
                        $location_res = em_api_request('location/add', $location);
                        if ($location_res['code'] == 200) {
                            $active_id = 1;
                        } else {
                            unset($lines[$i]);
                        }
                    }

                    if(count($lines) > 0) {
                        $customer_res['locations'] = implode("; ", $lines);
                    }
                }
				
				if ($address1 != '') {
                    $lines = explode("\n", $address1);
                    $active_id = 0;
                    foreach ($lines as $i => $line) {
                        $list = array_map('trim', explode(',', trim($line)));
                        $n = count($list);
                        
                        if($n < 3) continue;
    
                        $location = $location_fields;
                        
                        $location["customer_id"] = $customer_id;
                        $location["active"]     = $active_id == 0 ? 1 : 0;
                        $location["district"]   = $list[$n - 1];
                        unset($list[$n - 1]);
                        $location["ward"] = $list[$n - 2];
                        unset($list[$n - 2]);
                        $location["address"] = implode(', ', $list);
                        
                        $location_res = em_api_request('location/add', $location);
                        if ($location_res['code'] == 200) {
                            $active_id = 1;
                        } else {
                            unset($lines[$i]);
                        }
                    }

                    if(count($lines) > 0) {
                        $customer_res['locations'] = implode("; ", $lines);
                    }
                }

                if ($tag != '') {
                    $tags = array_map('trim', explode(',', trim($tag)));
                    $list_tags = array_map('sanitize_title', $em_customer->get_tags());
                    $tag_ids = [];

                    foreach($tags as $i => $tag_name) {
                        $search = sanitize_title($tag_name);
                        $tag_id = (int) array_search($search, $list_tags);

                        if($tag_id > -1 && in_array($tag_id, $tag_ids) == false) {
                            $tag_ids[] = $tag_id;
                            
                            $em_customer_tag->insert([
                                'tag_id' => $tag_id,
                                'customer_id' => $customer_id
                            ]);
                        } else {
                            unset($tags[$i]);
                        }
                    }

                    if(count($tags) > 0) {
                        $customer_res['tags'] = implode("; ", $tags);
                    }
                }
            } else {
                $customer_res['data'] = implode("; ", $customer_res['data']);
            }

            $res_data[$row] = $customer_res;
        }

        if (count($res_errors) > 0) {
            $response['errors'] = $res_errors;
            $response['code'] = 400;
            $response['message'] = 'Import errors';
        }

        $response['data'] = $res_data;
    }

    return $response;
}
