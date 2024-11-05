<?php
/**
 * Template Name: Detail-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_customer, $em_order, $em_customer_tag;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
	$customer_id   = intval($_POST['customer_id']);
	$customer_data = [
		'id' => $customer_id,
	];
	$response = em_api_request('customer/delete', $customer_data);
	wp_redirect(esc_url(add_query_arg([
		'message' => 'Delete Success',
	], '/customer/')));
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
	$note_shipping = isset($_POST['note_shipping']) ? sanitize_textarea_field($_POST['note_shipping']) : '';
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
		'note_shipping' => $note_shipping,
		'note_cook'     => $note_cook,
		'order_payment_status'     => $order_payment_status,
		'tag'           => $tag_post,
		'point'         => $point,
	];
	$response_update = em_api_request('customer/update', $customer_data);
	if ($customer_id == 0) {
		wp_redirect(home_url('customer'));
		exit();
	}
	foreach ($_POST['locations'] as $location) {
		// thêm data cho location
		$address = isset($location['address']) ? sanitize_text_field($location['address']) : '';
		$ward = isset($location['ward']) ? sanitize_text_field($location['ward']) : '';
		$district = isset($location['district']) ? sanitize_text_field($location['district']) : '';
		$city = isset($location['province']) ? sanitize_text_field($location['province']) : '79';
		$active = isset($location['active']) ? intval($location['active']) : 0;
		$location_data = [
			'customer_id'   => $customer_id,
			'active'        => $active,
			'address'       => $address,
			'ward'          => $ward,
			'district'      => $district,
			'city'          => $city
		];
		if (isset($location['id']) && intval($location['id']) > 0) {
			$location_data['id'] = $location['id'];
			$response_location = em_api_request('location/update', $location_data);
		} else {
			$response_location = em_api_request('location/add', $location_data);
		}
	}
	if (isset($_POST['tag_ids'])) {
		$customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
		$count = 0;
		if (count($_POST['tag_ids']) > 0) {
			foreach ($_POST['tag_ids'] as $i => $tag_id) {
				$tag_id = (int) $tag_id;
				if ($tag_id == 0) continue;
				if (isset($customer_tags[$i])) {
					$em_customer_tag->update([
						'tag_id' => $tag_id,
						'id' => $customer_tags[$i]['id']
					]);
				} else {
					$em_customer_tag->insert([
						'tag_id' => $tag_id,
						'customer_id' => $customer_id
					]);
				}
				$count++;
			}
		}
		for ($i = $count; $i < count($customer_tags); $i++) {
			$em_customer_tag->delete($customer_tags[$i]['id']);
		}
	}
	// xóa location
	if (!empty($_POST['location_delete_ids'])) {
		$delete_ids = explode(',', sanitize_text_field($_POST['location_delete_ids']));
		foreach ($delete_ids as $delete_id) {
			$delete_id = (int) $delete_id;
			if ($delete_id > 0) {
				$response = em_api_request('location/delete', ['id' => $delete_id]);
			}
		}
	}
	// echo "<meta http-equiv='refresh' content='0'>";
	wp_redirect(add_query_arg([
		'customer_id' => $customer_id,
		'code' => 200,
		'message' => 'Update Success',
	], get_permalink()));
	exit();
}
$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$list_tags    = $em_customer->get_tags();
$actives = $em_customer->get_actives();
// lấy 1 customer
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
$customer_filter = [
	'id' => $customer_id
];
$response_customer = em_api_request('customer/item', $customer_filter);
if ($customer_id == 0 || count($response_customer['data']) == 0) {
	wp_redirect(esc_url('/customer/'));
	exit;
}
// lấy danh sách location
$location_filter = [
	'customer_id' => $customer_id,
	'limit' => 5,
];
$response_get_location = em_api_request('location/list', $location_filter);
$list_cook = custom_get_list_cook();
$list_notes = custom_get_list_notes();
$list_payment_status = $em_order->get_statuses();
$customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
$tag_ids = custom_get_list_by_key($customer_tags, 'tag_id');
get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer">
	<!-- Content Header (Page header) -->
	<h1><?php echo $response_customer['data']['nickname'] ?></h1>
	<!-- Main content -->
	<section class="content">
		<?php
		if (isset($_GET['code']) && $_GET['code'] == 200 && $_GET['message'] == 'Update Success') {
			echo '<div class="alert alert-success mb-16" role="alert">Cập nhật thành công</div>';
		} else if (isset($_GET['code']) && $_GET['code'] != 200) {
			echo '<div class="alert alert-warning mb-16" role="alert">Cập nhật không thành công</div>';
		}
		if (isset($_GET['message']) && $_GET['code'] == 200 && $_GET['message'] == 'Add Success') {
			echo '<div class="alert alert-success mb-16" role="alert">Thêm thành công</div>';
		}
		?>
		<div class="container-fluid">
			<div class="card-header">
				<ul class="nav tabNavigation">
					<li class="nav-item defaulttab" rel="info">Thông tin khách hàng</li>
					<li class="nav-item" rel="note">Ghi chú</li>
					<li class="nav-item" rel="settings">Chỉnh sửa thông tin</li>
					<li class="nav-item" rel="history">Lịch sử thao tác</li>
				</ul>
			</div>
			<div class="card-primary">
				<div class="row">
					<div class="col-4">
						<!-- About Me Box -->
						<div class="card ">
							<!-- /.card-header -->
							<div class="card-body">
								<div class="ttl">
									Thông tin chi tiết
								</div>
								<div class="d-f jc-b pt-16">
									<span>Số điện thoại:</span>
									<span class="copy" title="Copy: <?php echo $response_customer['data']['phone']; ?>"><?php echo $response_customer['data']['phone'] ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Giới tính:</span>
									<span class="text-capitalize"><?php echo $response_customer['data']['gender_name'] ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Trạng thái khách hàng:</span>
									<span class="text-capitalize"><?php echo $response_customer['data']['status_name'] ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số đơn:</span>
									<span>12</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số ngày ăn:</span>
									<span>60</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số phần ăn:</span>
									<span>60</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số phần ăn:</span>
									<span>60</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Tổng tiền đã chi:</span>
									<span>4.000.000</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Điểm tích luỹ:</span>
									<span><?php echo $response_customer['data']['point'] ?></span>
								</div>
								<div class="d-f jc-b pt-8 pb-4">
									<span>Lịch sử đặt gần nhất:</span>
									<span>08:31 29/09/2024</span>
								</div>
								<hr>
								<div class="d-f jc-b pt-8">
									<span>Ghi chú dụng cụ ăn:</span>
									<span>chỉ DC</span>
								</div>
								<div class="d-f jc-b pt-8 ai-center">
									<span>Tag phân loại:</span>
									<?php foreach ($customer_tags as $item) : $tag = $item['tag_id']; ?>
										<span class="tag btn btn-sm tag_<?php echo $tag; ?>"><?php echo isset($list_tags[$tag]) ? $list_tags[$tag] : ''; ?></span>
									<?php endforeach; ?>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>
					</div>
					<!-- /.col -->
					<div class="col-8">
						<div class="card-body">
							<div class="tab-content">
								<div class="active tab-pane" id="info">
									<div class="card mb-16">
										<div class="ttl">
											Thông tin chi tiết
										</div>
										<?php
										foreach ($response_get_location['data'] as $index => $record) {
										?>
											<div class="d-f jc-b pt-16">
												<span><?php echo $record['address'] ?>,
													<?php echo $record['ward'] ?>,
													<?php echo $record['district'] ?>, Thành phố Hồ Chí Minh
												</span>
												<?php if ($record['active'] == 1) { ?>
													<span class="badge badge-warning">Mặc định</span>
												<?php } ?>
											</div>
										<?php
										}
										?>
									</div>
									<div class="card">
										<div class="ttl">
											Lịch sử đặt đơn
										</div>
										<table>
											<tr>
												<th class="nowrap">Mã đơn</th>
												<th class="nowrap">Mã gói sản phẩm</th>
												<th>Ngày <br>
												bắt đầu</th>
												<th>Ngày<br>
												kết thúc</th>
												<th>Tổng tiền</th>
												<th>Trạng thái<br>
												thanh toán</th>
												<th>Trạng thái<br>
												đơn hàng</th>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="note">
									<div class="card">
										<div class="ttl">
											Ghi chú
										</div>
										<div class="note-wraper pt-16 pb-16">
											<div class="row">
												<div class="account-name d-f ai-center col-6">
													<div class="avatar">
														<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/User.svg" alt="">
													</div>
													<div>em.fresh account test</div>
												</div>
												<div class="edit col-3 ">
													<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/edit-2-svgrepo-com.svg" alt="">
													<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/bin.svg" alt="">
													<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pin-svgrepo-com.svg" alt="">
												</div>
												<div class="time col-3">08:31 29/09/2024</div>
											</div>
											<div class="note-content">
												Some contents
											</div>
										</div>
										<div class="note-form">
											<textarea name="" id="" placeholder="Nhập emter để gửi"></textarea>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="settings">
									<form class="form-horizontal" method="POST" action="<?php the_permalink() ?>?customer_id=<?php echo $customer_id ?>">
										<?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
										<div class="form-group row">
											<div class="col-sm-3"><label>Active</label></div>
											<div class="col-sm-9 text-capitalize">
												<?php
												foreach ($actives as $value => $label) { ?>
													<div class="icheck-primary d-inline mr-2 text-capitalize">
														<input type="radio" id="radioActive<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked($response_customer['data']['active'], $value); ?> name="active" required>
														<label for="radioActive<?php echo $value; ?>">
															<?php echo $label; ?>
														</label>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="inputName">Tên tài khoản (*)</label></div>
											<div class="col-sm-9">
												<input type="text" name="nickname" class="nickname form-control" value="<?php echo $response_customer['data']['nickname'] ?>" required>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="fullname">Tên thật</label></div>
											<div class="col-sm-9"><input type="text" id="fullname" name="fullname" value="<?php echo $response_customer['data']['fullname'] ?>" class="fullname form-control"></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="customer_name">Tên khách hàng</label></div>
											<div class="col-sm-9">
												<input type="text" name="customer_name" readonly class="customer_name form-control" value="<?php echo $response_customer['data']['customer_name'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="phone">Số điện thoại (*)</label></div>
											<div class="col-sm-9"><input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $response_customer['data']['phone'] ?>" required></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label>Giới tính (*)</label></div>
											<div class="col-sm-9 text-capitalize">
												<?php
												foreach ($gender as $value => $label) { ?>
													<div class="icheck-primary d-inline mr-2 text-capitalize">
														<input type="radio" id="radioPrimary<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked($response_customer['data']['gender'], $value); ?> name="gender" required>
														<label for="radioPrimary<?php echo $value; ?>">
															<?php echo $label; ?>
														</label>
													</div>
												<?php } ?>
											</div>
										</div>
										<div id="location-fields">
											<?php foreach ($response_get_location['data'] as $index => $record) { ?>
												<hr>
												<div class="address-group location_<?php echo ($record['active']) ?>">
													<input type="hidden" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" />
													<div class="form-group row">
														<div class="col-sm-3"></div>
														<div class="col-sm-9">
															<div class="icheck-primary d-inline mr-2">
																<input type="radio" name="location_active" id="active_<?php echo $record['id'] ?>" value="<?php echo $record['id'] ?>" <?php checked($record['active'], 1) ?>>
																<input type="hidden" class="location_active" name="locations[<?php echo $index ?>][active]" value="<?php echo $record['active'] ?>" />
																<label for="active_<?php echo $record['id'] ?>">
																	Mặc định
																</label>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-3"><label for="province_<?php echo $record['id'] ?>">Tỉnh/Thành phố:</label></div>
														<div class="col-sm-9">
															<select id="province_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][province]" class="province-select form-control" required>
																<option value="<?php echo $record['city']; ?>" selected><?php echo $record['city']; ?></option>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-3"><label for="district_<?php echo $record['id'] ?>">Quận/Huyện:</label></div>
														<div class="col-sm-9">
															<select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control" required>
																<option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-3"><label for="ward_<?php echo $record['id'] ?>">Phường/Xã:</label></div>
														<div class="col-sm-9">
															<select id="ward_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][ward]" class="ward-select form-control" required>
																<option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-3"><label for="address_<?php echo $record['id'] ?>">Địa chỉ (*):</label></div>
														<div class="col-sm-9"><input id="address_<?php echo $record['id'] ?>" class="form-control" value="<?php echo $record['address']; ?>" name="locations[<?php echo $index ?>][address]" required /></div>
													</div>
													<p class="text-right"><span class="btn bg-gradient-danger delete-location-button" data-id="<?php echo $record['id'] ?>">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
												</div>
											<?php } ?>
										</div>
										<p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
										<hr>
										<div class="form-group row">
											<div class="col-sm-3"><label>Ghi chú dụng cụ ăn</label></div>
											<div class="col-sm-9">
												<select class="form-control text-capitalize" name="note_cook" style="width: 100%;" required>
													<?php foreach ($list_cook as $value) { ?>
														<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['note_cook'], $value); ?>><?php echo $value; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<div class="col-sm-3"><label>Ghi chú yêu cầu ăn đặc biệt</label></div>
											<div class="col-sm-9 js-list-note">
												<div class="mb-3">
													<textarea name="note" class="form-control" rows="2"><?php echo $response_customer['data']['note']; ?></textarea>
												</div>
												<p>
													<?php
													$list_values = array_map('trim', explode(',', $response_customer['data']['note']));
													foreach ($list_notes as $value) { ?>
														<button type="button" class="btn btn-outline-primary<?php echo in_array($value, $list_values) ? ' active' : '' ?>"><?php echo $value; ?></button>
													<?php } ?>
												</p>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<div class="col-sm-3"><label>Ghi chú giao hàng đặc biệt</label></div>
											<div class="col-sm-9"><textarea name="note_shipping" class="form-control" rows="2"><?php echo $response_customer['data']['note_shipping']; ?></textarea></div>
										</div>
										<hr>
										<div class="form-group row">
											<div class="col-sm-3"><label for="inputPaymentStatus">Trạng thái thanh toán</label></div>
											<div class="col-sm-9"><select id="inputPaymentStatus" name="order_payment_status" class="form-control custom-select text-capitalize">
													<option value="">Select one</option>
													<?php
													foreach ($list_payment_status as $key => $value) { ?>
														<option value="<?php echo $key; ?>" <?php selected($response_customer['data']['order_payment_status'], $key); ?>><?php echo $value; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
											<div class="col-sm-9">
												<select id="inputStatus" name="status" class="form-control custom-select text-capitalize">
													<option value="0">Select one</option>
													<?php
													foreach ($status as $value => $label) { ?>
														<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['status'], $value); ?>><?php echo $label; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="inputTag">Tag phân loại</label></div>
											<div class="col-sm-9 text-capitalize">
												<select class="form-control text-capitalize select2" multiple="multiple" name="tag_ids[]" style="width: 100%;">
													<option value="0">Select one</option>
													<?php
													foreach ($list_tags as $value => $label) { ?>
														<option value="<?php echo $value; ?>" <?php echo in_array($value, $tag_ids) ? 'selected' : ''; ?>><?php echo $label; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
											<div class="col-sm-9"><input type="number" id="inputPoint" name="point" value="<?php echo intval($response_customer['data']['point']); ?>" class="form-control"></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-9">
												<button type="submit" class="btn btn-primary" name="add_post">Cập nhật</button>
											</div>
											<?php
											$admin_role = wp_get_current_user()->roles;
											if (!empty($admin_role)) {
												if ($admin_role[0] == 'administrator') {
											?>
													<div class="col-sm-3 text-right">
														<button type="button" class="btn btn-danger remove-customer" data-toggle="modal" data-target="#modal-default">
															<i class="fas fa-trash">
															</i>
															Xóa khách hàng
														</button>
													</div>
											<?php }
											} ?>
										</div>
										<input type="hidden" name="customer_id" value="<?php echo $customer_id ?>" />
										<input type="hidden" name="location_delete_ids" value="" class="location_delete_ids" />
									</form>
								</div>
								<div class="tab-pane" id="history">
									<div class="card">
										<table>
											<tr>
												<th>User</th>
												<th>Action</th>
												<th>Description</th>
												<th>Time</th>
												<th>Date</th>
											</tr>
											<tr>
											<td>Nhu Quynh</td>
											<td>xoá</td>
											<td class="nowrap">ghi chú 
											T3 (21/4) giao về Toà nhà Riverbank, 3C Tôn Đức Thắng, Phường Bến Nghé, Quận 1</td>
											<td>01:00</td>
											<td>29/10/24</td>
											</tr>
											
											
										</table>
									</div>
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<div class="modal fade" id="modal-default" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Thông báo!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form method="post" id="list-customer" action="<?php the_permalink() ?>">
				<div class="modal-body">
					<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $response_customer['data']['id'] ?>">
					<p>Bạn muốn xóa khách hàng: <b><?php echo $response_customer['data']['nickname'] ?></b>?</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
					<button type="submit" name="remove" class="btn btn-danger"><i class="fas fa-trash"></i> Xóa!</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
</style>
<?php
// endwhile;
get_footer('customer');
?>
<script src="<?php echo site_get_template_directory_assets(); ?>js/assistant.js"></script>
<script src="<?php echo site_get_template_directory_assets(); ?>js/location.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.nickname').keyup(updatetxt);
		$('.fullname').keyup(updatetxt);
		function updatetxt() {
			$('.customer_name').val($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
		}
		$('.js-list-note').each(function() {
			let p = $(this);
			$('.btn', p).on('click', function() {
				let input = $('textarea', p),
					list = input.val() || '',
					btn = $(this),
					text = btn.text();
				list = (list != '' ? list.split(',') : []).map(v => v.trim());
				if (btn.hasClass('active')) {
					let tmp = [];
					list.forEach(function(v, i) {
						if (v != text) {
							tmp.push(v);
						}
					})
					list = tmp;
					btn.removeClass('active');
				} else {
					list.push(text);
					btn.addClass('active');
				}
				input.val(list.join(", "));
			});
		});
		var fieldCount = <?php echo count($response_get_location['data']); ?>;
		var maxFields = 5;
		$(document).on('click', '.delete-location-button', function(e) {
			e.preventDefault();
			let btn = $(this),
				id = parseInt(btn.data('id') || 0);
			btn.closest('.address-group').remove(); // Remove only the closest address group
			// fieldCount = fieldCount + 1;
			// console.log('log',fieldCount);
			if (id > 0) {
				let l_d = $('.location_delete_ids');
				l_d.val(id + (l_d.val() != '' ? ',' + l_d.val() : ''));
			}
		});
		// Fetching data from the new API endpoint
	});
</script>