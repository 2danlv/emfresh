<?php


$order_logs = $em_log->get_items([
    'module' => 'em_order',
    'module_id' => $order_id,
    'orderby'   => 'id DESC',
]);

?>
<div class="card history-action">
        <table class="regular">
            <thead>
                <tr>
                    <th>Người thực hiện</th>
                    <th class="nowrap">Hành động</th>
                    <th>Trường</th>
                    <th>Mô tả</th>
                    <th class="nowrap">Thời gian</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($order_logs as $item) :
                    $item_time = strtotime($item['created']);
                    $actions = array_map('trim', explode('-', $item['action']));
                    // $contents = array_map('trim', explode(':', $item['content']));

                    $content = str_replace(["\n", '  '], ' ', $item['content']);
                ?>
                <tr>
                    <td>
                        <img class="mr-8" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                        <?php echo $item['created_author'] ?>
                    </td>
                    <td><?php echo $actions[0] ?></td>
                    <td style="min-width: 140px;"><?php echo $actions[1] ?></td>
                    <td class="wrap-td" style="max-width: 300px;"><div class="nowrap ellipsis"><?php echo $content ?></div></td>
                    <td><?php echo date('H:i', $item_time) ?></td>
                    <td><?php echo date('d/m/Y', $item_time) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
