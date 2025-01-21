<ul class="nav tab-order edit-product pt-20">
    <li class="nav-item defaulttab_order" rel="detail-product">Sản phẩm</li>
    <li class="nav-item" rel="detail-pay">Thanh toán</li>
    <li class="nav-item" rel="detail-delivery">Giao hàng</li>
</ul>
<form method="post" action="<?php echo $action_url ?>">
    <input type="hidden" name="save_order" value="<?php echo time() ?>" />
    <input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
    <input type="hidden" class="order_item_total" value="<?php echo $order_item_total ?>" />
    <input type="hidden" name="customer_id" class="input-customer_id" value="<?php echo $order_detail['customer_id'] ?>" />
    <input type="hidden" name="location_id" class="input-location_id" value="<?php echo $order_detail['location_id'] ?>" />
    <input type="hidden" name="item_name" class="input-item_name" value="<?php echo $order_detail['item_name'] ?>" />
    <input type="hidden" name="location_name" class="input-location_name" value="<?php echo $order_detail['location_name'] ?>" />
    <input type="hidden" name="order_note" class="input-order_note" value="<?php echo $order_detail['note'] ?>" />
    <input type="hidden" name="order_type" class="input-order_type" value="<?php echo $order_detail['order_type'] ?>" />

    <div class="tab-content">
        <div class="tab-pane-2" id="detail-product">
            <?php include get_template_directory() . '/parts/order/edit-detail-create.php'; ?>
        </div>
        <div class="tab-pane-2 pay-field" id="detail-pay">
            <?php include get_template_directory() . '/parts/order/edit-detail-pay.php'; ?>
        </div>
        <div class="tab-pane-2 delivery-field" id="detail-delivery">
            <?php include get_template_directory() . '/parts/order/edit-detail-ship.php'; ?>
        </div>
    </div>
    
</form>