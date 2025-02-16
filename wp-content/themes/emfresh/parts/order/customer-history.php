<h3 class="card-title title-order d-f ai-center">
    <span class="fas fa-clock mr-8"></span>
    Đơn hàng gần đây
</h3>
<div class="history-order">
    <div class="no-history show">
        <img src="<?php site_the_assets(); ?>/img/icon/cart.svg" alt="">
        <div class="pt-8 color-gray fs-12 fw-regular">Chưa có lịch sử mua hàng</div>
    </div>
    <div id="order-container" class="history">
    <?php if ($customer_id != 0) { ?>
    <?php if (isset($response_order['data']) && is_array($response_order['data'])) { ?>
        <style>
            #order-container {
                display: block;
            }
            .order .history-order .no-history.show {
                display: none;
            }
        </style>
        <?php
        foreach ($response_order['data'] as $record_order) {
            //var_dump($record_order);
            if (is_array($record_order)) {
            ?>
            <details class="history-item using">
                <summary class="d-f jc-b ai-center history-header header_<?php echo $record_order['status'] ?>">
                    <div class="d-f ai-center history-id gap-8">
                        <span class="fas fa-dropdown"></span>
                        <span class="number"><?php echo $record_order['order_number'] ?></span>
                    </div>
                    <div class="d-f history-status gap-16">
                        <span class="status_order"><?php echo $record_order['status_name'] ?></span>
                        <a href="<?php echo $js_duplicate_url; ?>&amp;duplicate_order=<?php echo $record_order['order_number'] ?>"
                            target="_blank"><span class="copy"></span></a>
                    </div>
                </summary>
                <div class="history-content">
                    <div class="info">
                        <div class="d-f ai-center gap-10 address">
                            <span class="fas fa-location"></span>
                            <span class="txt"><?php echo $record_order['location_name'] ?></span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt"><?php echo strtoupper($record_order['item_name']) ?></span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8">
                            <span class="fas fa-shopping-money"></span>
                            <span class="txt-green fw-bold"><?php echo $record_order['total'] > 0 ? number_format($record_order['total']) : 0 ?></span>
                        </div>
                    </div>
                    
                    <div class="note-group">
                        <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                            <div class="d-f ai-center gap-10">
                                <span class="fas fa-note"></span>
                                <span class="txt">Yêu cầu đặc biệt:</span>
                            </div>
                            <span class="txt"><?php echo $record_order['note'] ?></span>
                        </div>
                        <div class="note">
                            <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                                <div class="d-f ai-center gap-10">
                                    <span class="fas fa-note"></span>
                                    <span class="txt">Giao hàng:</span>
                                </div>
                                <span class="txt"><?php echo $record_order['note_shipper'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </details>
        <?php
            } else {
                echo "Không tìm thấy dữ liệu!\n";
            }
        }
    }
 } ?>
    </div>
</div>