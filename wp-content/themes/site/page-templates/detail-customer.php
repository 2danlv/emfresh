<?php

/**
 * Template Name: Detail-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer;

// cập nhật data cho customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
  $customer_id = intval($_POST['customer_id']);
  $nickname   = sanitize_text_field($_POST['nickname']);
  $fullname   = sanitize_text_field($_POST['fullname']);
  $phone    = sanitize_text_field($_POST['phone']);
  $gender_post = isset($_POST['gender']) ? intval($_POST['gender']) : 0;
  $status_post = isset($_POST['status']) ? intval($_POST['status']) : 0;
  $active_post = isset($_POST['active']) ? intval($_POST['active']) : 0;
  $tag_post    = isset($_POST['tag']) ? intval($_POST['tag']) : 0;
  $point = sanitize_text_field($_POST['point']);
  $note = sanitize_textarea_field($_POST['note']);
  $note_shipping = sanitize_textarea_field($_POST['note_shipping']);
  $note_cook = sanitize_textarea_field($_POST['note_cook']);

  $customer_data = [
    'id'            => $customer_id,
    'nickname'      => $nickname,
    'fullname'      => $fullname,
    'phone'         => $phone,
    'active'        => $active_post,
    'status'        => $status_post,
    'gender'        => $gender_post,
    'note'          => $note,
    'note_shipping' => $note_shipping,
    'note_cook'     => $note_cook,
    'tag'           => $tag_post,
    'point'         => $point,
  ];
  $response_update = em_api_request('customer/update', $customer_data);

  if ($customer_id == 0) {
    die('customer_id is null!');
  }

  foreach ($_POST['locations'] as $location) {
    // thêm data cho location
    if (isset($location['address'])) {
      $address       = sanitize_text_field($location['address']);
    }
    if (isset($location['ward'])) {
      $ward       = sanitize_text_field($location['ward']);
    }
    if (isset($location['district'])) {
      $district       = sanitize_text_field($location['district']);
    }
    if (isset($location['province'])) {
      $city       = sanitize_text_field($location['province']);
    }

    $location_data = [
      'customer_id'   => $customer_id,
      'address'       => $address,
      'ward'          => $ward,
      'district'      => $district,
      'city'          => $city
    ];

    if (isset($location['id']) && intval($location['id']) > 0) {
      $location_data['id'] = $location['id'];
      $response_location = em_api_request('location/update', $location_data);
    } else {
      $response_location = em_api_request('location/add', $location_data);
    }
    //var_dump($location['id']);
  }

  // xóa location
  if (!empty($_POST['location_delete_ids'])) {
    $delete_ids = explode(',', sanitize_text_field($_POST['location_delete_ids']));
    foreach ($delete_ids as $delete_id) {
      $delete_id = (int) $delete_id;
      if ($delete_id > 0) {
        $response = em_api_request('location/delete', ['id' => $delete_id]);
      }
    }
  }

  //   $location_data = [
  //     'id' => 1
  // ];
  // $response = em_api_request('location/delete', $location_filter);
  echo "<meta http-equiv='refresh' content='0'>";
}

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag    = $em_customer->get_tags();
$actives = $em_customer->get_actives();
// lấy 1 customer
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
if ($customer_id == 0) {
  die('customer_id is null!');
}
$customer_filter = [
  'id' => $customer_id
];
$response_customer = em_api_request('customer/item', $customer_filter);

// lấy danh sách location
$location_filter = [
  'customer_id' => $customer_id,
  'limit' => 5,
];
$response_get_location = em_api_request('location/list', $location_filter);

$list_cook = ['Không', 'Chỉ Khăn Lạnh', 'Chỉ Dụng Cụ'];
$list_notes = ['Không Cà Rốt', 'Không Hành'];

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
          <h1><?php the_title(); ?>: <?php echo $response_customer['data']['nickname'] ?></h1>
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary d-none card-outline">
            <div class="card-body box-profile">
              <!-- <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                  src="/assets/dist/img/user4-128x128.jpg"
                  alt="User profile picture">
              </div>
              <h3 class="profile-username text-center text-capitalize">
                <?php echo $response_customer['data']['nickname'] ?>
              </h3> -->
              <!-- <ul class="list-group list-group-unbordered mb-0">
                <li class="list-group-item">
                  <b>Tổng số lượng đơn hàng đã đặt</b>: <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Tổng số ngày đã dùng bữa</b>: <a class="float-right">543</a>
                </li>
              </ul> -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?php the_title(); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fas fa-coins mr-1"></i> Điểm tích lũy</strong>: <?php echo $response_customer['data']['point'] ?>
              <hr>
              <strong><i class="fas fa-venus-mars mr-1"></i> Giới tính</strong>: <br><span class="text-capitalize"><?php echo $response_customer['data']['gender_name'] ?></span><br>
              <hr>
              <strong><i class="fas fa-signal mr-1"></i> Trạng thái khách hàng</strong>: <br><span class="text-capitalize"><?php echo $response_customer['data']['status_name'] ?></span><br>
              <hr>
              <strong><i class="fas fa-phone mr-1"></i> Số điện thoại</strong>: <br><?php echo $response_customer['data']['phone'] ?>
              <hr>
              <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>
              <?php
              foreach ($response_get_location['data'] as $index => $record) { ?>
                <p>
                  <?php echo $record['address'] ?>,
                  <?php echo $record['ward'] ?>,
                  <?php echo $record['district'] ?>,
                  <?php echo $record['city'] ?>
                </p>
              <?php }
              ?>
              <hr>
              <strong><i class="fas fa-pencil-alt mr-1"></i> Tag phân loại</strong>: <br><span class="text-capitalize"><?php echo $response_customer['data']['tag_name'] ?></span><br>
              <hr>
              <strong><i class="far fa-file-alt mr-1"></i> Ghi chú đặc biệt</strong>:
              <p class="text-muted">
                <?php echo $response_customer['data']['note'] ?>
              </p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Lịch sử giao dịch</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Trao đổi</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Cập nhật thông tin</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <table class="table table-striped projects">
                    <thead>
                      <tr>
                        <th style="width: 1%">
                          #
                        </th>
                        <th>
                          Tên giao dịch
                        </th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày dự kiến kết thúc</th>
                        <th>
                          Giá trị đơn hàng
                        </th>
                        <th style="width: 8%" class="text-center">
                          Status
                        </th>
                        <th style="width: 10%">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          #
                        </td>
                        <td>
                          <a href="#">
                            AdminLTE v3
                          </a>
                          <br>
                          <small>
                            Created 01.01.2019
                          </small>
                        </td>
                        <td>01.01.2019</td>
                        <td>02.01.2019</td>
                        <td class="project_progress">
                          100.000
                        </td>
                        <td class="project-state">
                          <span class="badge badge-success">Success</span>
                        </td>
                        <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-folder">
                            </i>
                            View
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <div class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-danger">
                        10 Feb. 2014
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-envelope bg-primary"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 12:05</span>
                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                        <div class="timeline-body">
                          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                          weebly ning heekya handango imeem plugg dopplr jibjab, movity
                          jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                          quora plaxo ideeli hulu weebly balihoo...
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-primary btn-sm">Read more</a>
                          <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-user bg-info"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                        </h3>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-comments bg-warning"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                        <div class="timeline-body">
                          Take me to your leader!
                          Switzerland is small and neutral!
                          We are more like Germany, ambitious and misunderstood!
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                  </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="settings">
                  <form class="form-horizontal" method="POST" action="<?php the_permalink() ?>?customer_id=<?php echo $customer_id ?>">
                    <?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
                    <div class="form-group row">
                      <div class="col-sm-3"><label>Active</label></div>
                      <div class="col-sm-9 text-capitalize">
                        <?php
                        foreach ($actives as $value => $label) { ?>
                          <div class="icheck-primary d-inline mr-2 text-capitalize">
                            <input type="radio" id="radioActive<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked($response_customer['data']['active'], $value); ?> name="active" required>
                            <label for="radioActive<?php echo $value; ?>">
                              <?php echo $label; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="inputName">Tên khách hàng (*)</label></div>
                      <div class="col-sm-9">
                        <input type="text" name="nickname" class="form-control" value="<?php echo $response_customer['data']['nickname'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="fullname">Tên đầy đủ</label></div>
                      <div class="col-sm-9"><input type="text" id="fullname" name="fullname" value="<?php echo $response_customer['data']['fullname'] ?>" class="form-control"></div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="phone">Số điện thoại (*)</label></div>
                      <div class="col-sm-9"><input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $response_customer['data']['phone'] ?>" required></div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label>Giới tính (*)</label></div>
                      <div class="col-sm-9 text-capitalize">
                        <?php
                        foreach ($gender as $value => $label) { ?>
                          <div class="icheck-primary d-inline mr-2 text-capitalize">
                            <input type="radio" id="radioPrimary<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked($response_customer['data']['gender'], $value); ?> name="gender" required>
                            <label for="radioPrimary<?php echo $value; ?>">
                              <?php echo $label; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div id="location-fields">
                      <?php foreach ($response_get_location['data'] as $index => $record) { ?>
                        <hr>
                        <div class="address-group">
                          <div class="form-group row">
                            <div class="col-sm-9"><input type="hidden" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" placeholder="id" readonly /></div>
                          </div>
                          
                          <div class="form-group row">
                            <div class="col-sm-3"><label for="province_<?php echo $record['id'] ?>">Tỉnh/Thành phố:</label></div>
                            <div class="col-sm-9">
                              <select id="province_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][province]" class="province-select form-control" required>
                                <option value="<?php echo $record['city']; ?>" selected><?php echo $record['city']; ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-3"><label for="district_<?php echo $record['id'] ?>">Quận/Huyện:</label></div>
                            <div class="col-sm-9">
                              <select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control" required>
                                <option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-3"><label for="ward_<?php echo $record['id'] ?>">Phường/Xã:</label></div>
                            <div class="col-sm-9">
                              <select id="ward_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][ward]" class="ward-select form-control" required>
                                <option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-3"><label for="address_<?php echo $record['id'] ?>">Địa chỉ (*):</label></div>
                            <div class="col-sm-9"><input id="address_<?php echo $record['id'] ?>" class="form-control" value="<?php echo $record['address']; ?>" name="locations[<?php echo $index ?>][address]" required /></div>
                          </div>
                          <p class="text-right"><span class="btn bg-gradient-danger delete-location-button" data-id="<?php echo $record['id'] ?>">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
                        </div>
                      <?php } ?>
                    </div>
                    <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
                    <hr>
                    <div class="form-group row">
                      <div class="col-sm-3"><label>Ghi chú dụng cụ ăn</label></div>
                      <div class="col-sm-9">
                        <select class="form-control text-capitalize" name="note_cook" style="width: 100%;" required>
                          <?php foreach ($list_cook as $value) { ?>
                            <option value="<?php echo $value; ?>" <?php selected($response_customer['data']['note_cook'], $value); ?>><?php echo $value; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <div class="col-sm-3"><label>Ghi chú yêu cầu ăn đặc biệt</label></div>
                      <div class="col-sm-9 js-list-note">
                        <div class="mb-3">
                          <textarea name="note" class="form-control" rows="2"><?php echo $response_customer['data']['note']; ?></textarea>
                        </div>
                        <p>
                          <?php 
                            $list_values = array_map('trim', explode(',', $response_customer['data']['note']));
                          foreach ($list_notes as $value) { ?>
                          <button type="button" class="btn btn-outline-primary<?php echo in_array($value, $list_values) ? ' active' : '' ?>"><?php echo $value; ?></button>
                          <?php } ?>
                        </p>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <div class="col-sm-3"><label>Ghi chú giao hàng đặc biệt</label></div>
                      <div class="col-sm-9"><textarea name="note_shipping" class="form-control" rows="2"><?php echo $response_customer['data']['note_shipping']; ?></textarea></div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                      <div class="col-sm-9">
                        <select id="inputStatus" name="status" class="form-control custom-select text-capitalize">
                          <option value="0">Select one</option>
                          <?php
                          foreach ($status as $value => $label) { ?>
                            <option value="<?php echo $value; ?>" <?php selected($response_customer['data']['status'], $value); ?>><?php echo $label; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="inputTag">Tag phân loại</label></div>
                      <div class="col-sm-9">
                        <select class="form-control text-capitalize" name="tag" style="width: 100%;">
                          <option value="0">Select one</option>
                          <?php
                          foreach ($tag as $value => $label) { ?>
                            <option value="<?php echo $value; ?>" <?php selected($response_customer['data']['tag'], $value); ?>><?php echo $label; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                      <div class="col-sm-9"><input type="number" id="inputPoint" name="point" value="<?php echo intval($response_customer['data']['point']); ?>" class="form-control"></div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary" name="add_post">Cập nhật</button>
                      </div>
                      <?php 
                    $admin_role = wp_get_current_user()->roles;
                    if(!empty($admin_role) ) {
                      if ($admin_role[0] == 'administrator') {
                     ?>
                      <div class="col-sm-3 text-right">
                      <button type="button" class="btn btn-danger remove-customer" data-toggle="modal" data-target="#modal-default">
                          <i class="fas fa-trash">
                          </i>
                          Delete
                        </button>
                      </div>
                      <?php }
                      } ?>
                    </div>
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>" />
                    
                      <input type="hidden" name="location_delete_ids" value="" class="location_delete_ids" />
                    
                  </form>

                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
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
          <input type="hidden" class="customer_id" name="customer_id" value="<?php echo $response_customer['data']['id'] ?>">
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

<style>
  .success-message {
    color: green;
  }

  .error-message {
    color: red;
  }
</style>
<?php
// endwhile;
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

    var hash = window.location.hash;
    if (hash) {
      $('li.nav-item a,.tab-content .tab-pane').removeClass('active');
      $('li.nav-item a[href="' + hash + '"]').addClass('active');
      var elementID = hash.replace('#', '');
      console.log('log', elementID);
      $('#' + elementID).addClass('active');
    }

    var $locationFields = $('#location-fields');
    var $addButton = $('#add-location-button');
    var fieldCount = <?php echo count($response_get_location['data']); ?>;
    var maxFields = 5;
    $(document).on('click', '.delete-location-button', function(e) {
      e.preventDefault();
      let btn = $(this),
        id = parseInt(btn.data('id') || 0);

      btn.closest('.address-group').remove(); // Remove only the closest address group
      // fieldCount = fieldCount + 1;
      // console.log('log',fieldCount);

      if (id > 0) {
        let l_d = $('.location_delete_ids');

        l_d.val(id + (l_d.val() != '' ? ',' + l_d.val() : ''));
      }
    });
    // Fetching data from the new API endpoint
    
  });
</script>