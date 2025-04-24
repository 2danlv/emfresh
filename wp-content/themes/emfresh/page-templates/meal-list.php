<?php

/**
 * Template Name: Meal-List
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();
$list_orders = [];

// cập nhật data cho customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
	$list_id = isset($_POST['list_id']) ? sanitize_textarea_field($_POST['list_id']) : '';
	$array_id = explode(',', $list_id);
	//$status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
	//$tag_post    = isset($_POST['tag']) ? intval($_POST['tag']) : 0;
	//$order_payment_status = isset($_POST['order_payment_status']) ? sanitize_textarea_field($_POST['order_payment_status']) : '';
	//vardump($tag_post);

	$updated = [];
	if (isset($_POST['tag_ids']) && count($_POST['tag_ids']) > 0) {
		$tag_radio = isset($_POST['tag_radio']) ? trim($_POST['tag_radio']) : 'add';

		$list_noti = [];

		foreach ($array_id as $key => $id) {
			$log_change = [];

			$customer_id = intval($id);
			$customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
			$tag_ids = custom_get_list_by_key($customer_tags, 'tag_id');

			if ($tag_radio == 'remove') {
				foreach ($_POST['tag_ids'] as $tag_id) {
					$deleted = $em_customer_tag->delete([
						'tag_id' => $tag_id,
						'customer_id' => $customer_id
					]);

					$log_change[] = sprintf('<span class="memo field-tag">Xóa Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));

					$list_noti[] = ['id' => $customer_id, 'success' => (int) $deleted];
				}
			} else {
				foreach ($_POST['tag_ids'] as $tag_id) {
					if (in_array($tag_id, $tag_ids) == false) {
						$inserted = $em_customer_tag->insert([
							'tag_id' => $tag_id,
							'customer_id' => $customer_id
						]);

						$tag_ids[] = $tag_id;

						$log_change[] = sprintf('<span class="memo field-tag">Thêm Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));

						$list_noti[] = ['id' => $customer_id, 'success' => (int) $inserted];
					} else {
						$list_noti[] = ['id' => $customer_id, 'success' => 0];
					}
				}
			}

			// Log update
			if (count($log_change) > 0) {
				$em_log->insert([
					'action' => 'Cập nhật',
					'module' => 'em_customer',
					'module_id' => $customer_id,
					'content' => implode("\n", $log_change)
				]);
			}
		}

		site_user_session_update('list_noti', $list_noti);
	}

	// if ($order_payment_status != '') {
	//   $customer_update_data = [
	//     'id'            => intval($id),
	//     'order_payment_status' => $order_payment_status
	//   ];
	// }

	// $response_update = $em_customer->update($customer_update_data);
	// if ($response_update) {
	//   $updated[$id] = 'ok';
	// }

	wp_redirect(add_query_arg([
		'code' => 200,
		'expires' => time() + 3,
		//'message' => 'Update Success',
	], get_permalink()));
	exit();
}

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>

<!-- Main content -->
<section class="content page-content">
	<?php
	if (isset($_GET['message']) && $_GET['message'] == 'Delete Success' && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
		echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
	}
	if (!empty($_GET['code']) && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
		// echo '<div class="alert alert-success mt-3 mb-16" role="alert">'
		//     . sprintf('Cập nhật%s thành công', $_GET['code'] != 200 ? ' không' : '')
		//     .'</div>';
	}
	?>

	<!-- Default box -->
	<div class="card datatable datatable-v2 meal-list">
		<div class="card-body">
			<div class="toolbar">
				<form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
					<div class="row ai-center">
						<div class="col-8">
							<ul class="d-f ai-center">
								<li><span class="add btn btn-v2 btn-primary btn-icon btn-plus">
									<a href="<?php echo home_url('/meal-list/create-new-meal') ?>"><img
												class="icon"
												src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus.svg"
												alt=""></a></span></li>
								<li><span class="btn btn-v2 btn-icon btn-filter btn-fillter relative"><img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/filter.svg"
											alt="">
										<span class="count tag-number absolute" style="bottom:2px;right:-1px;"></span>
									</span></li>
								<li><span class="btn btn-v2 btn-add-file modal-button" data-target="#modal-list"><img
											class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/file-plus.svg"
											alt=""><span>Thêm vào
											DS chờ</span></span></li>
							</ul>
						</div>
						<div class="col-4">
							<ul class="d-f ai-center jc-end">
								<li class="status">
									<span class="btn btn-v2 btn-status"><span class="count-checked"></span>
										<span>đã chọn</span>
										<img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x.svg"
											alt="">
									</span>
								</li>
								<li>
									<span class="btn btn-v2 has-child align-right">
										<span>Thao tác
											<img class="icon"
												src="<?php echo site_get_template_directory_assets(); ?>/img/icon/chevron-down.svg"
												alt="">
										</span>
										<ul>
											<li> <a href="/import/" class="upload"></a>
												<span class="btn btn-v2 btn-block btn-ghost">
													<img class="icon"
														src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload.svg"
														alt=""> Nhập dữ liệu
												</span>
												</a>
											</li>
											<li>
												<button class="btn btn-v2 btn-block btn-ghost" type="button"
													name="action" value="export" class="js-export"><img class="icon"
														src="<?php echo site_get_template_directory_assets(); ?>/img/icon/download.svg"
														alt="">Xuất dữ
													liệu</button>
											</li>
										</ul>

									</span>
								</li>
							</ul>
						</div>
					</div>
					<?php wp_nonce_field('importoken', 'importoken', false); ?>
				</form>
			</div>
			<table id="list-customer" class="table table-v2 table-meal-list" style="width:100%">
				<thead>
					<tr>
						<th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" />
						</th>
						<th data-number="1"><span class="nowrap">Tên món</span></th>
						<th data-number="2" class="text-left">Nhóm</th>
						<th data-number="3">Nguyên liệu</th>
						<th data-number="4">Loại</th>
						<th data-number="5" class="text-center"><span class="nowrap">Trạng thái </span></th>
						<th data-number="6" class="text-right"><span class="nowrap">Số lần nấu</span></th>
						<th data-number="7" class="text-right">Lần cuối dùng</th>
						<th data-number="8" class="text-left">Lưu ý</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$response = em_api_request('customer/list', [
						'active' => 1,
						'paged' => 1,
						'limit' => -1,
					]);

					$order_date_from = isset($_GET['order_date_from']) ? trim($_GET['order_date_from']) : '';
					$order_date_to = isset($_GET['order_date_to']) ? trim($_GET['order_date_to']) : '';

					if (isset($response['data']) && is_array($response['data'])) {
						// Loop through the data array and print each entry
						foreach ($response['data'] as $record) {
							if (is_array($record)) { // Check if each record is an array
								if ($record['active'] != '0') {
									$response_order = em_api_request('order/list', [
										'paged' => 1,
										'customer_id' => $record['id'],
										'date_from' => $order_date_from,
										'date_to' => $order_date_to,
										'limit' => -1,
									]);

									if (count($response_order['data']) > 0) {
										$list_orders = array_merge($list_orders, $response_order['data']);
									}

									$total_order_days = array_sum(array_column($response_order['data'], 'ship_days'));
									$total_quantity = array_sum(array_column($response_order['data'], 'total_quantity'));
									$total_ship = array_sum(array_column($response_order['data'], 'ship_amount'));
									$total_amount = array_sum(array_column($response_order['data'], 'total_amount'));
									$total_order_money = $total_amount + $total_ship;
									$dateStarts = array_column($response_order['data'], 'date_start');

									if (!empty($dateStarts)) {
										$max_date = date('d/m/Y', strtotime(max($dateStarts)));
									} else {
										// Xử lý khi không có giá trị date_start nào (ví dụ: gán giá trị mặc định hoặc thông báo lỗi)
										$max_date = null; // Hoặc giá trị phù hợp khác
									}
									?>
									<tr>
										<td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element"
												data-number="<?php echo $record['phone']; ?>" value="<?php echo $record['id'] ?>"></td>
										<td data-number="1" class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
											<div class="ellipsis"><a href="detail-meal/?meal_id=<?php echo $record['id'] ?>">Cơm
													tấm sườn trứng eatlean</a>
											</div>
										</td>
										<td data-number="2" class="text-left">
											<span>Món mặn</span>
										</td>
										<td data-number="3" class="text-capitalize wrap-td">
											<div class="nowrap ellipsis">Heo</div>
										</td>
										<td data-number="4" class="text-capitalize">
											Cốt lết
										</td>
										<td data-number="5" class="text-center">
											<span class="badge block badge-status-1">Hiện hành</span>
										</td>
										<td data-number="6" class="text-right">
											<span>10</span>
										</td>
										<td data-number="7" class="text-right">
											<span>Tuần 52</span>
										</td>
										<td data-number="8" class="text-center">Món này có mỡ hành</td>
									</tr>
								<?php }
							} else {
								echo "Không tìm thấy dữ liệu!\n";
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.card-body -->
</section>

<div class="modal fade modal-warning" id="modal-warning-edit">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body pt-8 pb-16">
				<div class="d-f ai-center">
					<i class="fas fa-warning mr-8"></i>
					<p>Hãy chọn khách hàng để <span class="txt_append">chỉnh sửa</span> nhanh!</p>
				</div>
			</div>
			<div class="modal-footer text-center pt-16 pb-8">
				<button type="button" class="btn btn-secondary modal-close">Đóng</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-list">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Thêm vào danh sách chờ</h4>
			</div>
			<div class="modal-body pt-16">
				<table class="table table-v2 table-simple table-print nowrap">
					<thead>
						<tr>
							<th class="text-left">Tên món</th>
							<th class="text-left">Nhóm</th>
							<th class="text-left">Nguyên liệu</th>
							<th class="text-left">Loại</th>
						</tr>
					</thead>
					<tbody>
						<?php
						for ($i = 0; $i < 20; $i++) {
							?>
							<tr>
								<td class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
									<span class="ellipsis"><a href="detail-customer/?customer_id">Cơm
											tấm sườn trứng eatlean</a>
									</span>
								</td>
								<td class="text-left"><span>Món mặn</span></td>
								<td class="text-left">
									<span>Heo</span>
								</td>
								<td class="text-left">Cốt lết</td>
							</tr>
							<?php
						}
						?>
					</tbody>

				</table>
				<div style="margin-top:20px">
					<label for="" class="input-label">Chọn danh sách bạn muốn thêm vào</label>
					<select name="note_name" class="input-control form-control input-note_name" style="width:100%">
						<option value="">
							Menu tuần 10 (03/02 - 07/02)
						</option>
					</select>
				</div>
			</div>
			<div class="form-group pt-16 text-right">
				<!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
				<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-primary modal-close">Thêm</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-edit">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cập nhật nhanh</h4>
			</div>
			<div class="modal-body pt-16">
				<?php
				//$status = $em_customer->get_statuses();
				//$list_payment_status = custom_get_list_payment_status();
				$tag = $em_customer->get_tags();
				?>
				<div class="alert-form alert alert-warning mb-16 hidden"></div>
				<form method="POST" action="<?php the_permalink() ?>">
					<input type="hidden" name="list_id" class="list_id" value="">
					<div class="form-group row">
						<div class="col-12">
							<select class="form-control field">
								<option value="tag">Tag phân loại</option>
							</select>
						</div>
						<div class="col-12 pt-16">
							<div class="d-f tag-radio  ai-center pb-2">
								<input type="radio" name="tag_radio" id="add" value="add" checked> <label for="add"
									class="pl-4 pr-8">Thêm tag phân loại</label>
							</div>
							<div class="d-f tag-radio ai-center deactive">
								<input type="radio" name="tag_radio" id="remove" value="remove"> <label class="pl-4"
									for="remove">Gỡ tag phân loại</label>
							</div>

						</div>
						<div class="col-12 pt-16">
							<select class="form-control list-tag" name="tag_ids[]" style="width: 100%;" required>
								<option value="" selected disabled>Chọn tag cần cập nhật</option>
								<?php
								foreach ($tag as $key => $value) { ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group pt-16 text-right">
						<button type="button" class="button btn-default modal-close">Huỷ</button>
						<button type="submit" class="button btn-primary add_post" name="add_post">Áp dụng</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php

get_template_part('parts/popup/result', 'update');

$html = [];
foreach ($list_tags as $key => $value) {
	$html[] = "'" . $value . "'";
} ?>
<script>
	let list_tags = [<?php echo implode(',', $html); ?>];
	let list_orders = <?php echo json_encode($list_orders, JSON_UNESCAPED_UNICODE); ?>;
</script>
<?php
// endwhile;

global $site_scripts;

if (empty($site_scripts))
	$site_scripts = [];
$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/meal-list.js"></script>
<script>
	// Function to save checkbox states to localStorage
	function saveCheckboxState() {
		$('.filter input[type="checkbox"]').each(function () {
			const columnKey = 'column_' + $(this).val(); // Create key like "column_1", "column_2"
			localStorage.setItem(columnKey, $(this).is(':checked'));
		});
	}
	// Function to load checkbox states from localStorage
	function loadCheckboxState() {
		$('.filter input[type="checkbox"]').each(function () {
			const columnKey = 'column_' + $(this).val();
			const savedState = localStorage.getItem(columnKey);
			// If there is no saved state, set defaults for values 1, 3, and 4
			if (savedState === null) {
				if (['1', '3', '4'].includes($(this).val())) {
					$(this).prop('checked', true);
				}
			} else {
				$(this).prop('checked', savedState === 'true');
				//$('.btn-column').addClass('active');
			}
		});
	}

	$(document).ready(function () {

		// Load checkbox states when the page loads
		loadCheckboxState();

		// Attach event listener to save state when checkboxes change
		$('.filter input[type="checkbox"]').on('change', saveCheckboxState);
		$('.tag-radio').click(function (e) {
			//e.preventDefault();
			$('.tag-radio').addClass('deactive');
			$(this).removeClass('deactive');
		});
		$('#modal-edit .btn-primary.add_post').on('click', function (e) {
			if ($('.list-tag').val() == '') {
				$(".alert-form").show();
				$(".alert-form").text('Chưa chọn tag cần cập nhật');
				return false;
			} else {
				$(".alert-form").hide();
			}
		});

		var $modalBody = $('.modal-result_update .modal-body');
		$('.modal-result_update .nav li.nav-item').click(function () {
			var rel = $(this).attr('rel');
			$('.modal-result_update .nav li.nav-item').removeClass('active');
			$(this).addClass('active');
			$modalBody.find('.row').hide();
			if (rel === 'all') {
				$modalBody.find('.row').show();
			} else {
				$modalBody.find('.row.' + rel).show();
			}
		});
	});
</script>