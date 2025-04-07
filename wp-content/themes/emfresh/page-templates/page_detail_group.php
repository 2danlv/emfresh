<?php

/**
 * Template Name: Page Detail group
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_customer_group, $em_group, $em_location, $em_log, $em_order;

$_GET = wp_unslash($_GET);

$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
$action_url = add_query_arg(['group_id' => $group_id], get_permalink());
$delete_url = add_query_arg([
    'delete_group' => $group_id, 
    'delnonce' => wp_create_nonce('delnonce')], 
    '../'
    );

$group_detail = $em_group->get_fields();
$group_order_status = "0";

$list = [];
$leader = [];
$locations = [];

$today = current_time('Y-m-d');

if ($group_id > 0) {
    $response = em_api_request('group/item', ['id' => $group_id]);
    
    if ($response['code'] == 200) {
        $group_detail = $response['data'];

        $list = $em_customer_group->get_items([
            'group_id' => $group_id,
            'orderby' => 'id ASC',
        ]);

        if(count($list) > 0) {
            $leader = $list[0];

            foreach($list as $i => $item) {
                $args = [
                    'customer_id' => $item['customer_id'],
                    'check_date_start' => $today,
                    'check_date_stop' => $today
                ];

                $item['order_status'] = $em_order->count($args) > 0 ? "1" : "0";
                $item['order_status_name'] = $em_order->get_statuses($item['order_status']);

                if($item['order_status'] > 0) {
                    $group_order_status = 1;
                }

                $list[$i] = $item;
            }

            $locations = $em_location->get_items(['customer_id' => $leader['customer_id']]);
        }
    }
} else {
    wp_redirect(site_group_list_link());
    exit();
}

extract($group_detail);

$list_logs = $em_log->get_items([
    'module' => 'em_group',
    'module_id' => $group_id,
]);

// Tu dong xoa sau 7 ngay
$time_to_delete = strtotime('-7 days');

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order create-group  pt-16">
    <style>
        .content-header {
            display: none;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 backtolist d-f ai-center">
                    <a href="../" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại danh sách nhóm</span></a>
                </div>
            </div>
            <div class="card-header">
                <ul class="nav tab-nav tab-nav-detail tabNavigation pt-16">
                    <li class="nav-item defaulttab" rel="info">Thông tin nhóm</li>
                    <li class="nav-item" rel="activity-history">Lịch sử thao tác</li>
                </ul>
            </div>
            <div class="card-primary">
                <form method="post" action="">
                <input type="hidden" name="save_group" value="<?php echo uniqid() ?>" />
                <input type="hidden" name="group_id" value="<?php echo $group_id ?>" />
                <h1 class="pt-8 pb-16 d-f jc-b ai-center">Nhóm <?php echo $name ?><a data-target="#modal-delete-member" data_href="<?php echo $delete_url ?>" class="btn btn-danger btn-remove_group openmodal" >Xóa nhóm</a></h1>
                
                <div class="row row32 tab-pane" id="info">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="ttl mb-16 d-f jc-b ai-center">
                                    <span>Thông tin trưởng nhóm</span>
                                </div>
                                <div class="row jc-b">
                                    <div class="col-3 pb-16">
                                        Trạng thái nhóm: 
                                    </div>
                                    <div class="col-9 pb-16 text-right">
                                        <span class="status_order status_order-<?php echo $group_order_status ?>"><?php echo $em_order->get_statuses($group_order_status) ?></span>
                                    </div>
                                    <div class="col-3 pb-16">
                                        Tên trưởng nhóm:
                                    </div>
                                    <div class="col-9 pb-16 text-right">
                                        <span><?php echo $name ?></span>
                                        <input type="text" name="name" value="<?php echo $name ?>" class="d-none fullname form-control" placeholder="Tên khách hàng">
                                    </div>
                                    <div class="col-3 pb-16">
                                        SĐT trưởng nhóm:
                                    </div>
                                    <div class="col-9 pb-16 text-right">
                                        <span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $phone ?>"><?php echo $phone ?></span>
                                        <input type="text" name="phone" class="d-none phone form-control" value="<?php echo $phone ?>" placeholder="SĐT">
                                    </div>
                                    <div class="col-3 pb-16">
                                        Địa chỉ nhóm:
                                    </div>
                                    <div class="col-9 pb-16 group-locations">
                                        <input type="hidden" class="location_id"  name="location_id" value="<?php echo $location_id ?>">
                                        <div class="text-right">
                                            <span><?php echo $location_name ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    <div class="col-4">
                        <!-- About Me Box -->
                        <div class="card">
                            <div class="card-body">
                                <div class="ttl d-f jc-b">
                                    Ghi chú nhóm
                                    <span class="edit-group  d-f ai-center"><i class="fas fa-edit-2"></i>Chỉnh sửa</span>
                                </div>
                                <div class="pt-16">
                                    <textarea name="note" id="" class="form-control" rows="9"><?php echo $note ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary d-none">Save</button>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="col-12 pt-32">
                        <div class="card">
                            <div class="card-body">
                                <div class="ttl mb-16">
                                    Danh sách thành viên
                                </div>
                                <table class="table table-member text-left">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="80">Thứ tự</th>
                                            <th>Tên khách hàng</th>
                                            <th>SĐT</th>
                                            <th class="text-center">TT đơn hàng</th>
                                            <th class="text-center">Túi riêng</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php foreach($list as $i => $item) : ?>
                                        <tr data-member="<?php echo $item['id'] ?>" data-customer_id="<?php echo $item['customer_id'] ?>">
                                            <td class="text-center" width="80">
                                                <input type="number" name="customers[<?php echo $i ?>][order]" class="input-order text-center" value="<?php echo $i + 1 ?>" <?php echo $i == 0 ? 'readonly' : 'min="2"' ?> />
                                            </td>
                                            <td>
                                                <div class="nameMember"><?php echo $item['customer_name'] ?></div>
                                                <input type="hidden" name="customers[<?php echo $i ?>][id]" value="<?php echo $item['customer_id'] ?>" />
                                            </td>
                                            <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $item['phone'] ?>"><?php echo $item['phone'] ?></span></td>
                                            <td class="text-center"><span class="status_order status_order-<?php echo $item['order_status'] ?>"><?php echo $item['order_status_name'] ?></span></td>
                                            <td class="text-center">
                                                <input type="checkbox" name="customers[<?php echo $i?>][bag]" value="1" class="mt-4" 
                                                    <?php echo !empty($item['bag']) ? "checked" : '' ?> />
                                            </td>
                                            <td class="text-center">
                                                <?php if($i > 0) : ?>
                                                <img src="<?php site_the_assets('img/icon/delete-svgrepo-com-red.svg'); ?>" class="openmodal remove-member mt-2" data-target="#modal-delete-member" alt="">
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <div class="d-f ai-center pb-54 pt-16 add-new-member openmodal" data-target="#modal-addnew_member">
                                    <span class="fas fa-plus mr-8"></span> Thêm thành viên
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="activity-history">
                    <div class="card history-action">
                        <table class="regular_pay">
                            <thead>
                                <tr>
                                    <th class="nowrap">Người thực hiện</th>
                                    <th class="nowrap">Hành động</th>
                                    <th>Mô tả</th>
                                    <th class="nowrap">Thời gian</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($list_logs as $item) :
                                        $item_time = strtotime($item['created']);

                                        if($item_time < $time_to_delete) {
                                            $em_log->delete($item['id']);

                                            continue;
                                        }
                                ?>
                                <tr data-id="<?php echo $item['id'] ?>">
                                    <td class="wrap-td" style="max-width: 160px;">
                                        <div class="nowrap ellipsis">
                                            <img class="avatar" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                                            <?php echo $item['created_author'] ?>
                                        </div>
                                    </td>
                                    <td><?php echo $item['action'] ?></td>
                                    <td class="wrap-td">
                                        <div class="descript-note nowrap">
                                            <?php $brString = nl2br($item['content']); ?>
                                            <?php echo str_replace('<br />', '<hr>', $brString) ?>
                                        </div>
                                    </td>
                                    <td><?php echo date('H:i', $item_time) ?></td>
                                    <td><?php echo date('d/m/Y', $item_time) ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
            </div>
            <!-- /.row -->
    </section>
        <?php include(get_template_directory() . '/parts/meal-plan/modal.php'); ?>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <span class="btn btn-secondary js-btn-prev btn-reload">Hủy</span>
    <span class="btn btn-primary">Lưu</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->

<?php

get_footer('customer');
include(get_template_directory() . '/parts/meal-plan/group-detail.php');
?>