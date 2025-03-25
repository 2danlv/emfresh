<?php

$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
// var_dump($response_customer);
?>
<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<div class="flex flex-col">
	<div style="padding:20px">
		<select name="" id="select-mode" style="display:inline-block;width:120px">
			<option value="default" selected>Mặc định</option>
			<option value="detail">Chi tiết</option>
		</select>
		<div class="menu" style="padding:20px 0;">
			<?php
			for ($i = 0; $i < 5; $i++) {
				?>
				<div class="day-section">
					<p class="day-title">THỨ <?php echo $i + 2 ?> <br /> (0<?php echo $i + 3 ?>/02)</p>
					<div class="meal-list">
						<?php
						for ($j = 0; $j < 3; $j++) {
							?>
							<div class="flex flex-col" style="gap:10px">
								<div class="meal-item">
									<select type="text" class="detail-input input-control input-line">
										<option value="default" selected>Món 1</option>
										<option value="detail">Món 2</option>
									</select>
									<select type="text" class="detail-input input-control input-line">
										<option value="default" selected>Món 1</option>
										<option value="detail">Món 2</option>
									</select>
									<input type="text" class="detail-mode detail-input input-control input-highlight"
										style="margin-top:10px" value="Vietnamese Broken Rice" placeholder="Tên Tiếng Anh">
									<div class="tb detail-mode relative">
										<span data-target="#modal-nf"
											class="detail-input detail-input-hide modal-button btn btn-v2 btn-icon btn-secondary absolute top-0 right-0"
											style="background:#E5E5E5!important;border:none!important;margin:3px;display:none"><img
												src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pen-square.svg" /></span>
										<table class="w-full table-input table-grid" style="margin-top:10px">
											<tbody>
												<tr>
													<td class="label" style="width:70px">EM:</td>
													<td colspan="3"><input class="detail-input" style="padding-right:42px"
															type="text"></td>
												</tr>
												<tr>
													<td class="label" style="width:70px">EL:</td>
													<td colspan="3"><input class="detail-input" type="text"></td>
												</tr>
												<tr>
													<td class="label" style="width:70px">SM:</td>
													<td colspan="3"><input class="detail-input" type="text"></td>
												</tr>
												<tr>
													<td class="label" style="width:70px">SL:</td>
													<td colspan="3"><input class="detail-input" type="text"></td>
												</tr>
												<tr>
													<td class="label" style="width:70px">PM:</td>
													<td colspan="3"><input class="detail-input" type="text"></td>
												</tr>
												<tr>
													<td class="label" style="width:70px">PL:</td>
													<td colspan="3"><input class="detail-input" type="text"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="flex items-center" style="padding: 10px 0">
										<p>Tag: </p>
										<div id="tag-<?php echo $i + 1 ?>-<?php echo $j + 1 ?>"
											class="tag-container flex flex-1" style="flex-wrap:wrap">

											<input type="text" class="detail-input detail-input-hide tag-input flex-1"
												style="width:1%;min-width:100px" placeholder="Nhập thẻ..." hidden>
			
											</select>
											<input type="text" class="input-value" value="tag1,tag2"
												style="width:1px;height:1;position:absolute;z-index:-1;visibility:hidden" />
										</div>
									</div>
								</div>
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
		<div class="waiting-list">
			<div class="flex items-center" style="margin:20px 0;">
				<p class="text-lg font-medium">Danh sách chờ </p>
				<span class="tag-number tag-badge tag-secondary" style="margin:0 10px;">11</span>
				<div class="line" style="background:#E5E5E5;height:1px;width:1%;flex:1"></div>
			</div>
			<table class="table table-v2 table-simple w-full table-waiting-list nowrap">
				<thead>
					<tr>
						<th class="text-left">Tên món</th>
						<th class="text-left">Thực đơn</th>
						<th class="text-left">Nguyên liệu</th>
						<th class="text-left">Loại</th>
						<th class="text-right">Số lần nấu</th>
						<th class="text-right">Lần dùng cuối</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i = 0; $i < 20; $i++) {
						?>
						<tr>
							<td class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
								<span class="ellipsis">Cơm tấm sườn trứng eatlean
								</span>
							</td>
							<td class="text-left"><span>Món mặn</span></td>
							<td class="text-left">
								<span>Cá</span>
							</td>
							<td class="text-left">Base</td>
							<td class="text-right">10</td>
							<td class="text-right">Tuần 52</td>
						</tr>
						<?php
					}
					?>
				</tbody>

			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-nf">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Chỉnh NF</h4>
			</div>
			<div class="modal-body pt-16">
				<div class="">
					<p class="text-secondary font-medium font-md" style="margin-bottom:10px">Thông tin cơ bản cho một
						phần ăn cơ bản</p>
					<div class="grid" style="grid-template-columns: repeat(3, 1fr);gap: 20px">
						<table class="w-full table-input table-grid">
							<tbody>
								<tr>
									<td class="label" style="width:100px">Protein</td>
									<td colspan="3"><input type="text"></td>
								</tr>

							</tbody>
						</table>
						<table class="w-full table-input table-grid">
							<tbody>
								<tr>
									<td class="label" style="width:100px">Protein</td>
									<td colspan="3"><input type="text"></td>
								</tr>
							</tbody>
						</table>
						<table class="w-full table-input table-grid">
							<tbody>
								<tr>
									<td class="label" style="width:100px">Liqid</td>
									<td colspan="3"><input type="text"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<span class="btn btn-v2 btn-secondary"
						style="background:#f5f5f5!important;border:none!important;margin:20px 0">Tính kết quả</span>
					<table class="w-full table-simple">
						<thead>
							<th class="align-left" style="width:50px">Mã</th>
							<th class="align-center" style="width:80px">C.Range</th>
							<th class="align-center" style="width:80px">P.Range</th>
							<th class="align-center" style="width:80px">C</th>
							<th class="align-center" style="width:80px">P</th>
							<th class="align-center" style="width:80px">L</th>
							<th class="align-center" style="width:80px">G</th>
							<th class="align-left">Kết quả</th>
						</thead>
						<tbody>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">480-530</td>
								<td class="align-center">30-40</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">660-720</td>
								<td class="align-center">40-55</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">400-450</td>
								<td class="align-center">30-40</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">500-570</td>
								<td class="align-center">40-55</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">620-720</td>
								<td class="align-center">55-70</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EM</td>
								<td class="align-center">800-900</td>
								<td class="align-center">67-80</td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-center"></td>
								<td class="align-left"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div class="flex items-center justify-between" style="padding:15px 15px 0 15px">
			<!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
			<span></span>
			<div class="flex items-center" style="gap:10px">
				<button type="button" class="btn btn-v2 btn-secondary modal-close">Huỷ</button>
				<button type="button" class="btn btn-v2 btn-primary modal-close">
					<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/pen-square-white.svg" />
					| Ghi đè và đóng</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		disableInputs();
		$("select#select-mode").change(function () {
			if ($(this).val() === "detail") {
				$(".detail-mode").show();
			} else {
				$(".detail-mode").hide();
			}
		}).trigger("change"); // Gọi ngay khi trang tải để áp dụng trạng thái ban đầu
	});

</script>