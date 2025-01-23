<?php


$order_logs = $em_log->get_items([
    'module' => 'em_order',
    'module_id' => $order_id,
    // 'orderby'   => 'id DESC',
]);

?>
<div class="table-container activity-history-table">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ngày thực hiện</th>
                    <th>Hành động</th>
                    <th>Trường</th>
                    <th>Mô tả</th>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($order_logs as $item) :
                
                    $item_time = strtotime($item['created']);
                    $contents = explode(':', $item['content']);
                ?>
                <tr>
                    <td>
                        <img class="mr-8" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                        <?php echo $item['created_author'] ?>
                    </td>
                    <td><?php echo $item['action'] ?></td>
                    <td><?php echo $contents[0] ?></td>
                    <td class="ellipsis"><?php echo isset($contents[1]) ? $contents[1] : '' ?></td>
                    <td><?php echo date('H:i', $item_time) ?></td>
                    <td><?php echo date('d/m/Y', $item_time) ?></td>
                </tr>
                <?php endforeach ?>

                <?php /*/ ?>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <tr>
                    <td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
                    <td>cập nhật</td>
                    <td>địa chỉ</td>
                    <td class="ellipsis">sản phẩm 1 số lượng 05</td>
                    <td>01:00</td>
                    <td>29/10/24</td>
                </tr>
                <?php /*/ ?>
            </tbody>
        </table>
    </div>
</div>
<div class="dt-container pb-16 pr-8">
    <div class="bottom">
        <div class="dt-paging">
            <nav aria-label="pagination">
                <button class="dt-paging-button disabled previous" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Previous"
                    data-dt-idx="previous" tabindex="-1"><i class="fas fa-left"></i></button>
                <button class="dt-paging-button current" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">1</button>
                <button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">2</button>
                <button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">3</button>
                <button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">4</button>
                <button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">5</button>
                <button class="dt-paging-button disabled next" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Next"
                    data-dt-idx="next" tabindex="-1"><i class="fas fa-right"></i></button>
            </nav>
        </div>
        <div class="dt-length"><select name="list-customer_length" aria-controls="list-customer" class="dt-input" id="dt-length-0">
                <option value="10">10 / trang</option>
                <option value="50">50 / trang</option>
                <option value="100">100 / trang</option>
                <option value="200">200 / trang</option>
            </select><label for="dt-length-0"> entries per page</label></div>
    </div>
</div>