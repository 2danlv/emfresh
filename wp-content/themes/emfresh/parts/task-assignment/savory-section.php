<div class="grid grid-col-3" style="gap:15px;padding:20px">
	<?php
	for ($i = 0; $i < 3; $i++) {
		?>
		<div class="flex flex-col" style="gap:15px">
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
						<div id="tag-<?php echo $i + 1 ?>-<?php echo $j + 1 ?>" class="tag-container flex flex-1"
							style="flex-wrap:wrap">
							<input type="text" class="detail-input tag-input flex-1" style="width:1%;min-width:100px"
								placeholder="Nhập thẻ..." hidden>
							<input type="text" class="input-value" value="Tag 1,Tag 2"
								style="width:1px;height:1;position:absolute;z-index:-1;visibility:hidden" />
						</div>
					</div>
				</div>

			</div>
			<div class="card card-border" style="border-radius:0px;padding:0">
				<div class="card-heading flex flex-col" style="margin-bottom:10px;background:none">
					<p class="font-medium text-tertiary uppercase text-sm">Tinh bột</p>
				</div>
				<div class="card-body" style="padding:10px">
					<ul style="list-style:inherit;padding-left: 20px;">
						<li>Cốt lết rửa sạch, đếm đủ 1 miếng</li>
						<li>Đập mềm miếng thịt để dễ thấm gia vị</li>
						<li>Ướp heo: 0,1 mc nước mắm, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc
							dầu hào, 0,2 mc dầu hào.</li>
					</ul>
				</div>
			</div>
			<div class="card card-border" style="border-radius:0px;padding:0">
				<div class="card-heading flex flex-col" style="margin-bottom:10px;background:none">
					<p class="font-medium text-tertiary uppercase text-sm">Nấu ăn</p>
				</div>
				<div class="card-body" style="padding:10px">
					<ul style="list-style:inherit;padding-left: 20px;">
						<li>Cốt lết rửa sạch, đếm đủ 1 miếng</li>
						<li>Đập mềm miếng thịt để dễ thấm gia vị</li>
						<li>Ướp heo: 0,1 mc nước mắm, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc
							dầu hào, 0,2 mc dầu hào.</li>
					</ul>
				</div>
			</div>
			<div class="card card-border" style="border-radius:0px;padding:0">
				<div class="card-heading flex flex-col" style="margin-bottom:10px;background:none">
					<p class="font-medium text-tertiary uppercase text-sm">Nước sốt riêng</p>
				</div>
				<div class="card-body" style="padding:10px">
					<ul style="list-style:inherit;padding-left: 20px;">
						<li>Cốt lết rửa sạch, đếm đủ 1 miếng</li>
						<li>Đập mềm miếng thịt để dễ thấm gia vị</li>
						<li>Ướp heo: 0,1 mc nước mắm, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc dầu hào, 0,2 mc
							dầu hào, 0,2 mc dầu hào.</li>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
</div>