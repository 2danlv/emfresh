<?php
/**
 * Template Name: Vegetable Layout
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
				<div class="card-body">
					<div class="menu">
						<?php
						for ($i = 0; $i < 5; $i++) {
							?>
							<div class="day-section has-border">
								<p class="day-title">THỨ <?php echo $i + 2 ?> <br /> (0<?php echo $i + 3 ?>/02)</p>
								<div class="meal-list">
									<?php
									for ($j = 0; $j < 3; $j++) {
										?>
										<div id="<?php echo $i ?>_<?php echo $j ?>" class="item flex flex-col">
											<div class="flex justify-between" style="padding:10px;background:#FAFAFA">
												<div class="flex flex-col">
													<p class="font-bold text-lg">Cơm tấm sườn trứng eatclean</p>
													<p class="text-tertiary text-md font-semibold">Cơm lứt Séng Cù</p>
												</div>
												<span class="btn-edit-item btn btn-v2 btn-icon btn-secondary "
													style="background:##F5F5F5!important;border:none!important;margin:3px"><img
														src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pencil-gray.svg" /></span>
											</div>
											<table class="w-full table-input table-simple">
												<tbody>
													<?php
													for ($r = 0; $r < 5; $r++) {
														?>
														<tr>
															<td style="width:150px">
																<select class="editable-input" disabled name="" id="">
																	<option value=""></option>
																	<option value="la-chuoi" selected>Lá chuối</option>
																	<option value="cu-dau">Củ đậu</option>
																	<option value="dau-que">Đậu que</option>
																</select>
															</td>
															<td><input class="editable-input" disabled value="Lót" type="text"></td>
															<td><input class="editable-input disabled text-right" value="50"
																	type="text">
															</td>
														</tr>
														<?php
													}
													?>
													<tr>
														<td style="width:150px">
															<select class="editable-input" disabled name="" id="">
																<option value=""></option>
																<option value="la-chuoi">Lá chuối</option>
																<option value="cu-dau">Củ đậu</option>
																<option value="dau-que">Đậu que</option>
															</select>
														</td>
														<td><input class="editable-input" disabled type="text"></td>
														<td><input class="editable-input text-right" disabled type="text"></td>
													</tr>
												</tbody>
											</table>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
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
		<span class="btn btn-v2 btn-primary btn-save-changes modal-button" data-target="#modal-confirm-save">Lưu thay
			đổi</span>
	</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<div class="modal fade" id="modal-confirm-save">
	<div class="overlay"></div>
	<div class="modal-dialog" style="min-width:400px">
		<div class="modal-content" style="padding:0">
			<div style="text-align:right;margin-right:10px">
				<span class="btn btn-v2 btn-ghost btn-icon modal-close">
					<img class="icon" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-black.svg" alt="">
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
				<button type="button" class="btn btn-v2 btn-primary btn-success btn-save modal-close" style="padding:0 30px">Lưu</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(".btn-edit-item").click(function () {
		const item = $(this).closest(".item")
		const inputs = item.find(".editable-input");
		inputs.each(function () {
			$(this).prop("disabled", false);
		});
		item.addClass("editing")
		$(".btn-edit-item").hide()
		$('.navigation-bottom').show()
	});
	$(".btn-cancel, .btn-save").click(function () {
		const inputs = $(".editable-input");
		inputs.each(function () {
			$(this).prop("disabled", true);
		});
		$(".editing").removeClass("editing")
		$(".btn-edit-item").show()
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