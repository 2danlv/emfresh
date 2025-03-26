<?php

/**
 * Template Name: Create group
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_customer, $em_group, $em_location;

$_GET = wp_unslash($_GET);

// $group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
// $action_url = add_query_arg(['group_id' => $group_id], get_permalink());

$group_detail = $em_group->get_fields();
$group_detail = $em_group->filter_item($group_detail);

extract($group_detail);

get_header();

// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order create-group">
    <section class="content">
        <div class="container-fluid">
            <div class="card-primary">
                <form method="post" action="">
                    <input type="hidden" name="save_group" value="<?php echo uniqid() ?>" />
                    <div class="row row32">
                        <!-- /.col -->
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="ttl mb-16">
                                        Thông tin trưởng nhóm
                                    </div>
                                    <div class="box-search">
                                        <input class="search-cus mb-16 form-control" id="search" value="" placeholder="Tìm khách hàng bằng tên / SĐT" type="text">
                                        <div class="group-search-results">
                                            <div class="group-search-autocomplete-results autocomplete-results"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8 pb-16">
                                            <input type="text" name="name" required value="" class="fullname form-control" placeholder="Tên khách hàng">
                                        </div>
                                        <div class="col-4 pb-16">
                                            <input type="tel" name="phone" required class="phone form-control" value="" placeholder="SĐT">
                                        </div>
                                        <div class="col-12 pb-16 group-locations">
                                            <input type="hidden" class="location_id" name="location_id">
                                            <input type="text" class="location_field form-control" readonly >
                                            <div class="group-locations-container">
                                                <div class="autocomplete-results"></div>
                                            </div>
                                            <div class="overlay-drop-menu"></div>
                                        </div>
                                        <input type="hidden" class="input-customer_id">
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        <div class="col-4">
                            <!-- About Me Box -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="ttl">
                                        Ghi chú nhóm
                                    </div>
                                    <div class="pt-16">
                                        <textarea name="note" id="" class="form-control note" rows="9"></textarea>
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
                                                <th>Địa chỉ đăng ký</th>
                                                <th class="text-center">TT đơn hàng</th>
                                                <th class="text-center">Túi riêng</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">01</td>
                                                <td>
                                                    Thien Phuong Bui
                                                    <input type="hidden" name="customers[0][id]" value="1" />
                                                </td>
                                                <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                                <td data-number="3" class="text-capitalize wrap-td" style="min-width: 360px;">
                                                    <div class="nowrap ellipsis">Saigon Centrer, 92-94 Nam Kỳ Khởi Nghĩa, Phường Bến Nghé, Quận 1</div>
                                                </td>
                                                <td class="text-center"><span class="status_order status_order-1">Đang dùng</span></td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="customers[0][bag]" value="1" class="mt-4">
                                                </td>
                                                <td class="text-center"><img src="<?php site_the_assets('img/icon/delete-svgrepo-com-red.svg'); ?>" class="openmodal mt-2"  data-target="#modal-delete-member" alt=""></td>
                                            </tr>
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
                                                <th>Địa chỉ đăng ký</th>
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
                                                <td data-number="3" class="text-capitalize wrap-td" style="min-width: 360px;">
                                                    <div class="nowrap ellipsis">Saigon Centrer, 92-94 Nam Kỳ Khởi Nghĩa, Phường Bến Nghé, Quận 1</div>
                                                </td>
                                                <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="mt-4">
                                                </td>
                                                <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2"  data-target="#modal-delete-member" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"></td>
                                                <td>Thien Phuong Bui</td>
                                                <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                                <td data-number="3" class="text-capitalize wrap-td" style="min-width: 360px;">
                                                    <div class="nowrap ellipsis">Saigon Centrer, 92-94 Nam Kỳ Khởi Nghĩa, Phường Bến Nghé, Quận 1</div>
                                                </td>
                                                <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="mt-4">
                                                </td>
                                                <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2"  data-target="#modal-delete-member" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"></td>
                                                <td>Thien Phuong Bui</td>
                                                <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                                                <td data-number="3" class="text-capitalize wrap-td" style="min-width: 360px;">
                                                    <div class="nowrap ellipsis">Saigon Centrer, 92-94 Nam Kỳ Khởi Nghĩa, Phường Bến Nghé, Quận 1</div>
                                                </td>
                                                <td class="text-center"><span class="status_order status_order-2">Hoàn tất</span></td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="mt-4">
                                                </td>
                                                <td class="text-center"><img src="<?php site_the_assets(); ?>/img/icon/delete-svgrepo-com-red.svg" class="openmodal mt-2"  data-target="#modal-delete-member" alt=""></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.card -->
            </div>
            <!-- /.col -->
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
                                <div class="col-12 pb-16 group-locations">
                                    <input type="hidden" class="location_id" name="location_id">
                                    <input type="text" class="location_field form-control" readonly >
                                    <div class="group-locations-container">
                                        <div class="autocomplete-results"></div>
                                    </div>
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
    <span class="btn btn-primary">Tạo nhóm mới</span>
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