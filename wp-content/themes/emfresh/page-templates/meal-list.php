<?php

/**
 * Template Name: Meal-List
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_menu;

$list_tags = $em_menu->get_setting('tag');

$items = $em_menu->get_items();

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
								<li>
									<a class="add btn btn-v2 btn-primary btn-icon btn-plus" href="<?php echo site_menu_edit_link() ?>">
										<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus.svg" alt="">
									</a>
								</li>
								<li>
									<span class="btn btn-v2 btn-icon btn-filter btn-fillter relative">
										<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/filter.svg" alt="">
										<span class="count tag-number absolute" style="bottom:2px;right:-1px;"></span>
									</span>
								</li>
								<li>
									<span class="btn btn-v2 btn-add-file modal-button" data-target="#modal-list">
										<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/file-plus.svg" alt="">
										<span>Thêm vào DS chờ</span>
									</span>
								</li>
							</ul>
						</div>
						<div class="col-4">
							<ul class="d-f ai-center jc-end">
								<li class="status">
									<span class="btn btn-v2 btn-status"><span class="count-checked"></span>
										<span>đã chọn</span>
										<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x.svg" alt="">
									</span>
								</li>
								<li>
									<span class="btn btn-v2 has-child align-right">
										<span>
											Thao tác
											<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/chevron-down.svg" alt="">
										</span>
										<ul>
											<li> <a href="/import/" class="upload"></a>
												<span class="btn btn-v2 btn-block btn-ghost">
													<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload.svg" alt="">
													Nhập dữ liệu
												</span>
												</a>
											</li>
											<li>
												<button class="btn btn-v2 btn-block btn-ghost" type="button" name="action" value="export" class="js-export">
													<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/download.svg" alt="">
													Xuất dữ liệu
												</button>
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
					if (count($items) > 0) {
						foreach ($items as $item) {
							$link = add_query_arg(['menu_id' => $item['id']], site_menu_edit_link());
						?>
							<tr>
								<td data-number="0" class="text-center">
									<input type="checkbox" class="checkbox-element" value="<?php echo $item['id'] ?>">
								</td>
								<td data-number="1" class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
									<div class="ellipsis">
										<a href="<?php echo $link ?>"><?php echo $item['name'] ?></a>
									</div>
								</td>
								<td data-number="2" class="text-left">
									<span><?php echo $item['group_name'] ?></span>
								</td>
								<td data-number="3" class="text-capitalize wrap-td">
									<div class="nowrap ellipsis"><?php echo $item['ingredient_name'] ?></div>
								</td>
								<td data-number="4" class="text-capitalize">
									<?php echo $item['type_name'] ?>
								</td>
								<td data-number="5" class="text-center">
									<span class="badge block badge-status-1"><?php echo $item['status_name'] ?></span>
								</td>
								<td data-number="6" class="text-right">
									<span><?php echo $item['cooking_times'] ?></span>
								</td>
								<td data-number="7" class="text-right">
									<?php if(intval($item['last_used']) > 0) : ?>
									<span>Tuần <?php echo date('W', strtotime($item['last_used'])) ?></span>
									<?php endif ?>
								</td>
								<td data-number="8" class="text-center"><?php echo $item['note'] ?></td>
							</tr>
						<?php
						}
					} else {
						echo "<tr><th colspan=100>Không tìm thấy dữ liệu!</td></tr>";
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
<?php

get_template_part('parts/popup/result', 'update');

$html = [];
foreach ($list_tags as $key => $value) {
	$html[] = "'" . $value . "'";
} ?>
<script>
	let list_tags = [<?php echo implode(',', $html); ?>];
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