<div class="card card-no_border">
    <div class="total-pay d-f jc-b ai-center">
        <p>Tổng tiền sản phẩm:</p>
        <p class="price-product fw-bold"><?php echo $order_detail['total_amount'] > 0 ? number_format($order_detail['total_amount']) : 0; ?></p>
        <input type="hidden" name="total_amount" class="input-total_amount" value="<?php echo $order_detail['total_amount'] ?>" />
    </div>
    <div class="shipping-fee">
        <div class="fee-item d-f jc-b ai-center">
            <p>Số ngày phát sinh phí ship:</p>
            <input type="number" name="ship_days" class="input-ship_days" value="<?php echo $order_detail['ship_days'] ?>" />
        </div>
        <div class="fee-item d-f jc-b ai-center">
            <p>Tổng tiền phí ship:</p>
            <input type="number" name="ship_amount" class="ip_ship_amount hidden" value="<?php echo $order_detail['ship_amount'] ?>" />
            <input type="text" class="input-ship_amount text-right" value="<?php echo $order_detail['ship_amount'] ?>" />
        </div>
        <div class="fee-item d-f jc-b ai-center">
            <p>Giảm giá:</p>
            <input type="number" name="discount" class="ip_discount hidden" value="<?php echo $order_detail['discount'] ?>" />
            <input type="text" class="input-discount text-right" value="<?php echo $order_detail['discount'] ?>" />
        </div>
    </div>
    <div class="total-pay d-f jc-b ai-center">
        <p>Tổng tiền đơn hàng:</p>
        <p class="price-order fw-bold"><?php echo ($total_money) > 0 ? number_format($total_money) : 0; ?></p>
    </div>
    <div class="order-payment">
        <div class="payment-item d-f jc-b ai-center">
            <p>Phương thức thanh toán:</p>
            <div class="d-f jc-b ai-center gap-16">
                <?php
                foreach ($list_payment_methods as $value => $label) {
                    printf('<label class="d-f ai-center gap-8"><input type="radio" name="payment_method" value="%s" %s>%s</label>', $value, $order_detail['payment_method'] == $value ? 'checked' : '', $label);
                }
                ?>
            </div>
        </div>
        <div class="payment-item d-f jc-b ai-center">
            <p>Trạng thái thanh toán:</p>
            <div class="status-payment">
                <div class="status-pay"><span data-status="<?php echo $order_detail['payment_status'] > 0 ? $order_detail['payment_status'] : 2; ?>"><?php echo $order_detail['payment_status'] ? $order_detail['payment_status_name'] : 'Chưa'; ?></span></div>
                <input type="hidden" name="payment_status" class="payment_status input_status-payment" value="<?php echo $order_detail['payment_status'] > 0 ? $order_detail['payment_status'] : 2; ?>" />
                <ul class="status-pay-menu">
                    <?php
                    foreach ($list_payment_statuses as $value => $label) {
                        printf('<li class="status-pay-item"><span data-status="%d" %s>%s</span></li>', $value, $order_detail['payment_status'] == $value ? 'selected' : '', $label);
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="paymented d-f jc-b ai-center pt-8">
            <p>Đã thanh toán:</p>
            <input type="number" name="paid" class="ip_preorder hidden" value="<?php echo $order_detail['paid'] > 0 ? $order_detail['paid'] : 0 ?>">
            <input type="text" placeholder="-" class="form-control input-preorder text-right" value="<?php echo $order_detail['paid'] > 0 ? $order_detail['paid'] : 0 ?>">
        </div>
        <div class="payment-item d-f jc-b ai-center pt-8">
            <p>Cần thanh toán:</p>
            <div class="payment-required fw-bold"><?php echo ($total_money - $order_detail['paid']) > 0 ? number_format($total_money - $order_detail['paid']) : 0; ?></div>
        </div>
    </div>
</div>