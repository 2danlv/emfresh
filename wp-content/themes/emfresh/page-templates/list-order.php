<?php

/**
 * Template Name: List Order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();

// cập nhật data cho customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
  $list_id = isset($_POST['list_id']) ? sanitize_textarea_field($_POST['list_id']) : '';
  $array_id = explode(',', $list_id);
  //$status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
  //$tag_post    = isset($_POST['tag']) ? intval($_POST['tag']) : 0;
  //$order_payment_status = isset($_POST['order_payment_status']) ? sanitize_textarea_field($_POST['order_payment_status']) : '';
  //vardump($tag_post);

  $updated = [];
  if (isset($_POST['tag_ids']) && count($_POST['tag_ids']) > 0) {
    $tag_radio = isset($_POST['tag_radio']) ? trim($_POST['tag_radio']) : 'add';
    
    $list_noti = [];

    foreach ($array_id as $key => $id) {
      $log_change = [];

      $customer_id = intval($id);
      $customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
      $tag_ids = custom_get_list_by_key($customer_tags, 'tag_id');

      if($tag_radio == 'remove') {
        foreach ($_POST['tag_ids'] as $tag_id) {
          $deleted = $em_customer_tag->delete([
            'tag_id' => $tag_id,
            'customer_id' => $customer_id
          ]);

          $log_change[] = sprintf('<span class="memo field-tag">Xóa Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));

          $list_noti[] = ['id' => $customer_id, 'success' => (int) $deleted];
        }
      } else {
        foreach ($_POST['tag_ids'] as $tag_id) {
          if (in_array($tag_id, $tag_ids) == false) {
            $inserted = $em_customer_tag->insert([
              'tag_id' => $tag_id,
              'customer_id' => $customer_id
            ]);

            $tag_ids[] = $tag_id;

            $log_change[] = sprintf('<span class="memo field-tag">Thêm Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));

            $list_noti[] = ['id' => $customer_id, 'success' => (int) $inserted];
          } else {
            $list_noti[] = ['id' => $customer_id, 'success' => 0];
          }
        }
      }
      
      // Log update
      if(count($log_change) > 0) {
        $em_log->insert([
          'action'        => 'Cập nhật',
          'module'        => 'em_customer',
          'module_id'     => $customer_id,
          'content'       => implode("\n", $log_change)
        ]);

      }
    }
    
    site_user_session_update('list_noti', $list_noti);
  }

  // if ($order_payment_status != '') {
  //   $customer_update_data = [
  //     'id'            => intval($id),
  //     'order_payment_status' => $order_payment_status
  //   ];
  // }
  
  // $response_update = $em_customer->update($customer_update_data);
  // if ($response_update) {
  //   $updated[$id] = 'ok';
  // }

  wp_redirect(add_query_arg([
    'code' => 200,
    'expires' => time() + 3,
    //'message' => 'Update Success',
  ], get_permalink()));
  exit();
}

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
  <div class="card list-customer list-order">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center">
              <li class="add"><a href="/customer/add-customer/"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus-svgrepo-com.svg" alt=""></a></li>
              <li><span class="btn btn-fillter">Bộ lọc</span></li>
              <li class="has-child">
                <span class="btn btn-action">Thao tác</span>
                <ul>
                  <li>
                    <span class="copyAllphone" data-target="#modal-copy">Sao chép nhanh SĐT</span>
                  </li>
                  <li>
                    <a href="/import/" class="upload">Nhập dữ liệu</a>
                  </li>
                  <li><button type="button" name="action" value="export" class="js-export">Xuất dữ liệu</button></li>
                </ul>
              </li>
              <li><span class="btn quick-print" data-target="#modal-print">In đơn</span></li>
              <li class="status"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
            </ul>
          </div>
          <div class="col-4">
            <ul class="d-f ai-center jc-end">
              <li class="has-time">
                <span class="btn btn-time">Thời gian</span>
                <ul>
                  <li><input type="text" id="datetimerange-input1"></li>
                </ul>
              </li>
              <li><span class="btn modal-button btn-column" data-target="#modal-default">Cột hiển thị</span></li>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-order" class="table table-list-order" style="width:100%">
        <thead>
          <tr class="nowrap">
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1" class="dt-orderable-none"><span class="nowrap">Mã đơn</span></th>
            <th data-number="2"><span class="nowrap">Tên khách hàng</span></th>
            <th data-number="3" class="text-left">SĐT</th>
            <th data-number="4" class="dt-orderable-none">Địa chỉ</th>
            <th data-number="5" class="dt-orderable-none">Địa chỉ</th>
            <th data-number="6" class="text-center">Phân loại</th>
            <th data-number="7" class="dt-orderable-none">Mã gói sản phẩm</th>
            <th data-number="8" class="dt-orderable-none">Ngày bắt đầu</th>
            <th data-number="9" class="dt-orderable-none">Ngày kết thúc</th>
            <th data-number="10" class="dt-orderable-none">Yêu cầu đặc biệt</th>
            <th data-number="11" class="dt-orderable-none"><span class="nowrap">Giao hàng</th>
            <th data-number="12" class="dt-orderable-none">Trạng thái <br>đơn hàng</th>
            <th data-number="13" class="dt-orderable-none">Hình thức <br>thanh toán</th>
            <th data-number="14" class="dt-orderable-none">Trạng thái <br>thanh toán</th>
            <th data-number="15" class="dt-orderable-none">Tổng tiền <br>đơn hàng</th>
            <th data-number="16" class="dt-orderable-none">Số tiền <br>còn lại</th>
            <th data-number="17" class="dt-orderable-none">Giá trị <br>đã dùng</th>
            <th data-number="18" class="dt-orderable-none">Giá trị <br>chưa dùng</th>
            <th data-number="19" class="text-center"><span class="nowrap">Nhân </span>viên</th>
            <th data-number="20" class="dt-orderable-none">Nhân <br>viên</th>
            <th data-number="21" class="text-left"><span class="nowrap">Lần cập </span><span class="nowrap">nhật cuối</span></th>
            <th data-number="22" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
            <th data-number="23" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $response = em_api_request('customer/list', [
              'active' => 1,
              'paged' => 1,
              'limit' => -1,
            ]);
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              if (is_array($record)) { // Check if each record is an array
                if ($record['active'] != '0') { ?>
                  <tr class="nowrap">
                    <td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element" data-number="<?php echo $record['phone']; ?>" value="<?php echo $record['id'] ?>"></td>
                    <td data-number="1" class="text-left">12345</td>
                    <td data-number="2" class="text-capitalize nowrap wrap-td"><div class="ellipsis"><a href="detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['customer_name']; ?></a></div></td>
                    <td data-number="3" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td data-number="4" class="text-capitalize wrap-td" style="min-width: 300px;">
                      <div class="nowrap ellipsis"><?php echo $record['address']; echo $record['address'] ? ', ' : ''; ?> <?php echo $record['ward'];  echo $record['ward'] ? ', ' : ''; echo $record['district'] ?></div>
                    </td>
                    <td data-number="5" class="text-capitalize">
                      <?php echo $record['district']; ?>
                    </td>
                    <td data-number="6" class="text-center">M</td>
                    <td data-number="7">2SM+1ET+1EP+1TA</td>
                    <td data-number="8">24/10/24</td>
                    <td data-number="9">25/10/24</td>
                    <td data-number="10" class="wrap-td" style="min-width: 290px;"><div class="ellipsis">Slimfit M: Note rau củ: cà rốt, bí đỏ, củ dền, bí ngòi</div></td>
                    <td data-number="11" class="wrap-td" style="min-width: 290px;"><div class="ellipsis">Thứ 3 - Thứ 5: 45 Hoa Lan, Phường 3, Quận Phú Nhuận</div></td>
                    <td data-number="12">Đang dùng</td>
                    <td data-number="13">Chuyển khoản</td>
                    <td data-number="14">1 phần</td>
                    <td data-number="15">60.000.000</td>
                    <td data-number="16">400.000</td>
                    <td data-number="17">12.345.000</td>
                    <td data-number="18">12.345.000</td>
                    <td data-number="19" class="text-center"><span class="avatar"><img src="<?php echo get_avatar_url($record['modified_at']); ?>" width="24" alt="<?php echo get_the_author_meta('display_name', $record['modified_at']); ?>"></span></td>
                    <td data-number="20"><?php echo get_the_author_meta('display_name', $record['modified_at']); ?></td>
                    <td data-number="21" style="min-width: 140px;"><?php echo date('H:i d/m/Y', strtotime($record['modified'])); ?></td>
                    <td data-number="22"><?php echo date('Y/m/d', strtotime($record['modified'])); ?></td>
                    <td data-number="23"><?php echo date('d/m/Y', strtotime($record['modified'])); ?></td>
                  </tr>
          <?php  }
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
<div class="modal fade" id="modal-default">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cột hiển thị</h4>
      </div>
      <div class="modal-body pt-16">
        <div class="row">
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="1" value="1" disabled checked> Tên khách hàng</label></li>
              <li><label><input type="checkbox" data-column="2" value="2" disabled checked> Số điện thoại</label></li>
              <li><label><input type="checkbox" data-column="3" value="3" checked> Địa chỉ mặc định</label></li>
              <li><label><input type="checkbox" data-column="5" value="5" checked> Trạng thái khách hàng</label></li>
              <li><label><input type="checkbox" data-column="7" value="7"> Tag phân loại</label></li>
              <li><label><input type="checkbox" data-column="8" value="8"> Giới tính</label></li>
              <li><label><input type="checkbox" data-column="9" value="9"> Note dụng cụ ăn</label></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="10" value="10" checked> Số đơn</label></li>
              <li><label><input type="checkbox" data-column="11" value="11" checked> Số ngày ăn</label></li>
              <li><label><input type="checkbox" data-column="12" value="12" checked> Số phần ăn</label></li>
              <li><label><input type="checkbox" data-column="13" value="13"> Tổng tiền đã chi</label></li>
              <li><label><input type="checkbox" data-column="14" value="14" checked> Điểm tích luỹ</label></li>
              <li><label><input type="checkbox" data-column="15" value="15"> Lịch sử đặt gần nhất</label></li>
              <li class="check_2"><label><input type="checkbox" value="16" data-column="16,18" checked> Nhân viên + Lần cập nhật cuối</label></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="form-group pt-16 text-right">
        <!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
        <button type="button" class="button btn-default modal-close">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-print" id="modal-print">
  <div class="overlay"></div>
  <div class="modal-dialog h-200">
      <div class="modal-header container">
          <div class="pl-16 pr-16">
            <h4 class="modal-title pb-16">In đơn</h4>
            <hr>
            <form method="POST" action="<?php the_permalink() ?>">
                <input type="hidden" name="list_id" class="list_id" value="">
                <div class="form-group pt-16 row">
                  <div class="col-12">
                    <p>Chọn mẫu in</p>
                    <div class="form-control field pt-16 pb-16">
                      <select class="">
                        <option value="tag">PHIẾU GIAO HÀNG</option>
                      </select>
                    </div>
                  </div>
                </div>
              </form>
              <div class="row pt-16">
                <div class="col-6">Danh sách in</div>
                <div class="col-6 text-right"><span class="list-print"></span> đơn đã chọn</div>
              </div>          
          </div>
      </div>
      <div class="modal-content">
        <div class="modal-body">
          <?php
          //$status = $em_customer->get_statuses();
          //$list_payment_status = custom_get_list_payment_status();
          ?>
          
          <table class="table table-print nowrap no-border">
            <thead>
            <tr class="text-left">
              <th>ID</th>
              <th class="text-left">Tên khách hàng</th>
              <th class="text-left">SĐT</th>
              <th>Địa chỉ giao hàng</th>
              <th style="width: 70px;" class="text-right">Bản sao</th>
            </tr>
            </thead>
            <tr>
              <td>12345</td>
              <td class="">Linh (Nu Kenny)</td>
              <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12346</td>
              <td>Linh (Nu Kenny)</td>
              <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12347</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12348</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12349</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12350</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12351</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12352</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12353</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            
          </table>
        </div>
      </div>
      <div class="modal-footer pl-16 pr-16">
        <div class="form-group pt-16 text-right">
          <button type="button" class="button btn-default modal-close">Huỷ</button>
          <button type="submit" class="button btn-primary add_post" name="add_post">In đơn</button>
        </div>
      </div>
    </div>
</div>

<script>
  //let list_tags = ['1 phần','Chưa','Rồi'];
</script>

<?php
// endwhile;

global $site_scripts;

if (empty($site_scripts)) $site_scripts = [];
$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer');
?>

<script>
  
  // Function to save checkbox states to localStorage
  function saveCheckboxState() {
    $('.filter input[type="checkbox"]').each(function() {
      const columnKey = 'column_' + $(this).val(); // Create key like "column_1", "column_2"
      localStorage.setItem(columnKey, $(this).is(':checked'));
    });
  }
  // Function to load checkbox states from localStorage
  function loadCheckboxState() {
    $('.filter input[type="checkbox"]').each(function() {
      const columnKey = 'column_' + $(this).val();
      const savedState = localStorage.getItem(columnKey);
      // If there is no saved state, set defaults for values 1, 3, and 4
      if (savedState === null) {
        if (['1', '3', '4'].includes($(this).val())) {
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
    loadCheckboxState();

    // Attach event listener to save state when checkboxes change
    $('.filter input[type="checkbox"]').on('change', saveCheckboxState);
      
  });
</script>