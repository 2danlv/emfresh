	<?php
		global $wpdb;
		function get_first_and_last_day_of_week( $year_number, $week_number ) {
			$today = new DateTime( 'today' );

			return (object) [
				'first_day' => clone $today->setISODate( $year_number, $week_number, 0 ),
				'last_day'  => clone $today->setISODate( $year_number, $week_number, 6 )
			];
		}
		$date = new DateTime($ddate);
		$week = $date->format("W");
		$year = date("Y");
		$week_day = get_first_and_last_day_of_week($year,$week);
		
		if(isset($_POST['action']) && $_POST['action'] == "add_week")
		{	
			$wpdb->show_errors = 1;
			$results = $wpdb->get_results( "SELECT tuan,nam FROM {$wpdb->prefix}em_menu_week ORDER BY id DESC LIMIT 1", OBJECT );
			if(null != $results){
				$week = $results[0]->tuan + 1;
				$year = $results[0]->nam;
				if($week>52) {
					$week = 1;
					$year = $year + 1;
				}
			}	
			$week_day = get_first_and_last_day_of_week($year,$week);
			$table = $wpdb->prefix.'em_menu_week';
			$data = array(
				'name' => "Menu Tuần ".$week.' ( '.$week_day->first_day->format("d/m").' - '.$week_day->last_day->format("d/m").' )',
				'create_at' => strtotime("now"),
				'tuan' => $week,
				'nam' => $year
			);
			$format = array('%s','%s');
			$wpdb->insert($table,$data,$format);
		}
	?>

	<?php

	/**
	 * Template Name: Weekly Menu
	 *
	 * @package WordPress
	 * @subpackage Twenty_Twelve
	 * @since Twenty Twelve 1.0
	 */

	get_header();
	// Start the Loop.
	// while ( have_posts() ) : the_post();
	?>

	<!-- Main content -->
	<?php
		//var_dump($_POST);
		//var_dump($wpdb);
	?>
	<section class="content page-content">
		<!-- Default box -->
		<div class="datatable datatable-v2 weekly-menu">
			<div class="toolbar">
				<form class="em-importer" id="form-submit" data-name="customer" action="<?php the_permalink() ?>" method="post">
					<div class="row ai-center">
						<div class="col-8">
							<ul class="d-f ai-center">
								<li><span value="add_week" class="add btn btn-v2 btn-primary btn-icon btn-plus"><a
											href="#"><img
												class="icon"
												src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus.svg"
												alt=""></a></span>
								</li>
							</ul>
							<input type="hidden" id="action" name="action" value="">
						</div>
						<div class="col-4">
							<ul class="d-f ai-center jc-end">
								<li class="status">
									<span class="btn btn-v2 btn-status" style="display:none"><span class="count-checked"></span>
										<span>đã chọn</span>
										<img class="icon"
											src="<?php echo site_get_template_directory_assets(); ?>/img/icon/x.svg" alt="">
									</span>
								</li>
							</ul>
						</div>
					</div>
					<?php wp_nonce_field('importoken', 'importoken', false); ?>
				</form>
			</div>
			<table class="table table-v2 table-weekly-menu" style="width:100%">
				<thead>
					<tr>
						<th data-number="1"><span class="nowrap">Tên Menu</span></th>
						<th data-number="2" class="text-center" style="width:200px"><span class="nowrap">Trạng thái
							</span></th>
						<th data-number="3" class="text-left"><span class="nowrap">Được tạo vào</span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}em_menu_week ORDER BY id DESC", OBJECT );
					
					foreach ($results as $data) {
						?>
						<tr>

							<td data-number="1" class="text-capitalize nowrap wrap-td" style="min-width: 300px;">
								<div class="ellipsis"><span class="modal-button text-link" data-target="#modal-detail" value="<?=$data->id;?>"><?=$data->name;?></span>
								</div>
							</td>
							<td data-number="2" class="text-center" style="width:200px">
								<span class="badge block badge-status-3">SẮP TỚI</span>
								<!-- <span class="badge block badge-status-1">ĐANG DIỄN RA</span>
								<span class="badge block badge-status-2">ĐÃ XONG</span> -->
							</td>
							<td data-number="3" class="text-left"><?=date("H:i d/m/Y",$data->create_at);?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

		</div>
		<!-- /.card-body -->
	</section>
	<div class="modal fade" id="modal-detail">
		<div class="overlay"></div>
		<div class="modal-dialog" style="min-width:1024px;max-width:95%;padding-bottom:0;overflow:hidden">
			<div class="modal-content" style="position:relative;padding-bottom:20px">
				<div class="modal-header" style="border:none">
					<h4 class="modal-title" style="margin-bottom:20px">Menu tuần 10 (03/02 - 07/02)</h4>
					<span class="badge badge-status-3" style="padding:6px 20px"><span>CHƯA DIỄN RA</span></span>
				</div>
				<div class="modal-body pt-16">
					<div class="menu">
						<?php
						for ($i = 0; $i < 5; $i++) {
							?>
							<div class="day-section">
								<p class="day-title">THỨ <?php echo $i + 2 ?> <br /> (0<?php echo $i + 3 ?>/02)</p>
								<div class="meal-list">
									<div class="flex flex-col" style="gap:10px">
										<div class="meal-item">
											<p class="font-semibold text-lg">Cơm tấm sườn trứng</p>
											<p class="font-semibold text-md text-tertiary">Cơm lứt Séng Cù</p>
										</div>
										<div class="meal-item">
											<p class="font-semibold text-lg">Ổi, táo, gừng</p>
										</div>
									</div>
									<div class="flex flex-col" style="gap:10px">
										<div class="meal-item">
											<p class="font-semibold text-lg">Cơm tấm sườn trứng</p>
											<p class="font-semibold text-md text-tertiary">Cơm lứt Séng Cù</p>
										</div>
										<div class="meal-item">
											<p class="font-semibold text-lg">Ổi, táo, gừng</p>
										</div>
									</div>
									<div class="flex flex-col" style="gap:10px">
										<div class="meal-item">
											<p class="font-semibold text-lg">Cơm tấm sườn trứng</p>
											<p class="font-semibold text-md text-tertiary">Cơm lứt Séng Cù</p>
										</div>
										<div class="meal-item">
											<p class="font-semibold text-lg">Ổi, táo, gừng</p>
										</div>
									</div>
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
			<div class="modal-footer">
				<div class="form-group flex justify-between" style="padding:15px 20px;background:#F5F5F5">
					<!-- <button type="button" class="button btn btn-v2 btn-outline btn-destructive  modal-close">Xoá
						Menu</button> -->
					<span></span>
					<a href="<?php echo home_url('/menu-tuan/chi-tiet/') ?>" class="arrived-detail button btn btn-v2 btn-primary"
						name="add_post">
						<img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/square-arrow-out-up-right.svg"
							alt="">
						Đi đến trang chi tiết</a>
				</div>
			</div>
		</div>
	</div>
	<?php
	// endwhile;

	global $site_scripts;

	if (empty($site_scripts))
		$site_scripts = [];
	$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
	$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

	get_footer('customer');
	?>
	<script src="<?php site_the_assets(); ?>js/weekly-menu.js"></script>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		// Function to save checkbox states to localStorage
		function saveCheckboxState() {
			$('.filter input[type="checkbox"]').each(function () {
				const columnKey = 'column_' + $(this).val(); // Create key like "column_1", "column_2"
				localStorage.setItem(columnKey, $(this).is(':checked'));
			});
		}
		// Function to load checkbox states from localStorage
		function loadCheckboxState() {
			$('.filter input[type="checkbox"]').each(function () {
				const columnKey = 'column_' + $(this).val();
				const savedState = localStorage.getItem(columnKey);
				// If there is no saved state, set defaults for values 1, 3, and 4
				if (savedState === null) {
					if (['1', '3', '4'].includes($(this).val())) {
						$(this).prop('checked', true);
					}
				} else {
					$(this).prop('checked', savedState === 'true');
					//$('.btn-column').addClass('active');
				}
			});
		}

		$(document).ready(function () {
			$('.btn-plus').click(function(e){
				e.preventDefault();
				$('#action').val($(this).attr('value'));
				$('#form-submit').submit();
			})
			// Load checkbox states when the page loads
			loadCheckboxState();

			// Attach event listener to save state when checkboxes change
			$('.filter input[type="checkbox"]').on('change', saveCheckboxState);
			$('.tag-radio').click(function (e) {
				//e.preventDefault();
				$('.tag-radio').addClass('deactive');
				$(this).removeClass('deactive');
			});
			$('#modal-edit .btn-primary.add_post').on('click', function (e) {
				if ($('.list-tag').val() == '') {
					$(".alert-form").show();
					$(".alert-form").text('Chưa chọn tag cần cập nhật');
					return false;
				} else {
					$(".alert-form").hide();
				}
			});

			var $modalBody = $('.modal-result_update .modal-body');
			$('.modal-result_update .nav li.nav-item').click(function () {
				var rel = $(this).attr('rel');
				$('.modal-result_update .nav li.nav-item').removeClass('active');
				$(this).addClass('active');
				$modalBody.find('.row').hide();
				if (rel === 'all') {
					$modalBody.find('.row').show();
				} else {
					$modalBody.find('.row.' + rel).show();
				}
			});
			$('[data-target="#modal-detail"]').click(function(){
				$('.arrived-detail').attr('href',"/menu-tuan/chi-tiet?t="+$(this).attr("value"))
			})
		});
	</script>