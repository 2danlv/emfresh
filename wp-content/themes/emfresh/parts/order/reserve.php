<?php
global $em_log;

$count_phan_an = 0;
$reserve_days = [];
$reserve_start = '';
$continue_link = '';
$cancel_link = '';
$end_link = '';

if($order_detail['status'] == 3) {
    foreach($order_items as $order_item) {
        if($order_item['meal_plan_reserve'] != '') {
            $meal_plan_reserve = (array) json_decode($order_item['meal_plan_reserve'], true);

            if(count($meal_plan_reserve) == 0) continue;

            $days = array_keys($meal_plan_reserve);

            $count_phan_an += array_sum($meal_plan_reserve);

            $reserve_days = array_merge($reserve_days, $meal_plan_reserve);

            $value = $days[0];

            if($reserve_start == '' || $reserve_start > $value) {
                $reserve_start = $value;
            }
        }
    }

    $continue_link = add_query_arg(['continonce' => wp_create_nonce('continonce'), 'continue_order' => $order_id], site_order_edit_link());
    $cancel_link = add_query_arg(['cancelnonce' => wp_create_nonce('cancelnonce'), 'cancel_order' => $order_id, 'new_order' => 1], site_order_edit_link());
    $end_link = add_query_arg(['cancelnonce' => wp_create_nonce('cancelnonce'), 'cancel_order' => $order_id], site_order_edit_link());
}

$count_days = count($reserve_days);

$reserve_logs = $em_log->get_items([
    'module' => 'em_order_reserve',
    'module_id' => $order_id,
    'orderby'   => 'id DESC',
]);

?>
<div class="row row32 reserve">
    <div class="col-8">
        <div class="section-wapper">
            <div class="tlt-section">Thông tin bảo lưu</div>
            <div class="section-content status-content">
                <div class="d-f ai-center jc-b">
                    <p class="txt">Trạng thái đặt đơn:</p>
                    <p class="txt tag-status red">Đặt đơn</p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Số phần ăn bảo lưu:</p>
                    <p class="txt"><?php echo $count_phan_an > 0 ? $count_phan_an : '-' ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Số ngày giao hàng bảo lưu:</p>
                    <p class="txt"><?php echo $count_days > 0 ? $count_days : '-' ?></p>
                </div>
                <div class="d-f ai-center jc-b">
                    <p class="txt">Ngày bắt đầu bảo lưu:</p>
                    <p class="txt"><?php echo $reserve_start != '' ? date('d/m/Y', strtotime($reserve_start)) : '-' ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <a href="#" data-href="<?php echo $continue_link ?>" class="btn btn-secondary btn-reserve db js-continue">Tiếp tục đơn hàng</a>
        <a href="<?php echo $cancel_link ?>#" class="btn btn-secondary btn-reserve db js-cancel">Huỷ phần bảo lưu & Giảm giá đơn mới</a>
        <a href="<?php echo $end_link ?>#" class="btn btn-secondary btn-reserve db js-end danger">Kết thúc đơn hàng vì quá hạn<!-- (admin only)--></a>
    </div>
</div>
<div class="table-container">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ngày thực hiện</th>
                    <th>Người thực hiện</th>
                    <th>Hành động</th>
                    <th>Mô tả</th>
                    <th>Ngày bắt đầu</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($reserve_logs as $item) :
                        $item_time = strtotime($item['created']);
                        $contents = explode("|", $item['content']);
                        $content = $item['content'];
                        $date_start = '-';
                        if(count($contents)==2) {
                            $content = $contents[1];
                            $date_start = $contents[0];
                        }
                ?>
                <tr>
                    <td><?php echo date('d/m/y', $item_time) ?></td>
                    <td>
                        <img class="mr-8" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                        <?php echo $item['created_author'] ?>
                    </td>
                    <td><?php echo $item['action'] ?></td>
                    <td><?php echo $content ?></td>
                    <td><?php echo date('d/m/y', strtotime($date_start)) ?></td>
                </tr>
                <?php endforeach ?>
                <?php /*/ ?>
                <tr>
                    <td>29/10/24</td>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>xử lý bảo lưu</td>
                    <td>Tạo đơn mới #23456 từ phần bảo lưu</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>29/10/24</td>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>xử lý bảo lưu</td>
                    <td>Giảm giá đơn mới #23456 từ phần bảo lưu</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>29/10/24</td>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>xử lý bảo lưu</td>
                    <td>kết thúc đơn hàng</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>29/09/24</td> 
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>bảo lưu</td>
                    <td>Số phần ăn bảo lưu: 15/ Số ngày giao hàng bảo lưu: 5</td>
                    <td>04/10/2024</td>
                </tr>
                <tr>
                    <td>29/09/24</td>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>bảo lưu</td>
                    <td>Số phần ăn bảo lưu: 15/ Số ngày giao hàng bảo lưu: 5</td>
                    <td>04/10/2024</td>
                </tr>
                <!-- Add more rows if needed -->
                <?php /*/ ?>
            </tbody>
        </table>
    </div>
</div>