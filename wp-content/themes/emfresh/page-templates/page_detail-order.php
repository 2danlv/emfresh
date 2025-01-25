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

$orderDetailSettings = [
	'em_api_url' 	=> home_url('em-api/customer/list/'),
	'em_ship_fees' 	=> $list_ship_fees,
	'em_products' 	=> $list_products,
	'em_notes' 		=> $list_notes,
];

$_GET = wp_unslash($_GET);

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$action_url = add_query_arg(['order_id' => $order_id], get_permalink());

$order_detail = $em_order->get_fields();
$list_payment_statuses = $em_order->get_payment_statuses();
$list_payment_methods = $em_order->get_payment_methods();

$order_item_default = $em_order_item->get_fields();
$order_item_default['id'] = 0;
$order_items = [$order_item_default];

if($order_id > 0) {
    $response = em_api_request('order/item', ['id' => $order_id]);

    if($response['code'] == 200) {
        $order_detail = $response['data'];

        $response = em_api_request('order_item/list', ['order_id' => $order_id, 'orderby' => 'id ASC']);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $order_items = $response['data'];
        }

        $response = em_api_request('location/list', ['customer_id' => $order_detail['customer_id']]);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $list_locations = $response['data'];
        }
    }
} else {
	$order_detail = $em_order->filter_item($order_detail);
}

$order_item_total = count($order_items);

extract($order_detail);

get_header();

// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order detail-order pt-16">

	<section class="content">
		<div class="container-fluid">
			<div class="scroll-menu pt-8">
				<div class="row">
					<div class="col-6 backtolist d-f ai-center">
						<a href="/list-order/" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại
								danh sách đơn hàng</span></a>
					</div>
					<div class="col-6 d-f ai-center jc-end group-button_top">
						<a class="btn btn-primary js-btn-clone out-line" href="#"><span class="d-f ai-center"><i class="fas mr-4"><img
										src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com.svg" alt=""></i>Tạo bảo sao</span></a>
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
					<div class="order-code pl-16">#<?php echo $order_detail['order_number'] ?></div>
					<div class="group-btn js-group-btn gap-8 ai-center">
						<div class="print btn btn-secondary d-f gap-8 ai-center"><span class="fas fas-print"></span>In đơn</div>
						<div class="btn btn-danger remove-customer modal-button" data-target="#modal-default">
							Xoá đơn này
						</div>
					</div>
				</div>
				<div class="card-body">
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
	<div class="total-cost txt d-f gap-16 ai-center fw-bold">Cần thanh toán: <span class="cost-txt red fw-bold"><?php echo ($total = $order_detail['total_amount'] + $order_detail['ship_amount']) > 0 ? number_format($total) : 0; ?></span></div>
	<span class="btn btn-primary btn-next">Đi đến Meal Plan chi tiết</span>
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
			<?php
				foreach ($list_notes as $name => $note_item) {
					printf('<option value="%s">%s</option>', $name, $note_item['name']);
				}
			?>
		</select>
	</div>
	<div class="col-8 col-note_values tag-container">
		<input type="text" name="note_values" class="form-control input-note_values" />
	</div>
</div>
</script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings) ?>;</script>
<?php
$categoriesJSON = json_encode($list_notes);
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
	initializeTagify('input.input-note_values');
});
function initializeTagify(selector) {
	const categories = <?php echo $categoriesJSON ?>;
	$(selector).each(function () {
		if (!$(this).data('tagify')) {
			var tagifyInstance = new Tagify(this, {
				whitelist: categories["rau-cu"].values,
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
    $(this).closest('.row-note').find($('.input-note_values')).val('');
    const selectedCategory = $(this).val();
    const categories = <?php echo $categoriesJSON ?>;
    $(this).closest('.row-note').find($('.input-note_values')).each(function () {
        const tagifyInstance = $(this).data('tagify');
        if (tagifyInstance) {
            tagifyInstance.settings.whitelist = categories[selectedCategory]?.values || [];
            tagifyInstance.dropdown.hide();
        }
    });
});
</script>