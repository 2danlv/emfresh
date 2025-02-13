<?php

$data = site_order_get_meal_plans($_GET);

// var_dump($data);

?>
<div class="detail-customer pt-16">
    <?php if(count($data) > 0) : ?>
    <table class="table">
        <thead>
            <tr>
                <th>Tên khách hàng</th>
                <th>Mã sản phẩm</th>
                <th>Phân loại</th>
                <th>Trạng thái đặt đơn</th>
                <?php foreach($data['schedule'] as $date) : ?>
                <td data-date="<?php echo $date ?>"><?php echo date('d', strtotime($date)) ?></td>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($data['orders'] as $order) : 
                    $meal_plan_items = $order['meal_plan_items'];
            ?>
            <tr class="order-<?php echo $order['order_number'] ?>">
                <td><?php echo $order['order_number'] ?></td>
                <td><?php echo $order['item_name'] ?></td>
                <td><?php echo $order['type_name'] ?></td>
                <td><?php echo $order['status_name'] ?></td>
                <?php foreach($data['schedule'] as $date) : 
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : '';
                ?>
                <td><?php echo $value ?></td>
                <?php endforeach; ?>
            </tr>
            <?php foreach($order['order_items'] as $i => $order_item) : 
                $meal_plan_items = $order_item['meal_plan_items'];
            ?>
            <tr class="order-of-<?php echo $order['order_number'] ?>">
                <td>Sản phẩm <?php echo $i + 1 ?></td>
                <td><?php echo $order_item['product_name'] ?></td>
                <td><?php echo strtoupper($order_item['type']) ?></td>
                <td></td>
                <?php foreach($data['schedule'] as $date) : 
                
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : ''; 
                
                ?>
                <td><?php echo $value ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif ?>
</div>