<?php
/**
 * Template Name: Import List
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
					<h4 class="text-xl font-bold">Danh sách nhập - Thứ 2 (03/02)</h4>
				</div>
				<div class="flex flex-col" style="gap:15px">
					<?php
					for ($i = 0; $i < 3; $i++) {
						?>
						<div class="card card-border rounded-md">
							<div style="padding:10px">
								<div style="margin-bottom:15px">
									<p class="text-llg font-semibold">Đặt trước</p>
									<p class="text-tertiary font-semibold">Danh sách nguyên liệu, gia vị cần trữ sẵn</p>
								</div>
								<table class="w-full table-input table-simple flex-1">
									<thead>
										<th class="text-left">Nhà cung cấp</th>
										<th class="text-left">Nguyên liệu</th>
										<th class="text-right">KL Thực nhập</th>
										<th class="text-left">Chú thích cho nhà cung cấp</th>
										<th class="text-left">Lưu ý cho bếp</th>
										<th class="text-right">KL Tính toán</th>
									</thead>
									<tbody>
										<tr>
											<td class="text-left">
												<span class="cell font-medium">Kho tinh bột</span>
											</td>
											<td class="text-left">
												<span class="cell font-medium">Cơm lức tím than</span>
											</td>
											<td class="text-right" style="width:150px"><span
													class="cell font-medium">3.500</span>
											</td>
											<td class="text-right" style="width:250px">
												<input type="text">
											</td>
											<td class="text-right" style="width:200px">
												<input type="text">
											</td>
											<td class="text-right" style="width:120px">
												<span class="cell font-medium">3.500</span>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					<?php } ?>
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
<div class="navigation-bottom flex justify-between items-center"
	style="padding: 5px 20px;text-align:right">
	<span></span>
	<div class="flex" style="gap:10px">
		<span class="btn btn-v2 btn-secondary btn-cancel">Huỷ</span>
		<span class="btn btn-v2 btn-primary btn-save">Lưu thay
			đổi</span>
	</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<!-- <div class="modal fade" id="modal-confirm-save">
	<div class="overlay"></div>
	<div class="modal-dialog" style="min-width:400px">
		<div class="modal-content" style="padding:0">
			<div style="text-align:right;margin-right:10px">
				<span class="btn btn-v2 btn-ghost btn-icon modal-close">
					<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-black.svg"
						alt="">
				</span>
			</div>
			<div class="modal-body" style="padding:0 20px 20px 20px;max-width:350px;margin:auto">
				<center>
					<div class="icon-wave warning-wave">
						<img class="icon"
							src="<?php echo site_get_template_directory_assets(); ?>/img/icon/alert-triangle-warning.svg"
							alt="">
					</div>
					<p class="font-bold" style="font-size:24px;margin: 10px 0">Lưu ý</p>
					<p class="text-tertiary font-medium text-lg">Bố cục rau chưa đầy đủ thông tin.</p>
					<p class="text-tertiary font-medium text-lg">Bạn có chắc chắn muốn lưu?</p>
				</center>
			</div>
			<div class="modal-footer text-center pb-16 flex justify-center" style="gap:15px">
				<button type="button" class="btn btn-v2 btn-secondary modal-close" style="padding:0 30px">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-primary btn-success btn-save modal-close"
					style="padding:0 30px">Lưu</button>
			</div>
		</div>
	</div>
</div> -->
<script>
	$(".btn-edit").click(function () {
		const inputs = $(".editable-input");
		inputs.each(function () {
			$(this).prop("disabled", false);
		});
		$(".btn-edit").hide()
		$('.navigation-bottom').show()
	});
	$(".btn-cancel, .btn-save").click(function () {
		const inputs = $(".editable-input");
		inputs.each(function () {
			$(this).prop("disabled", true);
		});
		$(".editing").removeClass("editing")
		$(".btn-edit").show()
		$('.navigation-bottom').hide()
	});
</script>
<?php

get_footer('customer');
?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings, JSON_UNESCAPED_UNICODE) ?>;</script>