<?php
/**
 * Template Name: Create order
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
$duplicate_url = add_query_arg(['duplicate_order' => $order_id, 'dupnonce' => wp_create_nonce('dupnonce')], get_permalink());
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
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;


// lấy 1 customer
$customer_filter = [
	'id' => $customer_id
];
$response_customer = em_api_request('customer/item', $customer_filter);

// lấy danh sách location
$location_filter = [
	'customer_id' => $customer_id,
	'limit' => -1,
	'orderby' => 'active DESC, id DESC',
];

$response_get_location = em_api_request('location/list', $location_filter);

$response_order = em_api_request('order/list', [
	'paged' => 1,
	'customer_id' => $customer_id,
	'limit' => -1,
  ]);
// var_dump($response_order);

$total_money = 0;

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order">
    <section class="content">
        <div class="container-fluid">
            <div class="card-primary">
                <div class="row row32">
                    <div class="col-4">
                        <!-- About Me Box -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="ttl">
                                    Thông tin đơn hàng
                                </div>
                                <div class="info-customer hidden line-dots">
                                    <p class="pt-16 customer-name"></p>
                                    <p class="customer-name_2nd hidden">Người nhận: <span></span></p>
                                    <p class="copy modal-button pt-8 customer-phone" data-target="#modal-copy" title="Copy"></p>
                                    <p class="pt-8 pb-16 text-ellipsis customer-address"></p>
                                </div>
                                <div class="order-details hidden">
                                    <div class="order-wapper">
                                        <div class="info-order hidden line" data-id="order_item_1">
                                            <div class="d-f jc-b pt-8">
                                                <span class="tlt fw-bold ">Phân loại đơn hàng:</span>
                                                <span class="type-total"></span>
                                            </div>
                                            <div class="d-f jc-b pt-8">
                                                <span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
                                                <span class="date-start"></span>
                                            </div>
                                            <div class="tlt fw-bold  pt-8">Thông tin sản phẩm:</div>
                                            <div class="info-product pt-8">
                                                <div class="d-f jc-b">
                                                    <div class="d-f"><span class="name">Slimfit M</span>&nbsp;x&nbsp;<span class="quantity">5</span></div>
                                                    <div class="price"></div>
                                                </div>
                                                <div class="note-box pb-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-pay hidden">
                                        <div class="d-f jc-b pt-18">
                                            <span class="tlt fw-bold ">Tổng tiền phí ship:</span>
                                            <span class="ship">-</span>
                                        </div>
                                        <div class="d-f jc-b pt-8">
                                            <span class="tlt fw-bold ">Giảm giá:</span>
                                            <span class="discount">-</span>
                                        </div>
                                        <div class="d-f jc-b pt-8 pb-8">
                                            <span class="tlt fw-bold ">Tổng tiền đơn hàng:</span>
                                            <span class="total total-price"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-8">
                        <div class="card-body">
                            <ul class="nav tab-order tab-nav pt-20">
                                <li class="nav-item defaulttab" rel="customer">Khách hàng</li>
                                <li class="nav-item" rel="product">Sản phẩm</li>
                                <li class="nav-item" rel="pay">Thanh toán</li>
                                <li class="nav-item" rel="delivery">Giao hàng</li>
                            </ul>
                            <div class="overlay-drop-menu"></div>
                            <div class="tab-content">
                                <div class="tab-pane" id="customer">
                                    <?php include get_template_directory() . '/parts/order/customer.php'; ?>
                                </div>
                                <form method="post" class="form-add-order" action="<?php echo $action_url ?>">
                                    <input type="hidden" class="input-date_create" value="<?php echo !empty($order_detail['created']) ? date('d-m-Y', strtotime($order_detail['created'])) : ''; ?>" />
                                    <input type="hidden" name="save_order" value="<?php echo time() ?>" />
                                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
                                    <input type="hidden" class="order_item_total" value="<?php echo $order_item_total ?>" />
                                    <input type="hidden" name="customer_id" class="input-customer_id" value="<?php echo $order_detail['customer_id'] ?>" />
                                    <input type="hidden" name="customer_name_2nd" class="input-customer_name_2nd" value="<?php echo $order_detail['customer_name_2nd'] ?>" />
                                    <input type="hidden" name="item_name" class="input-item_name" value="<?php echo $order_detail['item_name'] ?>" />
                                    <input type="hidden" name="type_name" class="input-type_name" value="<?php echo $order_detail['type_name'] ?>" />
                                    <input type="hidden" name="location_name" class="input-location_name" value="<?php echo $order_detail['location_name'] ?>" />
                                    <input type="hidden" name="location_id" class="input-location_id" value="<?php echo $order_detail['location_id'] ?>" />
                                    <input type="hidden" name="order_note" class="input-order_note" value="<?php echo $order_detail['note'] ?>" />
                                    <input type="hidden" name="order_type" class="input-order_type" value="<?php echo $order_detail['order_type'] ?>" />
                                    <input type="hidden" name="note_shipper" class="note_shiper" value="" />
                                    <input type="hidden" name="note_admin" class="note_admin" value="" />
                                    <div class="tab-pane" id="product">
                                        <?php include get_template_directory() . '/parts/order/edit-detail-create.php'; ?>
                                    </div>
                                    <div class="tab-pane pay-field" id="pay">
                                        <?php include get_template_directory() . '/parts/order/edit-detail-pay.php'; ?>
                                    </div>
                                    <div class="tab-pane delivery-field" id="delivery">
                                        <?php include get_template_directory() . '/parts/order/edit-detail-ship.php'; ?>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <div class="toast warning">
        <i class="fas fa-warning"></i>
        Khách hàng vẫn còn đơn đang dùng tại thời điểm <span  class="order_date_stop hidden"></span><span  class="order_date_stop_show"></span>
        <i class="fas fa-trash close-toast"></i>
    </div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <span class="btn btn-secondary js-btn-prev btn-disable">Quay lại</span>
    <span class="btn btn-primary js-next-tab btn-next">Tiếp theo</span>
    <span class="btn btn-primary js-create-order hidden">Tạo đơn</span>
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
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings, JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="<?php site_the_assets(); ?>js/order-detail.js"></script>
<script type="text/javascript">
function switch_tabs_add_order(obj) {
    $('.tab-pane').stop().fadeOut(1);
    $('ul.tab-order li').removeClass('selected');
    var id_order = obj.attr('rel');
    jQuery('#' + id_order).stop().fadeIn(300);
    obj.addClass('selected');
    updateNavigationButtons();
}
function navigateTabs(direction) {
    const currentTab = $('ul.tab-order li.selected');
    let newTab;
    if (direction === 'next') {
        newTab = currentTab.next('li');
    } else {
        newTab = currentTab.prev('li');
    }
    if (newTab.length > 0) {
        switch_tabs_add_order(newTab);
    }
}
function updateNavigationButtons() {
    const firstTab = $('ul.tab-order li').first();
    const lastTab1 = $('ul.tab-order li:nth-last-child(2)');
    const lastTab2 = $('ul.tab-order li').last();
    const currentTab = $('ul.tab-order li.selected');
    if (currentTab.is(firstTab)) {
        $('.js-btn-prev').addClass('btn-disable');
        //$('.js-btn-prev').removeClass('btn-primary');
    } else {
        $('.js-btn-prev').removeClass('btn-disable');
        //$('.js-btn-prev').addClass('btn-primary');
    }
    if (currentTab.is(lastTab1) || currentTab.is(lastTab2)) {
        $('.js-next-tab').addClass('hidden');
        $('.js-create-order').removeClass('hidden');
        $('.order-details .info-pay').show();
    } else {
        $('.js-next-tab').removeClass('hidden');
        $('.js-create-order').addClass('hidden');
    }
}
$(document).ready(function () {
    $('ul.tab-order.tab-nav li').click(function () {
        switch_tabs_add_order($(this));
    });
    $('.js-next-tab').click(function () {
        navigateTabs('next');
    });
    $('.js-btn-prev').click(function () {
        navigateTabs('prev');
    });
    switch_tabs_add_order($('.defaulttab'));
    
    $('.js-calendar.date').val('');
    initializeTagify('input.input-note_values');
});
function initializeTagify(selector) {
    const categories = <?php echo $categoriesJSON ?>;
    const keys = Object.keys(categories);
    $(selector).each(function () {
        if (!$(this).data('tagify')) {
            var tagifyInstance = new Tagify(this, {
                whitelist: categories[keys[0]].values,
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