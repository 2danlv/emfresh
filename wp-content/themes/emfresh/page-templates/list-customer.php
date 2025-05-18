<?php

/**
 * Template Name: List-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();
$list_orders = [];

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
  <div class="card list-customer">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center">
              <li class="add"><a href="<?php echo home_url('customer/add-customer') ?>"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus-svgrepo-com.svg" alt=""></a></li>
              <li class="ml-8 mr-8"><span class="btn btn-fillter">Bộ lọc</span></li>
              <li class="mr-8"><span class="btn quick-edit" data-target="#modal-edit">Cập nhật nhanh</span></li>

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
      <table id="list-customer" class="table table-list-customer" style="width:100%">
        <thead>
          <tr>
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1"><span class="nowrap">Tên khách hàng</span></th>
            <th data-number="2" class="text-left">SĐT</th>
            <th data-number="3">Địa chỉ</th>
            <th data-number="4">Địa chỉ</th>
            <th data-number="5" class="text-center"><span class="nowrap">Trạng thái </span><span class="nowrap">khách hàng</span></th>
            <th data-number="6" class="dt-orderable-none">Tag <span class="nowrap">phân loại</span></th>
            <th data-number="7" class="dt-orderable-none">Tag phân loại</th>
            <th data-number="8" class="text-center">Giới tính</th>
            <th data-number="9" class="text-center">Note <span class="nowrap">dụng cụ ăn</span></th>
            <th data-number="10" class="text-left"><span class="nowrap">Số </span>đơn</th>
            <th data-number="11" class="text-left">Số <span class="nowrap">ngày ăn</span></th>
            <th data-number="12" class="text-left">Số <span class="nowrap">phần ăn</span></th>
            <th data-number="13"><span class="nowrap">Tổng tiền </span><span class="nowrap">đã chi</span></th>
            <th data-number="14" class="text-left">Điểm <span class="nowrap">tích lũy</span></th>
            <th data-number="15">Lịch sử <span class="nowrap">đặt gần nhất</span></th>
            <th data-number="16" class="text-center"><span class="nowrap">Nhân </span>viên</th>
            <th data-number="17">Nhân viên</th>
            <th data-number="18" class="text-left"><span class="nowrap">Lần cập </span><span class="nowrap">nhật cuối</span></th>
            <th data-number="19" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
            <th data-number="20" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $response = em_api_request('customer/list', [
              'active' => 1,
              'paged' => 1,
              'limit' => -1,
            ]);

            $order_date_from = isset($_GET['order_date_from']) ? trim($_GET['order_date_from']) : '';
            $order_date_to = isset($_GET['order_date_to']) ? trim($_GET['order_date_to']) : '';
            
            $admin_role      = wp_get_current_user()->roles;
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              if (is_array($record)) { // Check if each record is an array
                if ( $record[ 'active' ] != '0' ) {
                  $response_order = em_api_request( 'order/list', [ 
                    'paged'       => 1,
                    'customer_id' => $record[ 'id' ],
                    'date_from'   => $order_date_from,
                    'date_to'     => $order_date_to,
                    'limit'       => -1,
                    ] );
                  if ( count( $response_order[ 'data' ] ) > 0 ) {
                    $list_orders = array_merge( $list_orders, $response_order[ 'data' ] );
                  }

                  $total_order_days  = array_sum( array_column( $response_order[ 'data' ], 'ship_days' ) );
                  $total_quantity    = array_sum( array_column( $response_order[ 'data' ], 'total_quantity' ) );
                  $total_ship        = array_sum( array_column( $response_order[ 'data' ], 'ship_amount' ) );
                  $total_amount      = array_sum( array_column( $response_order[ 'data' ], 'total_amount' ) );
                  $total_order_money = $total_amount + $total_ship;
                  $dateStarts        = array_column( $response_order[ 'data' ], 'date_start' );
                  $statuses          = array_column( $response_order[ 'data' ], 'status_name' );
                  $allCompleted      = true;
                  if ( !empty( $dateStarts ) ) {
                    $max_date = date( 'd/m/Y', strtotime( max( $dateStarts ) ) );
                  }
                  else {
                    // Xử lý khi không có giá trị date_start nào (ví dụ: gán giá trị mặc định hoặc thông báo lỗi)
                    $max_date = null; // Hoặc giá trị phù hợp khác
                  }
                  if ( count( $statuses ) > 0 || !empty( $admin_role ) && $admin_role[ 0 ] == 'administrator') {
                    foreach ( $statuses as $value ) {
                      if ( $value == 'Hoàn tất' ) {
                        $allCompleted = false;
                        break;
                      }
                      else {
                        $allCompleted = true;
                        break;
                      }
                    }

                    if ( $allCompleted ) {
                      ?>
                  <tr>
                    <td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element" data-number="<?php echo $record[ 'phone' ]; ?>" value="<?php echo $record[ 'id' ] ?>"></td>
                    <td data-number="1" class="text-capitalize nowrap wrap-td"><div class="ellipsis"><a href="detail-customer/?customer_id=<?php echo $record[ 'id' ] ?>"><?php echo $record[ 'customer_name' ]; ?></a></div></td>
                    <td data-number="2" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record[ 'phone' ]; ?>"><?php echo $record[ 'phone' ]; ?></span></td>
                    <td data-number="3" class="text-capitalize wrap-td" style="min-width: 300px;">
                      <div class="nowrap ellipsis"><?php echo $record[ 'address' ];
                      echo $record[ 'address' ] ? ', ' : ''; ?> <?php echo $record[ 'ward' ];
                      echo $record[ 'ward' ] ? ', ' : '';
                      echo $record[ 'district' ] ?></div>
                    </td>
                    <td data-number="4" class="text-capitalize">
                      <?php echo $record[ 'district' ]; ?>
                    </td>
                    <td data-number="5">
                    <?php
                    if ( count( $statuses ) > 0 ) {
                      foreach ( $statuses as $value ) {
                        if ( $value !== 'Hoàn tất' ) {
                          $allCompleted = false;
                          break;
                        }
                      }
                      if ( $allCompleted && !empty( $admin_role ) && $admin_role[ 0 ] == 'administrator' ) { ?>
                        <span class="tag btn btn-sm status_2">Hết dùng</span>
                      <?php }
                      else { ?>
                        <span class="tag btn btn-sm status_1">Đang dùng</span>
                      <?php }
                    }
                    ?>  
                    
                  </td>
                    <?php
                    $customer_tags = $em_customer_tag->get_items( [ 'customer_id' => $record[ 'id' ] ] );
                    $html          = [];
                    $html_tag      = [];
                    $title         = [];
                    $count         = 0;

                    $remainingTag      = array_slice( $customer_tags, 2 );
                    $countRemainingTag = count( $remainingTag );
                    $firstItemTag      = true;
                    foreach ( $customer_tags as $item ) {
                      $html[] = '<span class="tag btn btn-sm tag_' . $item[ 'tag_id' ] . '">' . $em_customer->get_tags( $item[ 'tag_id' ] ) . '</span>';
                    }

                    echo '<td data-number="6">' . implode( '', $html ) . '</td>';

                    echo '<td data-number="7"><div class="wrap-tags">';
                    foreach ( $customer_tags as $item_limit ) {
                      $html_tag[] = '<span class="tag btn btn-sm tag_' . $item_limit[ 'tag_id' ] . '">' . $em_customer->get_tags( $item_limit[ 'tag_id' ] ) . '</span>';
                      $count++;
                      if ( $count == 2 ) {
                        break;
                      }
                    }

                    echo implode( '', $html_tag );
                    if ( $countRemainingTag > 0 ) {
                      echo '<span class="badge tooltip" title="';
                      foreach ( $remainingTag as $items_ ) {
                        if ( $firstItemTag ) {
                          $title[] .= $em_customer->get_tags( $items_[ 'tag_id' ] );
                          $firstItemTag = false;
                        }
                        else {
                          $title[] .= ', ' . $em_customer->get_tags( $items_[ 'tag_id' ] );
                        }
                      }
                      echo implode( '', $title ) . '">+' . $countRemainingTag . '</span>';
                    }
                    echo '</div></td>';
                    ?>

                    <td data-number="8" class="text-center"><?php echo $record[ 'gender_name' ]; ?></td>
                    <td data-number="9" class="text-center"><?php echo $record[ 'note_cook' ]; ?></td>
                    <td data-number="10" class="text-left"><?php echo count( $response_order[ 'data' ] ); ?></td>
                    <td data-number="11" class="text-left"><?php echo $total_order_days; ?></td>
                    <td data-number="12" class="text-left"><?php echo $total_quantity; ?></td>
                    <td data-number="13" class="text-left"><?php echo number_format( $total_order_money ); ?></td>
                    <td data-number="14" class="text-left"><?php echo $total_order_days; ?></td>
                    <td data-number="15"><?php echo $max_date; ?></td>
                    <td data-number="16" class="text-right"><span class="avatar"><img src="<?php echo get_avatar_url( $record[ 'modified_at' ] ); ?>" width="24" alt="<?php echo get_the_author_meta( 'display_name', $record[ 'modified_at' ] ); ?>"></span></td>
                    <td data-number="17"><?php echo get_the_author_meta( 'display_name', $record[ 'modified_at' ] ); ?></td>
                    <td data-number="18" style="min-width: 146px;"><?php echo date( 'H:i d/m/Y', strtotime( $record[ 'modified' ] ) ); ?></td>
                    <td data-number="19"><?php echo date( 'Y/m/d', strtotime( $record[ 'modified' ] ) ); ?></td>
                    <td data-number="20"><?php echo date( 'd/m/Y', strtotime( $record[ 'modified' ] ) ); ?></td>
                  </tr>
          <?php }
                  }
                }
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
          <p>Hãy chọn khách hàng để <span class="txt_append">chỉnh sửa</span> nhanh!</p>
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
<div class="modal fade" id="modal-edit">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cập nhật nhanh</h4>
      </div>
      <div class="modal-body pt-16">
        <?php
        //$status = $em_customer->get_statuses();
        //$list_payment_status = custom_get_list_payment_status();
        $tag = $em_customer->get_tags();
        ?>
        <div class="alert-form alert alert-warning mb-16 hidden" ></div>
        <form method="POST" action="<?php the_permalink() ?>">
          <input type="hidden" name="list_id" class="list_id" value="">
          <div class="form-group row">
            <div class="col-12">
              <select class="form-control field">
                <option value="tag">Tag phân loại</option>
              </select>
            </div>
            <div class="col-12 pt-16">
              <div class="d-f tag-radio  ai-center pb-2">
                <input type="radio" name="tag_radio" id="add" value="add" checked> <label for="add" class="pl-4 pr-8">Thêm tag phân loại</label>
              </div>
              <div class="d-f tag-radio ai-center deactive">
                <input type="radio" name="tag_radio" id="remove" value="remove"> <label class="pl-4" for="remove">Gỡ tag phân loại</label>
              </div>

            </div>
            <div class="col-12 pt-16">
              <select class="form-control list-tag" name="tag_ids[]" style="width: 100%;" required>
              <option value="" selected disabled>Chọn tag cần cập nhật</option>
                <?php
                foreach ($tag as $key => $value) { ?>
                  <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group pt-16 text-right">
            <button type="button" class="button btn-default modal-close">Huỷ</button>
            <button type="submit" class="button btn-primary add_post" name="add_post">Áp dụng</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php

get_template_part('parts/popup/result', 'update');

$html = [];
foreach ($list_tags as $key => $value) { 
   $html[] = "'".$value."'"; 
} ?>
<script>
  let list_tags = [<?php echo implode(',', $html); ?>];
  let list_orders = <?php echo json_encode($list_orders, JSON_UNESCAPED_UNICODE); ?>;
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
    $('.tag-radio').click(function (e) { 
      //e.preventDefault();
      $('.tag-radio').addClass('deactive');
      $(this).removeClass('deactive');
    });
    $('#modal-edit .btn-primary.add_post').on('click', function(e) {
			if ($('.list-tag').val() == '') {
        $(".alert-form").show();
				$(".alert-form").text('Chưa chọn tag cần cập nhật');
				return false;
			} else {
				$(".alert-form").hide();
			}
    });
    
    var $modalBody = $('.modal-result_update .modal-body');
    $('.modal-result_update .nav li.nav-item').click(function() {
      var rel = $(this).attr('rel');
      $('.modal-result_update .nav li.nav-item').removeClass('active');
      $(this).addClass('active');
      $modalBody.find('.row').hide();
      if (rel === 'all') {
        $modalBody.find('.row').show();
      } else {
        $modalBody.find('.row.' + rel).show();
      }
    });
  });
</script>