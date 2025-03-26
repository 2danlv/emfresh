<?php

/**
 * Template Name: Page Detail group
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_customer_group, $em_group, $em_location;

$_GET = wp_unslash($_GET);

$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
$action_url = add_query_arg(['group_id' => $group_id], get_permalink());

$group_detail = $em_group->get_fields();
$list = [];

if ($group_id > 0) {
    $response = em_api_request('group/item', ['id' => $group_id]);
    
    if ($response['code'] == 200) {
        $group_detail = $response['data'];
        
        $list = $em_customer_group->get_items(['group_id' => $group_id]);
    }
} else {
    wp_redirect(site_group_list_link());
    exit();
}

extract($group_detail);

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
                <h1 class="pt-8 pb-16">Nhóm Thien Phuong Bui</h1>
                <div class="row row32 tab-pane" id="info">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="ttl mb-16 d-f jc-b ai-center">
                                    <span>Thông tin trưởng nhóm</span>
                                    <span class="edit-group  d-f ai-center"><i class="fas fa-edit-2"></i>Chỉnh sửa</span>
                                </div>
                                <div class="row jc-b">
                                    <div class="col-3 pb-16">
                                        Trạng thái nhóm: 
                                    </div>
                                    <div class="col-9 pb-16 text-right">
                                        <span class="status_order status_order-1">Đang dùng</span>
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
                                        <span><?php echo $phone ?></span>
                                        <input type="text" name="phone" class="d-none phone form-control" value="<?php echo $phone ?>" placeholder="SĐT">
                                    </div>
                                    <div class="col-3 pb-16">
                                        Địa chỉ nhóm:
                                    </div>
                                    <div class="col-9 pb-16 group-locations">
                                        <div class="text-right">
                                            <span><?php echo $location_name ?></span>
                                        </div>
                                            <input type="text" class="location_id"  name="location_id" value="<?php echo $location_id ?>">
                                            <div class="group-locations-container">
                                                <div class="autocomplete-results">
                                                    <option value="1" <?php echo $location_id == 1 ? "selected" : '' ?>>Địa chỉ nhóm</option>
                                                </div>
                                            </div>
                                            <div class="overlay-drop-menu"></div>
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
                                            <th class="text-center">Thứ tự</th>
                                            <th>Tên khách hàng</th>
                                            <th>SĐT</th>
                                            <th class="text-center">TT đơn hàng</th>
                                            <th class="text-center">Túi riêng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($list as $i => $item) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1 ?></td>
                                            <td>
                                                <?php echo $item['customer_name'] ?>
                                                <input type="hidden" name="customers[<?php echo $i ?>][id]" value="<?php echo $item['id'] ?>" />
                                            </td>
                                            <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $item['phone'] ?>"><?php echo $item['phone'] ?></span></td>
                                            <td class="text-center"><span class="status_order status_order-1">Đang dùng</span></td>
                                            <td class="text-center">
                                                <input type="checkbox" name="customers[<?php echo $i?>][bag]" value="1" class="mt-4" 
                                                    <?php echo !empty($item['bag']) ? "checked" : '' ?> />
                                            </td>
                                            <td class="text-center"><img src="<?php site_the_assets('img/icon/delete-svgrepo-com-red.svg'); ?>" class="openmodal mt-2" data-target="#modal-delete-member" alt=""></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <div class="d-f ai-center pb-54 pt-16 add-new-member openmodal" data-target="#modal-addnew_member">
                                    <span class="fas fa-plus mr-8"></span> Thêm thành viên
                                </div>
                                <!-- <table class="table table-member text-left">
                                    <thead class="visible-collapse">
                                        <tr>
                                            <th class="text-center">Thứ tự</th>
                                            <th>Tên khách hàng</th>
                                            <th>SĐT</th>
                                            <th class="text-center">TT đơn hàng</th>
                                            <th class="text-center">Túi riêng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>Thien Phuong Bui</td>
                                            <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                            <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                            <td class="text-center">
                                                <input type="checkbox" class="mt-4">
                                            </td>
                                            <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2" data-target="#modal-delete-member" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>Thien Phuong Bui</td>
                                            <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                            <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                            <td class="text-center">
                                                <input type="checkbox" class="mt-4">
                                            </td>
                                            <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2" data-target="#modal-delete-member" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>Thien Phuong Bui</td>
                                            <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                            <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                            <td class="text-center">
                                                <input type="checkbox" class="mt-4">
                                            </td>
                                            <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2" data-target="#modal-delete-member" alt=""></td>
                                        </tr>

                                    </tbody>
                                </table> -->
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
                                    <th>Trường</th>
                                    <th>Mô tả</th>
                                    <th class="nowrap">Thời gian</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="wrap-td" style="max-width: 160px;">
                                        <div class="nowrap ellipsis"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="">
                                            Nhu Quynh
                                        </div>
                                    </td>
                                    <td>cập nhật</td>
                                    <td style="min-width: 140px;">địa chỉ nhóm</td>
                                    <td class="wrap-td" style="max-width: 300px;">
                                        <div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div>
                                    </td>
                                    <td>01:00</td>
                                    <td>29/10/24</td>
                                </tr>
                                <tr>
                                    <td class="wrap-td" style="max-width: 160px;">
                                        <div class="nowrap ellipsis"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="">
                                            Nhu Quynh
                                        </div>
                                    </td>
                                    <td>cập nhật</td>
                                    <td style="min-width: 140px;">địa chỉ nhóm</td>
                                    <td class="wrap-td" style="max-width: 300px;">
                                        <div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div>
                                    </td>
                                    <td>01:00</td>
                                    <td>29/10/24</td>
                                </tr>
                                <tr>
                                    <td class="wrap-td" style="max-width: 160px;">
                                        <div class="nowrap ellipsis"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="">
                                            Nhu Quynh
                                        </div>
                                    </td>
                                    <td>cập nhật</td>
                                    <td style="min-width: 140px;">địa chỉ nhóm</td>
                                    <td class="wrap-td" style="max-width: 300px;">
                                        <div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div>
                                    </td>
                                    <td>01:00</td>
                                    <td>29/10/24</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
            </div>
            <!-- /.row -->
    </section>
    <div class="modal fade modal-addnew_member" id="modal-addnew_member">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm thành viên</h4>
            </div>
            <div class="modal-body pt-16 pb-16">
                <div class="card-primary">
                    <div class="card-body">
                        <div class="box-search">
                            <input class="search-cus mb-16 form-control" id="search" value="" placeholder="Tìm khách hàng bằng tên / SĐT" type="text">
                            <div class="group-search-results">
                                <div class="group-search-autocomplete-results autocomplete-results"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 pb-16">
                                <input type="text" name="nickname" value="" class="fullname form-control" placeholder="Tên khách hàng">
                            </div>
                            <div class="col-4 pb-16">
                                <input type="text" name="phone" class="phone form-control" value="" placeholder="SĐT">
                            </div>
                            <div class="col-12">
                                <hr class="dashed pb-16">
                                <p class="mb-4">Thứ tự</p>
                            </div>
                        </div>
                        <div class="row ai-center jc-b">
                            <div class="col-2">
                                <p><input type="text" class="form-control"></p>
                            </div>
                            <div class="col-8 text-right">
                                <div class="d-f ai-center jc-end">
                                    <span class="pt-6 mr-10"><input type="checkbox"></span>
                                    <span>Yêu cầu túi riêng</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer text-right pt-16 pb-8 pr-12">
            <button type="button" class="btn btn-secondary modal-close">Huỷ</button>
            <button type="button" class="btn btn-primary modal-close">Lưu</button>
        </div>
    </div>
</div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <span class="btn btn-secondary js-btn-prev btn-disable">Hủy</span>
    <span class="btn btn-primary">Lưu</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->

<div class="modal fade modal-warning" id="modal-delete-member">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-8 pb-16">
                <div class="d-f">
                    <i class="fas fa-warning mr-8"></i>
                    <p>Bạn có chắc muốn xoá khách hàng Dieu Linh (zalo) ra <br> khỏi nhóm này không?</p>
                </div>
            </div>
            <div class="modal-footer d-f jc-b pb-8 pt-16">
                <button type="button" class="btn btn-secondary modal-close">Đóng</button>
                <button type="submit" name="remove" class="btn btn-danger modal-close">Xóa</button>
            </div>
        </div>
    </div>
</div>

<?php

get_footer('customer');
include(get_template_directory() . '/parts/meal-plan/group-detail.php');
?>