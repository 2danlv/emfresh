<?php

/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title><?php echo strip_tags(get_the_title()); ?> | <?php echo get_bloginfo( 'name' ); ?></title>
	<?php if (0 && is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&display=swap" rel="stylesheet">
	<?php
	site_get_template_part('parts/section/header-customer');
	?>
	<?php wp_head(); ?>
	<!-- <link href="<?php site_the_assets('images/favicon.png'); ?>" type="image/png"  rel="shortcut icon"/> -->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
<script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
<![endif]-->
<script>
$(document).ready(function() {
    <?php 
	if ( is_page_template( 'page-templates/list-customer.php' ) || is_page_template( 'page-templates/detail-customer.php' ) ) { ?>
    <?php } else { ?>
		localStorage.setItem('DataTables_list-customer_/customer/', '');
		for (let i = 1; i <= 16; i++) {
			localStorage.removeItem('column_' + i);
		}
	<?php } 
	if ( is_page_template( 'page-templates/list-order.php' ) || is_page_template( 'page-templates/page_detail-order.php' ) ) { ?>
		<?php } else { ?>
			localStorage.setItem('DataTables_list-order_/list-order/', '');
			for (let i = 1; i <= 23; i++) {
				localStorage.removeItem('column_order_' + i);
			} 
		<?php } ?>
});
</script>
</head>

<body <?php body_class(); ?>>
	<div class="site container-fluid">
		<div class="row" style="flex-wrap:nowrap">
			<?php
			include get_theme_file_path('parts/sidebar/sidebar.php');
			?>
			<div class="col-10 content-wrapper">
				<!-- Content Header (Page header) -->
				<?php 
				if ( is_page_template( 'page-templates/detail-customer.php' ) ) { ?>
					<style>
					.content-header  {
						display: none;
					}
					</style>
					<?php } 
					?>
				<section class="content-header">
					<div class="row ai-center">
						<div class="col-9 d-f ai-center nowrap">
							<h1>
							<?php
							$args = wp_unslash( $_GET );
							if ( isset($args[ 'groupby' ]) && $args[ 'groupby' ] == 'group' ) {
								echo "Trang tổng quát Nhóm";
							} else {
								the_title();
							}
							?>
							</h1>
							<div class="wrap-search">
								<input class="input-search" placeholder="Tên khách hàng / SĐT / Địa chỉ" type="text">
								<div class="clear-input"><img
                src="<?php echo site_get_template_directory_assets(); ?>/img/icon/delete-svgrepo-com.svg" alt=""></div>
								<div class="top-results">
									 <div id="top-autocomplete-results" class="autocomplete-results"></div>
								</div>
							</div>
							<?php 
							if ( !is_page_template( 'page-templates/list-customer.php' ) &&
							 !is_page_template( 'page-templates/list-order.php' ) &&
							 !is_page_template( 'page-templates/list-meal-plan.php' ) &&
							 !is_page_template( 'page-templates/page_meal-select.php' ) &&
							 !is_page_template( 'page-templates/page_meal-detail.php' ) &&
							 !is_page_template( 'page-templates/page_meal-static.php' ) &&
							 !is_page_template( 'page-templates/page_meal-search.php' )
							  ) { ?>
							<style>
								.content-header .input-search {
									width: 0;
									padding-left: 0;
									padding-right: 0;
									border: 1px solid transparent;
									background: none;
								}
							</style>
							<?php } 
							?>
						</div>
						<div class="col-3">
							<div class="row ai-center jc-end">
								<?php global $current_user;
								wp_get_current_user(); ?>
								<?php if (is_user_logged_in()) : ?>
									<div class="d-f ai-center group-noti-top">
										<div class="history"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/log-activites-svgrepo-com-1.svg" alt=""></div>
										<div class="noti"><span class="active"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/notification.svg" alt=""></span></div>
									</div>
									<div class="info d-f ai-center">
									<span class="avatar"><img src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="40" alt="<?php echo $current_user->display_name; ?>"></span>
										<span class="d-block text-info"><?php echo $current_user->display_name; ?></span>
										<ul class="info-menu">
											<li><a href="<?php echo wp_logout_url(home_url()); ?>" class="logout">Đăng xuất</a></a></li>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</section>