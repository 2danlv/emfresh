<?php
		global $wpdb;
		$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
		function get_first_and_last_day_of_week( $year_number, $week_number ) {
			$today = new DateTime( 'today' );

			return (object) [
				'0' => clone $today->setISODate( $year_number, $week_number, 0 ),
				'1' => clone $today->setISODate( $year_number, $week_number, 1 ),
				'2' => clone $today->setISODate( $year_number, $week_number, 2 ),
				'3' => clone $today->setISODate( $year_number, $week_number, 3 ),
				'4' => clone $today->setISODate( $year_number, $week_number, 4 ),
			];
		}
		$date = new DateTime($ddate);
		$week = $date->format("W");
		$year = date("Y");
		$array_meal_mon_man = [];
		$array_meal_mon_tinh_bot = [];
		if(isset($_POST['action']) && $_POST['action'] == "add_mon_chinh"){
			$data_mon = explode('@',$_POST['data_mon']);			
			$data = [ 
				'thu_2' => join('-',array_filter(explode('-',$data_mon[0]))),
				'thu_3' => join('-',array_filter(explode('-',$data_mon[1]))),
				'thu_4' => join('-',array_filter(explode('-',$data_mon[2]))),
				'thu_5' => join('-',array_filter(explode('-',$data_mon[3]))),
				'thu_6' => join('-',array_filter(explode('-',$data_mon[4]))),
			]; 
			$where = [ 'id' => $_GET['t'] ];
			$wpdb->update( $wpdb->prefix . 'em_menu_week', $data, $where );
		}
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}em_menu_week where id=".$_GET['t'], OBJECT );
		$array_meal_load = array(
			$results[0]->thu_2,
			$results[0]->thu_3,
			$results[0]->thu_4,
			$results[0]->thu_5,
			$results[0]->thu_6,
		);
		$list_id = array_filter(explode('-',$results[0]->menu_id));
		$week_day = get_first_and_last_day_of_week($year,$results[0]->tuan);


?>
<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<div class="flex flex-col">
	<div style="padding:20px">
		<select name="" id="select-mode" style="display:inline-block;width:120px">
			<option value="default" selected>Mặc định</option>
			<option value="detail">Chi tiết</option>
		</select>
		<div class="menu mon-man-menu" style="padding:20px 0;">
			<?php
			for ($i = 0; $i < 5; $i++) {
				?>
				<div class="day-section">
					<p class="day-title">THỨ <?php echo $i + 2 ?> <br /> (<?=$week_day->$i->format('d/m');?>)</p>
					<div class="meal-list">
						<?php
						for ($j = 0; $j < 3; $j++) {
							$results_menu = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}em_menu where id=".$_GET['t'], OBJECT );
							?>
							<div class="flex flex-col" style="gap:10px">
								<div class="meal-item">
									<select type="text" class="detail-input input-control mon-man input-line">
										<option value="" selected>Món mặn</option>
									</select>
									<select type="text" class="detail-input input-control tinh-bot input-line">
										<option value="" selected>Món tinh bột</option>
									</select>
									<input type="text" class="detail-mode detail-input input-control input-highlight"
										style="margin-top:10px" value="Vietnamese Broken Rice" placeholder="Tên Tiếng Anh">
									<div class="tb detail-mode relative">
										<span data-target="#modal-nf"
											class="detail-input detail-input-hide modal-button btn btn-v2 btn-icon btn-secondary absolute top-0 right-0"
											style="background:#E5E5E5 !important;border:none !important;margin:3px;display:none"><img
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
						if(count($list_id)){
							foreach($list_id as $id)
							{
								$meal = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}em_menu where id=".$id, OBJECT )[0];
								if($meal->group == 'mon-man'){
									array_push($array_meal_mon_man,array(
										'id' => $meal->id,
										'name' => $meal->name,
										'type' => $meal->group,
										'tag' => $meal->tag,
										'status' => 0
									));	
								} elseif ($meal->group == 'tinh-bot'){
									array_push($array_meal_mon_tinh_bot,array(
										'id' => $meal->id,
										'name' => $meal->name,
										'type' => $meal->group,
										'tag' => $meal->tag
									));	
								}
								
															
								?>
									<tr>
								<td class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
									<span class="ellipsis"><?=$meal->name;?></span>
									</td>
									<td class="text-left"><span>Món mặn</span></td>
									<td class="text-left">
										<span>Cá</span>
									</td>
									<td class="text-left">Base</td>
									<td class="text-right">10</td>
									<td class="text-right"><?=$results[0]->name;?></td>
								</tr>
								<?php
							}
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
						style="background:#f5f5f5 !important;border:none !important;margin:20px 0">Tính kết quả</span>
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
<form id="edit_mon_chinh" method="POST">
	<input type="hidden" name="action" value="add_mon_chinh">
	<input type="hidden" name="data_mon" id="data_mon">
</form>
<script>
	$(document).ready(function () {
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		disableInputs();
		$("select#select-mode").change(function () {
			if ($(this).val() === "detail") {
				$(".detail-mode").show();
			} else {
				$(".detail-mode").hide();
			}
		}).trigger("change"); // Gọi ngay khi trang tải để áp dụng trạng thái ban đầu
		
		$('.btn-add-file').click(function(){

		})
		$('#menu_tuan_name').text('<?=$results[0]->name;?>');
		
		var data_meal_mon_man = <?=json_encode(array_reverse($array_meal_mon_man));?>;
		var data_meal_mon_tinh_bot = <?=json_encode(array_reverse($array_meal_mon_tinh_bot));?>;
		var load_meal_mon_man = <?=json_encode($array_meal_load);?>;
		
		console.log(load_meal_mon_man);
		console.log(data_meal_mon_man);
		console.log(data_meal_mon_tinh_bot);
// 		console.log(data_meal_mon_man.find(x => x.id == 3));
		
		function load_mon_man(){
			$.each(load_meal_mon_man,function(index,value){
				if(value!=""){
					var data = value.split('-');
					$.each(data,function(index1,value1){
						var data_1 = value1.split(',');
						if(data_1[0] != ""){
							var lay_mon_man = data_meal_mon_man.find(x => x.id == data_1[0]);
							var get_input_mon_man = $('.mon-man-menu .day-section').eq(index).find('.meal-item').eq(index1).find('.mon-man');
							get_input_mon_man.empty();
							get_input_mon_man.append($('<option>').val(lay_mon_man["id"]).text(lay_mon_man["name"]));
							update_state(data_meal_mon_man,"id",lay_mon_man["id"],1);
						}
						if(data_1.length == 2){
							var lay_mon_tinh_bot = data_meal_mon_tinh_bot.find(x => x.id == data_1[1]);
							var get_input_tinh_bot = $('.mon-man-menu .day-section').eq(index).find('.meal-item').eq(index1).find('.tinh-bot');
							get_input_tinh_bot.empty();
							get_input_tinh_bot.append($('<option>').val(lay_mon_tinh_bot["id"]).text(lay_mon_tinh_bot["name"]));
						}
					})
				}
			})
		}
		
		load_mon_man()
		
		$('.detail-input.input-control.mon-man').on('focus',function(){
			var temp_id = $(this).val();
			if(temp_id) update_state(data_meal_mon_man,"id",temp_id,0);
			var temp = $(this);
			temp.empty();
			temp.append($('<option>').val("").text("Chưa chọn"));
			$.each(data_meal_mon_man,function(index,value){
				if(value['status']==0){
					temp.append($('<option>').val(value['id']).text(value['name']));
				}
			})					
		}).focusout(function(){
			update_state(data_meal_mon_man,"id",$(this).val(),1);
		})	
		
		$.each(data_meal_mon_tinh_bot,function(index,value){
			$('.detail-input.input-control.tinh-bot').append($('<option>').val(value['id']).text(value['name']));
		})	
		
		function update_state(array,state,value_check,value_update){
			$.each(array,function(index,value){
				if(value[state]==value_check){
					value['status'] = value_update;
				}
			})
		}
		$('.btn-save-data').click(function(){
			var array_ketqua = [];
			var mon_mam,tinh_bot;
			var string_temp = "";
			$.each($('.mon-man-menu .meal-item'),function(index,value){
				mon_mam = $(value).find('.mon-man').val();
				tinh_bot = $(value).find('.tinh-bot').val();
				if(tinh_bot){
					string_temp += mon_mam+","+tinh_bot+"-";
				}else if(mon_mam){
					string_temp += mon_mam+"-";
				}
				if((index+1)%3 == 0 && index!=0){
					array_ketqua.push(string_temp);
					string_temp = "";
				}
			})
			$('#data_mon').val(array_ketqua.join("@"));
			$('#edit_mon_chinh').submit();
		})
	});

</script>