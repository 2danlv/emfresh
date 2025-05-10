<?php

/**
 * Template Name: Ingredients-List
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
								<li><span data-target="#modal-create"
										class="add btn btn-v2 btn-primary btn-icon  modal-button">
										<img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus.svg"
											alt=""></span></li>
								<li><span class="btn btn-v2 btn-icon btn-filter btn-fillter relative"><img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/filter.svg"
											alt="">
										<span class="count tag-number absolute" style="bottom:2px;right:-1px;"></span>
									</span></li>
								<li><span class="btn btn-v2 btn-secondary" data-target="#modal-list"><img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload.svg"
											alt=""><span>Nhập vào dữ liệu</span></span></li>
								<li><span class="btn btn-v2 btn-secondary" data-target="#modal-list"><img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/download.svg"
											alt=""><span>Xuất dữ liệu</span></span></li>
								<li><span class="btn btn-v2 btn-secondary" data-target="#modal-list"><img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/rocket.svg"
											alt=""><span>Cập nhật nhanh</span></span></li>
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

							</ul>
						</div>
					</div>
					<?php wp_nonce_field('importoken', 'importoken', false); ?>
				</form>
			</div>
			<table id="list-ingredients" class="table table-v2 table-ingredients-list" style="width:100%">
				<thead>
					<tr>
						<th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" />
						</th>
						<th data-number="1" class="text-center"></th>
						<th data-number="2" class="text-left"><span class="nowrap">Nguyên liệu</span></th>
						<th data-number="3" class="text-center">Phân loại</th>
						<th data-number="4">Nhà cung cấp</th>
						<th data-number="5" class="text-left"><span class="nowrap">Mô tả</span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i = 0; $i < 5; $i++) {
						?>
						<tr>
							<td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element"
									data-number="<?php echo $record['phone']; ?>" value="<?php echo $record['id'] ?>"></td>

							<td data-number="1" class="text-center">
								<div style="width:45px;height:30px;background:#eee;margin:auto">
									<img style="width:100%;height:100%;object-fit:contain" alt="" />
								</div>
							</td>
							<td data-number="2" class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
								<a class="ellipsis modal-button cursor-pointer" data-target="#modal-edit">Cơm lứt tím
									than</a>
							</td>
							<td data-number="3" class="text-center text-capitalize wrap-td">
								<div class="nowrap ellipsis">Tinh bột</div>
							</td>
							<td data-number="4" class="text-capitalize">
								Thịt 1 (Heo), Thịt 2 (Gà)
							</td>
							<td data-number="5" class="text-left">
								<span>Description goes here</span>
							</td>
						</tr>
						<?php
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
<div class="modal fade" id="modal-create">
	<div class="overlay"></div>
	<div class="modal-dialog" style="width:1000px;max-width:100%">
		<div class="modal-content">
			<div class="modal-header">
				<div class="flex justify-between">
					<h4 class="modal-title">Tạo nguyên liệu mới</h4>
					<span class="modal-close cursor-pointer"><img class="upload-image"
							src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-gray.svg" alt=""></span>
				</div>
			</div>
			<div class="modal-body pt-16">
				<div class="flex" style="align-items: stretch;gap:20px">
					<div class="" style="width:35%;">
						<form action="/target" style="height:100%;cursor:pointer">
							<div id="dropzone-template" class="fileinput-button dz-clickable upload-drop-zone"
								style="width:100%;height:100%">
								<div class="upload-wrapper">
									<div class="upload-content">
										<img class="upload-image"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload-image.svg"
											alt="">
										<p class="text-base font-medium">Drop your files here or <span
												class="text-primary font-semibold">browse</span></p>
										<p class="text-secondary font-medium text-small">Maximum size: 50MB</p>
									</div>
									<div class="upload-preview">
										<div id="previews">
											<div id="template" class="file-row">
												<img data-dz-thumbnail />
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
					<div style="flex:1">
						<div class="w-full" style="padding:10px 0px">
							<table class="w-full table-input table-grid">
								<tbody>
									<tr>
										<td class="label" style="width:150px">Tên nguyên liệu</td>
										<td colspan="3"><input class="editable-input" type="text"></td>
									</tr>
									<tr>
										<td class="label" style="width:150px">Phân loại</td>
										<td colspan="3">
											<select class="editable-input" name="" id="">
												<option value="">Loại 1</option>
												<option value="">Loại 2</option>
												<option value="">Loại 3</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label" style="width:150px">Nhà cung cấp</td>
										<td colspan="3">
											<select class="editable-input" name="" id="">
												<option value="">Nhà cung cấp 1</option>
												<option value="">Nhà cung cấp 2</option>
												<option value="">Nhà cung cấp 3</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label align-top" style="width:150px">Mô tả:</td>
										<td colspan="3">
											<textarea class="editable-input" id="w3review" name="w3review" rows="6"
												cols="50"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group pt-16 text-right">
				<!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
				<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-primary modal-close">Tạo mới</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-edit">
	<div class="overlay"></div>
	<div class="modal-dialog" style="width:1000px;max-width:100%">
		<div class="modal-content">
			<div class="modal-header">
				<div class="flex justify-between">
					<h4 class="modal-title">Nạc heo</h4>
					<span class="modal-close cursor-pointer"><img class="upload-image"
							src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-gray.svg" alt=""></span>
				</div>
			</div>
			<div class="modal-body pt-16">
				<div class="flex" style="align-items: stretch;gap:20px">
					<div class="" style="width:35%;">
						<form action="/target" style="height:100%;cursor:pointer">
							<div id="dropzone-template" class="fileinput-button dz-clickable upload-drop-zone"
								style="width:100%;height:100%">
								<div class="upload-wrapper">
									<div class="upload-content">
										<img class="upload-image"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload-image.svg"
											alt="">
										<p class="text-base font-medium">Drop your files here or <span
												class="text-primary font-semibold">browse</span></p>
										<p class="text-secondary font-medium text-small">Maximum size: 50MB</p>
									</div>
									<div class="upload-preview">
										<div id="previews">
											<div id="template" class="file-row">
												<img data-dz-thumbnail />
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
					<div style="flex:1">
						<div class="w-full" style="padding:10px 0px">
							<table class="w-full table-input table-grid">
								<tbody>
									<tr>
										<td class="label" style="width:150px">Tên nguyên liệu</td>
										<td colspan="3"><input class="editable-input" type="text"></td>
									</tr>
									<tr>
										<td class="label" style="width:150px">Phân loại</td>
										<td colspan="3">
											<select class="editable-input" name="" id="">
												<option value="">Loại 1</option>
												<option value="">Loại 2</option>
												<option value="">Loại 3</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label" style="width:150px">Nhà cung cấp</td>
										<td colspan="3">
											<select class="editable-input" name="" id="">
												<option value="">Nhà cung cấp 1</option>
												<option value="">Nhà cung cấp 2</option>
												<option value="">Nhà cung cấp 3</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label align-top" style="width:150px">Mô tả:</td>
										<td colspan="3">
											<textarea class="editable-input" id="w3review" name="w3review" rows="6"
												cols="50"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="flex pt-16 justify-between">
				<button data-target="#modal-confirm-delete" type="button" class="btn btn-v2 btn-destructive btn-outline modal-button"><img class="icon"
						src="<?php echo site_get_template_directory_assets(); ?>/img/icon/trash.svg" alt="">Xoá nguyên
					liệu</button>
				<div class="form-group text-right">
					<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
					<button type="button" class="btn btn-v2 btn-primary modal-close">Lưu thay đổi</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-warning" id="modal-confirm-delete">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content" style="padding:0">
			<div style="text-align:right;margin-right:10px"><span class="btn btn-v2 btn-ghost btn-icon modal-close"><img
						class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-black.svg"
						alt=""></span>
			</div>
			<div class="modal-body" style="padding:0 20px 20px 20px;max-width:350px;">
				<center>
					<div class="icon-wave danger-wave"><img class="icon"
							src="<?php echo site_get_template_directory_assets(); ?>/img/icon/alert-triangle.svg"
							alt=""></div>
					<p class="font-bold" style="font-size:24px;margin: 10px 0">Xoá nguyên liệu</p>
					<p class="text-secondary font-medium text-lg">Bạn có chắc chắn muốn xoá nguyên liệu Nạc vai không?</p>
				</center>
			</div>
			<div class="modal-footer text-center pb-16 flex justify-center" style="gap:15px">
				<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-destructive modal-close">Xoá</button>
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
<script src="<?php site_the_assets(); ?>js/ingredients-list.js"></script>
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
<script>
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
		url: "/target-url", // Set the url
		thumbnailWidth: null,
		thumbnailHeight: null,
		parallelUploads: 20,
		maxFiles: 1,
		acceptedFiles: "image/*",
		previewTemplate: previewTemplate,
		autoQueue: false, // Make sure the files aren't queued until manually added
		previewsContainer: "#previews", // Define the container to display the previews
		clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
	});


	myDropzone.on("sending", function (file) {
		// Show the total progress bar when upload starts
		// document.querySelector("#total-progress").style.opacity = "1";
		// // And disable the start button
		// file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
	});

	// Hide the total progress bar when nothing's uploading anymore
	myDropzone.on("queuecomplete", function (progress) {
		// document.querySelector("#total-progress").style.opacity = "0";
	});
</script>