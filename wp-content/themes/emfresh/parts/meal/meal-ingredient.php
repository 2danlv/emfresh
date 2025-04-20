<?php

$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
// var_dump($response_customer);
?>
<div class="flex flex-col">
	<div style="padding:20px">
		<div class="w-full" style="padding:10px 0px">
			<table class="w-full table-input table-simple">
				<thead>
					<th class="align-center" style="width:30px"></th>
					<th class="align-left" style="width:500px">NGUYÊN LIỆU</th>
					<th class="align-left">DẠNG THỨC</th>
					<th class="align-right" style="width:100px">ĐỊNH LƯỢNG</th>
					<th class="align-center" style="width:200px">NGÀY NHẬP</th>
					<th class="align-left" style="width:200px">NHÀ CUNG CẤP</th>
					<th class="align-center" style="width:30px"></th>
				</thead>
				<tbody>
					<?php
					for ($i = 0; $i < 5; $i++) {
						?>
						<tr class="group">
							<td class="align-center">
								<span class="cursor-pointer hover-visible edit-show">
									<img
										src="<?php echo site_get_template_directory_assets(); ?>/img/icon/grip-vertical.svg"
										alt="icon" />
								</span>
							</td>
							<td class="align-center"><input class="editable-input" disabled type="text"
									value="Tên nguyên liệu"></td>
							<td class="align-left"><input class="editable-input" disabled type="text" value="Dạng thức">
							</td>
							<td class="align-right"><input class="editable-input" disabled type="text" value="100"></td>
							<td class="align-right"> <select class="editable-input" disabled style="width:auto" name=""
									id="">
									<option value="">T-1</option>
									<option value="">T-2</option>
									<option value="">T-3</option>
								</select></td>
							<td class="align-center"> <select class="editable-input" disabled name="" id="">
									<option value="">Tên nhà cung cấp 1</option>
									<option value="">Tên nhà cung cấp 2</option>
									<option value="">Tên nhà cung cấp 3</option>
								</select></td>
							<td class="align-center">
								<span class="cursor-pointer hover-visible edit-show"><img
										src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x-gray.svg"
										alt="icon" /></span>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<span class="btn btn-v2 btn-ghost edit-show" style="margin:10px 0">
				<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus-gray.svg"
					alt="icon" /><span>Thêm hàng</span>
			</span>
		</div>
	</div>
</div>