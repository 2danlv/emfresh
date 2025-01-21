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
						<a href="/customer/" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại
								danh sách khách hàng</span></a>
					</div>
					<div class="col-6 d-f ai-center jc-end group-button_top">
						<a class="btn btn-primary js-btn-clone out-line" href="#"><span class="d-f ai-center"><i class="fas mr-4"><img
										src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com.svg" alt=""></i>Tạo bảo sao</span></a>
						<span class="btn btn-primary btn-disable btn-save_edit hidden">Lưu thay đổi</span>
						<button name="save_order" value="<?php echo time() ?>" class="btn btn-primary js-btn-save out-line">Lưu thay đổi</button>
					</div>
				</div>
				<div class="card-header">
					<ul class="nav tab-nav tab-nav-detail tabNavigation pt-16">
						<li class="nav-item defaulttab" rel="info">Thông tin đơn hàng</li>
						<li class="nav-item" rel="pay">Thanh toán</li>
						<li class="nav-item" rel="settings-product">Chỉnh sửa thông tin</li>
						<li class="nav-item" rel="activity-history">Lịch sử thao tác</li>
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
						<div class="tab-pane" id="pay">
							<?php include( get_template_directory().'/parts/order/pay.php');?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="settings-product">
							<?php include( get_template_directory().'/parts/order/settings-product.php');?>
						</div>
						<div class="tab-pane activity-history" id="activity-history">
							<?php include( get_template_directory().'/parts/order/activity-history.php');?>
						</div>
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
<div class="modal fade modal-warning" id="modal-cancel">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="list-customer" action="">
				<div class="modal-body pt-8 pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="">
					<div class="d-f">
						<i class="fas fa-warning mr-8"></i>
						<p>Bạn có chắc chắn muốn huỷ phần bảo lưu này và giảm giá cho đơn hàng mới? </p>
					</div>

				</div>
				<div class="modal-footer d-f jc-b pb-8 pt-16">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="submit" name="remove" class="btn btn-danger modal-close">Xóa</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-warning" id="modal-end">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" class="form-remove-note" action="">
				<div class="modal-body pt-8 pb-16">
					<div class="d-f ai-center">
						<i class="fas fa-warning mr-4"></i>
						<p>Bạn có chắc chắn muốn kết thúc đơn hàng này ?</p>
					</div>
				</div>
				<div class="modal-footer d-f jc-b pb-8 pt-16">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="submit" name="remove" class="btn btn-danger modal-close">Xóa</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-continue">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" class="form-remove-note" action="">
				<div class="modal-body pb-16">
					<div class="tlt pt-16">Sản phẩm</div>
					<p class="pt-16">Vui lòng chọn ngày bắt đầu tiếp diễn cho đơn hàng</p>
					<div class="calendar pt-16">
						<input type="text" value="" name="calendar" placeholder="DD/MM/YYYY" class="form-control start-day js-calendar">
					</div>
				</div>
				<div class="modal-footer d-f jc-end pb-8 pt-16 gap-16">
					<button type="button" class="btn btn-secondary modal-close">Hủy</button>
					<button type="submit" class="btn btn-primary modal-close">Xác nhận</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-warning" id="modal-remove-tab">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="list-customer" action="">
				<div class="modal-body pt-8 pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="">
					<div class="d-f ai-center">
						<i class="fas fa-warning mr-4"></i>
						<p>Bạn có chắc muốn xoá sản phẩm đang thực hiện trên đơn hàng này không?</p>
					</div>

				</div>
				<div class="modal-footer d-f jc-end pb-8">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="button" name="remove" class="btn btn-danger modal-close">Xóa</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script id="note_template" type="text/template">
<div class="row row-note mb-16">
	<div class="col-4">
		<select class="form-control input-note_name">
			<?php
				foreach ($list_notes as $name => $note_item) {
					printf('<option value="%s">%s</option>', $name, $note_item['name']);
				}
			?>
			<option value="khac" selected>Khác</option>
		</select>
	</div>
	<div class="col-8 col-note_values tag-container">
		<input type="text" class="form-control input-note_values" />
	</div>
</div>
</script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings) ?>;</script>
<?php

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
            $(selector).each(function () {
                if (!this.tagify) { 
                    var tagifyInstance = new Tagify(this, {
                        whitelist: [
                            "cà rốt",
                            "bí đỏ",
                            "củ dền",
                            "bí ngòi",
                            "thay bún sang cơm trắng",
                            "thay miến sang cơm trắng",
                            "1/2 tinh bột"
                        ],
                        placeholder: "...",
                        dropdown: {
                            enabled: 1, 
                            maxItems: 10, 
                            position: "all" 
                        }
                    });
                   
                }
            });
        }
</script>