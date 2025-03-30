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
                        <div class="col-12 pt-32 group_list-member d-none">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="first_item_group">
                                                <td class="text-center">1</td>
                                                <td>
                                                    <div class="nameMember">Thien Phuong Bui</div>
                                                    <input type="hidden" name="customers[0][id]" class="input-customer_id" value="1" />
                                                </td>
                                                <td><span class="copy modal-button" data-target="#modal-copy" title="Copy">0123456789</span></td>
                                                <td class="text-center"><span class="status_order status_order-1">Đang dùng</span></td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="customers[0][bag]" value="1" class="mt-4">
                                                </td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-f ai-center pb-54 pt-16 add-new-member openmodal" data-target="#modal-addnew_member">
                                        <span class="fas fa-plus mr-8"></span> Thêm thành viên
                                    </div>
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
    <?php include(get_template_directory() . '/parts/meal-plan/modal.php'); ?>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <a href="../" class="btn btn-secondary">Hủy</a>
    <span class="btn btn-primary">Tạo nhóm mới</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->



<?php

get_footer('customer');
include(get_template_directory() . '/parts/meal-plan/group-detail.php');
?>