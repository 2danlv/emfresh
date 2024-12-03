<?php

function site_customer_submit_form()
{
    if (! is_page_template('page-templates/list-customer.php')) {
        site_customer_submit_list_page();
    } else if (! is_page_template('page-templates/detail-customer.php')) {
        site_customer_submit_detail_page();
    }
}
add_action('wp', 'site_customer_submit_form');

function site_customer_submit_list_page() {}

function site_customer_submit_detail_page()
{
    global $em_customer, $em_location, $em_order, $em_customer_tag, $em_log;

    $_GET = wp_unslash($_GET);
    $_POST = wp_unslash($_POST);

    $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

    $list_customer_url         = home_url('customer');
    $detail_customer_url     = add_query_arg(['customer_id' => $customer_id], get_permalink());

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
        $customer_id   = intval($_POST['customer_id']);

        $customer_old = $em_customer->get_item($customer_id);

        $customer_data = [
            'id' => $customer_id,
        ];
        $response = em_api_request('customer/delete', $customer_data);

        if ($response['code'] == 200) {
            // Log delete
            $em_log->insert([
                'action'        => 'Xóa',
                'module'        => 'em_customer',
                'module_id'     => $customer_id,
                'content'       => $customer_old['customer_name']
            ]);
        }

        wp_redirect(add_query_arg([
            'message' => 'Delete Success',
            'expires' => time() + 3,
        ], $list_customer_url));
        exit;
    }

    // cập nhật data cho customer
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
        $customer_id = intval($_POST['customer_id']);
        $nickname   = isset($_POST['nickname']) ? sanitize_text_field($_POST['nickname']) : '';
        $fullname   = isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']) : '';
        $customer_name   = isset($_POST['customer_name']) ? sanitize_text_field($_POST['customer_name']) : '';
        $phone      = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $gender_post = isset($_POST['gender']) ? intval($_POST['gender']) : 0;
        $status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $active_post = isset($_POST['active']) ? intval($_POST['active']) : 0;
        $tag_post    = isset($_POST['tag']) ? intval($_POST['tag']) : 0;
        $point = isset($_POST['point']) ? intval($_POST['point']) : 0;
        $note = isset($_POST['note']) ? sanitize_textarea_field($_POST['note']) : '';
        $note_cook = isset($_POST['note_cook']) ? sanitize_textarea_field($_POST['note_cook']) : '';
        $order_payment_status = isset($_POST['order_payment_status']) ? sanitize_textarea_field($_POST['order_payment_status']) : '';

        $customer_data = [
            'id'            => $customer_id,
            'nickname'      => $nickname,
            'fullname'      => $fullname,
            'customer_name' => $customer_name,
            'phone'         => $phone,
            'active'        => $active_post,
            'status'        => $status_post,
            'gender'        => $gender_post,
            'note'          => $note,
            'note_cook'     => $note_cook,
            'order_payment_status' => $order_payment_status,
            'tag'           => $tag_post,
            'point'         => $point,
        ];

        $customer_old = $em_customer->get_item($customer_id);

        $response_update = em_api_request('customer/update', $customer_data);
        if ($customer_id == 0) {
            wp_redirect($list_customer_url);
            exit();
        }

        $log_labels = [
            'customer_name'    => 'Tên khách hàng',
            'phone'         => 'Số điện thoại',
            'gender'        => 'Giới tính',
            'note_cook'     => 'Ghi chú dụng cụ ăn',
            'point'         => 'Điểm tích lũy',
        ];

        $log_location_labels = [
            'address'        => '',
            'ward'            => '',
            'district'        => '',
        ];

        $log_note_labels = [
            'note_shipper'    => 'Note với shipper',
            'note_admin'    => 'Note với admin',
        ];

        $log_change = [];

        foreach ($log_labels as $key => $label) {
            $old = isset($customer_old[$key]) ? $customer_old[$key] : null;
            $new = isset($customer_data[$key]) ? $customer_data[$key] : null;

            if ($new != null && $new != $old) {
                if ($key == 'gender') {
                    $new = $em_customer->get_genders($new);
                }

                $log_change[] = sprintf('<span class="memo field-%s">%s</span><span class="note-detail">%s</span>', $key, $label, $new);
            }
        }

        foreach ($_POST['locations'] as $location) {
            // thêm data cho location
            $location_id = isset($location['id']) ? intval($location['id']) : 0;
            $address = isset($location['address']) ? sanitize_text_field($location['address']) : '';
            $ward = isset($location['ward']) ? sanitize_text_field($location['ward']) : '';
            $district = isset($location['district']) ? sanitize_text_field($location['district']) : '';
            $city = isset($location['province']) ? sanitize_text_field($location['province']) : '79';
            $active = isset($location['active']) ? intval($location['active']) : 0;
            $note_shipper = isset($location['note_shipper']) ? sanitize_text_field($location['note_shipper']) : '';
            $note_admin = isset($location['note_admin']) ? sanitize_text_field($location['note_admin']) : '';

            $location_data = [
                'customer_id'   => $customer_id,
                'active'        => $active,
                'address'       => $address,
                'ward'          => $ward,
                'district'      => $district,
                'city'          => $city,
                'note_shipper'  => $note_shipper,
                'note_admin'    => $note_admin,
            ];

            $address_new = [];
            foreach ($log_location_labels as $key => $label) {
                $address_new[] = isset($location_data[$key]) ? $label . $location_data[$key] : '';
            }
            $address_new = implode(', ', $address_new);

            if ($location_id > 0) {
                $location_old = $em_location->get_item($location_id);

                $location_data['id'] = $location_id;

                $response_location = em_api_request('location/update', $location_data);

                $address_old = [];
                foreach ($log_location_labels as $key => $label) {
                    $address_old[] = isset($location_old[$key]) ? $label . $location_old[$key] : '';
                }
                $address_old = implode(', ', $address_old);

                $check_active = ($active == 1 && $location_old['active'] == 0);

                if ($address_old != $address_new) {
                    $log_change[] = sprintf('<span class="memo field-location">%s</span><span class="note-detail">%s</span>', 'Cập nhật địa chỉ' . ($check_active ? ' và đặt làm mặc định.' : ''), $address_new);
                } else if ($check_active) {
                    $log_change[] = sprintf('<span class="memo field-location">Đặt địa chỉ mặc định</span><span class="note-detail">%s</span>', $address_new);
                }

                foreach ($log_note_labels as $key => $label) {
                    $new_value = isset($location_data[$key]) ? $location_data[$key] : '';
                    $old_value = isset($location_old[$key]) ? $location_old[$key] : '';

                    if ($new_value != $old_value) {
                        $log_change[] = sprintf('<span class="memo field-location">%s</span><span class="note-detail">%s</span>', $label, $new_value);
                    }
                }
            } else {
                $response_location = em_api_request('location/add', $location_data);

                $log_change[] = sprintf('<span class="memo field-location">%s</span><span class="note-detail">%s</span>', 'Thêm địa chỉ' . ($active == 1 ? ' và đặt làm mặc định.' : ''), $address_new);
            }
        }

        if (isset($_POST['tag_ids'])) {
            $customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
            $tag_ids = custom_get_list_by_key($customer_tags, 'tag_id');

            $tag_inserts = array_diff($_POST['tag_ids'], $tag_ids);
            $tag_removes = array_diff($tag_ids, $_POST['tag_ids']);
            $result = array_merge($tag_inserts, $tag_removes);

            if (count($result) > 0) {
                $em_customer_tag->update_list($customer_id, $_POST['tag_ids']);

                foreach ($tag_inserts as $tag_id) {
                    $log_change[] = sprintf('<span class="memo field-tag">Thêm Tag phân loại</span><span class="note-detail">%s</span>', $em_customer->get_tags($tag_id));
                }

                foreach ($tag_removes as $tag_id) {
                    $log_change[] = sprintf('<span class="memo field-tag">Xóa Tag phân loại</span><span class="note-detail">%s</span>', $em_customer->get_tags($tag_id));
                }
            }
        }

        // xóa location
        if (!empty($_POST['location_delete_ids'])) {
            $delete_ids = explode(',', sanitize_text_field($_POST['location_delete_ids']));
            foreach ($delete_ids as $delete_id) {
                $delete_id = (int) $delete_id;
                if ($delete_id > 0) {
                    $location_old = $em_location->get_item($delete_id);

                    $address_old = [];
                    foreach ($log_location_labels as $key => $label) {
                        $address_old[] = isset($location_old[$key]) ?     $label . $location_old[$key] : '';
                    }
                    $address_old = implode(', ', $address_old);

                    $log_change[] = sprintf('<span class="memo field-location">Xóa Địa chỉ</span><span class="note-detail">%s</span>', $address_old);

                    $response = em_api_request('location/delete', ['id' => $delete_id]);
                }
            }
        }

        // Log update
        if (count($log_change) > 0 && implode('', $log_change) != '') {
            $em_log->insert([
                'action'        => 'Cập nhật',
                'module'        => 'em_customer',
                'module_id'     => $customer_id,
                'content'       => implode("\n", $log_change)
            ]);
        }

        // echo "<meta http-equiv='refresh' content='0'>";
        wp_redirect(add_query_arg([
            'code' => 200,
            'message' => 'Update Success',
            'expires' => time() + 3,
        ], $detail_customer_url));
        exit();
    }
}
