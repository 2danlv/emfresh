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
                    <p class="pt-8 pb-16 text-ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 07, Quận Bình Thạnh</p>
                </div>
                <div class="order-details show">
                    <div class="info-order line-dots">
                        <div class="d-f jc-b pt-8">
                            <span class="tlt fw-bold ">Phân loại đơn hàng:</span>
                            <span>W</span>
                        </div>
                        <div class="d-f jc-b pt-8">
                            <span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
                            <span>04/11/2024</span>
                        </div>
                        <div class="tlt fw-bold  pt-8">Thông tin sản phẩm:</div>
                        <div class="info-product pt-8">
                            <div class="d-f jc-b">
                                <div class="d-f"><span class="name">Slimfit M</span>&nbsp;x&nbsp;<span class="quantity">5</span></div>
                                <div class="price">325.000</div>
                            </div>
                            <div class="note-box pb-20">
                                <p><span class="note">Note rau củ</span>:&nbsp;<span class="value">cà rốt, bí đỏ, củ dền, bí ngòi</span></p>
                                <p><span class="note">Note tinh bột</span>:&nbsp;<span class="value">thay bún sang cơm trắng, thay miến sang cơm trắng, 1/2 tinh
                                        bột</span></p>
                                <p><span class="note">Note khác</span>:&nbsp;<span class="value">ko rau lá, chỉ củ, 2 sốt</span></p>
                                <p><span class="note">Note đính kèm</span>:&nbsp;<span class="value">thêm 1 tương ớt, thêm 1 ớt, túi riêng</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="info-pay">
                        <div class="d-f jc-b pt-18">
                            <span class="tlt fw-bold ">Tổng tiền phí ship:</span>
                            <span class="ship"><?php echo number_format($order_detail['ship_amount']) ?></span>
                        </div>
                        <div class="d-f jc-b pt-8">
                            <span class="tlt fw-bold ">Giảm giá:</span>
                            <span class="discount"><?php echo $order_detail['discount'] ?></span>
                        </div>
                        <div class="d-f jc-b pt-8 pb-8">
                            <span class="tlt fw-bold ">Tổng tiền đơn hàng:</span>
                            <span class="total total-price"><?php echo ($total = $order_detail['total_amount'] + $order_detail['ship_amount']) > 0 ? number_format($total) : 0; ?></span>
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