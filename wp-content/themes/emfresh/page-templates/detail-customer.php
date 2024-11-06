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
	<h1><?php echo $response_customer['data']['customer_name'] ?></h1>
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
					<div class="col-4 about-box">
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
									<span><?php echo $response_customer['data']['note_cook'] ?></span>
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
									<div class="card card-history">
										<div class="ttl">
											Lịch sử đặt đơn
										</div>
										<div class="history-order">
											<table class="nowrap">
												<tr>
													<th>Mã đơn</th>
													<th>Mã gói sản phẩm</th>
													<th>Ngày <br>
														bắt đầu
													</th>
													<th>Ngày<br>
														kết thúc
													</th>
													<th>Tổng tiền</th>
													<th>Trạng thái<br>
														thanh toán</th>
													<th>Trạng thái<br>
														đơn hàng</th>
												</tr>
												<tr>
													<td>97</td>
													<td>2SM+1ET+1EP+1TA</td>
													<td>22/09/24</td>
													<td align="center">-</td>
													<td>400.000</td>
													<td align="center"><span class="status_pay">Rồi</td>
													<td align="center" class="status-order"><span class="status_order">Đang dùng</span></td>
												</tr>
												<tr>
													<td>97</td>
													<td>2SM+1ET+1EP+1TA</td>
													<td>22/09/24</td>
													<td>22/09/24</td>
													<td>400.000</td>
													<td align="center"><span class="status_pay">Rồi</td>
													<td align="center" class="status-order"><span class="status_order">Đang dùng</< /td>
												</tr>
											</table>
										</div>
										<div class="d-f ai-center jc-b pt-16">
											<div class="btn btn-export d-f ai-center">
												<span class="fas fa-export"></span> Xuất Excel
											</div>
											<div class="dt-paging">
												<nav aria-label="pagination">
													<button class="dt-paging-button disabled previous" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1"><i class="fas fa-left"></i></button>
													<button class="dt-paging-button current" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">1</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">2</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">3</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">4</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">5</button>
													<button class="dt-paging-button disabled next" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Next" data-dt-idx="next" tabindex="-1"><i class="fas fa-right"></i></button>
												</nav>
											</div>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="note">
									<div class="card">
										<div class="ttl">
											Ghi chú
										</div>
										<div class="note-wraper pt-16 pb-16">
										<?php
											extract(shortcode_atts([
												'comment' => false
											], (array) $args));

											if (is_object($comment)) :
											?>
											<div class="row row-comment<?php echo $comment->comment_approved == 0 ? 'status-trash' : '' ?>">
												<div class="account-name d-f ai-center col-6">
													<div class="avatar">
														<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/User.svg" alt="">
													</div>
													<div><?php echo $comment->comment_author ?></div>
												</div>
												<div class="edit col-3 ">
													<a href="#editcomment" data-id="<?php echo $comment->comment_ID ?>"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/edit-2-svgrepo-com.svg" alt=""></a>
													<a href="<?php echo site_comment_get_delete_link($comment->comment_ID) ?>"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/bin.svg" alt=""></a>
													<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pin-svgrepo-com.svg" alt="">
												</div>
												<div class="time col-3"><?php echo get_comment_date('d/m/Y', $comment->comment_ID) ?></div>
											</div>
											<div class="note-content">
											<?php echo $comment->comment_content ?> <?php echo $comment->comment_approved ?>
											</div>
											<?php

											endif; ?>
										</div>
										<div class="note-form">
											<?php
											$data = wp_unslash($_GET);
											if (!empty($data['message']) && !empty($data['expire']) && intval($data['expire']) > time()) {
												echo '<p style="color: red">' . site_base64_decode($data['message']) . '</p>';
											}
											?>
											<form action="<?php the_permalink() ?>?customer_id=<?php echo $customer_id ?>" method="post" enctype="multipart/form-data" class="js-comment-form" id="editcomment">
												<div class="binhluan-moi">
													<div class="box-right">
														<div class="form-group">
															<input type="text" name="comment" maxlength="65525" class="form-control comment-box" placeholder="Viết bình luận">
														</div>
														<button class="btn-common-fill hidden" type="submit" name="submit" value="submit">Send</button>
													</div>
													<input type="hidden" name="url" value="<?php the_permalink() ?>" />
													<input type="hidden" name="comment_post_ID" value="<?php the_ID() ?>" />
													<input type="hidden" name="comment_parent" value="0" />
													<input type="hidden" name="comment_ID" value="0" />
													<?php wp_nonce_field('comtoken', 'comtoken'); ?>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane customer" id="settings">
									<form class="form-horizontal" method="POST" action="<?php the_permalink() ?>?customer_id=<?php echo $customer_id ?>">
										<?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
										<div class="row pb-16">
											<div class="col-6">
												<div class="card-body">
													<div class="card-header">
														<h3 class="card-title d-f ai-center"><span class="fas fa-info mr-4"></span> Thông tin cơ bản</h3>
													</div>
													<div class="row">
														<div class="col-6 pb-16">
															<input type="text" name="nickname" class="nickname form-control" value="<?php echo $response_customer['data']['nickname'] ?>" required>
														</div>
														<div class="col-6 pb-16">
															<input type="text" name="fullname" class="fullname form-control" value="<?php echo $response_customer['data']['fullname'] ?>" required>
														</div>
														<div class="col-6 pb-16">
															<input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $response_customer['data']['phone'] ?>" required>
															<p id="phone_status" class="status text-danger"></p>
														</div>
														<div class="col-6 pb-16">
															<select name="gender" class="gender" required>
																<option value="0" selected>Giới tính*</option>
																<?php
																foreach ($gender as $value => $label) { ?>
																	<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['gender'], $value); ?> name="gender" required>
																		<?php echo $label; ?>
																	</option>
																<?php } ?>
															</select>
														</div>
														<div class="col-12 ">
															<div class="review">
																<p><span class="customer_name"></span></p>
																<p><span class="customer_phone"></span></p>
																<div class="info0">
																	<span class="address"></span>
																	<span class="street"></span>
																	<span class="ward"></span>
																	<span class="city"></span>
																</div>
																<div class="info1">
																	<span class="address"></span>
																	<span class="street"></span>
																	<span class="ward"></span>
																	<span class="city"></span>
																</div>
																<div class="info2">
																	<span class="address"></span>
																	<span class="street"></span>
																	<span class="ward"></span>
																	<span class="city"></span>
																</div>
																<div class="info3">
																	<span class="address"></span>
																	<span class="street"></span>
																	<span class="ward"></span>
																	<span class="city"></span>
																</div>
																<div class="info4">
																	<span class="address"></span>
																	<span class="street"></span>
																	<span class="ward"></span>
																	<span class="city"></span>
																</div>
															</div>
														</div>
														<div class="col-12 pb-16">
															<p class="pb-8">Ghi chú dụng cụ ăn</p>
															<select name="note_cook">
																<?php foreach ($list_cook as $value) { ?>
																	<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['note_cook'], $value); ?>><?php echo $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-12 pb-16">
															<p class="pb-8">Tag phân loại</p>
															<select class="form-control text-capitalize select2" multiple="multiple" name="tag_ids[]" style="width: 100%;">
																<?php
																foreach ($list_tags as $value => $label) { ?>
																	<option value="<?php echo $value; ?>" <?php echo in_array($value, $tag_ids) ? 'selected' : ''; ?>><?php echo $label; ?></option>
																<?php } ?>
															</select>
															<?php
															$admin_role = wp_get_current_user()->roles;
															if (!empty($admin_role)) {
																if ($admin_role[0] == 'administrator') {
															?>
																	<div class="form-group row pt-16 hidden">
																		<div class="col-sm-3"><label>Trạng thái khách hàng</label></div>
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
															<?php }
															} ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-6 ">
												<div class="card-body">
													<div class="card-header">
														<h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
													</div>
													<div id="location-fields">
														<?php
														foreach ($response_get_location['data'] as $index => $record) { ?>
															<div class="address-group location_<?php echo ($record['active']) ?>" data-index="<?php echo $index ?>">
																<input type="hidden" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" />
																<div class="row">
																	<div class="city col-12 pb-16">
																		<select id="province_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][province]" class="province-select form-control" required>
																			<option value="<?php echo $record['city']; ?>" selected><?php echo $record['city']; ?></option>
																		</select>
																	</div>
																	<div class="col-4 pb-16">
																		<select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control" required>
																			<option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
																		</select>
																	</div>
																	<div class="col-4 pb-16">
																		<select id="ward_<?php echo $record['id'] ?>" disabled name="locations[<?php echo $index ?>][ward]" class="ward-select form-control" required>
																			<option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
																		</select>
																	</div>
																	<div class="col-4 pb-16">
																		<input id="address_<?php echo $record['id'] ?>" type="text" class="form-control address" value="<?php echo $record['address']; ?>" placeholder="Địa chỉ cụ thể*" name="locations[<?php echo $index ?>][address]" required />
																	</div>
																</div>
																<?php 
																if ($record['note_shipper'] !='') {
																	$class_note_shipper = '';
																} else {
																	$class_note_shipper = 'hidden';
																}
																if ($record['note_admin'] !='') {
																	$class_note_admin = '';
																} else {
																	$class_note_admin = 'hidden';
																}
																 if ($record['note_shipper'] && $record['note_admin'] ) { 
																	$class_hidden = 'hidden';
																 }
																?>
																<div class="group-note">
																<div class="note_shiper <?php echo $class_note_shipper ?> pb-16">
																	<input type="text" name="locations[<?php echo $index ?>][note_shipper]" value="<?php echo $record['note_shipper'] ?>" placeholder="Note với shipper" />
																</div>
																<div class="note_admin <?php echo $class_note_admin ?> pb-16">
																	<input type="text" name="locations[<?php echo $index ?>][note_admin]" value="<?php echo $record['note_admin'] ?>" placeholder="Note với admin" />
																</div>
																</div>
																
																<div class="show-group-note d-f ai-center pb-16 <?php echo $class_hidden ?>">
																	<span class="fas fa-plus mr-4"></span> Thêm ghi chú giao hàng
																</div>
																
																<div class="col-12 pb-16">
																	<hr>
																	<div class="row pt-8">
																		<div class="col-6">
																			<div class="icheck-primary">
																				<input type="radio" name="location_active" id="active_<?php echo $record['id'] ?>" value="<?php echo $record['id'] ?>" <?php checked($record['active'], 1) ?>>
																				<input type="hidden" class="location_active" name="locations[<?php echo $index ?>][active]" value="<?php echo $record['active'] ?>" />
																				<label for="active_<?php echo $record['id'] ?>">
																					Đặt làm địa chỉ mặc định
																				</label>
																			</div>
																		</div>
																		<div class="col-6 text-right delete-location-button" data-id="<?php echo $record['id'] ?>">
																			<p class="d-f ai-center jc-end"><span>Xóa địa chỉ </span><i class="fas fa-bin-red"></i></p>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
													</div>

												</div>
												<p class="d-f ai-center pt-16 pb-16"><i class="fas fa-plus add-location-button"></i><span class="add-location-button">Thêm địa chỉ </span></p>
												<!-- /.card-body -->
												<!-- /.card -->

											</div>
										</div>





										<div class="row pt-16">
											<div class="col-6">
												<?php
												$admin_role = wp_get_current_user()->roles;
												if (!empty($admin_role)) {
													if ($admin_role[0] == 'administrator') {
												?>
														<button type="button" class="btn d-f ai-center btn-danger remove-customer modal-button" data-target="#modal-default">
															<i class="fas fa-bin"></i> Xoá khách này
														</button>
												<?php }
												} ?>
											</div>
											<div class="col-6 text-right">
												<button type="submit" class="btn btn-primary" name="add_post">Cập nhật</button>
											</div>
										</div>
										<input type="hidden" name="customer_name" readonly class="customer_name form-control" value="<?php echo $response_customer['data']['customer_name'] ?>">
										<input type="hidden" name="customer_id" value="<?php echo $customer_id ?>" />
										<input type="hidden" name="location_delete_ids" value="" class="location_delete_ids" />
									</form>
								</div>
								<div class="tab-pane" id="history">
									<div class="card history-action">
										<table>
											<thead>
												<tr>
													<th>User</th>
													<th>Action</th>
													<th class="descript">Description</th>
													<th>Time</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="nowrap">Nhu Quynh</td>
													<td>xoá</td>
													<td class="nowrap">
														<div class="descript-note">
															<span class="memo">ghi chú</span><span class="note-detail">T3 (21/4) giao về Toà nhà Riverbank, 3C Tôn Đức Thắng, Phường Bến Nghé, Quận 1</span>
														</div>
													</td>
													<td>01:00</td>
													<td>29/10/24</td>
												</tr>
												<tr>
													<td class="nowrap">Nhu Quynh</td>
													<td>tạo</td>
													<td class="nowrap">
														<div class="descript-note">
															<span class="memo">ghi chú</span><span class="note-detail">T3 (21/4) giao về Toà nhà Riverbank, 3C Tôn Đức Thắng, Phường Bến Nghé, Quận 1</span>
														</div>
													</td>
													<td>01:00</td>
													<td>29/10/24</td>
												</tr>
												<tr>
													<td class="nowrap">Nhu Quynh</td>
													<td>cập nhật</td>
													<td class="nowrap">
														<div class="descript-note">
															<span class="memo">đơn hàng</span><span class="note-detail">#979134</span>
														</div>
													</td>
													<td>01:00</td>
													<td>29/10/24</td>
												</tr>
												<tr>
													<td class="nowrap">Nhu Quynh</td>
													<td>cập nhật</td>
													<td class="nowrap">
														<div class="descript-note">
															<span class="memo">trạng thái khách hàng</span>
															<span class="tag btn tag_1">Đang dùng</span>
														</div>
													</td>
													<td>01:00</td>
													<td>29/10/24</td>
												</tr>
												<tr>
													<td class="nowrap">Nhu Quynh</td>
													<td>tạo</td>
													<td class="nowrap">
														<div class="descript-note">
															<span class="memo">khách hàng</span><span class="note-detail">Linh (Nu Kenny)</span>
														</div>
													</td>
													<td>01:00</td>
													<td>29/10/24</td>
												</tr>
											</tbody>
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
<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Thông báo!</h4>
			</div>
			<form method="post" id="list-customer" action="<?php the_permalink() ?>">
				<div class="modal-body pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $response_customer['data']['id'] ?>">
					<p>Bạn muốn xóa khách hàng: <b><?php echo $response_customer['data']['nickname'] ?></b>?</p>
				</div>
				<div class="modal-footer d-f jc-b pt-16">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="submit" name="remove" class="btn btn-danger modal-close">Xóa!</button>
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
		$('.phone_number').keyup(updatephone);
		$(document).on('change', '.address-group select', function() {
			$('.review').show();
			var selectItem = $(this).closest('.address-group'); // Get the closest select-item div
			var infoIndex = selectItem.data('index'); // Get the data-index attribute from select-item
			var city = selectItem.find('.district-select').val(); // Get the city value from select
			var ward = selectItem.find('.ward-select').val(); // Get the ward value from select
			// Update the corresponding .info div based on index
			var infoDiv = $('.review .info' + infoIndex);
			infoDiv.children('.city').text(city);
			if (ward) {
				infoDiv.children('.ward').text(ward + ',');
			}
		});

		$(document).on('keyup', '.address-group .address', function() {
			$('.review').show();
			var selectItem = $(this).closest('.address-group'); // Find the closest parent .address-group
			var infoIndex = selectItem.data('index'); // Get the index from data attribute
			var address = $(this).val(); // Get the current value of the address input field
			var infoDiv = $('.review .info' + infoIndex);
			if (address) {
				infoDiv.children('.address').text(address + ','); // Update the address text
			} else {
				infoDiv.children('.address').text(''); // Clear the address if the input is empty
			}
		});


		function updatetxt() {
			$('.review').show();
			$('input.customer_name').val($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
			$('span.customer_name').text($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
		}

		function updatephone() {
			$('span.customer_phone').text($('.phone_number').val());
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