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
            <?php include( get_template_directory().'/parts/order/edit-detail-pay.php');?>
        </div>
        <div class="tab-pane-2 delivery-field" id="detail-delivery">
            <?php include( get_template_directory().'/parts/order/edit-detail-ship.php');?>
        </div>
    </div>
</form>