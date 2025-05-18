<?php

function site_importer_action()
{
	$data = wp_unslash($_POST);

	if (empty($data['importoken']) || ! wp_verify_nonce($data['importoken'], 'importoken')) {
		return;
	}

	$response = [];

	$export = isset($data['export']) ? trim($data['export']) : '';
	$import = isset($data['import']) ? trim($data['import']) : '';

	if ($export == 'customer') {
		$response = site_importer_customer_export();
	} else if ($export == 'order') {
		$response = site_importer_order_export();
	} else if ($import == 'customer') {
		$response = site_importer_customer_import();
	} else if ($import == 'order') {
		$response = site_importer_order_import();
	}

	header('Content-type: application/json');
	echo wp_json_encode($response);
	exit();
}
add_action('wp', 'site_importer_action');

/* 
 * Customer
 */
function site_importer_customer_export()
{
	global $em_customer_tag;

	$response = em_api_request('customer/list', [
		'limit' => -1
	]);

	if ($response['code'] == 200 && count($response['data']) > 0) {
		$customer_labels = [
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
				if ($field == 'tag_name') {
					$customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
					$tag_names = [];

					foreach ($customer_tags as $item) {
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

function site_importer_customer_import()
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

			$index = 0;
			foreach ($customer_fields as $field => $get) {
				$value = isset($columns[$index]) ? sanitize_text_field($columns[$index]) : '';

				if ($get != '') {
					if (method_exists($em_customer, $get)) {
						$list = $em_customer->$get();
						if (is_array($list)) {
							$list   = array_map('sanitize_title', $list);
							$search = sanitize_title($value);

							$value = (int) array_search($search, $list);
						}
					}
				}

				if ($value == '') {
					$empty_count++;
				}

				if ($field == 'address') {
					$address = $value;
				} else if ($field == 'tag') {
					$tag = $value;
				} else {
					if ($field == 'phone') {
						if (substr($value, 0, 1) != '0' && strlen($value) == 9) {
							$value = '0' . $value;
						}
					}

					$customer[$field] = $value;
				}

				$index++;
			}

			if ($empty_count == count($customer_fields)) continue;

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

						if ($n < 3) continue;

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

					if (count($lines) > 0) {
						$customer_res['locations'] = implode("; ", $lines);
					}
				}

				if ($tag != '') {
					$tags = array_map('trim', explode(',', trim($tag)));
					$list_tags = array_map('sanitize_title', $em_customer->get_tags());
					$tag_ids = [];

					foreach ($tags as $i => $tag_name) {
						$search = sanitize_title($tag_name);
						$tag_id = (int) array_search($search, $list_tags);

						if ($tag_id > -1 && in_array($tag_id, $tag_ids) == false) {
							$tag_ids[] = $tag_id;

							$em_customer_tag->insert([
								'tag_id' => $tag_id,
								'customer_id' => $customer_id
							]);
						} else {
							unset($tags[$i]);
						}
					}

					if (count($tags) > 0) {
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

/* 
 * Order
 */
function site_importer_order_export()
{
	global $em_order, $em_order_item;

	$response = em_api_request('order/list', [
		'limit' => -1
	]);

	if ($response['code'] == 200 && count($response['data']) > 0) {
		$order_labels = [
			'order_number'  => 'Mã đơn',
			'customer_name' => 'Tên khách hàng',
			'phone' 		=> 'SĐT',
			'location_name' => 'Địa chỉ',
			'order_type' 	=> 'Loại đơn hàng',
			'type_name' 	=> 'Phân loại',
			'item_name' 	=> 'Mã gói sản phẩm',
			'date_start' 	=> 'Ngày bắt đầu đơn',
			'date_stop' 	=> 'Ngày kết thúc đơn',
			'note' => 'Yêu cầu đặc biệt',
			'ships' => 'Giao hàng',
			'status_name' => 'Trạng thái đơn hàng',
			'payment_method_name' => 'Hình thức thanh toán',
			'payment_status_name' => 'Trạng thái thanh toán',
			'total_money' => 'Tổng tiền đơn hàng',
			'remaining_amount' => 'Số tiền còn lại',
			'used_value' => 'Giá trị đã dùng',
			'remaining_value' => 'Giá trị chưa dùng',
			'discount' 		=> 'Giảm giá',
			'paid' 			=> 'Đã thanh toán'
		];

		$order_item_labels = [
			'product_name' 	=> 'Tên SP',
			'type' 			=> 'Loại SP',
			'days' 			=> 'Số ngày ăn',
			'quantity' 		=> 'Số lượng',
			'date_start' 	=> 'Ngày bắt đầu',
			'date_stop' 	=> 'Ngày kết thúc',
			'amount' 		=> 'Thành tiền',
			'auto_choose' 	=> 'Tự chọn món',
			'ship_days' 	=> 'Số ngày phát sinh phí ship',
			'ship_amount' 	=> 'Tổng tiền phí ship',
		];

		$rows = [];

		foreach ($response['data'] as $order) {
			$order_columns = [];

			foreach ($order_labels as $field => $label) {
				if ($field == 'ships') {
					$value = '';

					$ships = $em_order->get_ships($order);
					if (count($ships) > 0) {
						foreach ($ships as $ship) {
							if (!empty($ship['location_name'])) {
								if (!empty($ship['days']) && is_array($ship['days'])) {
									$value .= implode(", ", $ship['days']);
									$value .= ": ";
								}

								$value .= $ship['location_name'] . "; ";
							}
						}
					}

					$order_columns[$label] = $value;
				} else if ($field == 'total_money') {
					$order_columns[$label] = $order['total_amount'] +  $order['ship_amount'];
				} else {
					$order_columns[$label] = isset($order[$field]) ? $order[$field] : '';
				}
			}

			if(empty($order['modified_author_name'])) {
				$order['modified_author_name'] = get_the_author_meta('display_name', $order['modified_at']);
			}

			$order_items = $em_order_item->get_items([
                'limit' => -1,
                'order_id' => $order['id'],
				'orderby' => 'id ASC'
            ]);

			foreach ($order_items as $i => $order_item) {
				$columns = $order_columns;

				$columns['Sản phẩm'] = $i + 1;

				foreach ($order_item_labels as $field => $label) {
					$value = isset($order_item[$field]) ? $order_item[$field] : '';

					if($field == 'type') {
						$value = strtoupper($value);
					}

					$columns[$label] = $value;
				}

				$columns['Nhân viên'] = $order['modified_author_name'];
				$columns['Lần cập nhật cuối'] = isset($order['modified']) ? $order['modified'] : '';

				$rows[] = array_map('trim', $columns);
			}
		}

		$response['data'] = $rows;
	}

	return $response;
}

function site_importer_order_import() {
	global $em_order, $em_order_item, $em_customer, $em_log, $em_location, $em_product;

	$response = ['code' => 200, 'message' => 'Import success'];
	$error_res = ['code' => 400, 'message' => 'Error data', 'data' => ''];

	// site_response_json($_POST['data']);

	$post_data = isset($_POST['data']) ? (array) $_POST['data'] : [];
	if (count($post_data) > 1) {
		$res_errors = [];
		$res_data = [];

		$order_fields = [
			'order_number'  => 'null',	// Mã đơn hàng
			'customer_name_2nd'	=> '',	// Tên khách hàng
			'phone' 		=> '',	// SĐT
			'address' 		=> '',	// Địa chỉ
			'order_type' 	=> '',	// Loại đơn hàng
			'type_name' 	=> '',	// Phân loại
			'item_name' 	=> '',	// Mã gói sản phẩm
			'date_start' 	=> 'date',	// Ngày bắt đầu đơn
			'date_stop' 	=> 'date',	// Ngày kết thúc đơn
			'note' 			=> '',	// Yêu cầu đặc biệt
			'ships' 		=> 'null',	// 
			'status' 		=> 'get_statuses',	// Trạng thái đơn hàng
			'payment_method' => 'get_payment_methods',	// Hình thức thanh toán
			'payment_status' => 'get_payment_statuses',	// Trạng thái thanh toán
			'total_money' => '',	// Tổng tiền đơn hàng
			'remaining_amount' => '',	// Số tiền còn lại
			'used_value' 	=> '',	// Giá trị đã dùng
			'remaining_value' => '',	// Giá trị chưa dùng
			'discount' 		=> '',	// Giảm giá
			'paid' 			=> '',	// Đã thanh toán
		];

		$order_item_fields = [
			'stt' 			=> 'continue', // STT sản phẩm
			'product_id' 	=> 'product_name', // Tên sản phẩm
			'type' 			=> '', // Loại sản phẩm
			'days' 			=> 'number', // Số ngày ăn
			'quantity' 		=> 'number', // Số lượng
			'date_start' 	=> 'date', // Ngày bắt đầu
			'date_stop' 	=> 'date', // Ngày kết thúc
			'amount' 		=> 'number', // Thành tiền
			'auto_choose' 	=> 'number', // Tự chọn món
			'ship_days' 	=> 'continue', // Số ngày phát sinh phí ship
			'ship_amount' 	=> 'continue', // Tổng tiền phí ship
		];

		$location_fields = [
			"address"   => '',
			"ward"      => '',
			"district"  => '',
		];

		unset($post_data[0]);

		$orders = [];

		// $test = [];

		foreach ($post_data as $row => $columns) {
			$order = [];
			$address = '';
			$empty_count = 0;

			$index = 0;
			foreach ($order_fields as $field => $get) {
				$value = isset($columns[$index]) ? sanitize_text_field($columns[$index]) : '';

				if ($get == 'null') {
				} else if ($get == 'continue') {
					$index++;
					continue;
				} else if ($get != '') {
					if (method_exists($em_order, $get)) {
						$list = $em_order->$get();
						if ($value != '' && is_array($list)) {
							$list   = array_map('sanitize_title', $list);
							$search = sanitize_title($value);

							$value = (int) array_search($search, $list);
						} else {
							$value = 0;
						}
					}
				}
				
				if ($value == '') {
					$empty_count++;
				}

				if ($field == 'address') {
					$address = $value;
				} else {
					if ($field == 'phone') {
						if (substr($value, 0, 1) != '0' && strlen($value) == 9) {
							$value = '0' . $value;
						}
					} else if ($get == 'number') {
						$value = (int) $value;
					}

					$order[$field] = $value;

					// $test[] = "[$field]=($value)";
				}

				$index++;
			}

			if ($empty_count == count($order_fields) || empty($order['phone']) || $address == '') {
				$res_errors[$row] = $order;

				$res_data[$row] = shortcode_atts($error_res,['data' => 'Dữ liệu không chính xác!']);

				continue;
			}

			// check and get customer id
			$customers = $em_customer->get_items(['phone' => $order['phone']]);
			if(count($customers) == 0 || empty($customers[0]['id'])) {
				$res_errors[$row] = $order;

				$res_data[$row] = shortcode_atts($error_res,['data' => 'SĐT không tồn tại']);

				continue;
			}
			$customer = $customers[0];
			
			$customer_id = (int) $customer['id'];

			if($customer['customer_name'] == $order["customer_name_2nd"]) {
				$order["customer_name_2nd"] = '';
			}

			$order["customer_id"] = $customer_id;

			$list = array_map('trim', explode(',', $address));
			$n = count($list);

			if ($n < 3) {
				$res_errors[$row] = $list;

				$res_data[$row] = shortcode_atts($error_res,['data' => 'Địa chỉ không chính xác']);

				continue;
			}

			$location = $location_fields;

			$location["customer_id"] = $customer_id;
			$location["district"]   = $list[$n - 1];
			unset($list[$n - 1]);
			$location["ward"] = $list[$n - 2];
			unset($list[$n - 2]);
			$location["address"] = implode(', ', $list);
			
			// check and get location id
			$locations = $em_location->get_items($location);
			if(count($locations) == 0 || empty($locations[0]['id'])) {
				$location["active"] = 0;
				$location["city"] = 79;
				$location_id = (int) $em_location->insert($location);

				if($location_id == 0) {
					$res_errors[$row] = $location;

					$res_data[$row] = shortcode_atts($error_res,['data' => 'Lỗi thêm địa chỉ']);

					continue;
				}
			} else {
				$location_id = $locations[0]['id'];
			}

			$location['id'] = (int) $location_id;

			$order['customer_id'] = $customer_id;
			$order['location_id'] = $location_id;

			// exec order item
			$order_item = [];
			$product = [];
			$empty_count = 0;

			foreach ($order_item_fields as $field => $get) {
				$value = isset($columns[$index]) ? sanitize_text_field($columns[$index]) : '';

				if ($get == 'null') {
				} else if ($get == 'continue') {
					$index++;
					continue;
				} else if ($get == 'product_name') {
					$product = $em_product->get_item_by(['name' => $value]);
					if(empty($product['id'])) {
						$res_errors[$row] = $order_item;

						$res_data[$row] = shortcode_atts($error_res,['data' => 'Tên sản phẩm không chính xác']);

						break;
					}

					$value = (int) $product['id'];
				} else if ($get != '') {
					if (method_exists($em_order_item, $get)) {
						$list = $em_order_item->$get();
						if ($value != '' && is_array($list)) {
							$list   = array_map('sanitize_title', $list);
							$search = sanitize_title($value);

							$value = (int) array_search($search, $list);
						} else {
							$value = 0;
						}
					}
				}

				if ($value == '') {
					$empty_count++;
				}

				if($get == 'date') {
					if(strpos($value, '/') > 0) {
						// d/m/y in excel
						$list = site_uksort_list(explode('/', $value));

						$value = implode('-', $list);

						$value = date('Y-m-d', strtotime($value));
					} else if(strpos($value, '-') == 1) {
						$value = '';
					}
				} else if ($get == 'number') {
					$value = (int) $value;
				}

				$order_item[$field] = $value;

				// $test[] = "[$field]=($value)";

				$index++;
			}

			if ($empty_count == count($order_item_fields) || empty($product['id']) || isset($res_errors[$row])) continue;

			$order_item['days'] = (int) $order_item['days'];

			if ($order_item['date_stop'] == '' && $order_item['date_start'] != '') {
				$order_item['date_stop'] = site_order_get_date_value($order_item['date_start'], $order_item['days']);
			}

			if ($order['date_start'] == '' || $order['date_start'] > $order_item['date_start']) {
				$order['date_start'] = $order_item['date_start'];
			}

			if ($order['date_stop'] == '' || $order['date_stop'] < $order_item['date_stop']) {
				$order['date_stop'] = $order_item['date_stop'];
			}

			$meal_product = $em_order_item->get_meal_product($order_item, $product);
			if(empty($meal_product['meal_number'])) {
				$res_errors[$row] = $meal_product;

				$res_data[$row] = shortcode_atts($error_res,['data' => 'Lỗi tính toán số bữa ăn']);

				continue;
			}
			
			$order_item['meal_number'] 	 = $meal_product['meal_number'];
			$order_item['ship_price'] 	 = $meal_product['ship_price'];
			$order_item['product_price'] = $meal_product['product_price'];
			$order_item['amount'] 		 = $meal_product['amount'];

			// end of exec order item

			$order_key = "customer-{$customer_id}-location-{$location_id}";

			$order_res = [];

			if(empty($orders[$order_key])) {
				$order_res = em_api_request('order/add', $order);
				if($order_res['code'] != 200) {
					$res_errors[$row] = $order;

					$res_data[$row] = shortcode_atts($error_res,['data' => 'Lỗi thêm đơn hàng']);

					continue;
				}

				$order_id = (int) $order_res['data']['insert_id'];

				$order['order_number'] = $em_order->get_order_number($order_id);

				$order['row'] = (int) $row;

				$em_log->insert([
					'action'        => 'Tạo',
					'module'        => 'em_order',
					'module_id'     => $order_id,
					'content'       => 'Mã đơn hàng #'. $order['order_number']
				]);

				// $order_id = 106; // to dev

				$order['id'] = $order_id;

				$orders[$order_key] = $order;
			} else {
				$order = $orders[$order_key];
				$order_id = $order['id'];
			}
			
			// inser order item
			$order_item['order_id']	= $order_id;

			$order_item_id = $em_order_item->insert($order_item);

			$message = sprintf("Thêm sản phẩm số %d %s thành công của đơn hàng #%s %s", 
								$row - $order['row'] + 1, 
								$order_item_id == 0 ? ' không ' : '',
								$order['order_number'],
								count($order_res) > 0 ? '(mới tạo)' : '',
							);

			$res_data[$row] = shortcode_atts($response,['message' => $message]);
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