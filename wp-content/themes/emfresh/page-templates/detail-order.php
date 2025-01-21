<?php

/**
 * Template Name: Detail-order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 * 
 * Submit data in file `inc/functions/order.php`;
 * 
 */
global $em_product, $em_ship_fee, $em_order, $em_order_item, $site_scripts, $site_script_settings;

$list_ship_fees = $em_ship_fee->get_items(['orderby' => 'id ASC']);
$list_products  = $em_product->get_items(['orderby' => 'id ASC']);
$list_notes = em_admin_get_setting('em_notes');
$list_types = ['d', 'w', 'm'];
$list_locations = [];

$orderDetailSettings = [
	'em_api_url' 	=> home_url('em-api/'),
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
}

$order_item_total = count($order_items);

extract($order_detail);

get_header();

// while ( have_posts() ) : the_post();
?>
<div class="detail-customer pt-16">

	<form method="post" action="<?php echo $action_url ?>">
		<input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
		<input type="hidden" class="order_item_total" value="<?php echo $order_item_total ?>" />
		<input type="hidden" name="customer_id" class="input-customer_id" value="<?php echo $order_detail['customer_id'] ?>" />
		<input type="hidden" name="item_name" class="input-item_name" value="<?php echo $order_detail['item_name'] ?>" />
		<input type="hidden" name="location_name" class="input-location_name" value="<?php echo $order_detail['location_name'] ?>" />
		<input type="hidden" name="order_note" class="input-order_note" value="<?php echo $order_detail['note'] ?>" />
		<input type="hidden" name="order_type" class="input-order_type" value="<?php echo $order_detail['order_type'] ?>" />
		
		<br><br>

		<div class="row">
			<div class="col-md-6">
				<div class="card card-preview">
					<div class="card-header">
						<h3 class="card-title">Thông tin đơn hàng</h3>
					</div>
					<div class="card-body js-preview-info">
						<p><span class="customer_name"><?php echo $order_detail['customer_name'] ?></span></p>
						<p><span class="phone"><?php echo $order_detail['phone'] ?></span></p>
						<div class="js-preview-orders">

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card card-customer">
					<div class="card-header">
						<h3 class="card-title">Customer</h3>
					</div>
					<div class="card-body">
						<?php if(!empty($order_detail['customer_name'])) :?>
						<div class="mb-16">
							<strong class="customer_name"><?php echo $order_detail['customer_name'] ?></strong>
							|
							<strong class="phone"><?php echo $order_detail['phone'] ?></strong>
						</div>
						<div class="mb-16">
							<strong class="order_number">Order Number: #<?php echo $order_detail['order_number'] ?></strong>
						</div>
						<?php else :?>
						<div class="input-group mb-16">
							<input type="text" class="form-control input-customer_search" />
							<button type="button" class="input-group-text btn btn-outline-secondary js-search-customer" id="basic-addon2">search</button>
						</div>
						<div class="mb-16">
							<select name="customer_id" class="form-control select-customer_id input-customer_id"></select>
						</div>
						<?php endif ?>
					</div>
				</div>

				<div class="card card-products">
					<div class="card-header">
						<h3 class="card-title">Sản phẩm</h3>
					</div>

					<div class="card-buttons js-order-buttons">
						<?php foreach($order_items as $i => $order_item) : ?>
						<span class="btn <?php echo $i > 0 ? 'btn-secondary' : 'btn-primary' ?> js-show-order-item" data-id="order_item_<?php echo $i + 1 ?>">
							Sản phẩm <?php echo $i + 1 ?>
							<em class="js-remove-order-item">&times;</em>
						</span>
						<?php endforeach ?>
						<button class="btn btn-info js-add-order-item">+</button>
					</div>

					<div class="card-body js-order-items">
						<?php foreach($order_items as $i => $order_item) : extract($order_item); ?>
						<div class="js-order-item" id="order_item_<?php echo $i + 1 ?>" <?php echo $i > 0 ? 'style="display: none;"' : '' ?>>
							<input type="hidden" name="order_item[<?php echo $i ?>][id]" class="input-id" value="<?php echo $id ?>" />
							<input type="hidden" name="order_item[<?php echo $i ?>][remove]" class="input-remove" />
							<input type="hidden" name="order_item[<?php echo $i ?>][note]" class="input-note" value="<?php echo $note ?>" />
							<input type="hidden" name="order_item[<?php echo $i ?>][date_stop]" class="input-date_stop" value="<?php echo $date_stop ?>" />
							<input type="hidden" name="order_item[<?php echo $i ?>][product_price]" class="input-product_price" value="<?php echo $product_price ?>" />
							<input type="hidden" name="order_item[<?php echo $i ?>][ship_price]" class="input-ship_price" value="<?php echo $ship_price ?>" />
							<input type="hidden" name="order_item[<?php echo $i ?>][note]" class="input-note" value="<?php echo $note ?>" />
							<input type="hidden" class="input-note_list" value="<?php echo isset($note_list) ? base64_encode(json_encode($note_list)) : '' ?>" />
							<div class="mb-16">
								Sản phẩm <?php echo $i + 1 ?>
							</div>
							<div class="mb-16">
								<select name="order_item[<?php echo $i ?>][location_id]" class="form-control select-location_id input-location_id" required <?php echo isset($location_name) ? 'readonly' : '' ?>>
									<!-- <option value="">Chọn location</option> -->
									<?php
									foreach ($list_locations as $location) {
										printf('<option value="%s" %s>%s</option>', $location['id'], $location_id == $location['id'] ? 'selected' : '', $location['location_name']);
									}
									?>
								</select>
							</div>
							<div class="row mb-16">
								<div class="col-md-4">
									<select name="order_item[<?php echo $i ?>][type]" class="form-control input-type" required>
										<!-- <option value="">Chọn loại</option> -->
										<?php
										foreach ($list_types as $value) {
											printf('<option value="%s" %s>%s</option>', $value, $type == $value ? 'selected' : '', strtoupper($value));
										}
										?>
									</select>
								</div>
								<div class="col-md-4">
									<input type="number" class="form-control input-days" name="order_item[<?php echo $i ?>][days]" value="<?php echo $days ?>" min="1" placeholder="Số ngày" required/>
								</div>
								<div class="col-md-4">
									<input type="date" class="form-control input-date_start" name="order_item[<?php echo $i ?>][date_start]" value="<?php echo $date_start ?>" placeholder="Ngày bắt đầu" required />
								</div>
							</div>
							<div class="row mb-16">
								<div class="col-md-4">
									<select name="order_item[<?php echo $i ?>][product_id]" class="form-control input-product_id" required>
										<!-- <option value="0">Chọn gói</option> -->
										<?php
										foreach ($list_products as $product) {
											printf('<option value="%s" %s>%s</option>', $product['id'], $product_id == $product['id'] ? 'selected' : '', $product['name']);
										}
										?>
									</select>
								</div>
								<div class="col-md-4">
									<input type="number" name="order_item[<?php echo $i ?>][quantity]" value="<?php echo $quantity ?>" class="form-control input-quantity" min="1" placeholder="Số lượng" required />
								</div>
								<div class="col-md-4">
									Thành tiền : <span class="text-amount"><?php echo $amount > 0 ? number_format($amount) : 0 ?></span>
									<input type="hidden" name="order_item[<?php echo $i ?>][amount]" value="<?php echo $amount ?>" class="input-amount" />
								</div>
							</div>
							<div class="mb-16">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="1" name="order_item[<?php echo $i ?>][auto_choose]" id="auto_choose" <?php echo $auto_choose == 1 ? 'selected' : '' ?>>
									<label class="form-check-label" for="auto_choose">
										Tự động chọn
									</label>
								</div>
							</div>
							<div class="mb-16 js-note-list"></div>
							<div class="mb-16 js-add-note">
								+ Thêm yêu cầu 
							</div>
						</div>
						<?php endforeach ?>
					</div>
					<!-- /.card-body -->
				</div>
				
				<div class="card card-payment">
					<div class="card-header">
						<h3 class="card-title">Payment</h3>
					</div>
					<div class="card-body">
						<p>
							Tổng tiền sản phẩm: <span class="text-total_amount"><?php echo $order_detail['total_amount'] > 0 ? number_format($order_detail['total_amount']) : 0; ?></span>
							<input type="hidden" name="total_amount" class="input-total_amount" value="<?php echo $order_detail['total_amount'] ?>" />
						</p>
						<p>
							Số ngày phát sinh phí ship: <input type="number" name="ship_days" class="input-ship_days" value="<?php echo $order_detail['ship_days'] ?>" />
						</p>
						<p>
							Tổng tiền phí ship: <input type="number" name="ship_amount" class="input-ship_amount" value="<?php echo $order_detail['ship_amount'] ?>" />
						</p>
						<p>
							Giảm giá: <input type="number" name="discount" class="input-discount" value="<?php echo $order_detail['discount'] ?>"/>
						</p>
						<p>Tổng tiền đơn hàng: <span class="text-total"><?php echo ($total = $order_detail['total_amount'] + $order_detail['ship_amount']) > 0 ? number_format($total) : 0; ?></span> </p>
						<p>
							Phương thức thanh toán: 
							<?php
								foreach ($list_payment_methods as $value => $label) {
									printf('<label><input type="radio" name="payment_method" value="%s" %s>%s</label>', $value, $order_detail['payment_method'] == $value ? 'checked' : '', $label);
								}
							?>
						</p>
						<p>
							Trạng thái thanh toán: 
							<select name="payment_status">
								<?php
									foreach ($list_payment_statuses as $value => $label) {
										printf('<option value="%d" %s>%s</option>', $value, $order_detail['payment_status'] == $value ? 'selected' : '', $label);
									}
								?>
							</select>
						</p>
						<p>
							Cần thanh toán: <span class="text-payment_amount"><?php echo number_format($order_detail['total_amount'] + $order_detail['ship_amount']) ?></span>				
						</p>
					</div>
				</div>

				<div class="card card-shipping">
					<div class="card-header">
						<h3 class="card-title">Shipping</h3>
					</div>
					<div class="card-body">
						<p>
							Đặt lịch: 
							<label>
								<input type="checkbox" name="schedule_loop" value="1">
								Lặp lại trong tuần
							</label>
							<input type="date" name="schedule_date" class="input-schedule" />
						</p>

						<p>
							Địa chỉ giao: 
							<select name="ship_location_id" class="form-control select-location_id input-location_id">
								<?php
									foreach ($list_locations as $location) {
										printf('<option value="%s" %s>%s</option>', $location['id'], 0 == $location['id'] ? 'selected' : '', $location['location_name']);
									}
								?>
							</select>
						</p>

						<p>Note shipper theo ngày: </p>

						<p>Note admin theo ngày: </p>

						<p>
							+ Thêm note giao hàng mới
						</p>
					</div>
				</div>

				<div class="mt-3 mb-16">
					<button name="save_order" value="<?php echo time() ?>" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</form>

</div>
<script id="note_template" type="text/template">
<div class="row row-note mb-16">
	<div class="col-md-4">
		<select class="form-control input-note_name">
			<?php
				foreach ($list_notes as $name => $note_item) {
					printf('<option value="%s">%s</option>', $name, $note_item['name']);
				}
			?>
			<option value="khac" selected>Khác</option>
		</select>
	</div>
	<div class="col-md-8 col-note_values">
		<input type="text" class="form-control input-note_values" />
	</div>
</div>
</script>
<script>var orderDetailSettings = <?php echo json_encode($orderDetailSettings) ?>;</script>
<script src="<?php site_the_assets('js/order-detail.js?t=' . time()) ?>"></script>
<?php

// endwhile;

get_footer('customer');

?>