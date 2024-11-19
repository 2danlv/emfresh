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

    foreach ($array_id as $key => $id) {
      $log_change = [];

      $customer_id = intval($id);
      $customer_tags = $em_customer_tag->get_items(['customer_id' => $customer_id]);
      $tag_ids = custom_get_list_by_key($customer_tags, 'tag_id');

      if($tag_radio == 'remove') {
        foreach ($_POST['tag_ids'] as $tag_id) {
          $em_customer_tag->delete([
            'tag_id' => $tag_id,
            'customer_id' => $customer_id
          ]);

          $log_change[] = sprintf('<span class="memo field-tag">Xóa Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));
        }
      } else {
        foreach ($_POST['tag_ids'] as $tag_id) {
          if (in_array($tag_id, $tag_ids) == false) {
            $em_customer_tag->insert([
              'tag_id' => $tag_id,
              'customer_id' => $customer_id
            ]);

            $tag_ids[] = $tag_id;

            $log_change[] = sprintf('<span class="memo field-tag">Thêm Tag phân loại</span><span class="note-detail text-titlecase">%s</span>', $em_customer->get_tags($tag_id));
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
  if (isset($_GET['message']) && $_GET['message'] == 'Delete Success') {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
  }
  if (isset($_GET['code']) && $_GET['code'] == 200) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Cập nhật thành công</div>';
  } else if (isset($_GET['code'])) {
    echo '<div class="alert alert-warning mt-3 mb-16" role="alert">Cập nhật không thành công</div>';
  }
  ?>

  <!-- Default box -->
  <div class="card list-customer">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center">
              <li class="add"><a href="/customer/add-customer/"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus-svgrepo-com.svg" alt=""></a></li>
              <li><span class="btn btn-fillter">Bộ lọc</span></li>
              <li><span class="btn quick-edit" data-target="#modal-edit">Cập nhật nhanh</span></li>

              <li class="has-child">
                <span class="btn btn-action">Thao tác</span>
                <ul>
                  <li>
                    <a href="/import/">Nhập dữ liệu</a>
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
            <th class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th><span class="nowrap">Tên khách hàng</span></th>
            <th class="text-left">SĐT</th>
            <th>Địa chỉ</th>
            <th>Địa chỉ</th>
            <th class="text-center"><span class="nowrap">Trạng thái </span><span class="nowrap">khách hàng</span></th>
            <th>Tag <span class="nowrap">phân loại</span></th>
            <th class="text-center">Giới tính</th>
            <th class="text-center">Note <span class="nowrap">dụng cụ ăn</span></th>
            <th><span class="nowrap">Số </span>đơn</th>
            <th>Số <span class="nowrap">ngày ăn</span></th>
            <th>Số <span class="nowrap">phần ăn</span></th>
            <th><span class="nowrap">Tổng tiền </span><span class="nowrap">đã chi</span></th>
            <th class="text-left">Điểm <span class="nowrap">tích lũy</span></th>
            <th>Lịch sử <span class="nowrap">đặt gần nhất</span></th>
            <th class="text-center"><span class="nowrap">Nhân </span>viên</th>
            <th>Nhân viên</th>
            <th class="text-left"><span class="nowrap">Lần cập </span><span class="nowrap">nhật cuối</span></th>
            <th class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
            <th class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
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
                  <tr>
                    <td class="text-center"><input type="checkbox" class="checkbox-element" value="<?php echo $record['id'] ?>"></td>
                    <td class="text-capitalize nowrap"><a href="detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['customer_name']; ?></a></td>
                    <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td class="text-capitalize">
                      <div class="nowrap diachi"><?php echo $record['address']; echo $record['address'] ? ', ' : ''; ?> <?php echo $record['ward'];  echo $record['ward'] ? ', ' : ''; echo $record['district'] ?></div>
                    </td>
                    <td class="text-capitalize">
                      <?php echo $record['district']; ?>
                    </td>
                    <td><span class="tag btn btn-sm status_<?php echo $record['status']; ?>"><?php echo $record['status_name']; ?></span></td>
                    <td>
                      <?php
                        $customer_tags = $em_customer_tag->get_items(['customer_id' => $record['id']]);
                        $i = 0;
                        $len = count($customer_tags);
                        foreach ($customer_tags as $item) : $tag = $item['tag_id']; ?>
                          <span class="tag btn btn-sm tag_<?php echo $tag; ?>"><?php echo isset($list_tags[$tag]) ? $list_tags[$tag] : ''; ?></span>
                          <?php if ($i == $len - 1) {
                            echo ('');
                          } else {
                            echo ('<i class="hidden">,</i>');
                          }
                          $i++;
                        endforeach;
                      ?>
                    </td>
                    <td class="text-titlecase text-center"><?php echo $record['gender_name']; ?></td>
                    <td class="text-titlecase text-center"><?php echo $record['note_cook']; ?><!-- note dụng cụ --> </td>
                    <td class="text-left"><!-- note số đơn --></td>
                    <td class="text-left"><!-- note số ngày ăn --></td>
                    <td class="text-left"><!-- note số phần ăn --></td>
                    <td class="text-left"><!-- note tổng tiền --></td>
                    <td class="text-left"><?php echo $record['point']; ?></td>
                    <td><!-- note lịch sử đặt gần nhất --></td>
                    <td class="text-right"><span class="avatar"><img src="<?php echo get_avatar_url($record['modified_at']); ?>" width="24" alt="<?php echo get_the_author_meta('display_name', $record['modified_at']); ?>"></span></td>
                    <td><?php echo get_the_author_meta('display_name', $record['modified_at']); ?></td>
                    <td class="nowrap"><?php echo date('H:i d/m/Y', strtotime($record['modified'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($record['modified'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($record['modified'])); ?></td>
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


<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cột hiển thị</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="1" value="1" disabled checked> Tên khách hàng</label></li>
              <li><label><input type="checkbox" data-column="2" value="2" disabled checked> Số điện thoại</label></li>
              <li><label><input type="checkbox" data-column="3" value="3" checked> Địa chỉ mặc định</label></li>
              <li><label><input type="checkbox" data-column="5" value="5" checked> Trạng thái khách hàng</label></li>
              <li><label><input type="checkbox" data-column="6" value="6"> Tag phân loại</label></li>
              <li><label><input type="checkbox" data-column="7" value="7"> Giới tính</label></li>
              <li><label><input type="checkbox" data-column="8" value="8"> Note dụng cụ ăn</label></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="9" value="9" checked> Số đơn</label></li>
              <li><label><input type="checkbox" data-column="10" value="10" checked> Số ngày ăn</label></li>
              <li><label><input type="checkbox" data-column="11" value="11" checked> Số phần ăn</label></li>
              <li><label><input type="checkbox" data-column="12" value="12"> Tổng tiền đã chi</label></li>
              <li><label><input type="checkbox" data-column="13" value="13" checked> Điểm tích luỹ</label></li>
              <li><label><input type="checkbox" data-column="14" value="14"> Lịch sử đặt gần nhất</label></li>
              <li class="check_2"><label><input type="checkbox" value="15" data-column="15,17" checked> Nhân viên + Lần cập nhật cuối</label></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="form-group pt-16 text-right">
        <!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
        <button type="button" class="button btn-primary modal-close">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cập nhật nhanh</h4>
      </div>
      <div class="modal-body">
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
            <div class="col-12">
              <div class="d-f pt-8 ai-center">
                <input type="radio" name="tag_radio" id="add" value="add" checked> <label for="add" class="pl-4 pr-8">Thêm tag phân loại</label>
              </div>
              <div class="d-f ai-center">
                <input type="radio" name="tag_radio" id="remove" value="remove"> <label class="pl-4" for="remove">Gỡ tag phân loại</label>
              </div>

            </div>
            <div class="col-12 pt-16">
              <select class="form-control list-tag" name="tag_ids[]" style="width: 100%;">
              <option value="" selected>Chọn tag cần cập nhật</option>
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
      }
    });
  }

  $(document).ready(function() {
    // Load checkbox states when the page loads
    loadCheckboxState();

    // Attach event listener to save state when checkboxes change
    $('.filter input[type="checkbox"]').on('change', saveCheckboxState);
    
    $('#modal-edit .btn-primary.add_post').on('click', function(e) {
			if ($('.list-tag').val() == '') {
        $(".alert-form").show();
				$(".alert-form").text('Chưa chọn tag cần cập nhật');
				return false;
			} else {
				$(".alert-form").hide();
			}
    });
  });
</script>