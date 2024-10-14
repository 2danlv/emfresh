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
  $fullname   = sanitize_text_field($_POST['fullname']);
  $phone    = sanitize_text_field($_POST['phone']);
  $gender_post = sanitize_text_field($_POST['gender']);
  $status_post = sanitize_text_field($_POST['status']);
  $active_post = sanitize_text_field($_POST['active']);
  $tag_post = sanitize_text_field($_POST['tag']);
  $point = isset($_POST['point']) ? intval($_POST['point']) : 0;
  $note = sanitize_textarea_field($_POST['note']);

  $data = [
    'nickname'          => $nickname,
    'fullname'      => $fullname,
    'phone'         => $phone,
    'status'        => $status_post,
    'gender'        => $gender_post,
    'active'        => $active_post,
    'note'          => $note,
    'tag'           => $tag_post,
    'point'         => $point
  ];

  //var_dump($data);
  $response_add_customer = em_api_request('customer/add', $data);

  if($response_add_customer['code'] == 200) {
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

      if($response_location['code'] != 200) {
        $response_locations[] = $response_location;
      }
    }

    if(count($response_locations) > 0) {
      $response_add_customer['locations'] = $response_locations;
    }
  }

  // $result = base64_encode(http_build_query($response_add_customer, '', '&'));
  // wp_redirect(add_query_arg(['result' => $result], get_permalink()));
  // exit();
}



// $response_add_customer = [];
// if(!empty($_GET['result'])) {
//   $result = base64_decode($_GET['result']);
//   parse_str($result, $response_add_customer);
// }

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();
$actives = $em_customer->get_actives();

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
      if(isset($response_add_customer['code'])&&$response_add_customer['code']==200) {
        echo '<div class="alert alert-success mt-3" role="alert">'.$response_add_customer['message'].'</div>';
      } else if(isset($response_add_customer['code'])&&$response_add_customer['code']==400) {
        echo '<div class="alert alert-warning mt-3" role="alert">';
        foreach($response_add_customer['data'] as $field => $value) {
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
                <div class="col-sm-3"><label>Active</label></div>
                <div class="col-sm-9 text-capitalize">
                  <?php 
                    foreach ($actives as $key => $value) { ?>
                    <div class="icheck-primary d-inline mr-2">
                    <input type="radio" id="radioActive<?php echo $key; ?>" value="<?php echo $key; ?>" name="active" required>
                    <label for="radioActive<?php echo $key; ?>">
                      <?php echo $value; ?>
                    </label>
                  </div>
                    <?php } ?>
                </div>
              </div>
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
                <div class="col-sm-9"><input type="number" name="phone" class="form-control" required pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" /></div>
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
                  <div class="col-sm-3"><label>Địa chỉ (*):</label></div>
                  <div class="col-sm-9">
                    <input id="address_0" class="form-control" name="locations[0][address]" required />
                  </div>
                </div>
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
                <div class="col-sm-3"><label>Ghi chú đặc biệt</label></div>
                <div class="col-sm-9"><textarea name="note" class="form-control" rows="4"></textarea></div>
              </div>
              </div>
              </div>
              <div class="card card-info mb-5">
              <div class="card-header">
              <h3 class="card-title">Trạng thái</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select text-capitalize" required>
                    <option value="">Select one</option>
                    <?php 
                    foreach ($status as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                <div class="col-sm-9"><select class="form-control text-capitalize" name="tag" style="width: 100%;" required>
                    <option value="">Select one</option>
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
<script type="text/javascript">
  $(document).ready(function() {
    var $locationFields = $('#location-fields');
    var $addButton = $('#add-location-button');
    var fieldCount = 1;
    var maxFields = 5;
    $(document).on('click', '.delete-location-button', function (e) {
            e.preventDefault();
            $(this).closest('.address-group').remove(); 
        });
    // Fetching data from the new API endpoint
    $.getJSON('https://provinces.open-api.vn/api/?depth=3', function(data) {
      
      // Move the province with code 79 to the top of the data array
      var topProvince = data.find(p => p.code === 79);
      if (topProvince) {
        data = [topProvince].concat(data.filter(p => p.code !== 79));
      }

      // Function to populate the province dropdown
      function populateProvinces($selectElement, selectedValue) {
        $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
        $.each(data, function(index, province) {
          var option = `<option value="${province.name}" ${selectedValue === province.name ? 'selected' : ''}>${province.name}</option>`;
          $selectElement.append(option);
        });
      }

      // Function to handle cascading changes in province, district, and ward
      function handleLocationChange($provinceSelect, $districtSelect, $wardSelect) {
        $provinceSelect.on('change', function() {
          $districtSelect.html('<option value="">Select Quận/Huyện</option>');
          $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

          var selectedProvince = data.find(p => p.name === $(this).val());

          if (selectedProvince) {
            $.each(selectedProvince.districts, function(index, district) {
              $districtSelect.append(`<option value="${district.name}">${district.name}</option>`);
            });
            $districtSelect.prop('disabled', false);
          } else {
            $districtSelect.prop('disabled', true);
          }
        });

        $districtSelect.on('change', function() {
          $wardSelect.html('<option value="">Select Phường/Xã</option>');

          var selectedProvince = data.find(p => p.name === $provinceSelect.val());
          var selectedDistrict = selectedProvince ? selectedProvince.districts.find(d => d.name === $(this).val()) : null;

          if (selectedDistrict) {
            $.each(selectedDistrict.wards, function(index, ward) {
              $wardSelect.append(`<option value="${ward.name}">${ward.name}</option>`);
            });
            $wardSelect.prop('disabled', false);
          } else {
            $wardSelect.prop('disabled', true);
          }
        });
      }

      // Initialize existing address groups
      $('.address-group').each(function() {
        var $provinceSelect = $(this).find('.province-select');
        var $districtSelect = $(this).find('.district-select');
        var $wardSelect = $(this).find('.ward-select');

        populateProvinces($provinceSelect, $provinceSelect.val());
        handleLocationChange($provinceSelect, $districtSelect, $wardSelect);
      });

      // Add new address group functionality
      $addButton.on('click', function(e) {
        e.preventDefault();
        if (fieldCount < maxFields) {
          var newGroup = `
          <hr>
            <div class="address-group">
              <div class="form-group row">
                <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
                <div class="col-sm-9">
                  <input id="address_${fieldCount}" class="form-control" name="locations[${fieldCount}][address]" required />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="province_${fieldCount}">Tỉnh/Thành phố:</label>
                </div>
                <div class="col-sm-9">
                  <select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
                    <option value="">Select Tỉnh/Thành phố</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="district_${fieldCount}">Quận/Huyện:</label>
                </div>
                <div class="col-sm-9">
                  <select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" required disabled>
                    <option value="">Select Quận/Huyện</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="ward_${fieldCount}">Phường/Xã:</label>
                </div>
                <div class="col-sm-9">
                  <select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" required disabled>
                    <option value="">Select Phường/Xã</option>
                  </select>
                </div>
              </div>
              <p class="text-right"><span class="btn bg-gradient-danger  delete-location-button">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
            </div>`;
          
          $locationFields.append(newGroup);
          var $newProvinceSelect = $(`#province_${fieldCount}`);
          var $newDistrictSelect = $(`#district_${fieldCount}`);
          var $newWardSelect = $(`#ward_${fieldCount}`);

          populateProvinces($newProvinceSelect, '');
          handleLocationChange($newProvinceSelect, $newDistrictSelect, $newWardSelect);
          fieldCount++;
        } else {
          alert('You can only add up to 5 locations.');
        }
      });
    }).fail(function() {
      console.error('Error fetching location data');
    });
  });
</script>



