<?php

$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
// var_dump($response_customer);
?>
<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<div class="flex flex-col">
	<div style="padding:20px">
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
									<div class="flex items-center" style="padding: 10px 0">
										<p>Tag: </p>
										<div id="tag-<?php echo $i + 1 ?>-<?php echo $j + 1 ?>"
											class="tag-container flex flex-1" style="flex-wrap:wrap">

											<input type="text" class="detail-input detail-input-hide tag-input flex-1"
												style="width:1%;min-width:100px" placeholder="Nhập thẻ...">
											<input type="text" class="input-value"
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
