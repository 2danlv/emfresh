<?php

/**
 * Template Name: Order details
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header();
?>
<div class="customer">
    <div class="detail-customer pt-16">

        <section class="content">
            <div class="container-fluid">
                <div class="scroll-menu pt-8">
                    <div class="row">
                        <div class="col-6 backtolist d-f ai-center">
                            <a href="/customer/" class="d-f ai-center"><span class="mr-4"><img
                                        src="http://emfresh.web/wp-content/themes/emfresh/assets/img/icon/caretup.svg"
                                        alt=""></span><span> Quay lại danh sách khách hàng</span></a>
                        </div>
                        <div class="col-6 d-f ai-center jc-end group-button_top">
                            <span class="btn btn-danger remove-customer modal-button" data-target="#modal-default">
                                Xoá khách này
                            </span>
                            <a class="btn btn-primary btn-add_order" href="#" style=""><span class="d-f ai-center"><i
                                        class="fas mr-4"><img
                                            src="http://emfresh.web/wp-content/themes/emfresh/assets/img/icon-hover/plus-svgrepo-com_white.svg"
                                            alt=""></i>Tạo đơn mới</span></a>
                            <span class="btn btn-primary btn-disable btn-save_edit hidden" style="display: none;">Lưu
                                thay
                                đổi</span>
                        </div>
                    </div>
                    <div class="card-header">
                        <ul class="nav tabNavigation pt-16">
                            <li class="nav-item selected" rel="info">Thông tin khách hàng</li>
                            <li class="nav-item" rel="note">Ghi chú</li>
                            <li class="nav-item" rel="settings">Chỉnh sửa thông tin</li>
                            <li class="nav-item" rel="history">Lịch sử thao tác</li>
                        </ul>
                    </div>
                </div>
                <div class="card-primary">
                    <!-- Content Header (Page header) -->
                    <h1 class="pt-8">Hồng Nhung 1</h1>
                    <!-- Main content -->
                    <div class="row">
                        <div class="col-4 about-box">
                            <!-- About Me Box -->
                            <div class="card ">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="ttl">
                                        Thông tin chi tiết
                                    </div>
                                    <div class="d-f jc-b pt-16">
                                        <span>Số điện thoại:</span>
                                        <span class="copy modal-button" data-target="#modal-copy"
                                            title="Copy: 0909739506">0909739506</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Giới tính:</span>
                                        <span>Nữ</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Trạng thái khách hàng:</span>
                                        <span></span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Số đơn:</span>
                                        <span>12</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Số ngày ăn:</span>
                                        <span>60</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Số phần ăn:</span>
                                        <span>60</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Tổng tiền đã chi:</span>
                                        <span>4.000.000</span>
                                    </div>
                                    <div class="d-f jc-b pt-8">
                                        <span>Điểm tích luỹ:</span>
                                        <span>0</span>
                                    </div>
                                    <div class="d-f jc-b pt-8 pb-4">
                                        <span>Lịch sử đặt gần nhất:</span>
                                        <span>08:31 29/09/2024</span>
                                    </div>
                                    <hr>
                                    <div class="d-f jc-b pt-8">
                                        <span>Ghi chú dụng cụ ăn:</span>
                                        <span>Chỉ khăn</span>
                                    </div>
                                    <div class="pt-8 d-f">
                                        <span class="nowrap pt-4">Tag phân loại:</span>
                                        <div class="list-tag text-right jc-end col-item-right">
                                            <span class="tag btn btn-sm tag_2 mb-4">Ăn nhóm</span>
                                            <span class="tag btn btn-sm tag_3 mb-4">Khách nước ngoài</span>
                                            <span class="tag btn btn-sm tag_1 mb-4">Thân thiết</span>
                                            <span class="tag btn btn-sm tag_4 mb-4">Bệnh lý</span>
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
                                <div class="tab-content">
                                    <div class="tab-pane" id="info" style="">
                                        <div class="card mb-16">
                                            <div class="ttl">
                                                Địa chỉ
                                            </div>
                                            <div class="row pt-16">
                                                <div class="col-10">91 Trần Nguyên Đán,
                                                    Phường 3,
                                                    Quận Bình Thạnh </div>
                                                <div class="col-2 text-right">
                                                    <span class="badge badge-warning">Mặc định</span>
                                                </div>
                                            </div>
                                            <div class="row pt-16">
                                                <div class="col-10">Toà nhà ABC 26 Nguyễn Huy Lượng,
                                                    Phường 05,
                                                    Quận Gò Vấp </div>
                                            </div>
                                        </div>
                                        <div class="card card-history">
                                            <div class="ttl">
                                                Lịch sử đặt đơn
                                            </div>
                                            <div class="history-order" style="margin: 0;">
                                                <table class="nowrap-bak">
                                                    <tbody>
                                                        <tr>
                                                            <th>Mã đơn</th>
                                                            <th>Mã gói sản phẩm</th>
                                                            <th>Ngày <br>
                                                                bắt đầu
                                                            </th>
                                                            <th>Ngày<br>
                                                                kết thúc
                                                            </th>
                                                            <th>Tổng tiền</th>
                                                            <th>Trạng thái<br>
                                                                thanh toán</th>
                                                            <th>Trạng thái<br>
                                                                đơn hàng</th>
                                                        </tr>
                                                        <tr>
                                                            <td>97</td>
                                                            <td>2SM+1ET+1EP+1TA</td>
                                                            <td>22/09/24</td>
                                                            <td align="center">-</td>
                                                            <td>400.000</td>
                                                            <td align="center"><span class="status_pay">Rồi</span></td>
                                                            <td align="center" class="status-order"><span
                                                                    class="status_order">Đang dùng</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>97</td>
                                                            <td>2SM+1ET+1EP+1TA</td>
                                                            <td>22/09/24</td>
                                                            <td>22/09/24</td>
                                                            <td>400.000</td>
                                                            <td align="center"><span class="status_pay">Rồi</span></td>
                                                            <td align="center" class="status-order"><span
                                                                    class="status_order">Đang dùng
                                                                    <!--< /td-->
                                                                </span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-f ai-center jc-b pt-16">
                                                <div class="btn btn-export d-f ai-center">
                                                    <span class="fas fa-export"></span> Xuất Excel
                                                </div>
                                                <div class="dt-paging">
                                                    <nav aria-label="pagination">
                                                        <button class="dt-paging-button disabled previous" role="link"
                                                            type="button" aria-controls="list-customer"
                                                            aria-disabled="true" aria-label="Previous"
                                                            data-dt-idx="previous" tabindex="-1"><i
                                                                class="fas fa-left"></i></button>
                                                        <button class="dt-paging-button current" role="link"
                                                            type="button" aria-controls="list-customer"
                                                            aria-current="page" data-dt-idx="0">1</button>
                                                        <button class="dt-paging-button" role="link" type="button"
                                                            aria-controls="list-customer" aria-current="page"
                                                            data-dt-idx="0">2</button>
                                                        <button class="dt-paging-button" role="link" type="button"
                                                            aria-controls="list-customer" aria-current="page"
                                                            data-dt-idx="0">3</button>
                                                        <button class="dt-paging-button" role="link" type="button"
                                                            aria-controls="list-customer" aria-current="page"
                                                            data-dt-idx="0">4</button>
                                                        <button class="dt-paging-button" role="link" type="button"
                                                            aria-controls="list-customer" aria-current="page"
                                                            data-dt-idx="0">5</button>
                                                        <button class="dt-paging-button disabled next" role="link"
                                                            type="button" aria-controls="list-customer"
                                                            aria-disabled="true" aria-label="Next" data-dt-idx="next"
                                                            tabindex="-1"><i class="fas fa-right"></i></button>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="note" style="opacity: 1; display: none;">
                                        <div class="card">
                                            <div class="ttl">
                                                Ghi chú
                                            </div>
                                            <div class="note-wraper pt-16">
                                                <div class="js-comment-row pb-16 ">
                                                    <div class="row row-comment">
                                                        <div class="account-name d-f ai-center col-6">
                                                            <div class="avatar">
                                                                <img src="https://secure.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?s=96&amp;d=mm&amp;r=g"
                                                                    alt="" width="40">
                                                            </div>
                                                            <div>admin</div>
                                                        </div>
                                                        <div class="edit col-3">
                                                            <span class="pen">
                                                                <a href="#editcomment" data-id="171"><img
                                                                        src="http://emfresh.web/wp-content/themes/emfresh/assets//img/icon/edit-2-svgrepo-com.svg"
                                                                        alt=""></a>
                                                            </span>
                                                            <span class="pin"><a
                                                                    href="http://emfresh.web/customer/detail-customer/?customer_id=41&amp;pin-id=171&amp;pin-token=95270defd9"><img
                                                                        src="http://emfresh.web/wp-content/themes/emfresh/assets/img/icon/pin-svgrepo-com.svg"
                                                                        alt=""></a></span>
                                                            <span class="remove">
                                                                <a class="modal-remove-note modal-button"
                                                                    data-target="#modal-note"
                                                                    href="http://emfresh.web/customer/detail-customer/?customer_id=41&amp;delete_comment=171&amp;comtoken=b86b62f3d8"><img
                                                                        src="http://emfresh.web/wp-content/themes/emfresh/assets//img/icon/bin.svg"
                                                                        alt=""></a>
                                                            </span>
                                                        </div>
                                                        <div class="time col-3">03/12/2024</div>
                                                    </div>
                                                    <div class="note-content cap-nhat">
                                                        <span class="comment_content">3</span>
                                                        <span class="comment_status status-edited modal-button"
                                                            data-target="#modal-history171">• Đã sửa</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="note-form">
                                                <form
                                                    action="http://emfresh.web/customer/detail-customer/?customer_id=41&amp;tab=note"
                                                    method="post" enctype="multipart/form-data" class="js-comment-form"
                                                    id="editcomment">
                                                    <div class="binhluan-moi">
                                                        <div class="box-right">
                                                            <div class="form-group">
                                                                <textarea name="comment" maxlength="65525"
                                                                    class="form-control comment-box"
                                                                    placeholder="Viết bình luận"></textarea>
                                                            </div>
                                                            <button class="btn-common-fill hidden" type="submit"
                                                                name="submit" value="submit">Send</button>
                                                        </div>
                                                        <input type="hidden" name="url"
                                                            value="http://emfresh.web/customer/detail-customer/?customer_id=41">
                                                        <input type="hidden" name="comment_post_ID" value="41">
                                                        <input type="hidden" name="comment_parent" value="0">
                                                        <input type="hidden" name="comment_ID" value="0">
                                                        <input type="hidden" id="comtoken" name="comtoken"
                                                            value="b86b62f3d8"><input type="hidden"
                                                            name="_wp_http_referer"
                                                            value="/customer/detail-customer/?customer_id=41">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane customer detail-customer" id="settings"
                                        style="opacity: 1; display: none;">
                                        <div class="alert valid-form alert-warning hidden error mb-16"></div>
                                        <form class="form-horizontal" method="POST"
                                            action="http://emfresh.web/customer/detail-customer/?customer_id=41&amp;tab=settings">
                                            <input type="hidden" id="edit_locations_nonce" name="edit_locations_nonce"
                                                value="ce96a1e079"><input type="hidden" name="_wp_http_referer"
                                                value="/customer/detail-customer/?customer_id=41">
                                            <div class="row pb-16">
                                                <div class="col-6">
                                                    <div class="card-body">
                                                        <div class="card-header">
                                                            <h3 class="card-title d-f ai-center"><span
                                                                    class="fas fa-info mr-4"></span> Thông tin cơ bản
                                                            </h3>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 pb-16">
                                                                <input type="text" name="nickname"
                                                                    class="nickname form-control" maxlength="50"
                                                                    value="Hồng Nhung 1" placeholder="Tên tài khoản*">
                                                            </div>
                                                            <div class="col-6 pb-16">
                                                                <input type="text" name="fullname"
                                                                    class="fullname form-control" maxlength="50"
                                                                    value="" placeholder="Tên thật (nếu có)">
                                                            </div>
                                                            <div class="col-6 pb-16">
                                                                <input type="tel" id="phone" name="phone"
                                                                    class="phone_number form-control" value="0909739506"
                                                                    maxlength="10">
                                                                <p id="phone_status" class="status text-danger"></p>
                                                            </div>
                                                            <div class="col-6 pb-16">
                                                                <select name="gender" class="gender text-titlecase"
                                                                    required="">
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
                                                                    <p><span class="customer_name">Hồng Nhung 1</span>
                                                                    </p>
                                                                    <p><span class="customer_phone">0909739506</span>
                                                                    </p>
                                                                    <div class="info0">
                                                                        <span class="address">91 Trần Nguyên Đán,</span>
                                                                        <span class="ward">Phường 3,</span>
                                                                        <span class="city">Quận Bình Thạnh</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 pb-16">
                                                                <p class="pb-8">Ghi chú dụng cụ ăn</p>
                                                                <select name="note_cook">
                                                                    <option value=""></option>
                                                                    <option value="KHÔNG">KHÔNG</option>
                                                                    <option value="Chỉ khăn" selected="selected">Chỉ
                                                                        khăn
                                                                    </option>
                                                                    <option value="Chỉ DC">Chỉ DC</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 pb-16">
                                                                <p class="pb-8">Tag phân loại</p>
                                                                <select
                                                                    class="form-control select2 select2-hidden-accessible"
                                                                    multiple="" name="tag_ids[]" style="width: 100%;"
                                                                    data-select2-id="1" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option value="1" selected="" data-select2-id="3">
                                                                        Thân
                                                                        thiết</option>
                                                                    <option value="2" selected="" data-select2-id="4">Ăn
                                                                        nhóm</option>
                                                                    <option value="3" selected="" data-select2-id="5">
                                                                        Khách
                                                                        nước ngoài</option>
                                                                    <option value="4" selected="" data-select2-id="6">
                                                                        Bệnh
                                                                        lý</option>
                                                                </select><span
                                                                    class="select2 select2-container select2-container--default"
                                                                    dir="ltr" data-select2-id="2"
                                                                    style="width: 100%;"><span class="selection"><span
                                                                            class="select2-selection select2-selection--multiple"
                                                                            role="combobox" aria-haspopup="true"
                                                                            aria-expanded="false" tabindex="-1"
                                                                            aria-disabled="false">
                                                                            <ul class="select2-selection__rendered">
                                                                                <li class="select2-selection__choice"
                                                                                    title="Thân thiết"
                                                                                    data-select2-id="7">
                                                                                    <span
                                                                                        class="select2-selection__choice__remove"
                                                                                        role="presentation">×</span><span>Thân
                                                                                        thiết</span>
                                                                                </li>
                                                                                <li class="select2-selection__choice"
                                                                                    title="Ăn nhóm" data-select2-id="8">
                                                                                    <span
                                                                                        class="select2-selection__choice__remove"
                                                                                        role="presentation">×</span><span>Ăn
                                                                                        nhóm</span>
                                                                                </li>
                                                                                <li class="select2-selection__choice"
                                                                                    title="Khách nước ngoài"
                                                                                    data-select2-id="9"><span
                                                                                        class="select2-selection__choice__remove"
                                                                                        role="presentation">×</span><span>Khách
                                                                                        nước ngoài</span></li>
                                                                                <li class="select2-selection__choice"
                                                                                    title="Bệnh lý"
                                                                                    data-select2-id="10">
                                                                                    <span
                                                                                        class="select2-selection__choice__remove"
                                                                                        role="presentation">×</span><span>Bệnh
                                                                                        lý</span>
                                                                                </li>
                                                                                <li
                                                                                    class="select2-search select2-search--inline">
                                                                                    <input class="select2-search__field"
                                                                                        type="search" tabindex="0"
                                                                                        autocomplete="off"
                                                                                        autocorrect="off"
                                                                                        autocapitalize="none"
                                                                                        spellcheck="false"
                                                                                        role="searchbox"
                                                                                        aria-autocomplete="list"
                                                                                        placeholder=""
                                                                                        style="width: 0.75em;">
                                                                                </li>
                                                                            </ul>
                                                                        </span></span><span class="dropdown-wrapper"
                                                                        aria-hidden="true"></span></span>
                                                                <div class="form-group row pt-16 hidden">
                                                                    <div class="col-sm-3"><label>Trạng thái khách
                                                                            hàng</label></div>
                                                                    <div class="col-sm-9 text-titlecase">
                                                                        <div
                                                                            class="icheck-primary d-inline mr-2 text-titlecase">
                                                                            <input type="radio" id="radioActive1"
                                                                                value="1" checked="checked"
                                                                                name="active" required="">
                                                                            <label for="radioActive1">
                                                                                Active </label>
                                                                        </div>
                                                                        <div
                                                                            class="icheck-primary d-inline mr-2 text-titlecase">
                                                                            <input type="radio" id="radioActive0"
                                                                                value="0" name="active" required="">
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
                                                        <div class="address-group current-address pb-16 location_1 address_active "
                                                            data-index="0">
                                                            <input type="hidden" name="locations[0][id]" value="15">
                                                            <div class="card-body">
                                                                <div class="card-header">
                                                                    <h3 class="card-title d-f ai-center"><span
                                                                            class="fas fa-location mr-4"></span>Địa chỉ
                                                                    </h3>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="city col-4 pb-16">
                                                                        <select id="province_15"
                                                                            name="locations[0][province]"
                                                                            class="province-select form-control"
                                                                            disabled="">
                                                                            <option value="">Select Tỉnh/Thành phố
                                                                            </option>
                                                                            <option value="Thành phố Hồ Chí Minh"
                                                                                selected="">Thành phố Hồ Chí Minh
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4 pb-16">
                                                                        <select id="district_15"
                                                                            name="locations[0][district]"
                                                                            class="district-select form-control text-capitalize">
                                                                            <option value="Quận Bình Thạnh" selected="">
                                                                                Quận
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
                                                                            <option value="Quận Bình Thạnh">Quận Bình
                                                                                Thạnh
                                                                            </option>
                                                                            <option value="Quận Gò Vấp">Quận Gò Vấp
                                                                            </option>
                                                                            <option value="Quận Phú Nhuận">Quận Phú
                                                                                Nhuận
                                                                            </option>
                                                                            <option value="Quận Tân Bình">Quận Tân Bình
                                                                            </option>
                                                                            <option value="Quận Tân Phú">Quận Tân Phú
                                                                            </option>
                                                                            <option value="Thành phố Thủ Đức">Thành phố
                                                                                Thủ
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
                                                                        <select id="ward_15" name="locations[0][ward]"
                                                                            class="ward-select form-control disabled">
                                                                            <option value="Phường 3" selected="">Phường
                                                                                3
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 pb-16">
                                                                        <input id="address_15" type="text"
                                                                            class="form-control address"
                                                                            value="91 Trần Nguyên Đán"
                                                                            placeholder="Địa chỉ cụ thể*"
                                                                            name="locations[0][address]">
                                                                    </div>
                                                                </div>
                                                                <div class="group-note">
                                                                    <div class="note_shiper hidden pb-16">
                                                                        <input type="text"
                                                                            name="locations[0][note_shipper]" value=""
                                                                            placeholder="Note với shipper">
                                                                    </div>
                                                                    <div class="note_admin hidden pb-16">
                                                                        <input type="text"
                                                                            name="locations[0][note_admin]" value=""
                                                                            placeholder="Note với admin">
                                                                    </div>
                                                                </div>

                                                                <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú
                                                                    giao
                                                                    hàng
                                                                </div>

                                                                <div class="col-12 pb-16">
                                                                    <hr>
                                                                    <div class="row pt-16">
                                                                        <div class="col-6">
                                                                            <div class="icheck-primary d-f ai-center">
                                                                                <input type="radio"
                                                                                    name="location_active"
                                                                                    id="active_15" value="15"
                                                                                    checked="checked">
                                                                                <input type="hidden"
                                                                                    class="location_active"
                                                                                    name="locations[0][active]"
                                                                                    value="1">
                                                                                <label class="pl-4" for="active_15">
                                                                                    Đặt làm địa chỉ mặc định
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 text-right delete-location-button"
                                                                            data-id="15">
                                                                            <p class="d-f ai-center jc-end"><span>Xóa
                                                                                    địa
                                                                                    chỉ </span><i
                                                                                    class="fas fa-bin-red"></i></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="address-group current-address pb-16 location_0 "
                                                            data-index="1">
                                                            <input type="hidden" name="locations[1][id]" value="127">
                                                            <div class="card-body">
                                                                <div class="card-header">
                                                                    <h3 class="card-title d-f ai-center"><span
                                                                            class="fas fa-location mr-4"></span>Địa chỉ
                                                                    </h3>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="city col-4 pb-16">
                                                                        <select id="province_127"
                                                                            name="locations[1][province]"
                                                                            class="province-select form-control"
                                                                            disabled="">
                                                                            <option value="">Select Tỉnh/Thành phố
                                                                            </option>
                                                                            <option value="Thành phố Hồ Chí Minh"
                                                                                selected="">Thành phố Hồ Chí Minh
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4 pb-16">
                                                                        <select id="district_127"
                                                                            name="locations[1][district]"
                                                                            class="district-select form-control text-capitalize">
                                                                            <option value="Quận Gò Vấp" selected="">Quận
                                                                                Gò
                                                                                Vấp</option>
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
                                                                            <option value="Quận Bình Thạnh">Quận Bình
                                                                                Thạnh
                                                                            </option>
                                                                            <option value="Quận Gò Vấp">Quận Gò Vấp
                                                                            </option>
                                                                            <option value="Quận Phú Nhuận">Quận Phú
                                                                                Nhuận
                                                                            </option>
                                                                            <option value="Quận Tân Bình">Quận Tân Bình
                                                                            </option>
                                                                            <option value="Quận Tân Phú">Quận Tân Phú
                                                                            </option>
                                                                            <option value="Thành phố Thủ Đức">Thành phố
                                                                                Thủ
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
                                                                        <select id="ward_127" name="locations[1][ward]"
                                                                            class="ward-select form-control disabled">
                                                                            <option value="Phường 05" selected="">Phường
                                                                                05
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 pb-16">
                                                                        <input id="address_127" type="text"
                                                                            class="form-control address"
                                                                            value="Toà nhà ABC 26 Nguyễn Huy Lượng"
                                                                            placeholder="Địa chỉ cụ thể*"
                                                                            name="locations[1][address]">
                                                                    </div>
                                                                </div>
                                                                <div class="group-note">
                                                                    <div class="note_shiper  pb-16">
                                                                        <input type="text"
                                                                            name="locations[1][note_shipper]"
                                                                            value="Khi giao hàng tới gửi chú Long bảo vệ"
                                                                            placeholder="Note với shipper">
                                                                    </div>
                                                                    <div class="note_admin hidden pb-16">
                                                                        <input type="text"
                                                                            name="locations[1][note_admin]" value=""
                                                                            placeholder="Note với admin">
                                                                    </div>
                                                                </div>

                                                                <div class="show-group-note d-f ai-center pb-16 pt-8 ">
                                                                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú
                                                                    giao
                                                                    hàng
                                                                </div>

                                                                <div class="col-12 pb-16">
                                                                    <hr>
                                                                    <div class="row pt-16">
                                                                        <div class="col-6">
                                                                            <div class="icheck-primary d-f ai-center">
                                                                                <input type="radio"
                                                                                    name="location_active"
                                                                                    id="active_127" value="127">
                                                                                <input type="hidden"
                                                                                    class="location_active"
                                                                                    name="locations[1][active]"
                                                                                    value="0">
                                                                                <label class="pl-4" for="active_127">
                                                                                    Đặt làm địa chỉ mặc định
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 text-right delete-location-button"
                                                                            data-id="127">
                                                                            <p class="d-f ai-center jc-end"><span>Xóa
                                                                                    địa
                                                                                    chỉ </span><i
                                                                                    class="fas fa-bin-red"></i></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <p class="d-f ai-center pb-16 add-location-button"><i
                                                            class="fas fa-plus"></i><span>Thêm địa chỉ mới</span></p>
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
                                            <input type="hidden" name="customer_name" readonly=""
                                                class="customer_name form-control" value="Hồng Nhung 1">
                                            <input type="hidden" name="customer_id" value="41">
                                            <input type="hidden" name="location_delete_ids" value=""
                                                class="location_delete_ids">
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="history" style="opacity: 1; display: none;">
                                        <div class="card history-action">
                                            <div id="DataTables_Table_0_wrapper" class="dt-container dt-empty-footer">
                                                <div class="dt-buttons"> </div>
                                                <div class="dt-search"><label for="dt-search-0">Search:</label><input
                                                        type="search" class="dt-input" id="dt-search-0" placeholder=""
                                                        aria-controls="DataTables_Table_0"></div>
                                                <div class="dt-scroll">
                                                    <div class="dt-scroll-head"
                                                        style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                                        <div class="dt-scroll-headInner"
                                                            style="box-sizing: content-box; width: 1570px; padding-right: 0px;">
                                                            <table class="regular dataTable"
                                                                style="margin-left: 0px; width: 1570px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th data-dt-column="0" rowspan="1" colspan="1"
                                                                            class="dt-orderable-none"
                                                                            aria-label="Người thực hiện"><span
                                                                                class="dt-column-title">Người thực
                                                                                hiện</span><span
                                                                                class="dt-column-order"></span></th>
                                                                        <th data-dt-column="1" rowspan="1" colspan="1"
                                                                            class="dt-orderable-none"
                                                                            aria-label="Hành động"><span
                                                                                class="dt-column-title">Hành
                                                                                động</span><span
                                                                                class="dt-column-order"></span></th>
                                                                        <th class="descript dt-orderable-none"
                                                                            data-dt-column="2" rowspan="1" colspan="1"
                                                                            aria-label="Mô tả"><span
                                                                                class="dt-column-title">Mô
                                                                                tả</span><span
                                                                                class="dt-column-order"></span></th>
                                                                        <th data-dt-column="3" rowspan="1" colspan="1"
                                                                            class="dt-orderable-asc dt-orderable-desc dt-ordering-desc"
                                                                            aria-label="Thời gian: Activate to sort"
                                                                            tabindex="0"><span class="dt-column-title"
                                                                                role="button">Thời gian</span><span
                                                                                class="dt-column-order"></span></th>
                                                                        <th data-dt-column="4" rowspan="1" colspan="1"
                                                                            class="dt-orderable-asc dt-orderable-desc dt-ordering-desc"
                                                                            aria-sort="descending"
                                                                            aria-label="Ngày: Activate to remove sorting"
                                                                            tabindex="0"><span class="dt-column-title"
                                                                                role="button">Ngày</span><span
                                                                                class="dt-column-order"></span></th>
                                                                    </tr>
                                                                </thead>
                                                                <colgroup>
                                                                    <col data-dt-column="0" style="width: 270px;">
                                                                    <col data-dt-column="1" style="width: 180px;">
                                                                    <col data-dt-column="2" style="width: 810.031px;">
                                                                    <col data-dt-column="3" style="width: 180px;">
                                                                    <col data-dt-column="4" style="width: 129.969px;">
                                                                </colgroup>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="dt-scroll-body"
                                                        style="position: relative; overflow: auto; width: 100%; max-height: 50vh; height: 50vh;">
                                                        <table class="regular dataTable" id="DataTables_Table_0"
                                                            aria-describedby="DataTables_Table_0_info"
                                                            style="width: 100%;">
                                                            <colgroup>
                                                                <col data-dt-column="0" style="width: 270px;">
                                                                <col data-dt-column="1" style="width: 180px;">
                                                                <col data-dt-column="2" style="width: 810.031px;">
                                                                <col data-dt-column="3" style="width: 180px;">
                                                                <col data-dt-column="4" style="width: 129.969px;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th data-dt-column="0" rowspan="1" colspan="1"
                                                                        class="dt-orderable-none"
                                                                        aria-label="Người thực hiện">
                                                                        <div class="dt-scroll-sizing"><span
                                                                                class="dt-column-title">Người thực
                                                                                hiện</span><span
                                                                                class="dt-column-order"></span></div>
                                                                    </th>
                                                                    <th data-dt-column="1" rowspan="1" colspan="1"
                                                                        class="dt-orderable-none"
                                                                        aria-label="Hành động">
                                                                        <div class="dt-scroll-sizing"><span
                                                                                class="dt-column-title">Hành
                                                                                động</span><span
                                                                                class="dt-column-order"></span></div>
                                                                    </th>
                                                                    <th class="descript dt-orderable-none"
                                                                        data-dt-column="2" rowspan="1" colspan="1"
                                                                        aria-label="Mô tả">
                                                                        <div class="dt-scroll-sizing"><span
                                                                                class="dt-column-title">Mô
                                                                                tả</span><span
                                                                                class="dt-column-order"></span></div>
                                                                    </th>
                                                                    <th data-dt-column="3" rowspan="1" colspan="1"
                                                                        class="dt-orderable-asc dt-orderable-desc dt-ordering-desc"
                                                                        aria-label="Thời gian: Activate to sort">
                                                                        <div class="dt-scroll-sizing"><span
                                                                                class="dt-column-title"
                                                                                role="button">Thời
                                                                                gian</span><span
                                                                                class="dt-column-order"></span></div>
                                                                    </th>
                                                                    <th data-dt-column="4" rowspan="1" colspan="1"
                                                                        class="dt-orderable-asc dt-orderable-desc dt-ordering-desc"
                                                                        aria-sort="descending"
                                                                        aria-label="Ngày: Activate to remove sorting">
                                                                        <div class="dt-scroll-sizing"><span
                                                                                class="dt-column-title"
                                                                                role="button">Ngày</span><span
                                                                                class="dt-column-order"></span></div>
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="5" class="dt-empty">No data available
                                                                        in
                                                                        table</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="dt-scroll-foot"
                                                        style="overflow: hidden; border: 0px; width: 100%;">
                                                        <div class="dt-scroll-footInner">
                                                            <table class="regular dataTable" style="margin-left: 0px;">
                                                                <tfoot></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info"
                                                    role="status">Showing 0 to 0 of 0 entries</div>
                                                <div class="dt-paging">
                                                    <nav aria-label="pagination"><button
                                                            class="dt-paging-button disabled first" role="link"
                                                            type="button" aria-controls="DataTables_Table_0"
                                                            aria-disabled="true" aria-label="First" data-dt-idx="first"
                                                            tabindex="-1">«</button><button
                                                            class="dt-paging-button disabled previous" role="link"
                                                            type="button" aria-controls="DataTables_Table_0"
                                                            aria-disabled="true" aria-label="Previous"
                                                            data-dt-idx="previous" tabindex="-1"><i
                                                                class="fas fa-left"></i></button><button
                                                            class="dt-paging-button disabled next" role="link"
                                                            type="button" aria-controls="DataTables_Table_0"
                                                            aria-disabled="true" aria-label="Next" data-dt-idx="next"
                                                            tabindex="-1"><i class="fas fa-right"></i></button><button
                                                            class="dt-paging-button disabled last" role="link"
                                                            type="button" aria-controls="DataTables_Table_0"
                                                            aria-disabled="true" aria-label="Last" data-dt-idx="last"
                                                            tabindex="-1">»</button>
                                                    </nav>
                                                </div>
                                                <div id="" class="bottom">
                                                    <div class="dt-paging">
                                                        <nav aria-label="pagination"><button
                                                                class="dt-paging-button disabled first" role="link"
                                                                type="button" aria-controls="DataTables_Table_0"
                                                                aria-disabled="true" aria-label="First"
                                                                data-dt-idx="first" tabindex="-1"
                                                                style="">«</button><button
                                                                class="dt-paging-button disabled previous" role="link"
                                                                type="button" aria-controls="DataTables_Table_0"
                                                                aria-disabled="true" aria-label="Previous"
                                                                data-dt-idx="previous" tabindex="-1"><i
                                                                    class="fas fa-left"></i></button><button
                                                                class="dt-paging-button disabled next" role="link"
                                                                type="button" aria-controls="DataTables_Table_0"
                                                                aria-disabled="true" aria-label="Next"
                                                                data-dt-idx="next" tabindex="-1"><i
                                                                    class="fas fa-right"></i></button><button
                                                                class="dt-paging-button disabled last" role="link"
                                                                type="button" aria-controls="DataTables_Table_0"
                                                                aria-disabled="true" aria-label="Last"
                                                                data-dt-idx="last" tabindex="-1">»</button></nav>
                                                    </div>
                                                    <div class="dt-length"><select name="DataTables_Table_0_length"
                                                            aria-controls="DataTables_Table_0" class="dt-input"
                                                            id="dt-length-0">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select><label for="dt-length-0"> entries per page</label>
                                                    </div>
                                                </div>
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
            </div>

        </section>
    </div>
</div>