<?php

/**
 * Template Name: Page select meal
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
  <div class="card list-customer list-select-meal">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center pb-16">
          <div class="col-6 ai-center">
            <ul class="d-f pr-16">
              <li class="pr-16">
                <select name="" id="">
                  <option value="">Tuần 02/01 - 06/01</option>
                  <option value="">Tuần 02/01 - 06/01</option>
                  <option value="">Tuần 02/01 - 06/01</option>
                </select>
              </li>
              <li>
                <span class="btn btn-default">Đặt làm tuần mặc định</span>
              </li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="d-f jc-end right-action ai-center">
              <li class="mr-16"><span class="btn btn-fillter">&nbsp;</span></li>
              <li class="mr-16"><span class="btn btn-copy">&nbsp;</span></li>
              <li class="mr-16"><span class="btn btn-alert">&nbsp;</span></li>
              <li><span class="btn btn-primary disable">Lưu chọn món</span></li>
            </ul>
          </div>
        </div>
        <div class="row ai-center row-revert">
          <div class="col-6">
            <ul class="d-f jc-end ai-center">
              
              <li class="status mr-16"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
              <li class="has-child">
                <span class="btn btn-action">Thao tác</span>
                <ul>
                  <li>
                    <span class="openmodal btn-compare" data-target="#modal-compare">So sánh nhập liệu</span>
                  </li>
                  <li>
                    <span class="openmodal btn-split" data-target="#modal-split-order">Tách đơn khẩn</span>
                  </li>
                  <li><button type="button" name="action" value="export" class="js-export">Xuất dữ liệu</button></li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="d-f">
              <li class="mr-16">
                <span class="btn btn-primary">Danh sách chính</span>
              </li>
              <li class="mr-16">
                <span class="btn">Bản sao 1</span>
              </li>
              <li>
                <span class="btn openmodal" data-target="#modal-plan-history">modal-plan-history</span>
              </li>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-select-meal" class="table table-select-meal" style="width:100%">
        <thead>
          <tr class="nowrap">
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1"><span class="nowrap">Tên người nhận</span></th>
            <th data-number="2" class="text-left">SĐT</th>
            <th data-number="3">Mã</th>
            <th class="text-center" data-number="4">
              Thứ 2 <br>
              (02/01)
            </th>
            <th class="text-center" data-number="5">
              Thứ 3 <br>
              (02/01)
            </th>
            <th class="text-center" data-number="6">
              Thứ 4 <br>
              (02/01)
            </th>
            <th class="text-center" data-number="7">
              Thứ 5 <br>
              (02/01)
            </th>
            <th class="text-center" data-number="8">
              Thứ 6 <br>
              (02/01)
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $response = em_api_request('order/list', [
            'paged' => 1,
            'limit' => 3,
          ]);
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              // var_dump($record);
              if (is_array($record)) {
                $link = add_query_arg(['order_id' => $record['id']], $detail_order_url);
                $location_list = explode(',', $record['location_name']);
          ?>
                <tr class="nowrap">
                  <td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element" data-number="<?php echo $record['phone']; ?>" value="<?php echo $record['id'] ?>"></td>
                  <td data-number="1" class="text-capitalize nowrap wrap-td">
                    <div class="ellipsis"><a href="<?php echo $link ?>"><?php echo $record['customer_name']; ?></a></div>
                  </td>
                  <td data-number="2" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                  <td data-number="3"><?php echo $record['item_name'] ?></td>
                  <td data-number="4" class="wrap-td" style="min-width: 140px;">
                    <div class="nowrap ellipsis">1 - Sườn non chay chua ngọt</div>
                  </td>
                  <td data-number="5" class="wrap-td" style="min-width: 140px;">
                    <div class="nowrap ellipsis">1 - Sườn non chay chua ngọt</div>
                  </td>
                  <td data-number="6" class="wrap-td" style="min-width: 140px;">
                    <div class="nowrap ellipsis">1 - Sườn non chay chua ngọt</div>
                  </td>
                  <td data-number="7" class="wrap-td" style="min-width: 140px;">
                    <div class="nowrap ellipsis">1 - Sườn non chay chua ngọt</div>
                  </td>
                  <td data-number="8" class="wrap-td" style="min-width: 140px;">
                    <div class="nowrap ellipsis">1 - Sườn non chay chua ngọt</div>
                  </td>
                </tr>
          <?php
              } else {
                echo "Không tìm thấy dữ liệu!\n";
              }
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->
</section>

<div class="modal fade modal-warning" id="modal-warning-edit">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body pt-8 pb-16">
        <div class="d-f ai-center">
          <i class="fas fa-warning mr-8"></i>
          <p>Hãy chọn đơn hàng để <span class="txt_append">in</span>!</p>
        </div>
      </div>
      <div class="modal-footer text-center pt-16 pb-8">
        <button type="button" class="btn btn-secondary modal-close">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-compare" id="modal-compare">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
      <h4 class="modal-title">So sánh nhập liệu</h4>
    </div>
    <div class="modal-content">
      <div class="modal-body pt-16">
        <div class="ttl mb-16">Thứ 2 (02/01)</div>
        <table>
          <thead>
            <tr>
              <th>Tên khách hàng</th>
              <th>SĐT</th>
              <th>Mã</th>
              <th>Danh sách chính</th>
              <th>Bản sao 1</th>
              <th>Bản sao 2</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Khách hàng 1</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>
                <select name="" id="">
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                </select>
              </td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Khách hàng 2</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
        <div class="ttl">Thứ 3 (02/01)</div>
        <div class="text-center pt-16 pb-16">
          Không tìm thấy sai lệch nào
        </div>
        <div class="ttl mb-16">Thứ 3 (02/01)</div>
        <table>
          <thead>
            <tr>
              <th>Tên khách hàng</th>
              <th>SĐT</th>
              <th>Mã</th>
              <th>Danh sách chính</th>
              <th>Bản sao 1</th>
              <th>Bản sao 2</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Khách hàng 1</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>
                <select name="" id="">
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                </select>
              </td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Khách hàng 2</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
        <div class="ttl mb-16">Thứ 4 (02/01)</div>
        <table>
          <thead>
            <tr>
              <th>Tên khách hàng</th>
              <th>SĐT</th>
              <th>Mã</th>
              <th>Danh sách chính</th>
              <th>Bản sao 1</th>
              <th>Bản sao 2</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Khách hàng 1</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>
                <select name="" id="">
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                </select>
              </td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Khách hàng 2</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
        <div class="ttl mb-16">Thứ 5 (02/01)</div>
        <table>
          <thead>
            <tr>
              <th>Tên khách hàng</th>
              <th>SĐT</th>
              <th>Mã</th>
              <th>Danh sách chính</th>
              <th>Bản sao 1</th>
              <th>Bản sao 2</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Khách hàng 1</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>
                <select name="" id="">
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                </select>
              </td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Khách hàng 2</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
        <div class="ttl mb-16">Thứ 6 (02/01)</div>
        <table>
          <thead>
            <tr>
              <th>Tên khách hàng</th>
              <th>SĐT</th>
              <th>Mã</th>
              <th>Danh sách chính</th>
              <th>Bản sao 1</th>
              <th>Bản sao 2</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Khách hàng 1</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>
                <select name="" id="">
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                  <option value="1">Bắp bò sốt tiêu đen</option>
                </select>
              </td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Khách hàng 2</td>
              <td>0123456789</td>
              <td>SM</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>2 - Bắp bò sốt tiêu đen</td>
              <td>1 - Sườn non chay chua ngọt</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer text-right pt-16 pr-16">
      <button type="button" class="button btn-default modal-close">Huỷ</button>
      <button type="button" class="button btn-primary modal-close">Lưu và đóng</button>
    </div>
  </div>
</div>
<div class="modal fade modal-plan-history" id="modal-plan-history">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
        <h4 class="modal-title">Tuần 02/01 - 06/01</h4>
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
              <th>
                Thời gian
              </th>
              <th>
                Ngày
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            <tr>
              <td><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>Thien Phuong Bui - #0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td>01:00</td>
              <td>29/10/24</td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-split-order" id="modal-split-order">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-header">
        <h4 class="modal-title">Tách đơn khẩn</h4>
      </div>
    <div class="modal-content">
      <div class="modal-body pb-16 pt-16">
        <div class="order">
        <div class="card-primary">
          <div class="dropdown-address  pb-16">
            <p>Chọn địa chỉ giao đến</p>
              <div class="dropdown active pt-16" style="pointer-events: all;">  
                  <input type="hidden" name="ship_location_id" class="ship_location_id">                  
                  <input type="text" name="address_delivery" class="address_delivery is-disabled form-control" value="" placeholder="Vui lòng chọn">
              </div>
              <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
              <p class="fs-14 fw-regular note-admin hidden color-gray pt-4 pl-8">Note với admin: <span class="note_admin"></span></p>
              <div class="overlay-drop-menu"></div>
              <div class="dropdown-menu">
                  <div class="locations-container">
                      <div class="item" data-location_id="1">
                          <p class="fs-16 color-black other-address">45 Hoa Lan, Phường 3, Quận Phú Nhuận</p>
                      </div>
                  </div>
                  <div  class="btn-add-address d-f ai-center pb-8 pt-8 pl-8">
                      <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                  </div>
              </div>
          </div>
          <form method="post" class="hidden meal-add-location" id="meal-add-location" action="">
            <p>Nhập địa chỉ mới</p>
            <div class="row address-group location_0 address_active pt-16">
                <div class="city col-4 pb-16">
                    <select id="province" name="locations_province" class="province-select form-control" disabled="">
                        <option value="">Select Tỉnh/Thành phố</option>
                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="district" name="" class="district-select form-control text-capitalize">
                        <option value="" selected="">Quận/Huyện*</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="ward" name="locations_ward" class="ward-select form-control" disabled>
                        <option selected="">Phường/Xã*</option>
                    </select>
                </div>
                <div class="col-12 pb-16">
                    <input id="address" type="text" class="form-control address" placeholder="Địa chỉ cụ thể*" name="locations[0][address]">
                </div>
                <div class="group-note col-12">
                    <div class="note_shiper hidden pb-16">
                        <input type="text" name="locations_note_shipper" class="locations_note_shipper" placeholder="Note với shipper">
                    </div>
                    <div class="note_admin hidden pb-16">
                        <input type="text" name="locations_note_admin" class="locations_note_admin" placeholder="Note với admin">
                    </div>
                </div>
                <div class="show-group-note d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
                </div>
            </div>
        </form>
        <div class="row pb-8">
          <div class="col-6">
            Danh sách phần ăn được tách
          </div>
          <div class="col-6 text-right">
            1 đã chọn
          </div>
        </div>
        <hr>
        <div class="pt-16">
          <table class="table table-split-order" style="width: 100%;">
              <thead class="text-left">
                <tr>
                  <th>Tên khách hàng</th>
                  <th>SĐT</th>
                  <th class="text-center">Mã</th>
                  <th class="text-center">Thứ 3 <br>(03/01)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Khách hàng 1</td>
                  <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                  <td class="text-center">SM</td>
                  <td>1 - Sườn non chay chua ngọt</td>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="modal-footer text-right pt-16 pr-16">
      <button type="button" class="button btn-default modal-close">Huỷ</button>
      <button type="button" class="button btn-primary modal-close">Lưu và đóng</button>
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

    $(document).ready(function() {
      // Load checkbox states when the page loads
      // console.log('log',localStorage);
      loadCheckboxState();
      $('.filter input[type="checkbox"]').on('change', saveCheckboxState);
    });
  </script>