<div class="row row32">
    <div class="col-4">
        <div class="card section-wapper">
            <div class="card-body">
                <div class="ttl">
                    Thông tin đơn hàng
                </div>
                <div class="info-customer line-dots">
                    <p class="pt-16"><?php echo $order_detail['customer_name'] ?></p>
                    <p class="copy modal-button pt-8" data-target="#modal-copy" title="Copy: <?php echo $order_detail['phone'] ?>"><?php echo $order_detail['phone'] ?></p>
                    <p class="pt-8 pb-16 text-ellipsis address"><?php echo $detail_local; ?></p>
                </div>
                <div class="order-details show">
                    <div class="order-wapper">
                        <?php foreach ($order_items as $i => $order_item) : extract($order_item); ?>
                        <div class="info-order line" data-id="order_item_<?php echo $i + 1 ?>">
                            <?php if($i == 0) { ?>
                            <div class="d-f jc-b pt-8">
                                <span class="tlt fw-bold ">Phân loại đơn hàng:</span>
                                <span class="type-total"><?php echo $order_detail['type_name']; ?></span>
                            </div>
                            <div class="d-f jc-b pt-8">
                                <span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
                                <?php $min_date_start = null;
                                    foreach ($order_items as $item) {
                                        if ($min_date_start === null || strtotime($item['date_start']) < strtotime($min_date_start)) {
                                            $min_date_start = $item['date_start'];
                                        }
                                    } ?>
                                <span class="date-start"><?php echo date("d/m/Y", strtotime($min_date_start)); ?></span>
                            </div>
                            <div class="tlt fw-bold  pt-8">Thông tin sản phẩm:</div>
                            <?php } ?>
                            <div class="info-product pt-8">
                                <div class="d-f jc-b">
                                    <div class="d-f"><span class="name">
                                        <?php
                                            foreach ($list_products as $product) {
                                                echo $product['id'] == $product_id ? $product['name'] : '';
                                            }
                                            ?>
                                        </span>&nbsp;x&nbsp;<span class="quantity"><?php echo $quantity > 0 ? number_format($quantity) : 1 ?></span></div>
                                    <div class="price"><?php echo $amount > 0 ? number_format($amount) : 0 ?></div>
                                </div>
                                <div class="note-box pb-20">
                                    <?php
                                        foreach ($note_list as $note) {
                                            foreach ($note['values'] as $value) {
                                                printf('<p><span class="note">Note %s</span>:&nbsp;<span class="value">%s</span></p>', $note['name'], $value);
                                            }
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                        
                    </div>
                    <div class="info-pay">
                        <div class="d-f jc-b pt-18">
                            <span class="tlt fw-bold ">Tổng tiền phí ship:</span>
                            <span class="ship"><?php echo number_format($order_detail['ship_amount']) ?></span>
                        </div>
                        <div class="d-f jc-b pt-8">
                            <span class="tlt fw-bold ">Giảm giá:</span>
                            <span class="discount"><?php echo number_format($order_detail['discount']);?></span>
                        </div>
                        <div class="d-f jc-b pt-8 pb-8">
                            <span class="tlt fw-bold ">Tổng tiền đơn hàng:</span>
                            <span class="total total-price"><?php echo ($total = $order_detail['total_amount'] ) > 0 ? number_format($total) : 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <?php include( get_template_directory().'/parts/order/edit-detail.php');?>
    </div>
</div>