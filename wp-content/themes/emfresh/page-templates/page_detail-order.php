<?php

/**
 * Template Name: Page Detail-order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_product, $em_ship_fee, $em_order, $em_order_item, $site_scripts, $site_script_settings;

$list_ship_fees = $em_ship_fee->get_items(['orderby' => 'id ASC']);
$list_products  = $em_product->get_items(['orderby' => 'id ASC']);
$list_notes = em_admin_get_setting('em_notes');
$list_types = ['d', 'w', 'm'];
$list_locations = [];
$admin_role          = wp_get_current_user()->roles;
$orderDetailSettings = [
	'em_api_url' 	=> home_url('em-api/customer/list/'),
	'em_ship_fees' 	=> $list_ship_fees,
	'em_products' 	=> $list_products,
	'em_notes' 		=> $list_notes,
];

$_GET = wp_unslash($_GET);

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$get_date = isset($_GET['date']) ? $_GET['date'] : "";
$duplicate_order = isset($_GET['duplicate_order']) ? intval($_GET['duplicate_order']) : 0; 
if($duplicate_order > 0) {
	$order_id = $duplicate_order;
}

$action_url = add_query_arg(['order_id' => $order_id], get_permalink());
$duplicate_url = add_query_arg(['duplicate_order' => $order_id, 'dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
$delete_url = add_query_arg(['delete_order' => $order_id, 'delnonce' => wp_create_nonce('delnonce')], get_permalink());

$order_detail = $em_order->get_fields();
$list_payment_statuses = $em_order->get_payment_statuses();
$list_payment_methods = $em_order->get_payment_methods();

$order_item_default = $em_order_item->get_fields();
$order_item_default['id'] = 0;
$order_items = [$order_item_default];

$customer_group = [];
$group = [];

if($order_id > 0) {
    $response = em_api_request('order/item', ['id' => $order_id]);

    if($response['code'] == 200) {
        $order_detail = $response['data'];

        $response = em_api_request('order_item/list', ['order_id' => $order_id, 'orderby' => 'id ASC']);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $order_items = $response['data'];

			// duplicate reset data order item
			if($duplicate_order > 0) {
				foreach($order_items as &$order_item) {
					$order_item['order_id'] = 0;
					$order_item['id'] = 0;
					$order_item['date_start'] = '';
                    $order_item['date_stop'] = '';
                    $order_item['meal_plan'] = '';
				}
			}
        }

		// Lay thong tin dia chi
        $response = em_api_request('location/list', ['customer_id' => $order_detail['customer_id']]);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $list_locations = $response['data'];
        }

		// Lay thong tin nhom
        $response = em_api_request('customer_group/list', ['customer_id' => $order_detail['customer_id']]);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $customer_group = end($response['data']);

			$response = em_api_request('group/item', ['id' => $customer_group['group_id']]);
			if($response['code'] == 200) {
				$group = $response['data'];
			}
        }
    }
} else {
	$order_detail = $em_order->filter_item($order_detail);
}

$order_item_total = count($order_items);

extract($order_detail);
$tab_active = isset($_GET['tab']) ? $_GET['tab'] : 'info';

if($tab_active != '') {
	$query_arg['tab'] = $tab_active;
}

$total_money = 0;

// duplicate reset data order
if($duplicate_order > 0) {
	$order_detail['order_number'] = '';
	$order_detail['id'] = 0;
	$order_detail['status'] = 1;
	$order_detail['ship_days'] = 0;
	$order_detail['ship_amount'] = 0;
	$order_detail['payment_status'] = 2;
	$order_detail['paid'] = 0;
	$order_detail['remaining_amount'] = 0;
	$order_detail['discount'] = 0;
	$order_detail['total'] = 0;
	$order_detail['total_amount'] = 0;
	$order_detail['params'] = '';
}
if ( $order_detail[ 'status' ] == 2 ) {
	if ( !empty( $admin_role ) && $admin_role[ 0 ] != 'administrator' ) {
		wp_redirect( home_url( 'list-order' ) );
		exit();
	}
}

get_header();

// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order detail-order pt-16">
<style>
.content-header{display: none;}
</style>
	<section class="content">
		<div class="container-fluid">
			<div class="scroll-menu pt-8">
				<div class="row">
					<div class="col-6 backtolist d-f ai-center">
						<a href="/list-order/" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại
								danh sách đơn hàng</span></a>
					</div>
					<div class="col-6 d-f ai-center jc-end group-button_top">
						<?php if ( $get_date == "" ) { ?>
							<a class="btn btn-primary js-btn-clone out-line modal-button" data-target="#modal-clone_order" href="javascript:void();"><span class="d-f ai-center"><i class="fas mr-4"><img
										src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com.svg" alt=""></i>Tạo bản sao</span></a>
							<?php } ?>
						<span class="btn btn-primary btn-disable btn-save_edit hidden">Lưu thay đổi</span>
						<span class="btn btn-primary js-btn-save out-line">Lưu thay đổi</span>
					</div>
				</div>
				<div class="card-header">
					<ul class="nav tab-nav tab-nav-detail tabNavigation pt-16">
						<li class="nav-item defaulttab" rel="info">Thông tin đơn hàng</li>
						<li class="nav-item" rel="settings-product">Chỉnh sửa thông tin</li>
						<li class="nav-item" rel="activity-history">Lịch sử thao tác</li>
						<li class="nav-item" rel="pay">Lịch sử thanh toán</li>
						<li class="nav-item" rel="reserve">Bảo lưu</li>
					</ul>
				</div>
			</div>
			<div class="card-primary">
				<!-- Content Header (Page header) -->
				<div class="head-section d-f jc-b pb-16 ai-center">
					<div class="order-code pl-16"><?php echo $order_detail['order_number'] != '' ? '#' . $order_detail['order_number'] : '' ?></div>
					<div class="js-group-btn">
						<div class="d-f gap-8 ai-center">
							<?php if ( $get_date == "" ) { ?>
							<div class="print btn btn-secondary d-f gap-8 ai-center"><span class="fas fas-print"></span>In đơn</div>
							<?php } ?>
							<?php $min_date_start = null;
							
							foreach ($order_items as $item) {
								// 
								if ($item['date_start'] !='0000-00-00') {
									if ($min_date_start === null || strtotime($item['date_start']) < strtotime($min_date_start)) {
										$min_date_start = $item['date_start'];
									}
								} else {
									$min_date_start = '1970-01-01';
								}
							} 
							$today = date('Y-m-d');
							$user = $current_user->roles;
							$status = $order_detail['status'];
							if ($status != 2) {
							if ($today < $min_date_start || $user[0] === 'administrator') {
							 ?>
								<?php if ( $get_date == "" ) { ?>
									<div class="btn btn-danger remove-customer modal-button" data-target="#modal-end">
										Xoá đơn này
									</div>
								<?php } ?>
							<?php }
							}
							?>
						</div>
					</div>
				</div>
				<div class="card-body">
				<?php 
                        foreach ($list_locations as $location) {
                            if ($order_detail['location_id'] == $location['id']) {
                                $detail_local = $location['location_name'];
                            } else {
                                $detail_local = '';
                            }
                        }
                        ?>
					<div class="tab-content">
						<div class="tab-pane" id="info">
							<?php include( get_template_directory().'/parts/order/info.php');?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="settings-product">
							<?php include( get_template_directory().'/parts/order/settings-product.php');?>
						</div>
						<div class="tab-pane" id="activity-history">
							<?php include( get_template_directory().'/parts/order/activity-history.php');?>
						</div>
						<div class="tab-pane" id="pay">
							<?php include( get_template_directory().'/parts/order/pay.php');?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="reserve">
							<?php include( get_template_directory().'/parts/order/reserve.php');?>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div><!-- /.card-body -->
			</div>
			<!-- /.card -->

			<!-- /.row -->
		</div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center pl-16 pr-16">
	<div class="total-cost txt d-f gap-16 ai-center fw-bold">Cần thanh toán: <span class="cost-txt red fw-bold"><?php echo ($total_money - $order_detail['paid']) > 0 ? number_format($total_money - $order_detail['paid']) : 0; ?></span></div>
	<a href="<?php echo add_query_arg(['customer_id' => $order_detail['customer_id']], site_meal_plan_detail_link()) ?>" class="btn btn-primary btn-next">Đi đến Meal Plan chi tiết</a>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<?php include get_template_directory() . '/parts/order/modal.php'; ?>
<script id="note_template" type="text/template">
<div class="row row-note mb-16">
	<div class="col-4">
		<select name="note_name" class="form-control input-note_name">
            <option value="" disable selected>-</option>
			<?php
				foreach ($list_notes as $name => $note_item) {
					printf('<option value="%s">%s</option>', $name, $note_item['name']);
				}
			?>
		</select>
	</div>
	<div class="col-8 col-note_values tag-container">
		<input type="hidden" name="note_values" value="" class="form-control input-note_values" />
	</div>
</div>
</script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings, JSON_UNESCAPED_UNICODE) ?>;</script>
<?php
$list_notes = array_merge(
    ["-" => ["name" => "-", "values" => []]], // Mục rỗng
    $list_notes // Danh sách cũ
);
$categoriesJSON = json_encode($list_notes, JSON_UNESCAPED_UNICODE);
// endwhile;
get_footer('customer');
?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script src="<?php site_the_assets(); ?>js/order-detail.js?t=<?php echo time() ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
	initializeTagify('.row-note input.input-note_values');
	let $selects = $(".row-note select.input-note_name");
	<?php
		if($tab_active != '') {
			echo '$(".tabNavigation [rel='.$tab_active.']").trigger("click");';
		}
	?>
    // Kiểm tra xem có bao nhiêu select box
    if ($selects.length === 1) {
        // Nếu chỉ có 1 select box, giữ nguyên các option
    } else {
        // Nếu có nhiều select box, cập nhật danh sách option cho mỗi select
        $selects.each(function() {
            let selectedValue = $(this).val(); // Lấy giá trị được chọn
            $(this).html(`
                <option value="${selectedValue}" selected>${selectedValue}</option>
            `);
        });
    }
	$(".status-pay-menu .status-pay-item span[selected]").each(function() {
    var status = $(this).data('status');
    $(".status-pay").html($(this).closest('.status-pay-item').html());
    $(".input_status-payment").val(status);
    if (status == 3) {
        $(".paymented").css("display", "flex");
    }
	$('.tab-nav-detail li').click(function (e) { 
		e.preventDefault();
		$('.js-group-btn').hide();
	});
	$('.tab-nav-detail li:first').click(function (e) { 
		e.preventDefault();
		$('.js-group-btn').show();
	});
});
});
function initializeTagify(selector) {
	const categories = <?php echo $categoriesJSON ?>;
	const keys = Object.keys(categories);
	$(selector).each(function () {
		if (!$(this).data('tagify')) {
			var selectedCategory = $(this).closest(".row-note").find(".input-note_name").val();
			var whitelistData = categories[selectedCategory] ? categories[selectedCategory].values : [];
			var tagifyInstance = new Tagify(this, {
				whitelist: whitelistData,
				placeholder: "...",
				dropdown: {
					enabled: 0,
					maxItems: 10,
					position: "all"
				},
				originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', ')
			});
			$(this).data('tagify', tagifyInstance);
		}
	});
}
$(document).on('change', '.input-note_name', function () {
    let rowNote = $(this).closest('.row-note');
    let selectedCategory = $(this).val();
    const categories = <?php echo $categoriesJSON ?>;

    // Reset giá trị input khi thay đổi category
    rowNote.find('.input-note_values').val('');

    if (selectedCategory !== '') {
        let inputTagify = rowNote.find('.input-note_values');

        inputTagify.each(function () {
            const tagifyInstance = $(this).data('tagify');
            if (tagifyInstance) {
                tagifyInstance.settings.whitelist = categories[selectedCategory]?.values || [];
                tagifyInstance.dropdown.hide();
            }
        });
    } 
});
</script>