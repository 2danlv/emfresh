<?php

?>
<div class="flex flex-col">
	<div style="padding:20px">
		<div class="card card-border flex justify-between items-center" style="padding:10px 15px">
			<div class="flex" style="gap:15px;align-items:flex-start">
				<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/layout.svg" alt="icon" />
				<div class="">
					<p class="font-medium text-lg text-base">Bố cục cố định</p>
					<p class="font-medium text-secondary text-md">Nguyên liệu và định lượng rau củ sẽ tự động sao chép
						lần gần nhất</p>
				</div>
			</div>
			<label class="switch mt-16 mb-16">
				<input class="form-check-input" type="checkbox" value="1" name="layout-switch" id="auto_choose">
				<span class="slider"></span>
			</label>
		</div>
		<div class="w-full grid" style="padding:10px 0px;grid-template-columns: repeat(3, minmax(0, 1fr));gap:15px">
			<?php
			for ($j = 0; $j < 3; $j++) {
				?>
				<div class="w-full" style="padding:10px 0px">
					<table class="w-full table-input table-simple">
						<thead>
							<th class="align-left">NGUYÊN LIỆU</th>
							<th class="align-left">DẠNG THỨC</th>
							<th class="align-right" style="width:100px">Đ.LG</th>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < 5; $i++) {
								?>
								<tr class="group">
									<td class="align-left"><p class="cell">Lá chuối</p></td>
									<td class="align-left"><p class="cell">Lót</p></td>
									<td class="align-right"><p class="cell">50</p></td>
								</tr>
								<?php
							}
							?>
							<tr class="group">
								<td class="align-center"><p class="cell"></p></td>
								<td class="align-left"><p class="cell"></p></td>
								<td class="align-right"><p class="cell"></p></td>
							</tr>
						</tbody>
					</table>
					<p class="text-secondary font-medium font-md mt-10" style="padding:10px 15px;background:#F5F5F5">Sử dụng
						vào ngày 01/01/2025</p>
				</div>
				<?php
			}
			?>
		</div>

	</div>
</div>