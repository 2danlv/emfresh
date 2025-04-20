<?php
/**
 * Template Name: Create meal
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="page">
	<section class="content">
		<div class="container-fluid">
			<div class="card-primary">
				<div class="card-body">
					<div class="tab">
						<ul class="nav tab-order tab-nav">
							<li class="nav-item defaulttab" rel="general">Thông tin chung</li>
							<li class="nav-item disabled" rel="ingredient">Nguyên liệu</li>
							<li class="nav-item disabled" rel="recipe">Công thức</li>
							<li class="nav-item disabled" rel="layout">Bố cục rau</li>
							<li class="nav-item disabled" rel="note">Ghi chú</li>
						</ul>
						<div class="overlay-drop-menu"></div>
						<div class="tab-content">
							<div class="tab-pane" id="general">
								<?php include get_template_directory() . '/parts/meal/meal-info.php'; ?>
							</div>
							
						</div>
					</div>
					<!-- /.tab-pane -->
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<div class="toast warning">
		<i class="fas fa-warning"></i>
		Khách hàng vẫn còn đơn đang dùng tại thời điểm <span class="order_date_stop hidden"></span><span
			class="order_date_stop_show"></span>
		<i class="fas fa-trash close-toast"></i>
	</div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom" style="text-align:right">
	<span class="btn btn-secondary ">Huỷ</span>
	<span class="btn btn-primary">Tạo mới</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<?php

get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/common/tab.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>