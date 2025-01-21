<?php

/**
 * Template Name: Create order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_product, $em_ship_fee, $em_order, $em_order_item, $site_scripts, $site_script_settings;

$list_ship_fees = $em_ship_fee->get_items(['orderby' => 'id ASC']);
$list_products  = $em_product->get_items(['orderby' => 'id ASC']);
$list_notes = em_admin_get_setting('em_notes');
$list_types = ['d', 'w', 'm'];
$list_locations = [];

$orderDetailSettings = [
	'em_api_url' 	=> home_url('em-api/customer/list/'),
	'em_ship_fees' 	=> $list_ship_fees,
	'em_products' 	=> $list_products,
	'em_notes' 		=> $list_notes,
];

$_GET = wp_unslash($_GET);

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$action_url = add_query_arg(['order_id' => $order_id], get_permalink());

$order_detail = $em_order->get_fields();
$list_payment_statuses = $em_order->get_payment_statuses();
$list_payment_methods = $em_order->get_payment_methods();

$order_item_default = $em_order_item->get_fields();
$order_item_default['id'] = 0;
$order_items = [$order_item_default];

if($order_id > 0) {
    $response = em_api_request('order/item', ['id' => $order_id]);

    if($response['code'] == 200) {
        $order_detail = $response['data'];

        $response = em_api_request('order_item/list', ['order_id' => $order_id, 'orderby' => 'id ASC']);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $order_items = $response['data'];
        }

        $response = em_api_request('location/list', ['customer_id' => $order_detail['customer_id']]);
        if($response['code'] == 200 && count($response['data']) > 0) {
            $list_locations = $response['data'];
        }
    }
}

$order_item_total = count($order_items);

extract($order_detail);
get_header();
// Start the Loop.
// while ( have_posts() ) : the_post(); 
?>
<div class="detail-customer order">
    <section class="content">
        <div class="container-fluid">
            <div class="card-primary">
                <div class="row row32">
                    <div class="col-4">
                        <!-- About Me Box -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="ttl">
                                    Thông tin đơn hàng
                                </div>
                                <div class="info-customer line-dots">
                                    <p class="pt-16">Linh (Nu Kenny)</p>
                                    <p class="copy modal-button pt-8" data-target="#modal-copy" title="Copy: 0909739506">0909739506</p>
                                    <p class="pt-8 pb-16 text-ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 07, Quận Bình Thạnh</p>
                                </div>
                                <div class="order-details">
                                    <div class="info-order line-dots">
                                        <div class="d-f jc-b pt-8">
                                            <span class="tlt fw-bold ">Phân loại đơn hàng:</span>
                                            <span>W</span>
                                        </div>
                                        <div class="d-f jc-b pt-8">
                                            <span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
                                            <span>04/11/2024</span>
                                        </div>
                                        <div class="tlt fw-bold  pt-8">Thông tin sản phẩm:</div>
                                        <div class="info-product pt-8">
                                            <div class="d-f jc-b">
                                                <div class="d-f"><span class="name">Slimfit M</span>&nbsp;x&nbsp;<span class="quantity">5</span></div>
                                                <div class="price">325.000</div>
                                            </div>
                                            <div class="note-box pb-20">
                                                <p><span class="note">Note rau củ</span>:&nbsp;<span class="value">cà rốt, bí đỏ, củ dền, bí ngòi</span></p>
                                                <p><span class="note">Note tinh bột</span>:&nbsp;<span class="value">thay bún sang cơm trắng, thay miến sang cơm trắng, 1/2 tinh bột</span></p>
                                                <p><span class="note">Note khác</span>:&nbsp;<span class="value">ko rau lá, chỉ củ, 2 sốt</span></p>
                                                <p><span class="note">Note đính kèm</span>:&nbsp;<span class="value">thêm 1 tương ớt, thêm 1 ớt, túi riêng</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-pay">
                                        <div class="d-f jc-b pt-18">
                                            <span class="tlt fw-bold ">Tổng tiền phí ship:</span>
                                            <span class="ship">-</span>
                                        </div>
                                        <div class="d-f jc-b pt-8">
                                            <span class="tlt fw-bold ">Giảm giá:</span>
                                            <span class="discount">-</span>
                                        </div>
                                        <div class="d-f jc-b pt-8 pb-8">
                                            <span class="tlt fw-bold ">Tổng tiền đơn hàng:</span>
                                            <span class="total total-price">325.000</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-8">
                        <div class="card-body">
                            <ul class="nav tab-order tab-nav tabNavigation pt-20">
                                <li class="nav-item defaulttab" rel="customer">Khách hàng</li>
                                <li class="nav-item" rel="product">Sản phẩm</li>
                                <li class="nav-item" rel="pay">Thanh toán</li>
                                <li class="nav-item" rel="delivery">Giao hàng</li>
                            </ul>
                            <div class="overlay-drop-menu"></div>
                            <div class="tab-content">
                                <div class="tab-pane" id="customer">
                                    <div class="card rounded-b-r">
                                        <div class="box-search">
                                            <input class="search-cus mb-16" placeholder="Tìm khách hàng bằng tên / SĐT" type="text">
                                            <div class="search-result">
                                                <div class="no-results active">
                                                    <img class="pt-18 pb-8" src="<?php site_the_assets(); ?>/img/icon/no-results.svg" alt="">
                                                    <p class="color-gray fs-12 fw-regular pb-8">Không tìm thấy SĐT phù hợp</p>
                                                    <p class="color-gray fs-12 fw-regular pb-16">Hãy thử thay đổi từ khoá tìm kiếm hoặc thêm khách hàng mới với SĐT này</p>
                                                    <a href="/customer/add-customer/" class="btn-add-customer">
                                                        <span class="d-f ai-center"><i class="fas mr-4"><img src="<?php site_the_assets(); ?>img/icon-hover/plus-svgrepo-com_white.svg" alt=""></i>Thêm
                                                            khách hàng mới với SĐT này</span>
                                                            </a>
                                                </div>
                                                <div class="results">
                                                    <div class="result-item">
                                                        <p class="name">Linh (Nu Kenny)</p>
                                                        <p class="color-black fs-14 fw-regular phone pt-8 pb-8">0123456789</p>
                                                        <p class="color-black fs-14 fw-regular address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                                        <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row input-order">
                                            <div class="col-8 pb-16">
                                                <input type="text" name="nickname" class="fullname is-disabled form-control" maxlength="50" placeholder="Tên khách hàng">
                                            </div>
                                            <div class="col-4 pb-16">
                                                <input type="text" name="fullname" class="phone is-disabled form-control" maxlength="50" placeholder="SĐT">
                                            </div>
                                            <div class="col-12 pb-32 dropdown-address">
                                                <div class="dropdown active">
                                                    <input type="text" name="nickname" class="address_delivery is-disabled form-control" maxlength="50" placeholder="Địa chỉ giao hàng">
                                                </div>
                                                <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
                                                
                                                <div class="dropdown-menu">
                                                    <div class="item active">
                                                        <p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                                        <div class="group-management-link d-f jc-b ai-center pt-8">
                                                            <div class="tooltip d-f ai-center">
                                                                <p class="fs-14 fw-regular color-gray">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                                                                <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
                                                                <span class="fas tooltip-icon fa-info-gray"></span>
                                                                <div class="tooltip-content">
                                                                    <div class="close fas fa-trash"></div>
                                                                    <ul>
                                                                        <li>Thien Phuong Bui</li>
                                                                        <li>Dieu Linh (zalo)</li>
                                                                        <li>Nguyen Hai Minh Thi</li>
                                                                        <li>Dinh Thi Hien Ly</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <a class="management-link" href="#">Đi đến Quản lý nhóm</a>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <p class="fs-16 color-black other-address">45 Hoa Lan, Phường 3, Quận Phú Nhuận</p>
                                                    </div>
                                                    <div data-target="#modal-add-address-1" class="btn-add-address modal-button d-f ai-center pb-16 pt-8 pl-8">
                                                        <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="card-title title-order d-f ai-center">
                                            <span class="fas fa-clock mr-8"></span>
                                            Đơn hàng gần đây
                                        </h3>
                                        <div class="history-order">
                                            <div class="no-history show">
                                                <img src="<?php site_the_assets(); ?>/img/icon/cart.svg" alt="">
                                                <div class="pt-8 color-gray fs-12 fw-regular">Chưa có lịch sử mua hàng</div>
                                            </div>
                                            <div class="history">
                                                <details class="history-item using">
                                                    <summary class="d-f jc-b ai-center history-header">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Đang dùng</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </summary>
                                                    <div class="history-content">
                                                        <div class="info">
                                                            <div class="d-f ai-center gap-10 address">
                                                                <span class="fas fa-location"></span>
                                                                <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                                                            </div>
                                                            <p class="color-gray-2 fs-14 fw-regular pl-26 pt-8">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                                                            <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt">2EM+1PM+1EP</span>
                                                            </div>
                                                            <div class="d-f ai-center gap-10 pt-8">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt-green fw-bold ">400.000</span>
                                                            </div>
                                                        </div>
                                                        <div class="note">
                                                            <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                                                                <div class="d-f ai-center gap-10">
                                                                    <span class="fas fa-note"></span>
                                                                    <span class="txt">Yêu cầu đặc biệt:</span>
                                                                </div>
                                                                <span class="txt">Note rau củ: cà rốt, bí đỏ, củ dền, bí ngòi</span>
                                                            </div>
                                                            <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                                                                <div class="d-f ai-center gap-10">
                                                                    <span class="fas fa-note"></span>
                                                                    <span class="txt">Giao hàng:</span>
                                                                </div>
                                                                <span class="txt">Thứ 3 - Thứ 5: 45 Hoa Lan, Phường 3, Quận Phú Nhuận</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </details>
                                                <details class="history-item">
                                                    <summary class="d-f jc-b ai-center history-header">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Hoàn tất</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </summary>
                                                    <div class="history-content">
                                                        <div class="info">
                                                            <div class="d-f ai-center gap-10 address">
                                                                <span class="fas fa-location"></span>
                                                                <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                                                            </div>
                                                            <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt">2EM+1PM+1EP</span>
                                                            </div>
                                                            <div class="d-f ai-center gap-10 pt-8">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt-green fw-bold ">400.000</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </details>
                                                <details class="history-item">
                                                    <summary class="d-f jc-b ai-center history-header collapsed">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Hoàn tất</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </summary>
                                                    <div class="history-content">
                                                        <div class="info">
                                                            <div class="d-f ai-center gap-10 address">
                                                                <span class="fas fa-location"></span>
                                                                <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                                                            </div>
                                                            <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt">2EM+1PM+1EP</span>
                                                            </div>
                                                            <div class="d-f ai-center gap-10 pt-8">
                                                                <span class="fas fa-shopping-cart"></span>
                                                                <span class="txt-green fw-bold ">400.000</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </details>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action="<?php echo $action_url ?>">
    
                                <input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
                                <input type="hidden" class="order_item_total" value="<?php echo $order_item_total ?>" />
                                <input type="hidden" name="customer_id" class="input-customer_id" value="<?php echo $order_detail['customer_id'] ?>" />
                                <input type="hidden" name="item_name" class="input-item_name" value="<?php echo $order_detail['item_name'] ?>" />
                                <input type="hidden" name="location_name" class="input-location_name" value="<?php echo $order_detail['location_name'] ?>" />
                                <input type="hidden" name="order_note" class="input-order_note" value="<?php echo $order_detail['note'] ?>" />
                                <input type="hidden" name="order_type" class="input-order_type" value="<?php echo $order_detail['order_type'] ?>" />

                                <div class="tab-pane" id="product">
                                    <?php include(get_template_directory() . '/parts/order/edit-detail-create.php'); ?>
                                </div>
                                <div class="tab-pane pay-field" id="pay">
                                    <?php include(get_template_directory() . '/parts/order/edit-detail-pay.php'); ?>
                                </div>
                                <div class="tab-pane delivery-field" id="delivery">
                                    <?php include(get_template_directory() . '/parts/order/edit-detail-ship.php'); ?>
                                </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <div class="toast warning">
        <i class="fas fa-warning"></i>
        Khách hàng vẫn còn đơn đang dùng tại thời điểm<span>04/11/2024</span>
        <i class="fas fa-trash close-toast"></i>
    </div>
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <span class="btn btn-secondary js-btn-prev btn-disable">Quay lại</span>
    <span class="btn btn-primary js-next-tab btn-next">Tiếp theo</span>
    <span class="btn btn-primary js-create-order btn-next hidden">Tạo đơn</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<div class="modal fade modal-add-address" id="modal-add-address-1">
    <div class="overlay"></div>
    <div class="modal-content customer">
        <div class="d-f ai-center gap-10 tlt">
            <span class="fas fa-location"></span>
            <span>Địa chỉ</span>
        </div>
        <form method="post" id="customer-form" action="">
            <div class="row address-group location_0 address_active pt-16">
                <div class="city col-4 pb-16">
                    <select id="province_126" name="locations[0][province]" class="province-select form-control" disabled="">
                        <option value="">Select Tỉnh/Thành phố</option>
                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="district_126" name="" class="district-select form-control text-capitalize">
                        <option value="Quận Bình Thạnh" selected="">Quận Bình Thạnh</option>
                        <option value="Quận 1">Quận 1</option>
                        <option value="Quận 3">Quận 3</option>
                        <option value="Quận 4">Quận 4</option>
                        <option value="Quận 5">Quận 5</option>
                        <option value="Quận 6">Quận 6</option>
                        <option value="Quận 7">Quận 7</option>
                        <option value="Quận 8">Quận 8</option>
                        <option value="Quận 10">Quận 10</option>
                        <option value="Quận 11">Quận 11</option>
                        <option value="Quận 12">Quận 12</option>
                        <option value="Quận Bình Tân">Quận Bình Tân</option>
                        <option value="Quận Bình Thạnh">Quận Bình Thạnh</option>
                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                        <option value="Quận Phú Nhuận">Quận Phú Nhuận</option>
                        <option value="Quận Tân Bình">Quận Tân Bình</option>
                        <option value="Quận Tân Phú">Quận Tân Phú</option>
                        <option value="Thành phố Thủ Đức">Thành phố Thủ Đức</option>
                        <option value="Huyện Bình Chánh">Huyện Bình Chánh</option>
                        <option value="Huyện Cần Giờ">Huyện Cần Giờ</option>
                        <option value="Huyện Củ Chi">Huyện Củ Chi</option>
                        <option value="Huyện Hóc Môn">Huyện Hóc Môn</option>
                        <option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="ward_126" name="locations[0][ward]" class="ward-select form-control" disabled>
                        <option selected="">Phường/Xã*</option>
                    </select>
                </div>
                <div class="col-12 pb-16">
                    <input id="address_126" type="text" class="form-control address" placeholder="Địa chỉ cụ thể*" name="locations[0][address]">
                </div>
                <div class="group-note col-12">
                    <div class="note_shiper hidden pb-16">
                        <input type="text" name="locations[0][note_shipper]" value="" placeholder="Note với shipper">
                    </div>
                    <div class="note_admin hidden pb-16">
                        <input type="text" name="locations[0][note_admin]" value="" placeholder="Note với admin">
                    </div>
                </div>
                <div class="show-group-note d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
                </div>
                <div class="col-12 pb-16">
                    <hr>
                    <div class="row pt-16">
                        <div class="col-6">
                            <div class="icheck-primary d-f ai-center">
                                <input type="radio" name="location_active" id="active_126" value="126">
                                <input type="hidden" class="location_active" name="locations[0][active]" value="1">
                                <label class="pl-4" for="active_126">
                                    Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-footer d-f jc-e pb-8 pt-16">
            <button type="button" class="btn btn-secondary modal-close">Huỷ</button>
            <button type="submit" class="btn btn-primary add-address modal-close">Áp dụng</button>
        </div>
    </div>
</div>
<div class="modal fade modal-add-address" id="modal-add-address-2">
    <div class="overlay"></div>
    <div class="modal-content customer">
        <div class="d-f ai-center gap-10 tlt">
            <span class="fas fa-location"></span>
            <span>Địa chỉ</span>
        </div>
        <form method="post" id="customer-form" action="">
            <div class="row address-group location_0 address_active pt-16">
                <div class="city col-4 pb-16">
                    <select id="province_126" name="locations[0][province]" class="province-select form-control" disabled="">
                        <option value="">Select Tỉnh/Thành phố</option>
                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="district_126" name="" class="district-select form-control text-capitalize">
                        <option value="Quận Bình Thạnh" selected="">Quận Bình Thạnh</option>
                        <option value="Quận 1">Quận 1</option>
                        <option value="Quận 3">Quận 3</option>
                        <option value="Quận 4">Quận 4</option>
                        <option value="Quận 5">Quận 5</option>
                        <option value="Quận 6">Quận 6</option>
                        <option value="Quận 7">Quận 7</option>
                        <option value="Quận 8">Quận 8</option>
                        <option value="Quận 10">Quận 10</option>
                        <option value="Quận 11">Quận 11</option>
                        <option value="Quận 12">Quận 12</option>
                        <option value="Quận Bình Tân">Quận Bình Tân</option>
                        <option value="Quận Bình Thạnh">Quận Bình Thạnh</option>
                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                        <option value="Quận Phú Nhuận">Quận Phú Nhuận</option>
                        <option value="Quận Tân Bình">Quận Tân Bình</option>
                        <option value="Quận Tân Phú">Quận Tân Phú</option>
                        <option value="Thành phố Thủ Đức">Thành phố Thủ Đức</option>
                        <option value="Huyện Bình Chánh">Huyện Bình Chánh</option>
                        <option value="Huyện Cần Giờ">Huyện Cần Giờ</option>
                        <option value="Huyện Củ Chi">Huyện Củ Chi</option>
                        <option value="Huyện Hóc Môn">Huyện Hóc Môn</option>
                        <option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="ward_126" name="locations[0][ward]" class="ward-select form-control" disabled>
                        <option selected="">Phường/Xã*</option>
                    </select>
                </div>
                <div class="col-12 pb-16">
                    <input id="address_126" type="text" class="form-control address" placeholder="Địa chỉ cụ thể*" name="locations[0][address]">
                </div>
                <div class="group-note col-12">
                    <div class="note_shiper hidden pb-16">
                        <input type="text" name="locations[0][note_shipper]" value="" placeholder="Note với shipper">
                    </div>
                    <div class="note_admin hidden pb-16">
                        <input type="text" name="locations[0][note_admin]" value="" placeholder="Note với admin">
                    </div>
                </div>
                <div class="show-group-note d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
                </div>
                <div class="col-12 pb-16">
                    <hr>
                    <div class="row pt-16">
                        <div class="col-6">
                            <div class="icheck-primary d-f ai-center">
                                <input type="radio" name="location_active" id="active_126" value="126">
                                <input type="hidden" class="location_active" name="locations[0][active]" value="1">
                                <label class="pl-4" for="active_126">
                                    Lưu vào danh sách địa chỉ
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-footer d-f jc-e pb-8 pt-16">
            <button type="button" class="btn btn-secondary modal-close">Huỷ</button>
            <button type="submit" class="btn btn-primary add-address modal-close">Áp dụng</button>
        </div>
    </div>
</div>
<div class="modal fade modal-warning" id="modal-remove-tab">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="list-customer" action="">
                <div class="modal-body pt-8 pb-16">
                    <input type="hidden" class="customer_id" name="customer_id" value="">
                    <div class="d-f">
                        <i class="fas fa-warning mr-4"></i>
                        <p>Bạn có chắc muốn xoá sản phẩm đang thực hiện trên đơn hàng này không?</p>
                    </div>

                </div>
                <div class="modal-footer d-f jc-b pb-8">
                    <button type="button" class="btn btn-secondary modal-close">Đóng</button>
                    <button type="button" name="remove" class="btn btn-danger modal-close">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script id="note_template" type="text/template">
<div class="row row-note mb-16">
	<div class="col-4">
		<select class="form-control input-note_name">
			<?php
				foreach ($list_notes as $name => $note_item) {
					printf('<option value="%s">%s</option>', $name, $note_item['name']);
				}
			?>
			<option value="khac" selected>Khác</option>
		</select>
	</div>
	<div class="col-8 col-note_values tag-container">
		<input type="text" class="form-control input-note_values" />
	</div>
</div>
</script>
<?php


// endwhile;
get_footer('customer');
?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script src="<?php site_the_assets(); ?>js/order-detail.js"></script>
<script type="text/javascript">$(document).ready(function () {
		initializeTagify('input.input-note_values');
	});
	function initializeTagify(selector) {
            $(selector).each(function () {
                if (!this.tagify) { 
                    var tagifyInstance = new Tagify(this, {
                        whitelist: [
                            "cà rốt",
                            "bí đỏ",
                            "củ dền",
                            "bí ngòi",
                            "thay bún sang cơm trắng",
                            "thay miến sang cơm trắng",
                            "1/2 tinh bột"
                        ],
                        placeholder: "...",
                        dropdown: {
                            enabled: 1, 
                            maxItems: 10, 
                            position: "all" 
                        }
                    });
                   
                }
            });
        }
</script>