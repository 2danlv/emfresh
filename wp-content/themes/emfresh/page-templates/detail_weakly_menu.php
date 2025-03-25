<?php
/**
 * Template Name: Detail Weekly Menu
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="page">
	<section class="content">
		<div class="container-fluid">
			<div class="card-primary">
				<div class="flex justify-between align-center" style="padding-bottom:20px">
					<h4 class="text-xl font-bold">Menu tuần 10 (03/02 - 07/02)</h4>
					<div class="flex" style="gap:10px">
						<span class="btn btn-v2 btn-add-file btn-primary btn-edit"><img class="icon"
								src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pencil.svg"
								alt=""><span>Chỉnh sửa</span></span>
					</div>
				</div>
				<div class="card-body">
					<div class="tab">
						<ul class="nav tab-nav">
							<li class="nav-item defaulttab" rel="tab1">Món mặn</li>
							<li class="nav-item " rel="tab2">Món khác</li>
						</ul>
						<div class="overlay-drop-menu"></div>
						<div class="tab-content">
							<div class="tab-pane" id="tab1">
								<?php include get_template_directory() . '/parts/weekly-menu/menu-savory.php'; ?>
							</div>
							<div class="tab-pane" id="tab2">
								<?php include get_template_directory() . '/parts/weekly-menu/menu-other.php'; ?>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- <div class="toast warning">
		<i class="fas fa-warning"></i>
		Khách hàng vẫn còn đơn đang dùng tại thời điểm <span class="order_date_stop hidden"></span><span
			class="order_date_stop_show"></span>
		<i class="fas fa-trash close-toast"></i>
	</div> -->
</div><!-- /.container-fluid -->
<div class="navigation-bottom  flex justify-between items-center" style="padding: 5px 20px;text-align:right;display:none">
	<span></span>
	<div class="flex" style="gap:10px">
		<span class="btn btn-v2 btn-secondary btn-cancel">Huỷ</span>
		<span class="btn btn-v2 btn-primary">Lưu thay đổi</span>
	</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
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
					<p class="font-bold" style="font-size:24px;margin: 10px 0">Xoá món</p>
					<p class="text-secondary font-medium text-lg">Bạn có chắc chắn muốn xoá món Cơm tấm sườn trứng
						eatclean không?</p>
				</center>
			</div>
			<div class="modal-footer text-center pb-16 flex justify-center" style="gap:15px">
				<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-destructive modal-close">Xoá</button>
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
				<table class="table table-v2 table-print nowrap">
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
				<button type="button" class="btn btn-v2 btn-default modal-close">Đóng</button>
				<button type="button" class="btn btn-v2 btn-primary modal-close">Thêm</button>
			</div>
		</div>
	</div>
</div>
<script>
	function disableInputs() {
		const inputs = document.querySelectorAll(".detail-input");

		inputs.forEach(input => {
			if (input.className.includes("detail-input-hide")) {
				$(input).hide();
			} else {
				input.setAttribute("disabled", true)
			}

		});

	}
	function releaseInputs() {
		const inputs = document.querySelectorAll(".detail-input");

		inputs.forEach(input => {
			if (input.className.includes("detail-input-hide")) {
				$(input).show();
			} else {
				input.removeAttribute("disabled")
			}
		});
	}
	$(".btn-edit").click(function () {
		releaseInputs()
		$(this).hide();
		$('.navigation-bottom').show()
	});
	$(".btn-cancel").click(function () {
		disableInputs()
		$(".btn-edit").show()
		$('.navigation-bottom').hide()
	});
</script>
<script src="<?php site_the_assets(); ?>js/common/tab.js"></script>
<?php

get_footer('customer');
?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings, JSON_UNESCAPED_UNICODE) ?>;</script>