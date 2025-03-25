<div class="flex flex-col" style="gap:15px;padding:20px">
	<?php
	for ($i = 0; $i < 3; $i++) {
		?>
		<div class="card card-border rounded-md">
			<div style="padding:10px">
				<div style="margin-bottom:15px">
					<p class="text-llg font-semibold">Dùng ngay</p>
					<p class="text-tertiary font-semibold">Danh sách nguyên liệu sử dụng cho đầu ngày</p>
				</div>
				<table class="w-full table-simple">
					<thead>
						<th class="text-left">STT</th>
						<th class="text-left">Nguyên liệu</th>
						<th class="text-right">KL tính toán</th>
						<th class="text-left">Dạng thức</th>
						<th class="text-left">Nhà cung cấp</th>
					</thead>
					<tbody>
						<?php
						for ($j = 0; $j < 6; $j++) {
							?>
							<tr>
								<td class="text-left" style="width:50px">
									<span class="cell font-medium"><?php echo $j+1 ?></span>
								</td>
								<td class="text-left" style="width:200px">
									<span class="cell font-medium">Cơm lứt tím than</span>
								</td>
								<td class="text-right" style="width:150px">
									<span class="cell font-medium">3.500</span>
								</td>
								<td class="text-right" style="width:250px">
									<span class="cell font-medium"></span>
								</td>
								<td class="text-left">
									<span class="cell font-medium">Kho tinh bột</span>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
</div>