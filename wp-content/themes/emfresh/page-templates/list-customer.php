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
      <span class="mr-2"><a href="/import-export/" class="btn btn-success">Export Excel/CSV</a></span>
      <span class="mr-2"><a href="/import-export/" class="btn btn-primary">Import Excel/CSV</a></span>
      <span class="ml-2"><a href="#" class="btn btn-info">Quản lý tag</a></span>
      </div>
        <table id="example1" class="table table-bordered table-striped text-capitalize">
          <thead>
            <tr>
              <th>#</th>
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
                    <td><input type="checkbox" value="<?php echo $record['id'] ?>"></td>
                    <td><a href="detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['nickname']; ?></a></td>
                    <td><span class="copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td><?php echo $record['address']; ?></td>
                    <td><span class="tag btn btn-sm status_<?php echo $record['status']; ?>"><?php echo $record['status_name']; ?></td></td>
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
<style>
  .copy {
    cursor: pointer;
  }
  .tag {
    border-radius: 3px;
    padding:0 4px;
    color: #fff;
  }
  .tag_1{background-color: green;}
  .tag_2{background-color: #0056b3;}
  .tag_3{background-color: yellow; color: #000;}
  .tag_4{background-color: red;}
  .tag_5{background-color: orange;}
  .status_1{background-color: green;}
  .status_2{background-color: yellow; color: #000;}
  .status_3{background-color: yellow; opacity: 0.65; color: #000;}
  .status_4{background-color:gray;  }
  .status_5{background-color: orange;color: #fff;}

</style>

<?php
// endwhile;
get_footer('customer');
?>
<script>
  $(document).ready(function() {
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