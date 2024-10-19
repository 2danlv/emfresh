<?php

/**
 * Template Name: Customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer;

$response_add_customer = [];

// Check if the form is submitted and handle the submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
  $nickname   = sanitize_text_field($_POST['nickname']);
  $fullname   = isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']):'';
  $phone    = sanitize_text_field($_POST['phone']);
  $gender_post = isset($_POST['gender']) ? intval($_POST['gender']) : 0;
  $status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
  $active_post = isset($_POST['active']) ? intval($_POST['active']) : 0;
  $tag_post    = isset($_POST['tag']) ? intval($_POST['tag']): 0;
  $point = isset($_POST['point']) ? intval($_POST['point']) : 0;
  $note = sanitize_textarea_field($_POST['note']);
  $note_shipping = sanitize_textarea_field($_POST['note_shipping']);
  $note_cook = sanitize_textarea_field($_POST['note_cook']);

  $data = [
    'nickname'      => $nickname,
    'fullname'      => $fullname,
    'phone'         => $phone,
    'status'        => $status_post,
    'gender'        => $gender_post,
    'active'        => $active_post,
    'note'          => $note,
    'note_shipping' => $note_shipping,
    'note_cook'     => $note_cook,
    'tag'           => $tag_post,
    'point'         => $point
  ];

  //var_dump($data);
  $response_add_customer = em_api_request('customer/add', $data);

  if ($response_add_customer['code'] == 200) {
    $response_locations = [];

    foreach ($_POST['locations'] as $location) {
      $location_data = [
        'customer_id'   => $response_add_customer['data']['insert_id'],
        'address'       => sanitize_text_field($location['address']),
        'ward'          => sanitize_text_field($location['ward']),
        'district'      => sanitize_text_field($location['district']),
        'city'          => sanitize_text_field($location['province']),
      ];
      $response_location = em_api_request('location/add', $location_data);

      if ($response_location['code'] != 200) {
        $response_locations[] = $response_location;
      }
    }

    if (count($response_locations) > 0) {
      $response_add_customer['locations'] = $response_locations;
    }

    wp_redirect(add_query_arg([
      'customer_id' => $response_add_customer['data']['insert_id'],
      'code' => 200,
      'message' => 'Add Success',
    ], home_url('customer/detail-customer')));
    exit();
  }
}

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();
$actives = $em_customer->get_actives();

$list_cook = ['Không', 'Chỉ Khăn Lạnh', 'Chỉ Dụng Cụ'];
$list_notes = ['Không Cà Rốt', 'Không Hành'];

get_header("customer");
// Start the Loop.

?>
<div class="content-wrapper pb-5">
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
    if (isset($response_add_customer['code']) && $response_add_customer['code'] == 200) {
      echo '<div class="alert alert-success mt-3" role="alert">' . $response_add_customer['message'] . '</div>';
    } else if (isset($response_add_customer['code']) && $response_add_customer['code'] == 400) {
      echo '<div class="alert alert-warning mt-3" role="alert">';
      foreach ($response_add_customer['data'] as $field => $value) {
        echo "<p>$field : $value </p>";
      }
      echo '</div>';
    }
    ?>
    <form method="post" action="<?php the_permalink() ?>">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thông tin cơ bản</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label>Tên khách hàng (*)</label></div>
                <div class="col-sm-9">
                  <input type="text" name="nickname" class="form-control" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Tên đầy đủ</label></div>
                <div class="col-sm-9"><input type="text" name="fullname" class="form-control"></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Số điện thoại (*)</label></div>
                <div class="col-sm-9"><input type="tel" name="phone" class="form-control" required  /></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Giới tính (*)</label></div>
                <div class="col-sm-9 text-capitalize">
                  <?php
                  foreach ($gender as $key => $value) { ?>
                    <div class="icheck-primary d-inline mr-2">
                      <input type="radio" id="radioPrimary<?php echo $key; ?>" value="<?php echo $key; ?>" name="gender" required>
                      <label for="radioPrimary<?php echo $key; ?>">
                        <?php echo $value; ?>
                      </label>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div id="location-fields">
                <hr>
                <div class="address-group">
                  
                  <div class="form-group row">
                    <div class="col-sm-3">
                      <label for="province_0">Tỉnh/Thành phố:</label>
                    </div>
                    <div class="col-sm-9">
                      <select id="province_0" name="locations[0][province]" class="province-select form-control" required>
                        <option value="">Select Tỉnh/Thành phố</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-3">
                      <label for="district_0">Quận/Huyện:</label>
                    </div>
                    <div class="col-sm-9">
                      <select id="district_0" name="locations[0][district]" class="district-select form-control" required disabled>
                        <option value="">Select Quận/Huyện</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-3">
                      <label for="ward_0">Phường/Xã:</label>
                    </div>
                    <div class="col-sm-9">
                      <select id="ward_0" name="locations[0][ward]" class="ward-select form-control" required disabled>
                        <option value="">Select Phường/Xã</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-3"><label>Địa chỉ (*):</label></div>
                    <div class="col-sm-9">
                      <input id="address_0" class="form-control" name="locations[0][address]" required />
                    </div>
                  </div>
                </div>
              </div>
              <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Ghi chú đặc biệt</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label>Ghi chú dụng cụ ăn</label></div>
                <div class="col-sm-9">
                  <select class="form-control text-capitalize" name="note_cook" style="width: 100%;" required>
                    <?php foreach ($list_cook as $value) { ?>
                      <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Ghi chú yêu cầu ăn đặc biệt</label></div>
                <div class="col-sm-9 js-list-note">
                  <div class="mb-3">
                    <textarea name="note" class="form-control" rows="2"></textarea>
                  </div>
                  <p>
                    <?php foreach ($list_notes as $value) { ?>
                    <button type="button" class="btn btn-outline-primary"><?php echo $value; ?></button>
                    <?php } ?>
                  </p>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Ghi chú giao hàng đặc biệt</label></div>
                <div class="col-sm-9"><textarea name="note_shipping" class="form-control" rows="2"></textarea></div>
              </div>
            </div>
          </div>
          <div class="card card-info mb-5">
            <div class="card-header">
              <h3 class="card-title">Trạng thái</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label>Trạng thái khách hàng</label></div>
                <div class="col-sm-9 text-capitalize">
                  <?php
                  foreach ($actives as $key => $value) { ?>
                    <div class="icheck-primary d-inline mr-2">
                      <input type="radio" id="radioActive<?php echo $key; ?>" value="<?php echo $key; ?>" name="active" required <?php checked('1', $key); ?>>
                      <label for="radioActive<?php echo $key; ?>">
                        <?php echo $value; ?>
                      </label>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputStatus">Trạng thái đặt hàng</label></div>
                <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select text-capitalize">
                    <option value="0">Select one</option>
                    <?php
                    foreach ($status as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputTag">Tag phân loại</label></div>
                <div class="col-sm-9"><select class="form-control text-capitalize" name="tag" style="width: 100%;">
                    <option value="0">Select one</option>
                    <?php
                    foreach ($tag as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                <div class="col-sm-9"><input type="number" id="inputPoint" name="point" value="0" class="form-control"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="../" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Add new Customer" name="add_post" class="btn btn-primary float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<?php
get_footer('customer');
?>
<script src="/assets/js/assistant.js"></script>
<script src="/assets/js/location.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $('.js-list-note').each(function(){
      let p = $(this);

      $('.btn', p).on('click', function() {
        let input = $('textarea', p),
          list = input.val() || '',
          btn = $(this),
          text = btn.text();

        list = (list != '' ? list.split(',') : []).map(v => v.trim());

        if (btn.hasClass('active')) {
          let tmp = [];

          list.forEach(function(v, i) {
            if (v != text) {
              tmp.push(v);
            }
          })

          list = tmp;

          btn.removeClass('active');
        } else {
          list.push(text);

          btn.addClass('active');
        }

        input.val(list.join(", "));
      });
    });
  });
</script>