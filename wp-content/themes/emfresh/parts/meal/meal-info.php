<?php

$meal_tag_values = array_keys($meal_detail['tag_list']);

$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());

// var_dump($em_menu->get_setting('tag'));

$file = '/var/www/shop/html/wp-content/uploads/em-menu/20250424073102-465578788_858497503118215_7455140495729756933_n.jpg';
if(file_exists($file)) {
	@unlink($file);
}

?>
<form action="<?php the_permalink() ?>" class="meal-info-form" method="post" enctype="multipart/form-data">
<input type="hidden" name="save_menu" value="<?php echo wp_create_nonce('menunonce'); ?>">
<input type="hidden" name="menu_id" value="<?php echo $meal_detail['id']; ?>">
<input type="file" name="media" id="media" value="" style="display: none;"/>
<!-- <button>Submit</button> -->
<div class="flex flex-col">
	<div style="padding:20px">
		<div class="flex" style="align-items: stretch;gap:50px">
			<div class="" style="width:35%;">
				<div style="height:100%;cursor:pointer">
					<div id="dropzone-template" class="fileinput-button dz-clickable upload-drop-zone"
						style="width:100%;height:100%">
						<div class="upload-wrapper">
							<div class="upload-content">
								<img class="upload-image" src="<?php echo site_get_template_directory_assets(); ?>/img/icon/upload-image.svg" alt="">
								<p class="text-base font-medium">Drop your files here or <span class="text-primary font-semibold">browse</span></p>
								<p class="text-secondary font-medium text-small">Maximum size: 50MB</p>
							</div>
							<div class="upload-preview">
								<div id="previews">
									<div id="template" class="file-row">
										<img data-dz-thumbnail <?php echo !empty($meal_detail['image_url']) != '' ? 'src="'. $meal_detail['image_url'] .'"' : '' ?> />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="flex:1">
				<div class="w-full" style="padding:10px 0px">
					<table class="w-full table-input table-grid">
						<tbody>
							<tr>
								<td class="label" style="width:150px">Tên món</td>
								<td colspan="3"><input class="editable-input" name="name" type="text" value="<?php echo $meal_detail['name'] ?>" required></td>
							</tr>
							<tr>
								<td class="label" style="width:150px">Tên Tiếng Anh</td>
								<td colspan="3"><input class="editable-input" name="name_en" type="text" value="<?php echo $meal_detail['name_en'] ?>"></td>
							</tr>
							<tr>
								<td class="label" style="width:150px">Trạng thái</td>
								<td>
									<select class="editable-input" name="status" id="status" required>
										<?php
											foreach($list_statuses as $value => $label) {
												echo '<option value="'.$value.'" '
													.($value == $meal_detail['status'] ? 'selected' : '' ).'>'
													.$label.'</option>';
											}
										?>
									</select>
								</td>
								<td class="label" style="width:150px">Nhóm</td>
								<td><select class="editable-input" name="group" id="group" required>
										<?php
											foreach($list_groups as $value => $label) {
												echo '<option value="'.$value.'" '
													.($value == $meal_detail['group'] ? 'selected' : '' ).'>'
													.$label.'</option>';
											}
										?>
									</select></td>
							</tr>
							<tr>
								<td class="label" style="width:150px">Nguyên liệu</td>
								<td><select class="editable-input" name="ingredient" id="ingredient" required>
										<?php
											foreach($list_ingredients as $value => $label) {
												echo '<option value="'.$value.'" '
													.($value == $meal_detail['ingredient'] ? 'selected' : '' ).'>'
													.$label.'</option>';
											}
										?>
									</select></td>
								<td class="label" style="width:150px">Loại</td>
								<td><select class="editable-input" name="type" id="type" required>
										<?php
											foreach($list_types as $value => $label) {
												echo '<option value="'.$value.'" '
													.($value == $meal_detail['type'] ? 'selected' : '' ).'>'
													.$label.'</option>';
											}
										?>
									</select></td>
							</tr>
							<tr>
								<td class="label" style="width:150px">Tag</td>
								<td colspan="3">
									<select class="editable-input input-control select2" multiple="multiple"
										name="tags[]" style="width: 100%;">
										<?php
											foreach($list_tags as $value => $label) {
												echo '<option value="'.$value.'" '
													.(in_array($value, $meal_tag_values) ? 'selected' : '' ).'>'
													.$label.'</option>';
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="label" style="width:150px">Số lần nấu</td>
								<td><input class="editable-input" type="number" name="cooking_times" value="<?php echo $meal_detail['cooking_times'] ?>"></td>
								<td class="label" style="width:150px">Lần cuối dùng</td>
								<td><input class="editable-input" type="date" name="last_used" value="<?php echo $meal_detail['last_used'] ?>"></td>
							</tr>
							<tr>
								<td class="label align-top" style="width:150px">Lưu ý:</td>
								<td colspan="3">
									<textarea class="editable-input" id="w3review" name="note" rows="4" cols="50"><?php echo $meal_detail['note'] ?></textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div style="padding:20px">
		<div class="flex" style="align-items: stretch;gap:50px">
			<div class="flex flex-col" style="width:35%;gap:10px;align-items: flex-start">
				<p class="text-secondary font-medium font-md">Thông tin cơ bản cho một phần ăn cơ bản</p>
				<table class="w-full table-input table-grid">
					<tbody>
						<tr>
							<td class="label" style="width:150px">Protein</td>
							<td colspan="3"><input id="input_protein" class="editable-input" type="text"></td>
						</tr>
						<tr>
							<td class="label" style="width:150px">Liqid</td>
							<td colspan="3"><input id="input_liqid" class="editable-input" type="text"></td>
						</tr>
						<tr>
							<td class="label" style="width:150px">Glucid</td>
							<td colspan="3"><input id="input_glucid" class="editable-input" type="text"></td>
						</tr>
					</tbody>
				</table>
				<button id="btn_calculate" class="btn btn-secondary"><span class="font-semibold">Tính kết quả</span></button>
			</div>
			<div style="flex:1">
				<div class="w-full" style="padding:10px 0px">
					<table id="table_nutrition" class="w-full table-simple">
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
								<td class="c_range align-center">480-530</td>
								<td class="p_range align-center">30-40</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
							<tr>
								<td class="align-left">EL</td>
								<td class="c_range align-center">660-720</td>
								<td class="p_range align-center">40-55</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
							<tr>
								<td class="align-left">SM</td>
								<td class="c_range align-center">400-450</td>
								<td class="p_range align-center">30-40</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
							<tr>
								<td class="align-left">SL</td>
								<td class="c_range align-center">500-570</td>
								<td class="p_range align-center">40-55</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
							<tr>
								<td class="align-left">PM</td>
								<td class="c_range align-center">620-720</td>
								<td class="p_range align-center">55-70</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
							<tr>
								<td class="align-left">PL</td>
								<td class="c_range align-center">800-900</td>
								<td class="p_range align-center">67-80</td>
								<td class="c align-center"></td>
								<td class="p align-center"></td>
								<td class="l align-center"></td>
								<td class="g align-center"></td>
								<td class="result align-left"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<script src="<?php site_the_assets(); ?>js/meal.js"></script>
<script>
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
		url: "/target-url", // Set the url
		thumbnailWidth: null,
		thumbnailHeight: null,
		parallelUploads: 20,
		maxFiles: 1,
		acceptedFiles: "image/*",
		previewTemplate: previewTemplate,
		autoQueue: false, // Make sure the files aren't queued until manually added
		previewsContainer: "#previews", // Define the container to display the previews
		clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
		accept: function(file, done) {
			let media = document.getElementById('media');
			if(media && done) {
				let container = new DataTransfer(); 
    			container.items.add(file);
				media.files = container.files;
			}
		}
	});

	myDropzone.on("sending", function (file) {
		// Show the total progress bar when upload starts
		// document.querySelector("#total-progress").style.opacity = "1";
		// // And disable the start button
		// file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");		
	});

	// Hide the total progress bar when nothing's uploading anymore
	myDropzone.on("queuecomplete", function (progress) {
		// document.querySelector("#total-progress").style.opacity = "0";
	});
</script>