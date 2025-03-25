<?php
/**
 * Template Name: Detail meal
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
						<ul class="nav tab-nav">
							<li class="nav-item defaulttab" rel="summary">Tổng hợp danh sách</li>
							<li class="nav-item " rel="savory">Khu vực phần mặn</li>
							<li class="nav-item " rel="vegetable">Khu vực rau</li>
							<li class="nav-item " rel="preparation">Sơ chế cuối buổi</li>
						</ul>
						<div class="overlay-drop-menu"></div>
						<div class="tab-content">
							<div class="tab-pane" id="summary">
								<?php include get_template_directory() . '/parts/task-assignment/summary.php'; ?>
							</div>
							<div class="tab-pane" id="savory">
								<?php include get_template_directory() . '/parts/task-assignment/savory-section.php'; ?>
							</div>
							<div class="tab-pane" id="vegetable">
								<?php include get_template_directory() . '/parts/task-assignment/vegetable-section.php'; ?>
							</div>
							<div class="tab-pane" id="preparation">
								<?php include get_template_directory() . '/parts/task-assignment/final-preparation.php'; ?>
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
<div class="navigation-bottom flex justify-between items-center" style="padding: 5px 20px;text-align:right">
	<span></span>
	<div class="flex" style="gap:10px">
		<span class="btn btn-v2 btn-secondary ">Huỷ</span>
		<span class="btn btn-v2 btn-primary">Lưu thay đổi</span>
	</div>
</div>
</section>
<!-- /.content -->
</div>

<script src="<?php site_the_assets(); ?>js/tag-input/tag-input.js"></script>
<script src="<?php site_the_assets(); ?>js/common/tab.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>