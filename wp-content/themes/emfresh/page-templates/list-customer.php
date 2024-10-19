<?php

/**
 * Template Name: List-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('customer');
// Start the Loop.
// while ( have_posts() ) : the_post();
// xóa customer
if (isset($_GET['change']) && trim($_GET['change']) == 'error') {
  $hide_errer = '';
}

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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
      $customer_id   = sanitize_text_field($_POST['customer_id']);
      $customer_data = [
        'id' => $customer_id,
      ];
      $response = em_api_request('customer/delete', $customer_data);
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
          <span class="ml-2"><span class="btn btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fas fa-filter"></i> Cột hiển thị</span></span>
          <span class="ml-2"><span class="btn btn-info" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Chỉnh sửa nhanh</span></span>
        </div>
        <table id="example1" class="table table-bordered table-striped text-capitalize">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkall" id="checkall" /></th>
              <th>Tên khách hàng</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
              <th>Trạng thái đặt đơn</th>
              <th>Điểm tích lũy</th>
              <th>Tag phân loại</th>
              <th>Người cập nhật cuối</th>
              <th>thời gian nhật cuối</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $customer_filter = [
              'paged' => 1
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
                    <td><?php echo $record['address']; ?></td>
                    <td><span class="tag btn btn-sm status_<?php echo $record['status']; ?>"><?php echo $record['status_name']; ?></td>
                    </td>
                    <td><?php echo $record['point']; ?>
                    <td><span class="tag btn btn-sm tag_<?php echo $record['tag']; ?>"><?php echo $record['tag_name']; ?></span></td>
                    <td><?php echo $record['created_author']; ?></td>
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
          <li><label><input type="checkbox" data-column="5" checked> Điểm tích lũy</label></li>
          <li><label><input type="checkbox" data-column="6" checked> Tag phân loại</label></li>
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
        <form method="POST" action="<?php the_permalink() ?>">
          <div class="form-group row">
            <div class="col-sm-3">field</div>
            <div class="col-sm-9">
              <select class="form-control field">
                <option value="status_order">Trạng Thái Đặt Đơn</option>
                <option value="status_pay">Trạng Thái Thanh Toán</option>
                <option value="tag">Tag Phân Loại</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3">Value</div>
            <div class="col-sm-9">
              <div class="box status_order">
                <select class="form-control ">
                  <option value="">Select</option>
                  <option>Đặt đơn</option>
                  <option>Dí món</option>
                  <option>Chưa rõ</option>
                  <option>Bảo lưu</option>
                  <option>Ngừng</option>
                </select>
              </div>
              <div class="box status_pay">
                <select class="form-control">
                  <option value="">Select</option>
                  <option>Rồi</option>
                  <option>Chưa</option>
                  <option>COD</option>
                  <option>1 phần</option>
                </select>
              </div>
              <div class="box tag">
                <select class="form-control ">
                  <option value="">Select</option>
                  <option>Thân thiết</option>
                  <option>Ăn nhóm</option>
                  <option>Khách có bệnh lý</option>
                  <option>Bảo lưu</option>
                  <option>Khách hãm</option>
                </select>
              </div>


            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-6">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <div class="col-sm-6 text-right">
              <button type="submit" class="btn btn-primary" name="add_post">Cập nhật</button>
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

  .tag {
    border-radius: 3px;
    padding: 0 4px;
    color: #fff;
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

    $('.copy').on('click', function() {
      const textToCopy = $(this).text();

      const tempInput = $('<input>');
      $('body').append(tempInput);
      tempInput.val(textToCopy).select();

      document.execCommand('copy');

      tempInput.remove();

      alert('Đã copy số điện thoại: ' + textToCopy);
    });
  });
</script>