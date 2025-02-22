<?php

/**
 * Template Name: List Meal plan
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
  <div class="card list-customer list-order">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center">
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
              <li class="status"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
            </ul>
          </div>
          <div class="col-4 text-right">
            <div class="date-txt">Tháng 10, 2024</div>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-meal-plan" class="table table-list-meal-plan" style="width:100%">
        <thead>
          <tr class="nowrap">
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1"><span class="nowrap">Tên khách hàng</span></th>
            <th data-number="2" class="text-left">SĐT</th>
            <th data-number="3" class="text-center">Số đơn</th>
            <th data-number="4" class="text-center">Phân loại</th>
            <th data-number="5">Mã gói sản phẩm</th>
            <th data-number="6">Trạng thái <br>đơn hàng</th>
            <th data-number="7">Hình thức <br>thanh toán</th>
            <th data-number="8">Trạng thái <br>thanh toán</th>
            <th data-number="9">Số tiền <br>còn lại</th>
            <th data-number="10">
              <ul class="d-f date-group">
                <li>
                  1
                </li>
                <li>
                  2
                </li>
                <li class="active">
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
          <?php
            $response = em_api_request('order/list', [
              'paged' => 1,
              'limit' => -1,
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
                    <td data-number="1" class="text-capitalize nowrap wrap-td"><div class="ellipsis"><a href="<?php echo $link ?>"><?php echo $record['customer_name']; ?></a></div></td>
                    <td data-number="2" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td data-number="3" class="text-center">
                      <?php echo $record['total_quantity'] ?>
                    </td>
                    <td data-number="4" class="text-center"><?php echo strtoupper($record['type_name']) ?></td>
                    <td data-number="5"><?php echo $record['item_name'] ?></td>
                    <td data-number="6"><span class="status_order status_order-<?php echo $record['status']; ?>"><?php echo $record['status_name'] ?></span></td>
                    <td data-number="7"><?php echo $record['payment_method_name'] ?></td>
                    <td data-number="8"><span class="status_order status_pay-<?php echo $record['payment_status']; ?>"><?php echo $record['payment_status_name'] ?></span></td>
                    <td data-number="9"><?php echo $record['remaining_amount'] > 0 ? number_format($record['remaining_amount']) : 0 ?></td>
                    <td data-number="10" class="wrap-date">
                    <ul class="d-f date-group">
                      <li><span>1</span></li>
                      <li class="orange"><span>1</span></li>
                      <li><span>1</span></li>
                      <li class="white"><span></span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                      <li><span>1</span></li>
                    </ul>
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
              <li><label><input type="checkbox" data-column="0" value="" disabled checked>Mã đơn</label></li>
              <li><label><input type="checkbox" data-column="1" value="" disabled checked>Tên khách hàng</label></li>
              <li><label><input type="checkbox" data-column="2" value="" disabled checked> Số điện thoại</label></li>
              <li><label><input type="checkbox" data-column="3" value="" disabled checked> Địa chỉ</label></li>
              <li><label><input type="checkbox" data-column="6" value="6">Phân loại</label></li>
              <li><label><input type="checkbox" data-column="7" value="7" checked>Mã gói sản phẩm</label></li>
              <li><label><input type="checkbox" data-column="8" value="8">Ngày bắt đầu</label></li>
              <li><label><input type="checkbox" data-column="9" value="9">Ngày kết thúc</label></li>
              <li><label><input type="checkbox" data-column="10" value="10">Yêu cầu đặc biệt</label></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="11" value="11">Giao hàng</label></li>
              <li><label><input type="checkbox" data-column="12" value="12"checked >Trạng thái đơn hàng</label></li>
              <li><label><input type="checkbox" data-column="13" value="13">Hình thức thanh toán</label></li>
              <li><label><input type="checkbox" data-column="14" value="14">Trạng thái thanh toán</label></li>
              <li><label><input type="checkbox" data-column="15" value="15">Tổng tiền đơn hàng</label></li>
              <li><label><input type="checkbox" data-column="16" value="16">Số tiền còn lại</label></li>
              <li><label><input type="checkbox" data-column="17" value="17">Giá trị đã dùng <!-- (admin only) --></label></li>
              <li><label><input type="checkbox" data-column="18" value="18">Giá trị chưa dùng <!-- (admin only) --></label></li>
              <li class="check_2"><label><input type="checkbox" value="19" data-column="19,21" checked>Nhân viên + Lần cập nhật cuối</label></li>
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
        if (['7', '12','19'].includes($(this).val())) {
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