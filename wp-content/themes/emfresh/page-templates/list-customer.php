<?php

/**
 * Template Name: List-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer,$em_order;
$list_order_status = $em_order->get_statuses();

// cập nhật data cho customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
  $list_id = isset($_POST['list_id']) ? sanitize_textarea_field($_POST['list_id']) : '';
  $array_id = explode(',', $list_id);
  $status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
  $tag_post    = isset($_POST['tag']) ? intval($_POST['tag']) : 0;
  $order_payment_status = isset($_POST['order_payment_status']) ? sanitize_textarea_field($_POST['order_payment_status']):'';
  
  $updated = [];
  foreach ($array_id as $key => $id) {
    if ($status_post != 0) {
      $customer_update_data = [
        'id'            => intval($id),
        'status'        => $status_post
      ];
    }
    if ($tag_post !=0) {
      $customer_update_data = [
        'id'            => intval($id),
        'tag'           => $tag_post
      ];
    }
    if ($order_payment_status != '') {
      $customer_update_data = [
        'id'            => intval($id),
        'order_payment_status' => $order_payment_status
      ];
    }
    $response_update = $em_customer->update($customer_update_data);
    if($response_update) {
      $updated[$id] = 'ok';
    }
  }

  wp_redirect(add_query_arg([
    'code' => count($updated) > 0 ? 200 : 400,
    'message' => 'Update Success',
  ], get_permalink()));
  exit();
}

get_header('customer');
// Start the Loop.
// while ( have_posts() ) : the_post();

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php the_title(); ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?php the_title(); ?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
  <?php
    if (isset($_GET['message']) && $_GET['message'] == 'Delete Success') {
      echo '<div class="alert alert-warning mt-3" role="alert">Xóa khách hàng thành công</div>';
    }
    if (isset($_GET['code']) && $_GET['code'] == 200) {
      echo '<div class="alert alert-success mt-3" role="alert">Cập nhật thành công</div>';
    } else if (isset($_GET['code'])) {
      echo '<div class="alert alert-warning mt-3" role="alert">Cập nhật không thành công</div>';
    }
    ?>
    <!-- Default box -->
    <div class="card">
      <div class="card-body">
        <div class="mb-4">
          <form class="em-importer d-inline-block" data-name="customer" action="<?php the_permalink() ?>" method="post">
            <div class="form-group">
              <button type="button" name="action" value="export" class="btn btn-success js-export"><i class="fas fa-download"></i> Export</button>
            </div>
            <?php wp_nonce_field('importoken', 'importoken', false); ?>
          </form>
          <span class="ml-2"><a href="/import/" class="btn btn-primary"><i class="fas fa-upload"></i> ImportCSV</a></span>
          <span class="ml-2"><span class="btn btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fas fa-eye"></i> Cột hiển thị</span></span>
          <span class="ml-2"><span class="btn btn-info quick-edit" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Chỉnh sửa nhanh</span></span>
        </div>
        <table id="example1" class="table table-bordered table-striped text-capitalize">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkall" id="checkall" /></th>
              <th>Tên <span class="nowrap">khách hàng</span></th>
              <th>Số <span class="nowrap">điện thoại</span></th>
              <th class="nowrap">Địa chỉ</th>
              <th>Trạng thái <span class="nowrap">đặt đơn</span></th>
              <th>Điểm <span class="nowrap">tích lũy</span></th>
              <th>Tag <span class="nowrap">phân loại</span></th>
              <th>Trạng thái <span class="nowrap">thanh toán</span></th>
              <th>Người cập nhật cuối</th>
              <th>Thời gian nhật cuối</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $customer_filter = [
              'paged' => 1,
              'limit' => -1,
            ];
            $response = em_api_request('customer/list', $customer_filter);
            if (isset($response['data']) && is_array($response['data'])) {
              // Loop through the data array and print each entry
              foreach ($response['data'] as $record) {
                if (is_array($record)) { // Check if each record is an array
            ?>
                  <tr>
                    <td><input type="checkbox" class="checkbox-element" value="<?php echo $record['id'] ?>"></td>
                    <td><a href="detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['nickname']; ?></a></td>
                    <td><span class="copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td>
                    <?php
                    // lấy danh sách location
                    $location_filter = [
                      'customer_id' => $record['id'],
                      'limit' => 1,
                    ];
                    $response_get_location = em_api_request('location/list', $location_filter);
                foreach ($response_get_location['data'] as $index => $location) { 
                  ?><?php if($location['active'] == 1) {?>
                <p>
                  <?php echo $location['address'] ?>,
                  <?php echo $location['ward'] ?>,
                  <?php echo $location['district'] ?>,<br>
                  <?php echo $location['city'] ?> 
                  </p>
                  <?php } ?>
               
              <?php
                  
                }
              ?>
                    </td>
                    <td><span class="tag btn btn-sm status_<?php echo $record['status']; ?>"><?php echo $record['status_name']; ?></td>
                    </td>
                    <td><?php echo $record['point']; ?>
                    <td><span class="tag btn btn-sm tag_<?php echo $record['tag']; ?>"><?php echo $record['tag_name']; ?></span></td>
                    <td><span class="tag btn btn-sm order_<?php echo $record['order_payment_status']; ?>"><?php echo $record['payment_status_name']; ?></span></td>
                    <td><?php echo $record['modified_author'] != '' ? $record['modified_author'] : $record['created_author']; ?></td>
                    <td><?php echo $record['modified']; ?>
                    </td>
                  </tr>
            <?php  } else {
                  echo "Invalid record format.\n";
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
</div>
<div class="modal fade" id="modal-default" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-filter"></i> Chọn cột hiển thị!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="filter list-unstyled text-capitalize">
          <!-- <li><label><input type="checkbox" data-column="1" checked> Tên khách hàng</label></li> -->
          <li><label><input type="checkbox" data-column="2" checked> Số điện thoại</label></li>
          <li><label><input type="checkbox" data-column="3" checked> Địa chỉ</label></li>
          <li><label><input type="checkbox" data-column="4" checked> Trạng thái đặt đơn</label></li>
          <li><label><input type="checkbox" data-column="5"> Điểm tích lũy</label></li>
          <li><label><input type="checkbox" data-column="6"> Tag phân loại</label></li>
        </ul>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog text-capitalize">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">bulk edit!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <?php 
      $status = $em_customer->get_statuses();
      $list_payment_status = custom_get_list_payment_status();
      $tag = $em_customer->get_tags();
      ?>
        <form method="POST" action="<?php the_permalink() ?>">
          <input type="hidden" name="list_id" class="list_id" value="">
          <div class="form-group row">
            <div class="col-sm-3">field</div>
            <div class="col-sm-9">
              <select class="form-control field">
                <option value="tag">Tag Phân Loại</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3">Value</div>
            <div class="col-sm-9">
              
              <div class="box tag">
                <select class="form-control  text-capitalize" name="tag">
                <option value="0">Select one</option>
                <?php
                    foreach ($tag as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
                </select>
              </div>


            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-6">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <div class="col-sm-6 text-right">
              <button type="submit" class="btn btn-primary add_post" name="add_post">Cập nhật</button>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<style>
  .copy {
    cursor: pointer;
  }
  .nowrap{
    white-space: nowrap;
  }
  .tag {
    padding: 0 4px;
    color: #fff;
    white-space: nowrap;
  }

  .tag_1 {
    background-color: green;
  }

  .tag_2 {
    background-color: #0056b3;
  }

  .tag_3 {
    background-color: yellow;
    color: #000;
  }

  .tag_4 {
    background-color: red;
  }

  .tag_5 {
    background-color: orange;
  }

  .status_1 {
    background-color: green;
  }

  .status_2 {
    background-color: yellow;
    color: #000;
  }

  .status_3 {
    background-color: yellow;
    opacity: 0.65;
    color: #000;
  }

  .status_4 {
    background-color: gray;
  }

  .status_5 {
    background-color: orange;
    color: #fff;
  }
.order_1 {background-color: green;}
.order_2 {background-color: red;}
.order_3 {background-color: orange;}
.order_4 {background-color: yellow;}

</style>

<?php
// endwhile;

global $site_scripts;

if (empty($site_scripts)) $site_scripts = [];
$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';
get_footer('customer');
?>
<script>
  $(document).ready(function() {
    $('#checkall').change(function() {
      $('.checkbox-element').prop('checked', this.checked);
    });
    $('.checkbox-element').change(function() {
      if ($('.checkbox-element:checked').length == $('.checkbox-element').length) {
        $('#checkall').prop('checked', true);
      } else {
        $('#checkall').prop('checked', false);
      }
    });
    $('.box').hide();
    $('.field').change(function() {
      $('.box').hide();
      $('.box select').prop('selectedIndex',0);
      $('.' + $(this).val()).show();
    }).change();
    $(".checkbox-element").change(function() {
      updateAllChecked();
    });
    
    $("#checkall").change(function() {
      if (this.checked) {
        $(".checkbox-element").prop('checked', true).change();
      } else {
        $(".checkbox-element").prop('checked', false).change();
      }
    });
    
      $('.quick-edit').click(function (e) { 
        e.preventDefault();
        if($('.list_id').val() == '') {
          alert('Hãy chọn ô khách hàng để chỉnh sửa nhanh!');
          return false;
        }
      });
      $("#modal-edit .add_post").click(function (e) { 
        //e.preventDefault();
        var status_order = $('#modal-edit .status_order select').val();
        var status_pay = $('#modal-edit .status_pay select').val();
        var tag = $('#modal-edit .tag select').val();
        if (status_order == 0 && status_pay == '' && tag == 0) {
          alert('Hãy chọn value!');
          return false;
        }
      });
      
      
    function updateAllChecked() {
      $('.list_id').val('');
      $(".checkbox-element").each(function() {
        if (this.checked) {
          let old_text = $('.list_id').val() ? $('.list_id').val() + ',' : '';
          $('.list_id').val(old_text + $(this).val());
        }
      })
    }
    $('.copy').on('click', function() {
      const textToCopy = $(this).text();

      const tempInput = $('<input>');
      $('body').append(tempInput);
      tempInput.val(textToCopy).select();

      document.execCommand('copy');

      tempInput.remove();

      //alert('Đã copy số điện thoại: ' + textToCopy);
    });
  });
</script>