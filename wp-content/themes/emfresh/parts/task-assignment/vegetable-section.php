<div class="flex flex-col" style="gap:15px;padding:20px">
	<div class="grid grid-col-3" style="gap:15px;">
		<?php
		for ($i = 0; $i < 3; $i++) {
			?>
			<div class="flex flex-col" style="gap:15px">
				<div class="card card-border" style="border-radius:0px;padding:0">
					<div class="card-heading flex flex-col" style="background:#FAFAFA">
						<p class="font-bold text-lg">Cơm tấm sườn trứng eatclean</p>
						<p class="text-tertiary text-md font-semibold">Cơm lứt Séng Cù</p>
					</div>
					<div class="card-body" style="padding:0px">
						<table class="w-full table-simple">
							<tbody>
								<?php
								for ($j = 0; $j < 8; $j++) {
									?>
									<tr>
										<td class="text-left">
											<span class="cell font-medium">Xà lách</span>
										</td>
										<td class="destructive text-left">
											<span class="cell font-medium">Sợi</span>
										</td>
										<td class="text-right">
											<span class="cell font-medium">1.200</span>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		<?php } ?>
	</div>
	<div class="input">
		<label for="" class="input-label">Khu vực bếp 1</label>
		<textarea name="" class="input-control" id="" rows="5"></textarea>
	</div>
	<div class="input">
		<label for="" class="input-label">Khu vực bếp 2</label>
		<textarea name="" class="input-control" id="" rows="5"></textarea>
	</div>
	<div class="input">
		<label for="" class="input-label">Thứ tự luộc</label>
		<textarea name="" class="input-control" id="" rows="5"></textarea>
	</div>
</div>