<form method="post" action="<?php echo $action_url ?>">
    <button name="save_order" value="<?php echo time() ?>" class="btn btn-primary js-btn-save">Lưu thay đổi</button>
    <input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
    <input type="hidden" class="order_item_total" value="<?php echo $order_item_total ?>" />
    <input type="hidden" name="customer_id" class="input-customer_id" value="<?php echo $order_detail['customer_id'] ?>" />
    <input type="hidden" name="item_name" class="input-item_name" value="<?php echo $order_detail['item_name'] ?>" />
    <input type="hidden" name="location_name" class="input-location_name" value="<?php echo $order_detail['location_name'] ?>" />
    <input type="hidden" name="order_note" class="input-order_note" value="<?php echo $order_detail['note'] ?>" />
    <input type="hidden" name="order_type" class="input-order_type" value="<?php echo $order_detail['order_type'] ?>" />

    <ul class="nav tab-order edit-product pt-20">
        <li class="nav-item defaulttab_order" rel="detail-product">Sản phẩm</li>
        <li class="nav-item" rel="detail-pay">Thanh toán</li>
        <li class="nav-item" rel="detail-delivery">Giao hàng</li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane-2" id="detail-product">
            <div class="card">
                <div class="pl-16 pr-16 tab-products">
                    <div class="tab-add-product" id="tabNav">
                        <?php foreach($order_items as $i => $order_item) : ?>
                        <span class="btn <?php echo $i > 0 ? '' : 'active' ?> d-f jc-b ai-center gap-8 btn btn-add_order tab-button "  data-tab="order_item_<?php echo $i + 1 ?>" data-id="order_item_<?php echo $i + 1 ?>">
                            Sản phẩm <?php echo $i + 1 ?>
                            <span class="remove-tab"></span></span>
                            <?php endforeach ?>
                            <span class="add-tab" id="addTabButton"></span>
                    </div>
                </div>
                <div class="tab-products">
                    <div id="tabContents" class="js-order-items">
                        <?php foreach($order_items as $i => $order_item) : extract($order_item); ?>
                        <div class="js-order-item" id="order_item_<?php echo $i + 1 ?>" <?php echo $i > 0 ? 'style="display: none;"' : '' ?>>
                            <div class="tab-content">
                                <input type="hidden" name="order_item[<?php echo $i ?>][id]" class="input-id" value="<?php echo $id ?>" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][remove]" class="input-remove" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][note]" class="input-note" value="<?php echo $note ?>" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][date_stop]" class="input-date_stop" value="<?php echo $date_stop ?>" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][product_price]" class="input-product_price" value="<?php echo $product_price ?>" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][ship_price]" class="input-ship_price" value="<?php echo $ship_price ?>" />
                                <input type="hidden" name="order_item[<?php echo $i ?>][note]" class="input-note" value="<?php echo $note ?>" />
                                <input type="hidden" class="input-note_list" value="<?php echo isset($note_list) ? base64_encode(json_encode($note_list)) : '' ?>" />
                                <div class="row24">
                                    <div class="col-5">
                                        <div class="label mb-4">Phân loại:</div>
                                        <select name="order_item[<?php echo $i ?>][type]" class="form-control input-type" required>
                                            <!-- <option value="">Chọn loại</option> -->
                                            <?php
                                            foreach ($list_types as $value) {
                                                printf('<option value="%s" %s>%s</option>', $value, $type == $value ? 'selected' : '', strtoupper($value));
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="label mb-4">Số ngày dùng:</div>
                                        <input type="number" class="form-control input-days" name="order_item[<?php echo $i ?>][days]" value="<?php echo $days ?>" min="1" placeholder="Số ngày" required/>
                                    </div>
                                    <div class="col-4">
                                        <div class="label mb-4">Số ngày dùng:</div>
                                        <input type="text" class="form-control js-calendar date input-date_start" name="order_item[<?php echo $i ?>][date_start]" value="<?php echo date("d/m/Y", strtotime($date_start));  ?>" placeholder="Ngày bắt đầu" required />
                                    </div>
                                </div>
                                <div class="list-product">
                                    <div class="product-item">
                                        <div class="d-f gap-24 item-head">
                                            <div class="col-5 label">Tên sản phẩm</div>
                                            <div class="col-3 label text-right">Số lượng</div>
                                            <div class="col-4 label text-right">Thành tiền</div>
                                        </div>
                                        <div class="pt-16 item-body">
                                            <div class="d-f gap-24">
                                                <div class="col-5">
                                                    <select name="order_item[<?php echo $i ?>][product_id]" class="form-control input-product_id" required>
                                                        <!-- <option value="0">Chọn gói</option> -->
                                                        <?php
                                                        foreach ($list_products as $product) {
                                                            printf('<option value="%s" %s>%s</option>', $product['id'], $product_id == $product['id'] ? 'selected' : '', $product['name']);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-3"><input type="number" name="order_item[<?php echo $i ?>][quantity]" value="<?php echo $quantity ?>" class="form-control input-quantity" min="1" placeholder="-" required /></div>
                                                <div class="col-4 text-right">
                                                    <p class="fs-16 fw-bold price text-amount pt-8 pb-8"><?php echo $amount > 0 ? number_format($amount) : 0 ?></p>
                                                    <input type="hidden" name="order_item[<?php echo $i ?>][amount]" value="<?php echo $amount ?>" class="input-amount" />
                                                </div>
                                            </div>
                                            <p class="note note-no-use pl-8 pt-4">Chưa dùng: <span>3</span></p>
                                            <div class="d-f gap-12 ai-center">
                                                <label class="auto-fill-checkbox mt-16 mb-16">
                                                    <input class="form-check-input" type="checkbox" value="1" name="order_item[<?php echo $i ?>][auto_choose]" id="auto_choose" <?php echo $auto_choose == 1 ? 'selected' : '' ?>>
                                                    <span class="slider"></span>
                                                </label>
                                                Tự chọn món
                                                <div class="explain-icon">
                                                    <img width="16" src="<?php site_the_assets(); ?>img/icon/WarningCircle-gray.svg" alt="">
                                                    <div class="explain-block d-f ai-center gap-8">
                                                        Chế độ này bật khi được khách hàng cho phép chọn món giúp họ
                                                        <i class="fas fa-trash close-explain"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="special-request js-note-list pt-16">
                                </div>
                                <div class="d-f ai-center pt-20 clone-note js-add-note fw-bold">
                                    <span class="fas fa-plus mr-8"></span>Thêm yêu cầu phần ăn đặc biệt
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane-2 pay-field" id="detail-pay">
            <div class="card">
                <div class="total-pay d-f jc-b ai-center">
                    <p>Tổng tiền sản phẩm:</p>
                    <p class="price-product fw-bold"><?php echo $order_detail['total_amount'] > 0 ? number_format($order_detail['total_amount']) : 0; ?></p>
                    <input type="hidden" name="total_amount" class="input-total_amount" value="<?php echo $order_detail['total_amount'] ?>" />
                </div>
                <div class="shipping-fee">
                    <div class="fee-item d-f jc-b ai-center">
                        <p>Là đơn gộp tụ ship?</p>
                        <div class="d-f gap-12 ai-center">
                            <label class="auto-fill-checkbox">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span class="fs-16 color-gray">Không</span>
                        </div>
                    </div>
                    <div class="fee-item d-f jc-b ai-center">
                        <p>Số ngày phát sinh phí ship:</p>
                        <input type="number" name="ship_days" class="input-ship_days" value="<?php echo $order_detail['ship_days'] ?>" />
                    </div>
                    <div class="fee-item d-f jc-b ai-center">
                        <p>Tổng tiền phí ship:</p>
                        <input type="number" name="ship_amount" class="input-ship_amount" value="<?php echo $order_detail['ship_amount'] ?>" />
                    </div>
                    <div class="fee-item d-f jc-b ai-center">
                        <p>Giảm giá:</p>
                        <input type="number" name="discount" class="input-discount" value="<?php echo $order_detail['discount'] ?>"/>
                    </div>
                </div>
                <div class="total-pay d-f jc-b ai-center">
                    <p>Tổng tiền đơn hàng:</p>
                    <p class="price-order fw-bold"><?php echo ($total = $order_detail['total_amount'] + $order_detail['ship_amount']) > 0 ? number_format($total) : 0; ?></p>
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
                            <div class="status-pay"><span class="red">Chưa</span></div>
                            <input type="hidden" name="payment_status" class="payment_status input_status-payment" value="" />
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
                        <input type="number" name="number" placeholder="-" class="form-control text-right">
                    </div>
                    <div class="payment-item d-f jc-b ai-center pt-8">
                        <p>Cần thanh toán:</p>
                        <div class="payment-required fw-bold"> <?php echo number_format($order_detail['total_amount'] + $order_detail['ship_amount']) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane-2 delivery-field" id="detail-delivery">
            <div class="card">
                <div class="pl-16 pr-16">
                    <div class="row delivery-item">
                        <div class="col-4">Đặt lịch:</div>
                        <div class="col-8">
                            <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                                <input type="checkbox" name="loop" id="loop">
                                Lặp lại hàng tuần
                            </label>
                            <div class="calendar">
                                <input type="text" name="calendar" placeholder="DD/MM/YYYY" class="form-control js-calendar date">
                            </div>
                            <div class="repeat-weekly">
                                <input type="checkbox" id="monday" hidden name="days" value="monday">
                                <label for="monday">Thứ Hai</label>
                                <input type="checkbox" id="tuesday" hidden name="days" value="tuesday">
                                <label for="tuesday"> Thứ Ba</label>
                                <input type="checkbox" id="wednesday" hidden name="days" value="wednesday">
                                <label for="wednesday"> Thứ Tư</label>
                                <input type="checkbox" id="thursday" hidden name="days" value="thursday">
                                <label for="thursday"> Thứ Năm</label>
                                <input type="checkbox" id="friday" hidden name="days" value="friday">
                                <label for="friday"> Thứ Sáu</label>
                            </div>
                        </div>
                    </div>
                    <div class="row delivery-item pt-24 ai-center">
                        <div class="col-4">Địa chỉ giao:</div>
                        <div class="col-8 address">
                            <div class="dropdown">
                                <select name="ship_location_id" class="form-control select-location_id input-location_id">
                                    <?php
                                    foreach ($list_locations as $location) {
                                        printf('<option value="%s" %s>%s</option>', $location['id'], 0 == $location['id'] ? 'selected' : '', $location['location_name']);
                                    }
                                    ?>
                                </select>
                                <span class="fs-14 hidden fw-regular note-shipper color-gray pl-8">Note với shipper: <span class="note_shiper"></span></span>
                            </div>
                            <div class="dropdown-menu">
                                <div class="item">
                                    <p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                    <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
                                </div>
                                <a href="#modal-add-address" class="btn-add-address d-f ai-center pb-16 pt-8 pl-8">
                                    <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="js-note delivery-item">
                        <div class="row pt-16 ai-center">
                            <div class="col-4">Note shipper theo ngày:</div>
                            <div class="col-8">
                                <input type="text" name="note_shipper_by_day" class="form-control note_shipper_by_day">
                            </div>
                        </div>
                        <div class="row pt-16 ai-center">
                            <div class="col-4">Note admin theo ngày:</div>
                            <div class="col-8">
                                <input type="text" name="note_admin_by_day" class="form-control note_admin_by_day">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-f ai-center pb-16 pt-24 add-new-note">
                <span class="fas fa-plus mr-8"></span> Thêm note giao hàng mới
            </div>
        </div>
    </div>
</form>