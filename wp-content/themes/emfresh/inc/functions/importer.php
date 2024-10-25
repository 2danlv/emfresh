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

function site_importer_export_customer()
{
    $response = em_api_request('customer/list', [
        'limit' => -1
    ]);

    if ($response['code'] == 200 && count($response['data']) > 0) {
        $customer_labels = [
            'fullname'      => 'Tên khách hàng',
            'nickname'      => 'Họ và tên',
            'phone'         => 'Số điện thoại',
            'status_name'   => 'Tình trạng',
            'gender_name'   => 'Giới tính',
            'note'          => 'Ghi chú',
            'tag_name'      => 'Phân loại',
            'address'       => 'Địa chỉ',
            'point'         => 'Điểm tích lũy',
        ];

        $location_fields = [
            "address",
            "ward",
            "district",
            "city"
        ];

        $items = $response['data'];

        foreach ($items as $i => $customer) {
            $res = em_api_request('location/list', [
                'customer_id' => $customer['id'],
                'limit' => 5
            ]);

            if ($res['code'] == 200) {
                $addresses = [];

                foreach ($res['data'] as $location) {
                    $columns = [];

                    foreach ($location_fields as $field) {
                        $columns[] = isset($location[$field]) ? $location[$field] : '';
                    }

                    $addresses[] = implode(",", $columns);
                }

                $customer['address'] = implode("\n", $addresses);
            }

            $rows = [];

            foreach ($customer_labels as $field => $label) {
                // $label = ucwords(str_replace('_', ' ', $field));

                $rows[$label] = isset($customer[$field]) ? $customer[$field] : '';
            }

            $items[$i] = $rows;
        }

        $response['data'] = $items;
    }

    return $response;
}

function site_importer_import_customer()
{
    $response = ['code' => 200, 'message' => 'Import success'];

    $post_data = isset($_POST['data']) ? (array) $_POST['data'] : [];
    if (count($post_data) > 1) {
        $res_errors = [];
        $res_data = [];

        global $em_customer;

        $customer_fields = [
            'fullname'      => '',
            'nickname'      => '',
            'phone'         => '',
            'status'        => 'get_statuses',
            'gender'        => 'get_genders',
            'note'          => '',
            'tag'           => 'get_tags',
            'address'       => '',
            'point'         => '',
        ];

        $location_fields = [
            "address",
            "ward",
            "district",
            "city"
        ];

        unset($post_data[0]);

        foreach ($post_data as $row => $columns) {
            $customer = [];
            $address = '';
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
                if ($customer_id > 0 && $address != '') {
                    $lines = explode("\n", $address);
                    $active_id = 0;
                    foreach ($lines as $line) {
                        $list = explode(',', trim($line));

                        if (count($list) == count($location_fields)) {
                            $location = [
                                'customer_id' => $customer_id,
                                'active' => $active_id == 0 ? 1 : 0
                            ];

                            foreach ($location_fields as $i => $field) {
                                $location[$field] = sanitize_text_field($list[$i]);
                            }

                            $location_res = em_api_request('location/add', $location);
                            if ($location_res['code'] == 200) {
                                $active_id = 1;
                            }
                        }
                    }
                }
            } else {
                $customer_res['data'] = implode(", ", $customer_res['data']);
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
