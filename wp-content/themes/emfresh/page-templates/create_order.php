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
                            <ul class="nav tab-order tabNavigation pt-20">
                                <li class="nav-item selected" rel="customer">Khách hàng</li>
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
                                                <p class="fs-14 fw-regular color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
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
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="product">
                                    <div class="card">
                                        <div class="tab-products">
                                            <div class="tab-nav" id="tabNav">
                                                <button class="d-f jc-b ai-center gap-8 btn btn-add_order tab-button active" data-tab="tab-1">Sản phẩm 1 <span class="remove-tab"></span></button>
                                                <button class="add-tab" id="addTabButton"></button>
                                            </div>

                                            <!-- Tab Content Areas -->
                                            <div id="tabContents">
                                                <div class="tab-content-wrapper active" id="tab-1">
                                                    <div class="tab-content">
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
                                                                <div class="label mb-4">Số ngày dùng:</div>
                                                                <input type="text" name="number" placeholder="-" class="form-control number">
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="label mb-4">Số ngày dùng:</div>
                                                                <input type="date" name="date" placeholder="DD/MM/YYYY" class="form-control date">
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
                                                                        <label class="auto-fill-checkbox">
                                                                            <input type="checkbox">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                        <span class="fs-16 color-gray">Tự chọn món</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="special-request pt-16">
                                                            <div class="special-item row">
                                                                <div class="col-4">
                                                                    <select id="district_0" name="locations[0][district]" class="district-select form-control">
                                                                        <option value="Note rau củ" selected>Note rau củ</option>
                                                                        <option value="Note tinh bột">Note tinh bột</option>
                                                                        <option value="Note nước sốt">Note nước sốt</option>
                                                                        <option value="Note khác">Note khác</option>
                                                                        <option value="Note đính kèm">Note đính kèm</option>
                                                                        <option value="Phân loại yêu cầu">Note tinh bột</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-8">
                                                                    <div class="tag-container" id="tagContainer">
                                                                        <input type="text" class="form-control tag-input" id="tagInput">
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                <div class="tab-pane" id="pay">
                                    <div class="card">
                                        <div class="total-pay d-f jc-b ai-center">
                                            <p>Tổng tiền sản phẩm:</p>
                                            <p class="price-product fw-bold">650.000</p>
                                        </div>
                                        <div class="shipping-fee">
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Số ngày phát sinh phí ship:</p>
                                                <input type="number" name="number" placeholder="-" class="form-control text-right ship_fee_days">
                                            </div>
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Tổng tiền phí ship:</p>
                                                <input type="number" name="number" placeholder="-" class="form-control text-right total_ship">
                                            </div>
                                            <div class="fee-item d-f jc-b ai-center">
                                                <p>Giảm giá:</p>
                                                <input type="number" name="number" placeholder="-" class="form-control text-right discount">
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
                                <div class="tab-pane" id="delivery">
                                    <div class="card">
                                        <div class="row delivery-item">
                                            <div class="col-4">Đặt lịch:</div>
                                            <div class="col-8">
                                                <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                                                    <input type="checkbox" name="" id="loop">
                                                    Lặp lại hàng tuần
                                                </label>
                                                <input type="date" name="date" placeholder="DD/MM/YYYY" class="form-control date">
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
                                                    <input type="text" name="nickname" class="address_delivery is-disabled form-control" maxlength="50" placeholder="Vui lòng chọn">
                                                </div>
                                                <div class="dropdown-menu">
                                                    <div class="item">
                                                        <p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                                                    </div>
                                                    <a href="#modal-add-address" class="btn-add-address d-f ai-center pb-16 pt-8 pl-8">
                                                        <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row delivery-item note pt-16 ai-center">
                                            <div class="col-4">Note shipper theo ngày:</div>
                                            <div class="col-8">
                                                <input type="text" name="note_shipper_by_day" class="form-control note_shipper_by_day">
                                            </div>
                                        </div>
                                        <div class="row delivery-item note pt-16 ai-center">
                                            <div class="col-4">Note admin theo ngày:</div>
                                            <div class="col-8">
                                                <input type="text" name="note_admin_by_day" class="form-control note_admin_by_day">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-f ai-center pb-16 pt-24">
                                        <span class="fas fa-plus mr-8"></span> Thêm note giao hàng mới
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane customer detail-customer" id="settings">
                                    <div class="alert valid-form alert-warning hidden error mb-16"></div>
                                    <form class="form-horizontal" method="POST" action="http://emfresh.web/customer/detail-customer/?customer_id=139&amp;tab=settings">
                                        <input type="hidden" id="edit_locations_nonce" name="edit_locations_nonce" value="20b59c82a2"><input type="hidden" name="_wp_http_referer"
                                            value="/customer/detail-customer/?customer_id=139">
                                        <div class="row pb-16">
                                            <div class="col-6">
                                                <div class="card-body">
                                                    <div class="card-header">
                                                        <h3 class="card-title d-f ai-center"><span class="fas fa-info mr-4"></span> Thông tin cơ bản</h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 pb-16">
                                                            <input type="text" name="nickname" class="nickname form-control" maxlength="50" value="Van Lee" placeholder="Tên tài khoản*">
                                                        </div>
                                                        <div class="col-6 pb-16">
                                                            <input type="text" name="fullname" class="fullname form-control" maxlength="50" value="Vân" placeholder="Tên thật (nếu có)">
                                                        </div>
                                                        <div class="col-6 pb-16">
                                                            <input type="tel" id="phone" name="phone" class="phone_number form-control" value="0342784124" maxlength="10">
                                                            <p id="phone_status" class="status text-danger"></p>
                                                        </div>
                                                        <div class="col-6 pb-16">
                                                            <select name="gender" class="gender text-titlecase" required="">
                                                                <option value="0" selected="">Giới tính*</option>
                                                                <option value="1" name="gender">
                                                                    Nam </option>
                                                                <option value="2" selected="selected" name="gender">
                                                                    Nữ </option>
                                                                <option value="3" name="gender">
                                                                    - </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 ">
                                                            <div class="review" style="display: block;">
                                                                <p><span class="customer_name">Vân (Van Lee)</span></p>
                                                                <p><span class="customer_phone">0342784124</span></p>
                                                                <div class="info0">
                                                                    <span class="address">44L đường số 11, KDC Miếu
                                                                        Nổi,</span>
                                                                    <span class="ward">Phường 07,</span>
                                                                    <span class="city">Quận Bình Thạnh</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 pb-16">
                                                            <p class="pb-8">Ghi chú dụng cụ ăn</p>
                                                            <select name="note_cook">
                                                                <option value=""></option>
                                                                <option value="KHÔNG">KHÔNG</option>
                                                                <option value="Chỉ khăn">Chỉ khăn</option>
                                                                <option value="Chỉ DC" selected="selected">Chỉ DC
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 pb-16">
                                                            <p class="pb-8">Tag phân loại</p>
                                                            <select class="form-control select2 select2-hidden-accessible" multiple="" name="tag_ids[]" style="width: 100%;" data-select2-id="1"
                                                                tabindex="-1" aria-hidden="true">
                                                                <option value="1" selected="" data-select2-id="3">Thân
                                                                    thiết</option>
                                                                <option value="2" selected="" data-select2-id="4">Ăn
                                                                    nhóm</option>
                                                                <option value="3" selected="" data-select2-id="5">Khách
                                                                    nước ngoài</option>
                                                                <option value="4">Bệnh lý</option>
                                                            </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 100%;"><span
                                                                    class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true"
                                                                        aria-expanded="false" tabindex="-1" aria-disabled="false">
                                                                        <ul class="select2-selection__rendered">
                                                                            <li class="select2-selection__choice" title="Thân thiết" data-select2-id="6">
                                                                                <span class="select2-selection__choice__remove" role="presentation">×</span><span>Thân
                                                                                    thiết</span>
                                                                            </li>
                                                                            <li class="select2-selection__choice" title="Ăn nhóm" data-select2-id="7">
                                                                                <span class="select2-selection__choice__remove" role="presentation">×</span><span>Ăn
                                                                                    nhóm</span>
                                                                            </li>
                                                                            <li class="select2-selection__choice" title="Khách nước ngoài" data-select2-id="8"><span
                                                                                    class="select2-selection__choice__remove" role="presentation">×</span><span>Khách
                                                                                    nước ngoài</span></li>
                                                                            <li class="select2-search select2-search--inline">
                                                                                <input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off"
                                                                                    autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder=""
                                                                                    style="width: 0.75em;">
                                                                            </li>
                                                                        </ul>
                                                                    </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                            <div class="form-group row pt-16 hidden">
                                                                <div class="col-sm-3"><label>Trạng thái khách
                                                                        hàng</label></div>
                                                                <div class="col-sm-9 text-titlecase">
                                                                    <div class="icheck-primary d-inline mr-2 text-titlecase">
                                                                        <input type="radio" id="radioActive1" value="1" checked="checked" name="active" required="">
                                                                        <label for="radioActive1">
                                                                            Active </label>
                                                                    </div>
                                                                    <div class="icheck-primary d-inline mr-2 text-titlecase">
                                                                        <input type="radio" id="radioActive0" value="0" name="active" required="">
                                                                        <label for="radioActive0">
                                                                            Inactive </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 ">

                                                <div id="location-fields">
                                                    <div class="address-group current-address pb-16 location_1 address_active " data-index="0">
                                                        <input type="hidden" name="locations[0][id]" value="126">
                                                        <div class="card-body">
                                                            <div class="card-header">
                                                                <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
                                                            </div>
                                                            <div class="row">
                                                                <div class="city col-4 pb-16">
                                                                    <select id="province_126" name="locations[0][province]" class="province-select form-control" disabled="">
                                                                        <option value="">Select Tỉnh/Thành phố</option>
                                                                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="district_126" name="locations[0][district]" class="district-select form-control text-capitalize">
                                                                        <option value="Quận Bình Thạnh" selected="">Quận
                                                                            Bình Thạnh</option>
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
                                                                        <option value="Quận Bình Tân">Quận Bình Tân
                                                                        </option>
                                                                        <option value="Quận Bình Thạnh">Quận Bình Thạnh
                                                                        </option>
                                                                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                                                                        <option value="Quận Phú Nhuận">Quận Phú Nhuận
                                                                        </option>
                                                                        <option value="Quận Tân Bình">Quận Tân Bình
                                                                        </option>
                                                                        <option value="Quận Tân Phú">Quận Tân Phú
                                                                        </option>
                                                                        <option value="Thành phố Thủ Đức">Thành phố Thủ
                                                                            Đức</option>
                                                                        <option value="Huyện Bình Chánh">Huyện Bình
                                                                            Chánh</option>
                                                                        <option value="Huyện Cần Giờ">Huyện Cần Giờ
                                                                        </option>
                                                                        <option value="Huyện Củ Chi">Huyện Củ Chi
                                                                        </option>
                                                                        <option value="Huyện Hóc Môn">Huyện Hóc Môn
                                                                        </option>
                                                                        <option value="Huyện Nhà Bè">Huyện Nhà Bè
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="ward_126" name="locations[0][ward]" class="ward-select form-control disabled">
                                                                        <option value="Phường 07" selected="">Phường 07
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 pb-16">
                                                                    <input id="address_126" type="text" class="form-control address" value="44L đường số 11, KDC Miếu Nổi" placeholder="Địa chỉ cụ thể*"
                                                                        name="locations[0][address]">
                                                                </div>
                                                            </div>
                                                            <div class="group-note">
                                                                <div class="note_shiper hidden pb-16">
                                                                    <input type="text" name="locations[0][note_shipper]" value="" placeholder="Note với shipper">
                                                                </div>
                                                                <div class="note_admin hidden pb-16">
                                                                    <input type="text" name="locations[0][note_admin]" value="" placeholder="Note với admin">
                                                                </div>
                                                            </div>

                                                            <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao
                                                                hàng
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
                                                                    <div class="col-6 text-right delete-location-button" data-id="126">
                                                                        <p class="d-f ai-center jc-end"><span>Xóa địa
                                                                                chỉ </span><i class="fas fa-bin-red"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="address-group current-address pb-16 location_0 " data-index="1">
                                                        <input type="hidden" name="locations[1][id]" value="128">
                                                        <div class="card-body">
                                                            <div class="card-header">
                                                                <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
                                                            </div>
                                                            <div class="row">
                                                                <div class="city col-4 pb-16">
                                                                    <select id="province_128" name="locations[1][province]" class="province-select form-control" disabled="">
                                                                        <option value="">Select Tỉnh/Thành phố</option>
                                                                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="district_128" name="locations[1][district]" class="district-select form-control text-capitalize">
                                                                        <option value="Quận 5" selected="">Quận 5
                                                                        </option>
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
                                                                        <option value="Quận Bình Tân">Quận Bình Tân
                                                                        </option>
                                                                        <option value="Quận Bình Thạnh">Quận Bình Thạnh
                                                                        </option>
                                                                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                                                                        <option value="Quận Phú Nhuận">Quận Phú Nhuận
                                                                        </option>
                                                                        <option value="Quận Tân Bình">Quận Tân Bình
                                                                        </option>
                                                                        <option value="Quận Tân Phú">Quận Tân Phú
                                                                        </option>
                                                                        <option value="Thành phố Thủ Đức">Thành phố Thủ
                                                                            Đức</option>
                                                                        <option value="Huyện Bình Chánh">Huyện Bình
                                                                            Chánh</option>
                                                                        <option value="Huyện Cần Giờ">Huyện Cần Giờ
                                                                        </option>
                                                                        <option value="Huyện Củ Chi">Huyện Củ Chi
                                                                        </option>
                                                                        <option value="Huyện Hóc Môn">Huyện Hóc Môn
                                                                        </option>
                                                                        <option value="Huyện Nhà Bè">Huyện Nhà Bè
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="ward_128" name="locations[1][ward]" class="ward-select form-control disabled">
                                                                        <option value="Phường 05" selected="">Phường 05
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 pb-16">
                                                                    <input id="address_128" type="text" class="form-control address" value="29 An Dương Vương" placeholder="Địa chỉ cụ thể*"
                                                                        name="locations[1][address]">
                                                                </div>
                                                            </div>
                                                            <div class="group-note">
                                                                <div class="note_shiper hidden pb-16">
                                                                    <input type="text" name="locations[1][note_shipper]" value="" placeholder="Note với shipper">
                                                                </div>
                                                                <div class="note_admin hidden pb-16">
                                                                    <input type="text" name="locations[1][note_admin]" value="" placeholder="Note với admin">
                                                                </div>
                                                            </div>

                                                            <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao
                                                                hàng
                                                            </div>

                                                            <div class="col-12 pb-16">
                                                                <hr>
                                                                <div class="row pt-16">
                                                                    <div class="col-6">
                                                                        <div class="icheck-primary d-f ai-center">
                                                                            <input type="radio" name="location_active" id="active_128" value="128">
                                                                            <input type="hidden" class="location_active" name="locations[1][active]" value="0">
                                                                            <label class="pl-4" for="active_128">
                                                                                Đặt làm địa chỉ mặc định
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right delete-location-button" data-id="128">
                                                                        <p class="d-f ai-center jc-end"><span>Xóa địa
                                                                                chỉ </span><i class="fas fa-bin-red"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="address-group current-address pb-16 location_0 " data-index="2">
                                                        <input type="hidden" name="locations[2][id]" value="125">
                                                        <div class="card-body">
                                                            <div class="card-header">
                                                                <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
                                                            </div>
                                                            <div class="row">
                                                                <div class="city col-4 pb-16">
                                                                    <select id="province_125" name="locations[2][province]" class="province-select form-control" disabled="">
                                                                        <option value="">Select Tỉnh/Thành phố</option>
                                                                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="district_125" name="locations[2][district]" class="district-select form-control text-capitalize">
                                                                        <option value="Quận 1" selected="">Quận 1
                                                                        </option>
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
                                                                        <option value="Quận Bình Tân">Quận Bình Tân
                                                                        </option>
                                                                        <option value="Quận Bình Thạnh">Quận Bình Thạnh
                                                                        </option>
                                                                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                                                                        <option value="Quận Phú Nhuận">Quận Phú Nhuận
                                                                        </option>
                                                                        <option value="Quận Tân Bình">Quận Tân Bình
                                                                        </option>
                                                                        <option value="Quận Tân Phú">Quận Tân Phú
                                                                        </option>
                                                                        <option value="Thành phố Thủ Đức">Thành phố Thủ
                                                                            Đức</option>
                                                                        <option value="Huyện Bình Chánh">Huyện Bình
                                                                            Chánh</option>
                                                                        <option value="Huyện Cần Giờ">Huyện Cần Giờ
                                                                        </option>
                                                                        <option value="Huyện Củ Chi">Huyện Củ Chi
                                                                        </option>
                                                                        <option value="Huyện Hóc Môn">Huyện Hóc Môn
                                                                        </option>
                                                                        <option value="Huyện Nhà Bè">Huyện Nhà Bè
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="ward_125" name="locations[2][ward]" class="ward-select form-control disabled">
                                                                        <option value="Phường Bến Nghé" selected="">
                                                                            Phường Bến Nghé</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 pb-16">
                                                                    <input id="address_125" type="text" class="form-control address" value="15 Lê Thánh Tôn" placeholder="Địa chỉ cụ thể*"
                                                                        name="locations[2][address]">
                                                                </div>
                                                            </div>
                                                            <div class="group-note">
                                                                <div class="note_shiper  pb-16">
                                                                    <input type="text" name="locations[2][note_shipper]" value="toà nhà Sonatus" placeholder="Note với shipper">
                                                                </div>
                                                                <div class="note_admin hidden pb-16">
                                                                    <input type="text" name="locations[2][note_admin]" value="" placeholder="Note với admin">
                                                                </div>
                                                            </div>

                                                            <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao
                                                                hàng
                                                            </div>

                                                            <div class="col-12 pb-16">
                                                                <hr>
                                                                <div class="row pt-16">
                                                                    <div class="col-6">
                                                                        <div class="icheck-primary d-f ai-center">
                                                                            <input type="radio" name="location_active" id="active_125" value="125">
                                                                            <input type="hidden" class="location_active" name="locations[2][active]" value="0">
                                                                            <label class="pl-4" for="active_125">
                                                                                Đặt làm địa chỉ mặc định
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right delete-location-button" data-id="125">
                                                                        <p class="d-f ai-center jc-end"><span>Xóa địa
                                                                                chỉ </span><i class="fas fa-bin-red"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="address-group current-address pb-16 location_0 " data-index="3">
                                                        <input type="hidden" name="locations[3][id]" value="115">
                                                        <div class="card-body">
                                                            <div class="card-header">
                                                                <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
                                                            </div>
                                                            <div class="row">
                                                                <div class="city col-4 pb-16">
                                                                    <select id="province_115" name="locations[3][province]" class="province-select form-control" disabled="">
                                                                        <option value="">Select Tỉnh/Thành phố</option>
                                                                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="district_115" name="locations[3][district]" class="district-select form-control text-capitalize">
                                                                        <option value="Quận 5" selected="">Quận 5
                                                                        </option>
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
                                                                        <option value="Quận Bình Tân">Quận Bình Tân
                                                                        </option>
                                                                        <option value="Quận Bình Thạnh">Quận Bình Thạnh
                                                                        </option>
                                                                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                                                                        <option value="Quận Phú Nhuận">Quận Phú Nhuận
                                                                        </option>
                                                                        <option value="Quận Tân Bình">Quận Tân Bình
                                                                        </option>
                                                                        <option value="Quận Tân Phú">Quận Tân Phú
                                                                        </option>
                                                                        <option value="Thành phố Thủ Đức">Thành phố Thủ
                                                                            Đức</option>
                                                                        <option value="Huyện Bình Chánh">Huyện Bình
                                                                            Chánh</option>
                                                                        <option value="Huyện Cần Giờ">Huyện Cần Giờ
                                                                        </option>
                                                                        <option value="Huyện Củ Chi">Huyện Củ Chi
                                                                        </option>
                                                                        <option value="Huyện Hóc Môn">Huyện Hóc Môn
                                                                        </option>
                                                                        <option value="Huyện Nhà Bè">Huyện Nhà Bè
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="ward_115" name="locations[3][ward]" class="ward-select form-control disabled">
                                                                        <option value="Phường 02" selected="">Phường 02
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 pb-16">
                                                                    <input id="address_115" type="text" class="form-control address" value="180 Nguyễn Trãi" placeholder="Địa chỉ cụ thể*"
                                                                        name="locations[3][address]">
                                                                </div>
                                                            </div>
                                                            <div class="group-note">
                                                                <div class="note_shiper hidden pb-16">
                                                                    <input type="text" name="locations[3][note_shipper]" value="" placeholder="Note với shipper">
                                                                </div>
                                                                <div class="note_admin hidden pb-16">
                                                                    <input type="text" name="locations[3][note_admin]" value="" placeholder="Note với admin">
                                                                </div>
                                                            </div>

                                                            <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao
                                                                hàng
                                                            </div>

                                                            <div class="col-12 pb-16">
                                                                <hr>
                                                                <div class="row pt-16">
                                                                    <div class="col-6">
                                                                        <div class="icheck-primary d-f ai-center">
                                                                            <input type="radio" name="location_active" id="active_115" value="115">
                                                                            <input type="hidden" class="location_active" name="locations[3][active]" value="0">
                                                                            <label class="pl-4" for="active_115">
                                                                                Đặt làm địa chỉ mặc định
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right delete-location-button" data-id="115">
                                                                        <p class="d-f ai-center jc-end"><span>Xóa địa
                                                                                chỉ </span><i class="fas fa-bin-red"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="address-group current-address pb-16 location_0 " data-index="4">
                                                        <input type="hidden" name="locations[4][id]" value="114">
                                                        <div class="card-body">
                                                            <div class="card-header">
                                                                <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
                                                            </div>
                                                            <div class="row">
                                                                <div class="city col-4 pb-16">
                                                                    <select id="province_114" name="locations[4][province]" class="province-select form-control" disabled="">
                                                                        <option value="">Select Tỉnh/Thành phố</option>
                                                                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="district_114" name="locations[4][district]" class="district-select form-control text-capitalize">
                                                                        <option value="Quận Bình Thạnh" selected="">Quận
                                                                            Bình Thạnh</option>
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
                                                                        <option value="Quận Bình Tân">Quận Bình Tân
                                                                        </option>
                                                                        <option value="Quận Bình Thạnh">Quận Bình Thạnh
                                                                        </option>
                                                                        <option value="Quận Gò Vấp">Quận Gò Vấp</option>
                                                                        <option value="Quận Phú Nhuận">Quận Phú Nhuận
                                                                        </option>
                                                                        <option value="Quận Tân Bình">Quận Tân Bình
                                                                        </option>
                                                                        <option value="Quận Tân Phú">Quận Tân Phú
                                                                        </option>
                                                                        <option value="Thành phố Thủ Đức">Thành phố Thủ
                                                                            Đức</option>
                                                                        <option value="Huyện Bình Chánh">Huyện Bình
                                                                            Chánh</option>
                                                                        <option value="Huyện Cần Giờ">Huyện Cần Giờ
                                                                        </option>
                                                                        <option value="Huyện Củ Chi">Huyện Củ Chi
                                                                        </option>
                                                                        <option value="Huyện Hóc Môn">Huyện Hóc Môn
                                                                        </option>
                                                                        <option value="Huyện Nhà Bè">Huyện Nhà Bè
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-4 pb-16">
                                                                    <select id="ward_114" name="locations[4][ward]" class="ward-select form-control disabled">
                                                                        <option value="Phường 03" selected="">Phường 03
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 pb-16">
                                                                    <input id="address_114" type="text" class="form-control address" value="268 Phan Xích Long" placeholder="Địa chỉ cụ thể*"
                                                                        name="locations[4][address]">
                                                                </div>
                                                            </div>
                                                            <div class="group-note">
                                                                <div class="note_shiper hidden pb-16">
                                                                    <input type="text" name="locations[4][note_shipper]" value="" placeholder="Note với shipper">
                                                                </div>
                                                                <div class="note_admin hidden pb-16">
                                                                    <input type="text" name="locations[4][note_admin]" value="" placeholder="Note với admin">
                                                                </div>
                                                            </div>

                                                            <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao
                                                                hàng
                                                            </div>

                                                            <div class="col-12 pb-16">
                                                                <hr>
                                                                <div class="row pt-16">
                                                                    <div class="col-6">
                                                                        <div class="icheck-primary d-f ai-center">
                                                                            <input type="radio" name="location_active" id="active_114" value="114">
                                                                            <input type="hidden" class="location_active" name="locations[4][active]" value="0">
                                                                            <label class="pl-4" for="active_114">
                                                                                Đặt làm địa chỉ mặc định
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right delete-location-button" data-id="114">
                                                                        <p class="d-f ai-center jc-end"><span>Xóa địa
                                                                                chỉ </span><i class="fas fa-bin-red"></i></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <p class="d-f ai-center pb-16 add-location-button"><i class="fas fa-plus"></i><span>Thêm địa chỉ mới</span></p>
                                                <!-- /.card-body -->
                                                <!-- /.card -->

                                            </div>
                                        </div>
                                        <div class="row pt-16 hidden">
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary" name="add_post">Cập
                                                    nhật</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="customer_name" readonly="" class="customer_name form-control" value="Vân (Van Lee)">
                                        <input type="hidden" name="customer_id" value="139">
                                        <input type="hidden" name="location_delete_ids" value="" class="location_delete_ids">
                                    </form>
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
</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center">
    <span class="btn btn-secondary btn-prev btn-disable">Quay lại</span>
    <span class="btn btn-primary btn-next">Tiếp theo</span>
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

        $( '.current-address .delete-location-button' ).click( function ( e )
        {
            e.preventDefault();
            $( ".scroll-menu .btn-disable" ).removeClass( 'btn-disable' );
        } );

        $( '.form-horizontal' ).each( function ()
        {
            let p = $( this ),
                data = p.serialize();

            p.on( 'input', function ()
            {
                var hook = true;
                // $('[type="submit"]', p).prop('disabled', data == p.serialize())
                $( ".scroll-menu .btn-disable" ).removeClass( 'btn-disable' );
                // window.onbeforeunload = function() {
                // 	if (hook) {
                // 		$('.modal-confirm').addClass('is-active');
                // 		$('body').addClass('overflow');
                // 		return false;
                // 	}
                // }
            } )
        } );

        function unhook ()
        {
            hook = false;
        }
        <?php
        if ($tab_active != '') {
            echo '$(".tabNavigation [rel=' . $tab_active . ']").trigger("click");';
        }
        ?>

        $( '.modal-remove-note' ).click( function ( e )
        {
            e.preventDefault();
            var href = $( this ).attr( 'href' );
            $( '#modal-note form.form-remove-note' ).attr( 'action', href );
        } );
        $( '#modal-note form.form-remove-note .btn-secondary' ).click( function ( e )
        {
            e.preventDefault();
            $( '#modal-note form.form-remove-note' ).attr( 'action', '' );
        } );

        $( '.js-comment-form' ).each( function ()
        {
            let $form = $( this );

            $( '.js-comment-row' ).each( function ()
            {
                let row = $( this );

                row.find( 'a[href="#editcomment"]' ).on( 'click', function ( e )
                {
                    let id = $( this ).data( 'id' ) || 0,
                        value = row.find( '.comment_content' ).text();

                    if ( id > 0 && value != '' ) {
                        let title = 'Bạn đang chỉnh sửa ghi chú - ' + value;

                        $form.find( '[name="comment"]' ).val( value ).attr( 'placeholder', title )
                            .attr( 'title', title ).attr( 'data-value', value )
                        $form.find( '[name="comment_ID"]' ).val( id );
                    }
                } );
            } );

            $( '.comment-box' ).on( "keypress", function ( evt )
            {
                if ( evt.keyCode == 13 ) {
                    let box = $( evt.target );

                    if ( evt.shiftKey == false && box.val().trim().length > 0 ) {
                        evt.preventDefault();

                        $form.find( '[type="submit"]' ).trigger( 'click' );
                    }
                }
            } ).on( 'input', function ( evt )
            {
                let box = $( evt.target ),
                    rows = box.val().split( "\n" ).length;

                if ( rows < 1 ) {
                    rows = 1;
                }

                box.attr( 'rows', rows + 1 );
            } );
        } );

        $( '.nickname' ).keyup( updatetxt );
        $( '.fullname' ).keyup( updatetxt );
        $( '.phone_number' ).keyup( updatephone );
        $( '.address-group select.district-select' ).each( function ()
        {
            $( this ).on( 'change', function ()
            {
                $( this ).closest( '.address-group' ).find( '.ward-select' ).removeClass( 'disabled' );
            } );
        } );
        $( document ).on( 'change', '.address_active select', function ()
        {
            $( '.review' ).show();
            //$(this).parents('.address-group').find($('.form-control.address')).val('');
            var selectItem = $( this ).closest( '.address_active' ); // Get the closest select-item div
            var infoIndex = 0; // Get the data-index attribute from select-item
            var city = selectItem.find( '.district-select' ).val(); // Get the city value from select
            var ward = selectItem.find( '.ward-select' ).val(); // Get the ward value from select
            // Update the corresponding .info div based on index
            var infoDiv = $( '.review .info' + infoIndex );
            infoDiv.children( '.city' ).text( city );
            if ( ward ) {
                infoDiv.children( '.ward' ).text( ward + ',' );
            } else {
                infoDiv.children( '.ward' ).text( '' );
            }
        } );

        $( document ).on( 'keyup', '.address_active .address', function ()
        {
            $( '.review' ).show();
            var selectItem = $( this ).closest( '.address_active' ); // Find the closest parent .address-group
            var infoIndex = 0; // Get the index from data attribute
            var address = $( this ).val(); // Get the current value of the address input field
            var infoDiv = $( '.review .info' + infoIndex );
            if ( address ) {
                infoDiv.children( '.address' ).text( address + ',' ); // Update the address text
            } else {
                infoDiv.children( '.address' ).text( '' ); // Clear the address if the input is empty
            }
        } );

        function updatetxt ()
        {
            $( '.review' ).show();
            if ( $( '.nickname' ).val() != '' && $( '.fullname' ).val() != '' ) {
                $( 'input.customer_name' ).val( $( '.fullname' ).val() + ' (' + $( '.nickname' ).val() + ') ' );
                $( 'span.customer_name' ).text( $( '.fullname' ).val() + ' (' + $( '.nickname' ).val() + ') ' );
            }
            if ( $( '.fullname' ).val() == '' ) {
                $( 'input.customer_name' ).val( $( '.nickname' ).val() );
                $( 'span.customer_name' ).text( $( '.nickname' ).val() );
            }
        }

        function updatephone ()
        {
            $( 'span.customer_phone' ).text( $( '.phone_number' ).val() );
        }
        var ass = new Assistant();
        $( '.btn-primary[name="add_post"]' ).on( 'click', function ( e )
        {
            if ( $( '.nickname' ).val() == '' ) {
                $( ".alert.valid-form" ).show();
                $( ".alert.valid-form" ).text( 'Chưa nhập tên tài khoản' );
                $( "html, body" ).animate( {
                    scrollTop: 0
                }, 600 );
                return false;
            } else {
                $( ".alert.valid-form" ).hide();
            }
            if ( !ass.checkPhone( $( 'input[type="tel"]' ).val() ) ) {
                // $('input[type="tel"]').addClass('error');
                $( ".alert.valid-form" ).show();
                $( ".alert.valid-form" ).text( "Số điện thoại không đúng định dạng" );
                $( "html, body" ).animate( {
                    scrollTop: 0
                }, 600 );
                return false;
            } else {
                $( ".alert.valid-form" ).hide();
                $( 'input[type="tel"]' ).removeClass( 'error' );
            }
            if ( $( '.gender' ).val() == 0 ) {
                $( ".alert.valid-form" ).show();
                $( ".alert.valid-form" ).text( 'Chưa chọn giới tính' );
                $( "html, body" ).animate( {
                    scrollTop: 0
                }, 600 );
                e.preventDefault();
                return false;
            } else {
                $( ".alert.valid-form" ).hide();
            }
            $( '.address-group select,.address-group .address' ).each( function ()
            {
                var selectedValues = $( this ).val();
                if ( selectedValues == '' ) {
                    $( ".alert.valid-form" ).show();
                    $( ".alert.valid-form" ).text( 'Kiểm tra mục địa chỉ' );
                    $( "html, body" ).animate( {
                        scrollTop: 0
                    }, 600 );
                    e.preventDefault();
                    return false;
                } else {
                    $( ".alert.valid-form" ).hide();
                }
            } );
        } );
        $( '.js-list-note' ).each( function ()
        {
            let p = $( this );
            $( '.btn', p ).on( 'click', function ()
            {
                let input = $( 'textarea', p ),
                    list = input.val() || '',
                    btn = $( this ),
                    text = btn.text();
                list = ( list != '' ? list.split( ',' ) : [] ).map( v => v.trim() );
                if ( btn.hasClass( 'active' ) ) {
                    let tmp = [];
                    list.forEach( function ( v, i )
                    {
                        if ( v != text ) {
                            tmp.push( v );
                        }
                    } )
                    list = tmp;
                    btn.removeClass( 'active' );
                } else {
                    list.push( text );
                    btn.addClass( 'active' );
                }
                input.val( list.join( ", " ) );
            } );
        } );

        var fieldCount = <?php echo count($response_get_location['data']); ?>;
        var maxFields = 5;
        $( document ).on( 'click', '.delete-location-button', function ( e )
        {
            e.preventDefault();
            let btn = $( this ),
                id = parseInt( btn.data( 'id' ) || 0 );
            btn.closest( '.address-group' ).remove(); // Remove only the closest address group
            // fieldCount = fieldCount + 1;
            // console.log('log',fieldCount);
            if ( id > 0 ) {
                let l_d = $( '.location_delete_ids' );
                l_d.val( id + ( l_d.val() != '' ? ',' + l_d.val() : '' ) );
            }
        } );
        // Fetching data from the new API endpoint
    } );
</script>