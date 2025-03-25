<?php
/**
 * Template Name: Detail Import Goods
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
					<h4 class="text-xl font-bold">Thứ 2 (03/02)</h4>
					<div class="flex" style="gap:10px">
						<a href="/import-list">
							<span class="btn btn-v2 btn-secondary"><img class="icon"
									src="<?php echo site_get_template_directory_assets(); ?>/img/icon/list-ordered.svg"
									alt=""><span>Xem danh sách nhập</span>
							</span>
						</a>
						<span class="btn btn-v2 btn-edit btn-primary"><img class="icon"
								src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pencil.svg"
								alt=""><span>Chỉnh sửa</span>
						</span>
					</div>
				</div>
				<div class="card card-border">
					<div class="card-heading" style="margin-bottom:15px">
						<p class="text-lg font-semibold">Gà viên sốt Teriyaki</p>
					</div>
					<div class="flex flex-col" style="gap:15px">
						<div class="flex" style="gap:15px">
							<table class="w-full table-input table-simple flex-1">
								<thead>
									<th class="text-left">Nguyên liệu</th>
									<th class="text-left">Dạng thức</th>
									<th class="text-right">Đ.LG</th>
									<th class="text-right">Tổng KL</th>
									<th class="text-left">Ngày Nhập</th>
									<th class="text-left">Nhà cung cấp</th>
								</thead>
								<tbody>
									<tr>
										<td class="text-left" style="width:250px"><span class="cell font-medium">Cơm lức
												tím
												than</span></td>
										<td class="text-left">
											<span class="cell font-medium"></span>
										</td>
										<td class="text-right" style="width:80px"><span
												class="cell font-medium">35</span></td>
										<td class="text-right" style="width:100px"><span
												class="cell font-medium">3.500</span></td>
										<td class="text-right" style="width:120px">
											<select name="" class="font-medium editable-input" disabled
												style="width:auto" id="">
												<option value="1" selected>T-1</option>
												<option value="2">T-2</option>
												<option value="3">T-3</option>
											</select>
										</td>
										<td class="text-left" style="width:200px">
											<select name="" class="font-medium editable-input" disabled id="">
												<option value="1" selected>Kho tinh bột 1</option>
												<option value="2">Kho tinh bột 2</option>
												<option value="3">Kho tinh bột 3</option>
											</select>
										</td>
									</tr>

								</tbody>
							</table>
							<table class="w-full table-simple" style="width:25%">
								<thead>
									<th class="text-right"></th>
									<th class="text-right">Đã đặt</th>
									<th class="text-right">Dự kiến</th>
								</thead>
								<tbody>
									<tr>
										<td class="text-left"><span class="cell font-semibold">Số tinh bột</span></td>
										<td class="text-right" style="width:80px"><span class="cell">100</span></td>
										<td class="text-right" style="width:80px"><span
												class="cell text-primary font-bold">100</span></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="flex items-start" style="gap:15px">
							<table class="w-full table-input table-simple flex-1">
								<tbody>
									<?php
									for ($i = 0; $i < 3; $i++) {
										?>
										<tr>
											<td class="text-left" style="width:250px"><span class="cell font-medium">Ức gà
													không da</span></td>
											<td class="text-left">
												<span class="cell font-medium"></span>
											</td>
											<td class="text-right" style="width:80px"><span
													class="cell font-medium">35</span></td>
											<td class="text-right" style="width:100px"><span
													class="cell font-medium">3.500</span></td>
											<td class="text-right" style="width:120px">
												<select name="" class="font-medium editable-input" disabled
													style="width:auto" id="">
													<option value="1" selected>T-1</option>
													<option value="2">T-2</option>
													<option value="3">T-3</option>
												</select>
											</td>
											<td class="text-left" style="width:200px">
												<select name="" class="font-medium editable-input" disabled id="">
													<option value="1" selected>Kho tinh bột 1</option>
													<option value="2">Kho tinh bột 2</option>
													<option value="3">Kho tinh bột 3</option>
												</select>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
							<table class="w-full table-simple" style="width:25%">
								<tbody>
									<tr>
										<td class="text-left"><span class="cell font-semibold">Số đạm</span></td>
										<td class="text-right" style="width:80px"><span class="cell">100</span></td>
										<td class="text-right" style="width:80px"><span
												class="cell text-primary font-bold">100</span></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="flex items-start" style="gap:15px">
							<table class="w-full table-input table-simple flex-1">
								<tbody>
									<?php
									for ($i = 0; $i < 5; $i++) {
										?>
										<tr>
											<td class="text-left" style="width:250px"><span class="cell font-medium">Lá
													chuối</span></td>
											<td class="text-left">
												<span class="cell font-medium">Lót</span>
											</td>
											<td class="text-right" style="width:80px"><span
													class="cell font-medium">35</span></td>
											<td class="text-right" style="width:100px"><span
													class="cell font-medium">3.500</span></td>
											<td class="text-right" style="width:120px">
												<select name="" class="font-medium editable-input" disabled
													style="width:auto" id="">
													<option value="1" selected>T-1</option>
													<option value="2">T-2</option>
													<option value="3">T-3</option>
												</select>
											</td>
											<td class="text-left" style="width:200px">
												<select name="" class="font-medium editable-input" disabled id="">
													<option value="1" selected>Kho tinh bột 1</option>
													<option value="2">Kho tinh bột 2</option>
													<option value="3">Kho tinh bột 3</option>
												</select>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
							<table class="w-full table-simple" style="width:25%">
								<tbody>
									<tr>
										<td class="text-left"><span class="cell font-semibold">Số hộp</span></td>
										<td class="text-right" style="width:80px"><span class="cell">100</span></td>
										<td class="text-right" style="width:80px"><span
												class="cell text-primary font-bold">100</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
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
<div class="navigation-bottom  flex justify-between items-center"
	style="padding: 5px 20px;text-align:right;display:none">
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