<?php

$data = site_order_get_meal_plans($_GET);

// var_dump($data);

?>
<div class="detail-customer pt-16 js-meal-plan">
    <?php if(count($data) > 0) : ?>
    <p align=right>
        <a class="btn btn-primary js-save-meal-plan">Save</a>
    </p>
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
            <tr class="order-<?php echo $order['id'] ?>" data-order_id="<?php echo $order['id'] ?>">
                <td><?php echo $order['order_number'] ?></td>
                <td><?php echo $order['item_name'] ?></td>
                <td><?php echo $order['type_name'] ?></td>
                <td><?php echo $order['status_name'] ?></td>
                <?php foreach($data['schedule'] as $date) : 
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : '';
                ?>
                <td data-date="<?php echo $date ?>"><?php echo $value ?></td>
                <?php endforeach; ?>
            </tr>
            <?php foreach($order['order_items'] as $i => $order_item) : 
                $meal_plan_items = $order_item['meal_plan_items'];
                $total = array_sum($meal_plan_items);
            ?>
            <tr class="order-<?php echo $order['id'] ?> order-item" 
                data-order_id="<?php echo $order['id'] ?>" 
                data-order_item_id="<?php echo $order_item['id'] ?>"
                data-total="<?php echo $total ?>"
            >
                <td class="title">Sản phẩm <?php echo $i + 1 ?></td>
                <td><?php echo $order_item['product_name'] ?></td>
                <td><?php echo strtoupper($order_item['type']) ?></td>
                <td></td>
                <?php foreach($data['schedule'] as $date) : 
                
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : ''; 
                
                ?>
                <td><input type="text" 
                        class="input-meal_plan<?php echo $value == '' ? ' empty' : '' ?>" 
                        value="<?php echo $value ?>" 
                        data-date="<?php echo $date ?>" 
                        data-old="<?php echo $value ?>" 
                    /></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif ?>
</div>
<script>
jQuery(function($){

    $('.input-meal_plan').on('change', function(){
        let input = $(this), value = input.val();

        input.closest('.order-item').toggleClass('changed', value != input.data('old'));
    })

    $('.js-save-meal-plan').on('click', function(e){
        e.preventDefault();

        let list_meal = [], errors = [];

        $('.js-meal-plan .order-item.changed').each(function(){
            let p = $(this), meal_plan = {}, 
                total = parseInt(p.data('count')),
                count = 0;
                
            p.find('.input-meal_plan').each(function(){
                let input = $(this)

                if(input.val() > 0) {
                    meal_plan[input.data('date')] = input.val();

                    count += input.val();
                }
            })
            
            if(total == count) {
                list_meal.push({
                    order_id : p.data('order_id'),
                    order_item_id : p.data('order_item_id'),
                    meal_plan : meal_plan
                });
            } else {
                errors.push(p.find('.title').text());
            }
        });

        if(errors.length > 0) return alert('Vui lòng kiểm tra số ngày: ' + errors.join(", ") + '.');

        if(list_meal.length == 0) return ;

        $.post('?', {
            ajax: 1,
            save_meal_plan: 1,
            list_meal: list_meal
        }, function(res){

            console.log('res', res);

            if(res.code == 200) {
                alert('Lưu thành công! ');
            } else {
                alert('Lưu không thành công! ');
            }
        }, 'JSON');
    })

});
</script>