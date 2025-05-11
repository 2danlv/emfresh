<div class="row row32">
    <div class="col-8">
        <div class="section-wapper">
            <div class="tlt-section">Đơn hàng</div>
            <div class="section-content">
                <div class="d-f ai-center jc-b">
                    <p class="txt">Phân loại đơn hàng:</p>
                    <p class="txt"><?php echo $order_detail['type_name']; ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Mã gói sản phẩm:</p>
                    <p class="txt"><?php echo $order_detail['item_name']; ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Ngày bắt đầu:</p>
                    <p class="txt">
                    <?php if ($min_date_start !='1970-01-01' && $get_date == "") { ?>
                        <?php echo date("d/m/Y", strtotime($min_date_start)); ?>
                    <?php } elseif ( $get_date != "" ) {?>
                        <?php echo date("d/m/Y", strtotime($get_date)); ?>
                    <?php } ?>
                    </p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Ngày kết thúc:</p>
                    <?php $max_date_stop = null;
                    foreach ($order_items as $item) {
                        if ($max_date_stop === null || strtotime($item['date_stop']) > strtotime($max_date_stop)) {
                            $max_date_stop = $item['date_stop'];
                        }
                    } 
                    ?>
                    <p class="txt">
                    <?php if ($min_date_start !='1970-01-01' && $get_date == "") { ?>
                        <?php echo date("d/m/Y", strtotime($max_date_stop)); ?>
                    <?php } ?>
                    </p>
                </div>
                
            </div>
        </div>
        <?php //var_dump($order_detail); ?>
        <div class="section-wapper">
            <div class="tlt-section">Sản phẩm</div>
            <div class="section-content">
                <?php foreach ($order_items as $i => $order_item) : extract($order_item); ?>
                    <div class="product-item" data-id="order_item_<?php echo $i + 1 ?>">
                        <div class="product-head d-f jc-b ai-center">
                            <div class="txt fw-bold">
                                <?php
                                    foreach ($list_products as $product) {
                                        echo $product['id'] == $product_id ? $product['name'] : '';
                                    }
                                    ?>
                                &nbsp;x&nbsp;<span class="quantity"><?php echo $quantity > 0 ? number_format($quantity) : 1 ?></span></div>
                            <div class="txt"><?php echo $amount > 0 ? number_format($amount) : 0 ?></div>
                        </div>
                        <div class="product-body">
                            <?php
                            if (!empty($note_list) && is_array($note_list)) {
                                foreach ($note_list as $note) {
                                    printf('<div class="note-txt"><span class="note">Note %s</span>:&nbsp;', $note['name']);
                                    $values_string = implode(', ', $note['values']);
                                    printf('<span class="value">%s</span>', htmlspecialchars($values_string, ENT_QUOTES, 'UTF-8'));
                                    printf('</div>');
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="section-ship line-dots-top">
                <div class="d-f ai-center jc-b">
                    <p class="txt">Số ngày phát sinh phí ship:</p>
                    <p class="txt"><?php echo $order_detail['ship_days']; ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Tổng tiền phí ship:</p>
                    <p class="txt"><?php echo number_format($order_detail['ship_amount']); ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Giảm giá:</p>
                    <p class="txt"><?php echo number_format($order_detail['discount']); ?></p>
                </div>
                <div class="d-f ai-center jc-b mt-4">
                    <p class="txt black fw-bold">Tổng tiền đơn hàng:</p>
                    <p class="cost-txt"><?php
                    $total_money = $order_detail['total_amount'] + $order_detail['ship_amount'] - $order_detail['discount'];
                    echo number_format($total_money)?></p>
                </div>
            </div>
        </div>
        <div class="section-wapper">
            <div class="tlt-section">Thanh toán</div>
            <div class="section-content">
                <div class="d-f ai-center jc-b">
                    <p class="txt">Cần thanh toán:</p>
                    <p class="txt"><?php echo number_format($total_money)?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Đã thanh toán:</p>
                    <p class="txt"><?php echo number_format($order_detail['paid']) ?></p>
                </div>
            </div>
            <div class="section-ship line-dots-top">
                <div class="d-f ai-center jc-b mt-4">
                    <p class="txt black fw-bold">Số tiền còn lại:</p>
                    <p class="cost-txt red">
                        <?php echo ($total_money - $order_detail['paid'] ) > 0 ? number_format($total_money - $order_detail['paid'] ) : 0; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="section-wapper">
            <div class="tlt-section">Khách hàng</div>
            <?php if(!empty($group['id']) && $order_detail['order_type'] == 'group') : ?>
            <div class="section-content">
                <p class="txt"><a href="/customer/detail-customer/?customer_id=<?php echo $order_detail['customer_id'] ?>"><?php echo $order_detail['customer_name'] ?></a></p>
                <p class="txt">Người nhận: <?php echo $group['name']; ?></p>
                <p class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $group['phone'] ?>"><?php echo $group['phone'] ?></p>
                <p class="txt ellipsis"><?php echo $group['location_name']; ?></p>
                <?php if (!empty($group['note'])) { ?>
                <p class="txt ellipsis">Note nhóm: <?php echo $group['note'] ?></p>
                <?php } ?>
                <?php if (!empty($order_detail['note_shipper'])) { ?>
                <p class="txt ellipsis">Note shipper: <?php echo $order_detail['note_shipper'] ?></p>
                <?php }
                if (!empty($order_detail['note_admin'])) { ?>
                <p class="txt ellipsis">Note admin: <?php echo $order_detail['note_admin'] ?></p>
                <?php } ?>
                <p class="note-txt italic">(Đã đăng ký chung nhóm ship: <?php echo $group['name'] ?>)</p>
            </div>
            <?php else : ?>
            <div class="section-content">
                <p class="txt"><a href="/customer/detail-customer/?customer_id=<?php echo $order_detail['customer_id'] ?>"><?php echo $order_detail['customer_name'] ?></a></p>
                <?php if ($order_detail['customer_name_2nd'] != '') { ?>
                <p class="txt">Người nhận: <?php echo $order_detail['customer_name_2nd']; ?></p>
                <?php } ?>
                <p class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $order_detail['phone'] ?>"><?php echo $order_detail['phone'] ?></p>
                <p class="txt ellipsis"><?php echo $order_detail['location_name']; ?></p>
                <?php if (!empty($order_detail['note_shipper'])) { ?>
                <p class="txt ellipsis">Note shipper: <?php echo $order_detail['note_shipper'] ?></p>
                <?php }
                if (!empty($order_detail['note_admin'])) { ?>
                <p class="txt ellipsis">Note admin: <?php echo $order_detail['note_admin'] ?></p>
                <?php } ?>
            </div>
            <?php endif ?>
        </div>
        <div class="section-wapper">
            <div class="tlt-section">Trạng thái</div>
            <div class="section-content status-content">
                <div class="d-f jc-b ai-center">
                    <p class="txt">Trạng thái đặt đơn:</p>
                    <!-- <div class="tag-status purple">Dí món</div> -->
                    <div class="status_order status_order-meal-<?php echo $order_detail['order_status']; ?>"><?php echo $order_detail['order_status_name']; ?></div>
                </div>
                <div class="d-f jc-b ai-center">
                    <p class="txt">Phương thức thanh toán:</p>
                    <p class="txt "><?php echo $order_detail['payment_method_name']; ?></p>
                </div>
                <div class="d-f jc-b ai-center">
                    <p class="txt">Trạng thái thanh toán:</p>
                    <div class="tag-status bg<?php echo $order_detail['payment_status']; ?>"><?php echo $order_detail['payment_status_name']; ?></div>
                </div>
                <div class="d-f jc-b ai-center">
                    <p class="txt">Trạng thái đơn hàng:</p>
                    <?php
                    if ( $order_detail[ 'status' ] == 2 ) {
                        if ( !empty($admin_role) && $admin_role[ 0 ] == 'administrator' ) { ?>
                            <span
                                class="status_order status_order-<?php echo $order_detail[ 'status' ] ?>"><?php echo $order_detail[ 'status_name' ] ?></span>
                        <?php }
                        else { ?>
                            <span class="status_order status_order-1">Đang dùng</span>
                        <?php }
                    }
                    else { ?>
                        <span
                            class="status_order status_order-<?php echo $order_detail[ 'status' ] ?>"><?php echo $order_detail[ 'status_name' ] ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php $params = unserialize($order_detail['params']);
        //var_dump($params);
        if (!empty($params['ship'][0]) && array_filter($params['ship'][0])) {
        ?>
        <div class="section-wapper">
            <div class="tlt-section">Giao hàng</div>
            <div class="section-content">
                <?php 
                    foreach ($params['ship'] as $ship) {  
                        if (!empty($ship['location_name'])) { ?>
                        <div class="item-section">
                            <p class="txt black ellipsis">
                            <?php
                            if (!empty($ship['days']) && is_array($ship['days'])) { 
                                echo implode(", ", $ship['days']);
                                echo "<br>";
                            } else { 
                                echo  date("d/m/Y", strtotime($ship['calendar']));
                                echo "<br>";
                            }
                                ?>
                            <?php echo $ship['location_name']; ?>
                            </p>
                            <ul>
                                <?php if (!empty($ship['note_shipper'])) { ?>
                                <li class="txt black">
                                    Note shipper theo ngày: <br><?php echo $ship['note_shipper'];  ?>
                                </li>
                                <?php } 
                                if (!empty($ship['note_admin'])) { ?>
                                    <li class="txt black">
                                        Note admin theo ngày: <br><?php echo $ship['note_admin'];  ?>
                                    </li>
                                <?php  } ?>
                            </ul>
                        </div>
                    <?php    }
                    }
                ?>
                <p class="note-txt italic">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>