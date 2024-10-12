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
          <h1>List Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List Customer</li>
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

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Tên đầy đủ</th>
              <th>Số điện thoại</th>
              <th>Tag phân loại</th>
              <th>Điểm tích lũy</th>
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
                    <td><a href="detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['fullname']; ?></a></td>
                    <td><?php echo $record['phone']; ?></td>
                    <td><?php echo $record['tag_name']; ?></td>
                    <td><?php echo $record['point']; ?>
                      <div class="float-sm-right">
                        <a class="btn btn-info btn-sm" href="detail-customer/?customer_id=<?php echo $record['id'] ?>">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                        </a>

                        <button type="button" class="btn btn-danger remove-customer btn-sm" data-toggle="modal" data-target="#modal-default">
                          <i class="fas fa-trash">
                          </i>
                          Delete
                          <span class="d-none"><?php echo $record['id'] ?></span>
                        </button>
                      </div>
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

<!-- /.card-body -->
<div class="modal fade" id="modal-default" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thông báo!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="list-customer" action="<?php the_permalink() ?>">
          <input type="hidden" class="customer_id" name="customer_id" value="">
          <p>Bạn muốn xóa khách hàng này?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="remove" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>

  </div>

</div>

<?php
// endwhile;
get_footer('customer');
?>
<script>
  $(document).ready(function() {
    $(document).on('click', '.remove-customer', function(e) {
      $('#list-customer').find('.customer_id').val(val);
    });
  });
</script>