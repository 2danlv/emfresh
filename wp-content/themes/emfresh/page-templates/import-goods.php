<?php
/**
 * Template Name: Import Goods
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
							<a href="detail-import-goods">
								<div class="day-section has-border hoverred">
									<p class="day-title">THỨ <?php echo $i + 2 ?> <br /> (0<?php echo $i + 3 ?>/02)</p>
									<div class="meal-list">
										<?php
										for ($j = 0; $j < 3; $j++) {
											?>
											<div id="<?php echo $i ?>_<?php echo $j ?>" class="item flex flex-col"
												style="gap:10px">
												<div class="card card-border" style="border-radius:10px">
													<div class="card-body" style="padding:10px">
														<div class="flex flex-col" style="margin-bottom:10px">
															<p class="font-bold text-lg">Cơm tấm sườn trứng eatclean</p>
															<p class="text-tertiary text-md font-semibold">Cơm lứt Séng Cù</p>
														</div>
														<div class="flex text-tertiary font-medium" style="gap:0 20px">
															<div class="flex flex-col">
																<p>Số tinh bột: 100</p>
																<p>Số đạm: 100</p>
																<p>Số hộp: 100</p>
															</div>
															<div class="flex flex-col">
																<p>Dự kiến: 100</p>
																<p>Dự kiến: 100</p>
																<p>Dự kiến: 100</p>
															</div>
														</div>
														<div class="flex items-center" style="padding: 10px 0">
															<p class="text-tertiary">Tag: </p>
															<div id="tag-<?php echo $i + 1 ?>-<?php echo $j + 1 ?>"
																class="tag-container flex flex-1" style="flex-wrap:wrap">
																<input type="text" class="detail-input tag-input flex-1"
																	style="width:1%;min-width:100px" placeholder="Nhập thẻ..."
																	hidden>
																<input type="text" class="input-value" value="Tag 1,Tag 2"
																	style="width:1px;height:1;position:absolute;z-index:-1;visibility:hidden" />
															</div>
														</div>
													</div>

												</div>
												<div class="card card-border" style="border-radius:10px">
													<div class="card-body" style="padding:10px">
														<div class="flex flex-col" style="margin-bottom:10px">
															<p class="font-bold text-lg">Ổi táo, gừng</p>
														</div>
														<div class="flex text-tertiary font-medium" style="gap:0 20px">
															<div class="flex flex-col">
																<p>Số lượng: 100</p>
															</div>
															<div class="flex flex-col">
																<p>Dự kiến: 100</p>
															</div>
														</div>
													</div>

												</div>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</a>
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
<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<?php

get_footer('customer');
?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings, JSON_UNESCAPED_UNICODE) ?>;</script>