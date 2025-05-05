<?php

?>
<div class="flex flex-col">
	<?php
	for ($j = 0; $j < 3; $j++) {
		?>
		<div style="padding:20px 20px 0px 20px">
			<div class="w-full" style="padding:10px 0px">
				<div style="margin-bottom:10px">
					<h4 class="text-lg font-bold">Sơ chế</h4>
					<p class="text-md font-semibold text-secondary">Công đoạn chuẩn bị từ ngày T - 1</p>
				</div>
				<div class="flex items-stretch" style="gap:0 10px">
					<div class="flex-1">
						<table class="w-full table-input table-simple">
							<thead>
								<th class="align-center" style="width:30px"></th>
								<th class="align-left">Thao Tác</th>
								<th class="align-center" style="width:80px">Lượng</th>
								<th class="align-center" style="width:80px">ĐVT</th>
								<th class="align-left" style="width:200px">Nguyên liệu</th>
								<th class="align-center" style="width:100px"></th>
							</thead>
							<tbody>
								<?php
								for ($i = 0; $i < 5; $i++) {
									?>
									<tr class="group">
										<td class="align-center">
											<span class="cursor-pointer hover-visible edit-show">
												<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/grip-vertical.svg"
													alt="icon" />
											</span>
										</td>
										<td><input class="editable-input" type="text" value="Cốt lết rửa sạch, đếm đủ "></td>
										<td><input class="editable-input" type="text" value="1" style="text-align:right"></td>
										<td class="align-right"><select class="editable-input" style="width:auto" name="" id="">
												<option value=""></option>
												<option value="" selected>Miếng</option>
												<option value="">mc</option>
											</select></td>
										<td class="align-center"><input class="editable-input" type="text" value="dầu hào"></td>
										<td class="align-center"> <span class="cursor-pointer hover-visible edit-show"><img
													src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-gray.svg"
													alt="icon" /></span></td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="" style="width:300px;height:100%">
						<p class="text-sm font-medium text-secondary uppercase" style="margin-bottom:5px;padding: 0 5px">Xem
							trước</p>
						<div class="card card-simple card-border">
							<p>Cốt lết rửa sạch, đếm đủ 1 miếng</p>
							<p>Đập mềm miếng thịt để dễ thấm gia vị</p>
							<p>Ướp heo: 0,1 mc nước mắm, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào,
								0,2 mc dầu hào, 0,2 mc dầu hào.</p>
						</div>
					</div>
				</div>
				<p class="text-md font-medium text-secondary" style="margin-top:10px">Cập nhật lần cuối 01/01/2025</p>
			</div>
		</div>
		<?php
	}
	?>
</div>