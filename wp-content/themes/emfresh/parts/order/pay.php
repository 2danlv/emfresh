<?php

$order_payment_logs = $em_log->get_items([
    'module' => 'em_order_payment',
    'module_id' => $order_id,
    // 'orderby'   => 'id DESC',
]);

?>
<div class="card history-action">
        <table class="regular">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                    <th>Nhân viên cập nhật</th>
                    <th>Mô tả</th>
                    <th>Số tiền</th>
                    <th>Còn nợ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($order_payment_logs as $item) :
                    
                    $item_time = strtotime($item['created']);
                    $contents = explode('|', $item['content']);
                ?>
                <tr>
                    <td><?php echo date('H:i', $item_time) ?></td>
                    <td><?php echo date('d/m/Y', $item_time) ?></td>
                    <td>
                        <img class="mr-8" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                        <?php echo $item['created_author'] ?>
                    </td>
                    <td><?php echo $item['action'] ?></td>
                    <td><?php echo $contents[0] ?></td>
                    <td><?php echo isset($contents[1]) ? $contents[1] : '' ?></td>
                </tr>
                <?php endforeach ?>
                <?php /*/ ?>
                <tr>
                    <td>01:00</td>
                    <td>29/10/24</td>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>Tạo đơn hàng</td>
                    <td>+ 700.000</td>
                    <td>+ 700.000</td>
                </tr>
                <?php /*/ ?>
            </tbody>
        </table>
</div>