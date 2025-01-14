<?php

/**
 * Template Name: Create order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
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
                                    <p class="copy modal-button pt-8 fw-bold" data-target="#modal-copy" title="Copy: 0909739506">0909739506</p>
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
                                                    <button class="btn-add-customer">
                                                        <span class="d-f ai-center"><i class="fas mr-4"><img src="<?php site_the_assets(); ?>img/icon-hover/plus-svgrepo-com_white.svg" alt=""></i>Thêm
                                                            khách hàng mới với SĐT này</span>
                                                    </button>
                                                </div>
                                                <div class="results">
                                                    <p class="name">Linh (Nu Kenny)</p>
                                                    <p class="color-black fs-14 fw-regular phone pt-8 pb-8">0123456789</p>
                                                    <p class="color-black fs-14 fw-regular address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                                    <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
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
                                                    <a href="#modal-add-address" class="btn-add-address d-f ai-center pb-16 pt-8 pl-8">
                                                        <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                                                    </a>
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
                                                <div class="history-item using">
                                                    <div class="d-f jc-b ai-center history-header">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Đang dùng</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </div>
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
                                                                <span class="txt txt-green fw-bold ">400.000</span>
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
                                                </div>
                                                <div class="history-item">
                                                    <div class="d-f jc-b ai-center history-header">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Hoàn tất</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </div>
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
                                                                <span class="txt txt-green fw-bold ">400.000</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="history-item">
                                                    <div class="d-f jc-b ai-center history-header collapsed">
                                                        <div class="d-f ai-center history-id gap-8">
                                                            <span class="fas fa-dropdown"></span>
                                                            <span class="number">123456</span>
                                                        </div>
                                                        <div class="d-f history-status gap-16">
                                                            <span class="status_order">Hoàn tất</span>
                                                            <span class="copy"></span>
                                                        </div>
                                                    </div>
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
                                                                <span class="txt txt-green fw-bold ">400.000</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="product">
                                    <div class="card">
                                        <div class="tab-products">
                                            <div class="tab-add-product" id="tabNav">
                                                <a href="#tab-1" class="btn btn-add_order tab-button active" data-tab="tab-1">Sản phẩm 1 <span class="remove-tab"></span></a>
                                                <button class="add-tab" id="addTabButton"></button>
                                            </div>

                                            <!-- Tab Content Areas -->
                                            <div id="tabContents">
                                                <div class="tab-content-wrapper active" id="tab-1">
                                                    <div class="tab-content js-input-field">
                                                        <div class="row24">
                                                            <div class="col-5">
                                                                <div class="label mb-4">Phân loại:</div>
                                                                <select id="classify" name="classify" class="classify-select form-control text-capitalize">
                                                                    <option value="" selected="">D/W/M</option>
                                                                    <option value="D">D</option>
                                                                    <option value="W">W</option>
                                                                    <option value="M">M</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="label mb-4">Số ngày ăn:</div>
                                                                <input type="text" name="number" placeholder="-" class="form-control number">
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="label mb-4">Ngày bắt đầu:</div>
                                                                <div class="calendar">
                                                                    <input type="text" value="" name="calendar" placeholder="DD/MM/YYYY" class="form-control start-day js-calendar">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="list-product">
                                                            <div class="product-item">
                                                                <div class="d-f gap-24 item-head">
                                                                    <div class="col-5 label">Tên sản phẩm</div>
                                                                    <div class="col-3 label text-right">Số lượng</div>
                                                                    <div class="col-4 label text-right">Thành tiền</div>
                                                                </div>
                                                                <div class="pt-16 item-body">
                                                                    <div class="d-f gap-24">
                                                                        <div class="col-5"><input type="text" name="name" placeholder="Nhập tên/mã sản phẩm" class="form-control name"></div>
                                                                        <div class="col-3"><input type="text" name="number" placeholder="-" class="form-control text-right number"></div>
                                                                        <div class="col-4 text-right">
                                                                            <p class="fs-16 fw-bold price pt-8 pb-8">325.000</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-f gap-12 ai-center">
                                                                        <label class="auto-fill-checkbox mt-16 mb-16">
                                                                            <input type="checkbox">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                        Tự chọn món
                                                                        <div class="explain-icon">
                                                                            <img width="16" src="<?php site_the_assets(); ?>img/icon/WarningCircle-gray.svg" alt="">
                                                                            <div class="explain-block d-f ai-center gap-8">
                                                                                Chế độ này bật khi được khách hàng cho phép chọn món giúp họ
                                                                                <i class="fas fa-trash close-explain"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="special-request pt-16">
                                                        </div>
                                                        <div class="d-f ai-center pt-20 clone-note">
                                                            <span class="fas fa-plus mr-8"></span>Thêm yêu cầu phần ăn đặc biệt
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane pay-field" id="pay">
                                    <div class="card">
                                        <div class="total-pay d-f jc-b ai-center">
                                            <p>Tổng tiền sản phẩm:</p>
                                            <p class="price-product fw-bold">650.000</p>
                                        </div>
                                        <div class="shipping-fee">
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Số ngày phát sinh phí ship:</p>
                                                <input type="number" name="number" placeholder="-" min="0" class="form-control text-right ship_fee_days">
                                            </div>
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Tổng tiền phí ship:</p>
                                                <input type="number" name="number" placeholder="-" min="0" class="form-control text-right total_ship">
                                            </div>
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Giảm giá:</p>
                                                <input type="number" name="number" placeholder="-" min="0" class="form-control text-right discount">
                                            </div>
                                        </div>
                                        <div class="total-pay d-f jc-b ai-center">
                                            <p>Tổng tiền đơn hàng:</p>
                                            <p class="price-order fw-bold">650.000</p>
                                        </div>
                                        <div class="order-payment">
                                            <div class="payment-item d-f jc-b ai-center">
                                                <p>Phương thức thanh toán:</p>
                                                <div class="d-f jc-b ai-center gap-16">
                                                    <label class="d-f ai-center gap-12">
                                                        <input type="radio" name="payment-method" class="form-control cod" checked="checked">COD
                                                    </label>
                                                    <label class="d-f ai-center gap-12">
                                                        <input type="radio" name="payment-method" class="form-control transfer">Chuyển khoản
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="payment-item d-f jc-b ai-center">
                                                <p>Trạng thái thanh toán:</p>
                                                <div class="status-payment">
                                                    <div class="status-pay"><span class="red">Chưa</span></div>
                                                    <ul class="status-pay-menu">
                                                        <li class="status-pay-item" data-status='no'><span class="red">Chưa</span></>
                                                        <li class="status-pay-item" data-status='pending'><span class="purple">1 phần</span></>
                                                        <li class="status-pay-item" data-status='yes'><span class="white">Rồi</span></>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="paymented d-f jc-b ai-center pt-8">
                                                <p>Đã thanh toán:</p>
                                                <input type="number" name="number" placeholder="-" class="form-control text-right">
                                            </div>
                                            <div class="payment-item d-f jc-b ai-center pt-8">
                                                <p>Cần thanh toán:</p>
                                                <div class="payment-required fw-bold"> 650.000</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane delivery-field" id="delivery">
                                    <div class="card">
                                        <div class="row delivery-item">
                                            <div class="col-4">Đặt lịch:</div>
                                            <div class="col-8">
                                                <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                                                    <input type="checkbox" name="loop" id="loop">
                                                    Lặp lại hàng tuần
                                                </label>
                                                <div class="calendar">
                                                    <input type="text" name="calendar" placeholder="DD/MM/YYYY" class="form-control js-calendar date">
                                                </div>
                                                <div class="repeat-weekly">
                                                    <input type="checkbox" id="monday" hidden name="days" value="monday">
                                                    <label for="monday">Thứ Hai</label>
                                                    <input type="checkbox" id="tuesday" hidden name="days" value="tuesday">
                                                    <label for="tuesday"> Thứ Ba</label>
                                                    <input type="checkbox" id="wednesday" hidden name="days" value="wednesday">
                                                    <label for="wednesday"> Thứ Tư</label>
                                                    <input type="checkbox" id="thursday" hidden name="days" value="thursday">
                                                    <label for="thursday"> Thứ Năm</label>
                                                    <input type="checkbox" id="friday" hidden name="days" value="friday">
                                                    <label for="friday"> Thứ Sáu</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row delivery-item pt-24 ai-center">
                                            <div class="col-4">Địa chỉ giao:</div>
                                            <div class="col-8 address">
                                                <div class="dropdown">
                                                    <input type="text" name="nickname" class="address_delivery is-disabled form-control pb-4" maxlength="50" placeholder="Vui lòng chọn">
                                                    <span class="fs-14 hidden fw-regular note-shipper color-gray pl-8">Note với shipper: <span class="note_shiper"></span></span>
                                                </div>
                                                <div class="dropdown-menu">
                                                    <div class="item">
                                                        <p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                                        <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
                                                    </div>
                                                    <a href="#modal-add-address" class="btn-add-address d-f ai-center pb-16 pt-8 pl-8">
                                                        <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row delivery-item js-note show pt-16 ai-center">
                                            <div class="col-4">Note shipper theo ngày:</div>
                                            <div class="col-8">
                                                <input type="text" name="note_shipper_by_day" class="form-control note_shipper_by_day">
                                            </div>
                                        </div>
                                        <div class="row delivery-item js-note show pt-16 ai-center">
                                            <div class="col-4">Note admin theo ngày:</div>
                                            <div class="col-8">
                                                <input type="text" name="note_admin_by_day" class="form-control note_admin_by_day">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-f ai-center pb-16 pt-24 add-new-note">
                                        <span class="fas fa-plus mr-8"></span> Thêm note giao hàng mới
                                    </div>
                                </div>
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
<div class="modal fade" id="modal-add-address">
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
                                <input type="radio" name="location_active" id="active_126" value="126" checked="checked">
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
            <button type="submit" class="btn btn-primary add-address">Áp dụng</button>
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
                    <div class="d-f ai-center">
                        <i class="fas fa-warning mr-4"></i>
                        <p>Bạn có chắc muốn xoá sản phẩm đang thực hiện trên đơn hàng này không?</p>
                    </div>

                </div>
                <div class="modal-footer d-f jc-end pb-8">
                    <button type="button" class="btn btn-secondary modal-close">Đóng</button>
                    <button type="button" name="remove" class="btn btn-danger modal-close">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php


// endwhile;
get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script type="text/javascript">
    jQuery( function ( $ )
    {
        
    } );
</script>