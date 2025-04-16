<?php

/**
 * Template Name: Page meal group
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log, $em_location;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();
$detail_order_url = site_order_edit_link();


get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();

?>
<!-- Main content -->
<section class="content">
  <?php
  if (isset($_GET['message']) && $_GET['message'] == 'Delete Success' && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
  }
  if (!empty($_GET['code']) && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    // echo '<div class="alert alert-success mt-3 mb-16" role="alert">'
    //     . sprintf('Cập nhật%s thành công', $_GET['code'] != 200 ? ' không' : '')
    //     .'</div>';
  }
  ?>

  <!-- Default box -->
  <div class="card list-customer detail-meal">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        
        <div class="row ai-center">
          <div class="col-6">
            <ul class="d-f  ai-center">
              <li>
                <span class="btn btn-show-count">Bộ đếm</span>
              </li>
            </ul>
          </div>
          
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-select-meal" class="table table-detail-meal mt-16">
        <thead>
          <tr class="nowrap">
            <th data-number="1"><span class="nowrap">Tên khách hàng</span></th>
            <th data-number="2"><span class="nowrap">Địa chỉ</span></th>
            <th data-number="3" class="text-left">Mã <br>sản phẩm</th>
            <th data-number="4">Phân <br>loại</th>
            <th data-number="5">Trạng thái <br>đặt đơn</th>
            <th>
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="top">
            <td>Vy (Vy Vy)</td>
            <td class="nowrap">Vy (Vy Vy)</td>
            <td>5SM+1EP</td>
            <td>M,W</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="accordion-tit_table">
            <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a></td>
            <td></td>
            <td>1SM</td>
            <td>M</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="accordion-content_table">
            <td>Vy (Vy Vy)</td>
            <td></td>
            <td>5SM</td>
            <td>M</td>
            <td></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="accordion-tit_table">
            <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a></td>
            <td></td>
            <td>1SM</td>
            <td>M</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="accordion-content_table">
            <td>Vy (Vy Vy)</td>
            <td></td>
            <td>5SM</td>
            <td>M</td>
            <td></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="top">
            <td>Vy (Vy Vy)</td>
            <td class="nowrap">Vy (Vy Vy)</td>
            <td>5SM+1EP</td>
            <td>M,W</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="accordion-tit_table">
            <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a></td>
            <td></td>
            <td>1SM</td>
            <td>M</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="accordion-content_table">
            <td>Vy (Vy Vy)</td>
            <td></td>
            <td>5SM</td>
            <td>M</td>
            <td></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="accordion-tit_table">
            <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a></td>
            <td></td>
            <td>1SM</td>
            <td>M</td>
            <td class="text-center">Đặt đơn</td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          <tr class="accordion-content_table">
            <td>Vy (Vy Vy)</td>
            <td></td>
            <td>5SM</td>
            <td>M</td>
            <td></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li>
                  3
                </li>
                <li>
                  4
                </li>
                <li>
                  5
                </li>
                <li>
                  6
                </li>
                <li>
                  7
                </li>
                <li>
                  8
                </li>
                <li>
                  9
                </li>
                <li>
                  10
                </li>
                <li>
                  11
                </li>
                <li>
                  12
                </li>
                <li>
                  13
                </li>
                <li>
                  14
                </li>
                <li>
                  15
                </li>
                <li>
                  16
                </li>
                <li>
                  17
                </li>
                <li>
                  18
                </li>
                <li>
                  19
                </li>
                <li>
                  20
                </li>
                <li>
                  21
                </li>
                <li>
                  22
                </li>
                <li>
                  23
                </li>
                <li>
                  24
                </li>
                <li>
                  25
                </li>
                <li>
                  26
                </li>
                <li>
                  27
                </li>
                <li>
                  28
                </li>
                <li>
                  29
                </li>
                <li>
                  30
                </li>
                <li>
                  31
                </li>
              </ul>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
  <div class="group-btn-bottom">
  <div class="count-group">
    <div class="row">
      <div class="col-10">
        <div class="ttl pb-8">
          Bộ đếm
        </div>
      </div>
      <div class="col-2 text-right">
        <span class="count-close"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
      </div>
    </div>
    <hr>
    <div class="card-primary pt-16">
      <div class="row">
        <div class="col-5">
          <div class="row pb-16">
            <div class="col-6">
              <input type="text" placeholder="Tên người nhận (chọn ô ở trên)">
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-6"><input type="text" placeholder="Mã đơn hàng"></div>
                <div class="col-6"><input type="text" placeholder="Mã sản phẩm"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <input type="text" placeholder="Ngày bắt đầu (chọn ô ở trên)">
            </div>
            <div class="col-6">
              <input type="text" placeholder="Ngày kết thúc">
            </div>
          </div>
        </div>
        <div class="col-2 col-btn ai-end d-f">
          <div class="btn btn-primary  openmodal" data-target="#modal-warning-input">Xác nhận</div>
        </div>
        <div class="col-5 d-f col-txt text-right">
          <p>Tổng ngày ăn: <span>-</span></p>
          <p>Tổng phần ăn: <span>-</span></p>
        </div>
      </div>
    </div>
    
  </div>
  <div class="bottom-btn row ">
    <div class="col-6">
      <span class="btn btn-secondary openmodal" data-target="#modal-plan-history">Lịch sử thao tác</span>
    </div>
    <div class="col-6 text-right">
      <span class="btn btn-primary">Đi đến chọn món</span>
      </div>
  </div>
</div>
  <!-- /.card-body -->
</section>
<div class="modal fade modal-warning-input" id="modal-warning-input">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body pt-8 pb-16">
        <div class="d-f">
          <i class="fas fa-warning mr-8"></i>
          <div>
            <p class="pb-4"><b>Cảnh báo</b></p>
          <p>Bạn nhập thiếu phần ăn: 02 <br>
          Vui lòng kiểm tra lại.</p>
          </div>
          
        </div>
        
      </div>
      <div class="modal-footer text-center pt-16 pb-8">
        <p class="pb-16"><button type="button" class="btn btn-primary modal-close">Quay lại chỉnh sửa</button></p>
        <p class="pb-16"><button type="button" class="btn btn-secondary modal-close">Tạo đơn mới & giảm giá</button></p>
        <p><button type="button" class="btn btn-secondary modal-close">Chuyển sang bảo lưu</button></p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-plan-history" id="modal-plan-history">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
        <h4 class="modal-title">Vy (Vy Vy)</h4>
        <span class="modal-close"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
      </div>
    <div class="modal-content">
      <div class="modal-body pb-16">
        <table class="table regular_pay">
          <thead class="text-left">
            <tr>
              <th>
                Người thực hiện
              </th>
              <th>
                Trang
              </th>
              <th>
                Hành động
              </th>
              <th>
                Đối tượng
              </th>
              <th>
                Mô tả
              </th>
              <th class="text-center">
                Thời gian
              </th>
              <th class="text-center">
                Ngày
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td><div class="d-f ai-center"><i class="fas show-detail"></i> <a href="#">0001</a> - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


  <?php
  // endwhile;

  global $site_scripts;

  if (empty($site_scripts)) $site_scripts = [];
  $site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
  $site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

  get_footer('customer');
  ?>
  <script src="<?php site_the_assets(); ?>js/order.js"></script>
  <script>
    // Function to save checkbox states to localStorage
    function saveCheckboxState() {
      $('.filter input[type="checkbox"]').each(function() {
        const columnKey_order = 'column_order_' + $(this).val(); // Create key like "column_1", "column_2"
        localStorage.setItem(columnKey_order, $(this).is(':checked'));
      });
    }
    // Function to load checkbox states from localStorage
    function loadCheckboxState() {
      $('.filter input[type="checkbox"]').each(function() {
        const columnKey_order = 'column_order_' + $(this).val();
        const savedState = localStorage.getItem(columnKey_order);
        if (savedState === null) {
          if (['7', '12', '19'].includes($(this).val())) {
            $(this).prop('checked', true);
          }
        } else {
          $(this).prop('checked', savedState === 'true');
          //$('.btn-column').addClass('active');
        }
      });
    }
    function accordion_table() {
      $('table .accordion-tit_table')
      .off()
      .on('click', function () {
        var item = $(this).toggleClass('on')
        while (item.next().hasClass('accordion-content_table')) {
          item = item.next()
          
          item.toggleClass('is-active').find('td > div').slideToggle(400)
        }
      })
      
      $('table .accordion-content_table')
      .addClass('d-table-row')
      .find('td')
      .each(function () {
        let td = $(this)
        
        if (td.find('> div').length == 0) {
          td.html('<div>' + td.html() + '</div>')
        }
      })
    }
    $(document).ready(function() {
      // Load checkbox states when the page loads
      // console.log('log',localStorage);
      loadCheckboxState();
      $('.filter input[type="checkbox"]').on('change', saveCheckboxState);
      accordion_table();
      $('.btn-show-count').click(function (e) { 
        e.preventDefault();
        $(this).addClass('selected');
        $('.count-group').show();
      });
      $('.count-group .count-close').click(function (e) { 
        e.preventDefault();
        $('.count-group').hide();
        $('.btn-show-count').removeClass('selected');
      });
    });
  </script>