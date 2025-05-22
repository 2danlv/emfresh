<div class="card card-no_border">
    <div class="pl-16 pr-16 tab-products">
        <div class="tab-add-product" id="tabNav">
            <?php
                $current_date_format = current_time('Y-m-d');
                foreach ($order_items as $i => $order_item) : extract($order_item); ?>
                <span class="btn <?php echo $i > 0 ? '' : 'active' ?> d-f jc-b ai-center gap-8 btn btn-add_order tab-button js-show-order-item" data-tab="order_item_<?php echo $i + 1 ?>" data-id="order_item_<?php echo $i + 1 ?>">
                    Sản phẩm <?php echo $i + 1 ?>
                    <?php 
                    if (!empty($date_start) || $date_start <= $current_date_format) {?>
                        <span class="remove-tab"></span>
                    <?php } ?>
                </span>
            <?php endforeach ?>
            <span class="add-tab" id="addTabButton"></span>
        </div>
    </div>
    <div class="tab-products">
        <div id="tabContents" class="js-order-items">
            <?php 
                foreach ($order_items as $i => $order_item) : 
                    extract($order_item);

                    if (!empty($date_start) && $date_start <= $current_date_format && $date_start !='0000-00-00') {
                        //echo "Ngày " . $min_date->format('Y-m-d') . " đã bắt đầu";
                        $day_start = $date_start ;
                        $class_disable ="disable_edit";
                    } else {
                        //echo "Ngày " . $min_date->format('Y-m-d') . " chưa bắt đầu";
                        $day_start = $current_date_format;
                        $class_disable ="";
                    }

                    $meal_plan_not_use_count = $em_order_item->count_meal_plan_not_use($order_item);

                ?>
                <div class="js-order-item" id="order_item_<?php echo $i + 1 ?>" <?php echo $i > 0 ? 'style="display: none;"' : '' ?>>
                    <div class="tab-content">
                        <input type="hidden" class="mindate_start" value="<?php echo $day_start; ?>">
                        <input type="hidden" name="order_item[<?php echo $i ?>][id]" class="input-id" value="<?php echo $id ?>" />
                        <input type="hidden" name="order_item[<?php echo $i ?>][remove]" class="input-remove" />
                        <input type="hidden" name="order_item[<?php echo $i ?>][meal_number]" class="input-meal_number" value="<?php echo isset($meal_number) ? $meal_number : '' ?>" />
                        <?php if ( isset($get_date) && $get_date != "" ) {
                            $working_days_to_add = $days;

                            $date = new DateTime( $get_date );
                            // Nếu ngày bắt đầu là ngày làm việc thì trừ 1 luôn
                            if ( !in_array( $date->format( 'w' ), [ 0, 6 ] ) ) {
                                $working_days_to_add--;
                            }

                            // Bắt đầu tăng từng ngày (bỏ qua T7, CN)
                            while ( $working_days_to_add > 0 ) {
                                $date->modify( '+1 day' );
                                if ( !in_array( $date->format( 'w' ), [ 0, 6 ] ) ) {
                                    $working_days_to_add--;
                                }
                            }
                            ?>
                            <input type="hidden" name="order_item[<?php echo $i ?>][date_stop]" class="input-date_stop" value="<?php echo $date->format( 'Y-m-d' ); ?>" />
                        <?php } else {
                            $get_date = "";
                             ?>
                            <input type="hidden" name="order_item[<?php echo $i ?>][date_stop]" class="input-date_stop" value="<?php echo $date_stop ?>" />
                        <?php } ?>
                        <input type="hidden" name="order_item[<?php echo $i ?>][product_price]" class="input-product_price" value="<?php echo $product_price ?>" />
                        <input type="hidden" name="order_item[<?php echo $i ?>][ship_price]" class="input-ship_price" value="<?php echo $ship_price ?>" />
                        <input type="hidden" name="order_item[<?php echo $i ?>][note]" class="input-note" value="<?php echo $note ?>" />
                        <input type="hidden" class="input-note_list" value="<?php echo isset($note_list) ? base64_encode(json_encode($note_list)) : '' ?>" />
                        <div class="row24 group-type <?php echo $class_disable; ?>">
                            <div class="col-5">
                                <div class="label mb-4">Phân loại:</div>
                                <select name="order_item[<?php echo $i ?>][type]" class="form-control input-type" required>
                                    <option value="" disabled selected>D / W / M</option>
                                    <?php
                                    foreach ($list_types as $value) {
                                        printf('<option value="%s" %s>%s</option>', $value, $type == $value ? 'selected' : '', strtoupper($value));
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="label mb-4">Số ngày ăn:</div>
                                <input type="number" class="form-control input-days" name="order_item[<?php echo $i ?>][days]" value="<?php echo $days ?>" min="1" placeholder="Số ngày" required />
                            </div>
                            <div class="col-4">
                                <div class="label mb-4">Ngày bắt đầu:</div>
                                <?php if ($date_start !='' && $date_start !='0000-00-00') { ?>
                                    <input type="hidden" class="form-control input-date_start" name="order_item[<?php echo $i ?>][date_start]" value="<?php echo $date_start;?>" />
                                    <input type="text" class="form-control js-calendar date"  name="startday" value="<?php echo date("d/m/Y", strtotime($date_start));  ?>" placeholder="Ngày bắt đầu" required />
                                <?php } else { ?>
                                    <input type="hidden" class="form-control input-date_start" name="order_item[<?php echo $i ?>][date_start]" value="<?php echo $get_date; ?>" />
                                    <input type="text" class="form-control js-calendar date" name="startday" value="<?php echo date( "d/m/Y", strtotime( $get_date ) ); ?>" placeholder="Ngày bắt đầu" required />
                               <?php }
                                ?>
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
                                                <option value="" disabled selected>Nhập tên/mã sản phẩm</option>
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
                                    <?php if($order_id > 0) { ?>
                                    <p class="note note-no-use pl-8 pt-4">Chưa dùng: <span><?php echo $meal_plan_not_use_count ?></span></p>
                                    <?php } ?>
                                    <p class="console-product pl-8 pt-4"></p>
                                    <div class="d-f gap-12 ai-center">
                                        <label class="auto-fill-checkbox mt-16 mb-16">
                                            <input class="form-check-input" type="checkbox" value="1" name="order_item[<?php echo $i ?>][auto_choose]" id="auto_choose" <?php echo $auto_choose == 1 ? 'checked' : '' ?>>
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
                            <?php
                            if (!empty($note_list) && is_array($note_list)) {
                                foreach ($note_list as $note) {
                                    $selectedCategory = $note['name']; 
                                     ?>
                                    <div class="row row-note mb-16">
                                        <div class="col-4">
                                            <select name="note_name" class="form-control input-note_name">
                                            <?php foreach ($list_notes as $key => $note_select) { ?>
                                                <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>" 
                                                    <?php echo ($key === $selectedCategory) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($note_select['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php } ?>		
                                            </select>
                                        </div>
                                        <div class="col-8 col-note_values tag-container">
                                            <?php
                                            // Convert array to comma-separated string
                                            $values_string = implode(', ', $note['values']);
                                            ?>
                                            <input type="hidden" name="note_values" value="<?php echo htmlspecialchars($values_string, ENT_QUOTES, 'UTF-8'); ?>" class="form-control input-note_values">
                                        </div>
                                    </div>
                                <?php }
                            } ?>
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
