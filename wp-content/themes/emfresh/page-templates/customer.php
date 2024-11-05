<?php

/**
 * Template Name: Customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag;
$response_add_customer = [];

// Check if the form is submitted and handle the submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {

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

	$data = [
		'nickname'      => $nickname,
		'fullname'      => $fullname,
		'customer_name' => $customer_name,
		'phone'         => $phone,
		'status'        => $status_post,
		'gender'        => $gender_post,
		'active'        => $active_post,
		'note'          => $note,
		'note_shipping' => $note_shipping,
		'note_cook'     => $note_cook,
		'order_payment_status' => $order_payment_status,
		'tag'           => $tag_post,
		'point'         => $point,
		'modified'      => current_time('mysql')
	];

	//var_dump($data);
	$response_add_customer = em_api_request('customer/add', $data);

	if ($response_add_customer['code'] == 200) {
		$customer_id = (int) $response_add_customer['data']['insert_id'];

		if (isset($_POST['locations']) && is_array($_POST['locations'])) {
			foreach ($_POST['locations'] as $location) {
				$location_data = [
					'customer_id'   => $customer_id,
					'active'        => isset($location['active']) ? intval($location['active']) : 0,
					'address'       => isset($location['address']) ? sanitize_text_field($location['address']) : '',
					'ward'          => isset($location['ward']) ? sanitize_text_field($location['ward']) : '',
					'district'      => isset($location['district']) ? sanitize_text_field($location['district']) : '',
					'city'          => isset($location['province']) ? sanitize_text_field($location['province']) : '79',
				];
				em_api_request('location/add', $location_data);
			}
		}

		if (isset($_POST['tag_ids']) && is_array($_POST['tag_ids'])) {
			foreach ($_POST['tag_ids'] as $i => $tag_id) {
				$tag_id = (int) $tag_id;
				if ($tag_id == 0) continue;

				$em_customer_tag->insert([
					'tag_id' => $tag_id,
					'customer_id' => $customer_id
				]);
			}
		}

		wp_redirect(add_query_arg([
			'customer_id' => $customer_id,
			'code' => 200,
			'message' => 'Add Success',
		], home_url('customer/detail-customer')));
		exit();
	}
}

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$list_tags = $em_customer->get_tags();
$actives = $em_customer->get_actives();

$list_cook = custom_get_list_cook();
$list_notes = custom_get_list_notes();
$list_payment_status = $em_order->get_statuses();


// Start the Loop.
get_header();
?>
<div class="customer">
	<!-- Content Header (Page header) -->


	<!-- Main content -->
	<section class="content">
		<?php
		if (isset($response_add_customer['code']) && $response_add_customer['code'] == 200) {
			echo '<div class="alert alert-success mt-3" role="alert">' . $response_add_customer['message'] . '</div>';
		} else if (isset($response_add_customer['code']) && $response_add_customer['code'] == 400) {
			echo '<div class="alert alert-warning mt-3" role="alert">';
			foreach ($response_add_customer['data'] as $field => $value) {
				echo "<p>$field : $value </p>";
			}
			echo '</div>';
		}
		?>
		<form method="post" id="customer-form" action="<?php the_permalink() ?>">
			<div class="row pb-16">
				<div class="col-6">
					<div class="card-body">
						<div class="card-header">
							<h3 class="card-title">Thông tin cơ bản</h3>
						</div>
						<div class="row">
							<div class="col-6 pb-16">
								<input type="text" name="nickname" class="nickname form-control" placeholder="Tên tài khoản*" value="<?php site__post_e('nickname') ?>" required>
							</div>
							<div class="col-6 pb-16">
								<input type="text" name="fullname" placeholder="Tên thật(nếu có)" value="<?php site__post_e('fullname') ?>" class="fullname form-control">
							</div>
							<div class="col-6 pb-16">
								<input type="tel" name="phone" placeholder="Số điện thoại*" class="form-control phone_number" onkeyup="checkphone();" required />
								<p id="phone_status" class="status text-danger"></p>
							</div>
							<div class="col-6 pb-16">
								<select name="gender" class="gender" required>
									<option value="0" selected>Giới tính*</option>
									<?php
									foreach ($gender as $key => $value) { ?>
										<option value="<?php echo $key; ?>">
											<?php echo $value; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-12 pb-16">
								<p class="pb-8">Ghi chú dụng cụ ăn</p>
								<select name="tool_eat">
									<option value="0">chỉ DC</option>
									<option value="1">Không DC</option>
								</select>
							</div>
							<div class="col-12 pb-16">
								<p class="pb-8">Tag phân loại</p>
								<select class="form-control text-capitalize select2" multiple="multiple" name="tag_ids[]" style="width: 100%;">
									<?php
									foreach ($list_tags as $key => $value) { ?>
										<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
								<?php
									$admin_role = wp_get_current_user()->roles;
									if(!empty($admin_role) ) {
										if ($admin_role[0] == 'administrator') {
										?>
									<div class="form-group row pt-16">
										<div class="col-sm-3"><label>Trạng thái khách hàng</label></div>
										<div class="col-sm-9 text-capitalize">
										<?php
										foreach ($actives as $key => $value) { ?>
											<span class="icheck-primary d-inline mr-2">
											<input type="radio" id="radioActive<?php echo $key; ?>" value="<?php echo $key; ?>" name="active" required <?php checked('1', $key); ?>>
											<label for="radioActive<?php echo $key; ?>">
												<?php echo $value; ?>
											</label>
											</span>
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
							<h3 class="card-title">Địa chỉ</h3>
						</div>
						<div id="location-fields">
							<div class="address-group location_0 address_active">
								<div class="row">
								<div class="city col-12 pb-16">
									<select id="province_0" name="locations[0][province]" class="province-select form-control" required>
										<option value="">Select Tỉnh/Thành phố</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="district_0" name="locations[0][district]" class="district-select form-control" required disabled>
										<option value="">Quận/Huyện*</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="ward_0" name="locations[0][ward]" class="ward-select form-control" required disabled>
										<option value="">Phường/Xã*</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<input id="address_0" type="text" class="form-control" placeholder="Địa chỉ cụ thể*" name="locations[0][address]" required />
								</div>
									</div>
								<div class="note_ship row pb-8">
									<div class="col-4">
										<select name="" id="">
											<option value="">Note với shipper</option>
										</select>
									</div>
									<div class="col-8">
										<input type="text">
									</div>
								</div>
								<div class="col-12 pb-16">
									<p class="d-f ai-center pb-8"><i class="fas fa-plus"></i><span class="bg-gradient-primary" id="add-location-button">Thêm ghi chú giao hàng</span></p>
									<hr>
									<div class="row pt-8">
										<div class="col-6">
											<div class="icheck-primary">
												<input type="radio" name="location_active" id="active_0" value="1" checked>
												<input type="hidden" class="location_active" name="locations[0][active]" value="1" />
												<label for="active_0">
													Đặt làm địa chỉ mặc định
												</label>
											</div>
										</div>
										<div class="col-6 text-right delete-location-button">
											<p class="d-f ai-center jc-end"><span>Xóa địa chỉ </span><i class="fas fa-bin-red"></i></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p class="d-f ai-center pt-16 pb-16"><i class="fas fa-plus add-location-button"></i><span class="add-location-button">Thêm địa chỉ </span></p>
					<!-- /.card-body -->
					<!-- /.card -->
				</div>
			</div>
			<div class="row pt-16">
				<div class="col-6">
					<a href="../" class="btn btn-secondary">Huỷ</a>
				</div>
				<div class="col-6 text-right">
					<input type="hidden" name="customer_name" readonly class="customer_name form-control" value="<?php site__post_e('customer_name') ?>">
					<input type="submit" value="Add new Customer" name="add_post" class="btn btn-primary">
				</div>
			</div>
</div>

</div>
</form>
</section>
<!-- /.content -->
</div>
<?php
get_footer('customer');
?>
<style>

</style>
<script src="<?php echo site_get_template_directory_assets();?>js/assistant.js"></script>
<script src="<?php echo site_get_template_directory_assets();?>js/location.js"></script>
<script type="text/javascript">
	function checkphone() {
		var phone = $(".phone_number").val();
		if (phone) {
			jQuery.ajax({
				type: 'post',
				url: '<?php echo site_get_template_directory_assets();?>js/checkdata.php',
				data: {
					user_phone: phone,
				},
				success: function(response) {
					jQuery('#phone_status').html(response);
					if (response == "OK") {
						jQuery('#phone_status').addClass('d-none');
						return true;
					} else {
						jQuery('#phone_status').removeClass('d-none');
						return false;
					}
				}
			});

		} else {
			jQuery('#phone_status').html("");
			// return false;
		}
	}
	$(document).ready(function() {
		$('.nickname').keyup(updatetxt);
		$('.fullname').keyup(updatetxt);

		function updatetxt() {
			$('.customer_name').val($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
		}

		$('.btn-primary[name="add_post"]').on('click', function(e) {
			// if ($('#phone_status').html() == "OK") {
			// 	e.stopPropagation();
			// 	$('.btn-primary[name="add_post"]').css({
			// 		"display": "none"
			// 	});
			// 	setTimeout(() => {
			// 		$('.btn-primary[name="add_post"]').css({
			// 			"display": "block"
			// 		});
			// 	}, 2000);
			// 	document.getElementById('customer-form').submit();
			// } else {
			// 	alert('Số điện thoại đã tồn tại!');
			// 	e.preventDefault();
			// }
		});
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

		$('[name="location_active"]').on('change', function() {
			$('.location_active').val(0);
			if (this.checked) {
				$(this).next('.location_active').val(1);
			}
		});

	});
</script>