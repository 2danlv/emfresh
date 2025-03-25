<?php
/**
 * Template Name: Detail meal
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
					<h4 class="text-xl font-bold">Cơm tấm sườn trứng eatclean</h4>
					<div class="top-pannel flex" style="gap:10px">
						<span class="btn btn-v2 btn-secondary modal-button" data-target="#modal-list"><img class="icon"
								src="<?php echo site_get_template_directory_assets(); ?>/img/icon/file-plus-gray.svg"
								alt=""><span>Thêm vào
								DS chờ</span></span>
						<span class="btn btn-v2 btn-edit btn-primary"><img class="icon"
								src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pencil.svg"
								alt=""><span>Chỉnh sửa</span></span>
					</div>
				</div>
				<div class="card-body">
					<div class="tab">
						<ul class="nav tab-nav">
							<li class="nav-item defaulttab" rel="general">Thông tin chung</li>
							<li class="nav-item " rel="ingredient">Nguyên liệu</li>
							<li class="nav-item" rel="recipe">Công thức</li>
							<li class="nav-item " rel="layout">Bố cục rau</li>
							<li class="nav-item " rel="notes">Ghi chú</li>
						</ul>
						<div class="overlay-drop-menu"></div>
						<div class="tab-content">
							<div class="tab-pane" id="general">
								<?php include get_template_directory() . '/parts/meal/meal-info.php'; ?>
							</div>
							<div class="tab-pane" id="ingredient">
								<?php include get_template_directory() . '/parts/meal/meal-ingredient.php'; ?>
							</div>
							<div class="tab-pane" id="recipe">
								<?php include get_template_directory() . '/parts/meal/meal-recipe.php'; ?>
							</div>
							<div class="tab-pane" id="layout">
								<?php include get_template_directory() . '/parts/meal/meal-layout.php'; ?>
							</div>
							<div class="tab-pane" id="notes">
								<?php include get_template_directory() . '/parts/meal/meal-notes.php'; ?>
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
	<div class="toast warning">
		<i class="fas fa-warning"></i>
		Khách hàng vẫn còn đơn đang dùng tại thời điểm <span class="order_date_stop hidden"></span><span
			class="order_date_stop_show"></span>
		<i class="fas fa-trash close-toast"></i>
	</div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom flex justify-between items-center" style="padding: 5px 20px;text-align:right">
	<span class="btn btn-v2 btn-destructive btn-outline modal-button" data-target="#modal-confirm-delete"><img
			class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/trash.svg" alt=""><span>Xoá
			Món</span></span>
	<div class="flex" style="gap:10px">
		<span class="btn btn-v2 btn-secondary btn-cancel">Huỷ</span>
		<span class="btn btn-v2 btn-primary btn-save">Lưu thay đổi</span>
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
<?php
get_footer('customer');
?>
<script>
	jQuery(document).ready(function () {
		$(".editable-input").prop("disabled", true);
		$(".edit-show").hide()
		$('.navigation-bottom').hide()
	})
	$(".btn-edit").click(function () {
	
		$(".editable-input").prop("disabled", false);
		$(".edit-show").show()
		$(".btn-edit").hide()
		$('.navigation-bottom').show()
		$(".top-pannel").hide()
	});
	$(".btn-cancel, .btn-save").click(function () {
		$(".editable-input").prop("disabled", true)
		$(".edit-show").hide()
		$(".btn-edit").show()
		$('.navigation-bottom').hide()
		$(".top-pannel").show()
	});
</script>
<script src="<?php site_the_assets(); ?>js/common/tab.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>