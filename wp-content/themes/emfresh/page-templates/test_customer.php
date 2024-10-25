<?php

/**
 * Template Name: Customer Test
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(get_current_user_id() == 0) {
  // wp_redirect(add_query_arg([], home_url('login')));
  wp_redirect(home_url('login'));
  exit();
}

get_header("customer");
// Start the Loop.

?>
<?php
    global $em_customer;
      
    $response = em_api_request('customer/list', []);
    $status = $em_customer->get_statuses();
    $gender = $em_customer->get_genders();
    $tag = $em_customer->get_tags();
    $list = [];
    if(isset($response['data'])) {
      $list = $response['data'];
    }
    
    $response = [];
    // Check if the form is submitted and handle the submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {

      $nickname   = sanitize_text_field($_POST['nickname']);
      $fullname   = sanitize_text_field($_POST['fullname']);
      $phone    = sanitize_text_field($_POST['phone']);
      $address    = sanitize_text_field($_POST['address']);
      $gender_post = sanitize_text_field($_POST['gender']);
      $status_post = sanitize_text_field($_POST['status']);
      $tag_post = sanitize_text_field($_POST['tag']);
      $point = sanitize_text_field($_POST['point']);
      $note = sanitize_textarea_field($_POST['note']);
      
      // foreach ($_POST['locations'] as $location) {
      //   if (!empty($location['province']) && !empty($location['district']) && !empty($location['ward'])) {
      //     $location_data = array(
      //       'address'  => sanitize_text_field($location['address']),
      //       'province' => sanitize_text_field($location['province']),
      //       'district' => sanitize_text_field($location['district']),
      //       'ward'     => sanitize_text_field($location['ward']),
      //     );
      //     add_post_meta($post_id, 'location', $location_data);
      //   }
      // }
      
      
      $data = [
        'nickname'          => $nickname,
        'fullname'      => $fullname,
        'phone'         => $phone,
        'status'        => $status_post,
        'gender'        => $gender_post,
        'note'          => $note,
        'tag'           => $tag_post,
        'point'         => $point,
        'address'       => $address,
    ];
    $response = em_api_request('customer/add', $data);
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
    
    <?php if(count($list) > 0) : ?>
        <!-- <h3>List</h3> -->
    <ul>
        <?php // foreach($list as $item) :?>
        <!-- <li><?php // echo $item['id'] . ') ' . $item['fullname'] ;?></li> -->
        <?php // endforeach; ?>
    </ul>
    <?php endif;?>
    <?php 
        if(isset($response['code'])) {
            echo '<div class="alert alert-success mt-3" role="alert">'.$response['message'].'</div>';
        }
    ?>
    <?php
          // Ensure user is logged in (optional if you want to restrict access to logged-in users)
          if (!is_user_logged_in()) {
            echo '<p>You need to log in to edit this content.</p>';
            return;
          }
          ?>
    <form method="post" action="<?php the_permalink() ?>">

      <div class="row">
        <div class="col-md-6">
          


          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>
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
                <div class="col-sm-9"><input type="number" name="phone" class="form-control" required></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label>Giới tính (*)</label></div>
                <div class="col-sm-9">
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
                <div class="address-group">
                <div class="form-group row">
                  <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
                  <div class="col-sm-9">
                    <input id="address_0" class="form-control" name="address" required />
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-3">
                    <label for="province_0">Tỉnh/Thành phố:</label>

                  </div>
                  <div class="col-sm-9">
                    <select id="province_0" name="locations[0][province]" class="province-select form-control" >
                      <option value="">Select Tỉnh/Thành phố</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-3">
                    <label for="district_0">Quận/Huyện:</label>
                  </div>
                  <div class="col-sm-9">
                    <select id="district_0" name="locations[0][district]" class="district-select form-control"  disabled>
                      <option value="">Select Quận/Huyện</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-3">
                    <label for="ward_0">Phường/Xã:</label>
                  </div>
                  <div class="col-sm-9">
                    <select id="ward_0" name="locations[0][ward]" class="ward-select form-control"  disabled>
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
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select" required>
                    <option selected disabled>Select one</option>
                    <?php 
                    foreach ($status as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                <div class="col-sm-9"><select class="form-control" name="tag" style="width: 100%;" required>
                    <option selected disabled>Select one</option>
                    <?php 
                    foreach ($tag as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                <div class="col-sm-9"><input type="number" id="inputPoint" name="point" class="form-control"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Add new Customer" name="add_post" class="btn btn-primary float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>

<!-- <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var locationFields = document.getElementById('location-fields');
    var addButton = document.getElementById('add-location-button');
    var fieldCount = 1;
    var maxFields = 5;

    // Fetch the JSON data from the provided URL
    fetch('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json')
      .then(response => response.json())
      .then(data => {
        // Function to populate province select
        function populateProvinces(selectElement, selectedValue) {
          selectElement.innerHTML = '<option value="">Select  Tỉnh/Thành phố</option>';
          data.forEach(province => {
            var option = document.createElement('option');
            option.value = province.Name;
            option.text = province.Name;
            if (selectedValue && selectedValue === province.Name) {
              option.selected = true;
            }
            selectElement.appendChild(option);
          });
        }

        // Function to handle district and ward population
        function handleLocationChange(provinceSelect, districtSelect, wardSelect) {
          provinceSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">Select Quận/Huyện</option>';
            wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';
            wardSelect.disabled = true;

            var selectedProvince = data.find(p => p.Name === this.value);

            if (selectedProvince) {
              selectedProvince.Districts.forEach(district => {
                var option = document.createElement('option');
                option.value = district.Name;
                option.text = district.Name;
                districtSelect.appendChild(option);
              });
              districtSelect.disabled = false;
            } else {
              districtSelect.disabled = true;
            }
          });

          districtSelect.addEventListener('change', function() {
            wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';

            var selectedProvince = data.find(p => p.Name === provinceSelect.value);
            var selectedDistrict = selectedProvince.Districts.find(d => d.Name === this.value);

            if (selectedDistrict) {
              selectedDistrict.Wards.forEach(ward => {
                var option = document.createElement('option');
                option.value = ward.Name;
                option.text = ward.Name;
                wardSelect.appendChild(option);
              });
              wardSelect.disabled = false;
            } else {
              wardSelect.disabled = true;
            }
          });
        }

        // Initialize existing locations
        document.querySelectorAll('.address-group').forEach(function(group, index) {
          var provinceSelect = group.querySelector('.province-select');
          var districtSelect = group.querySelector('.district-select');
          var wardSelect = group.querySelector('.ward-select');

          populateProvinces(provinceSelect, provinceSelect.value);
          handleLocationChange(provinceSelect, districtSelect, wardSelect);
        });

        // Add new location field set
        addButton.addEventListener('click', function(e) {
          e.preventDefault();
          if (fieldCount < maxFields) {
            var newGroup = document.createElement('div');
            newGroup.classList.add('address-group');
            newGroup.innerHTML = `
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
                    `;
            locationFields.appendChild(newGroup);
            populateProvinces(newGroup.querySelector('.province-select'), '');
            handleLocationChange(newGroup.querySelector('.province-select'), newGroup.querySelector('.district-select'), newGroup.querySelector('.ward-select'));
            fieldCount++;
          } else {
            alert('You can only add up to 5 locations.');
          }
        });
      })
      .catch(error => {
        console.error('Error fetching location data:', error);
        //alert('There was an error loading the location data. Please try again later.');
      });
  });
</script> -->



<?php
get_footer('customer');
