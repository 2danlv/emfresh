<?php

/**
 * Template Name: Customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header("customer");

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
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      
      $new_post = array(
        'post_title'   => sanitize_text_field($_POST['post_title']),   
        'post_content' => wp_kses_post($_POST['post_content']),        
        'post_type'    => 'customer',                                 
        'post_status'  => 'publish',                                  
        'post_author'  => get_current_user_id(),                      
      );

      
      $post_id = wp_insert_post($new_post);

      
      if (!is_wp_error($post_id)) {
        

        

        
        if (isset($_POST['fullname'])) {
          update_post_meta($post_id, 'fullname', sanitize_text_field($_POST['fullname']));
        }

        
        if (isset($_POST['phone'])) {
          update_post_meta($post_id, 'phone', preg_replace('/[^0-9]/', '', $_POST['phone'])); 
        }

        
        if (isset($_POST['gender'])) {
          update_post_meta($post_id, 'gender', sanitize_text_field($_POST['gender']));
        }

        
        if (isset($_POST['status'])) {
          update_post_meta($post_id, 'status', sanitize_text_field($_POST['status']));
        }

        
        if (isset($_POST['tag'])) {
          update_post_meta($post_id, 'tag', sanitize_text_field($_POST['tag']));
        }

        
        if (isset($_POST['point'])) {
          update_post_meta($post_id, 'point', sanitize_text_field($_POST['point']));
        }

        
        if (isset($_POST['locations'])) {
          
          delete_post_meta($post_id, 'location');

          
          foreach ($_POST['locations'] as $location) {
            if (!empty($location['province']) && !empty($location['district']) && !empty($location['ward'])) {
              $location_data = array(
                'address'  => sanitize_text_field($location['address']),
                'province' => sanitize_text_field($location['province']),
                'district' => sanitize_text_field($location['district']),
                'ward'     => sanitize_text_field($location['ward']),
              );
              add_post_meta($post_id, 'location', $location_data);
            }
          }
        }

        
        echo '<p class="success-message">Customer added successfully!</p>';
      } else {
        
        echo '<p class="error-message">Error: Failed to add new customer.</p>';
      }
    }
    ?>
    <style>
      .success-message {
        color: green;
      }

      .error-message {
        color: red;
      }
    </style>

    <form method="POST">
      <?php wp_nonce_field(); ?>

      <div class="row">
        <div class="col-md-6">
          <?php
          
          if (!is_user_logged_in()) {
            echo '<p>You need to log in to edit this content.</p>';
            return;
          }
          ?>


          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label>Tên khách hàng (*)</label></div>
                <div class="col-sm-9">
                  <input type="text" name="post_title" class="form-control" required>
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
                  <div class="icheck-primary d-inline mr-2">
                    <input type="radio" id="radioPrimary1" value="Nam" name="gender" required>
                    <label for="radioPrimary1">
                      Nam
                    </label>
                  </div>
                  <div class="icheck-primary d-inline mr-2">
                    <input type="radio" id="radioPrimary2" value="Nữ" name="gender" required>
                    <label for="radioPrimary2">
                      Nữ
                    </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary3" value="Không có thông tin" name="gender" required>
                    <label for="radioPrimary3">
                      Không có thông tin
                    </label>
                  </div>

                </div>
              </div>
              <div id="location-fields">
                <div class="address-group">
                <div class="form-group row">
                  <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
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
                <div class="col-sm-9"><textarea name="post_content" class="form-control" rows="4"></textarea></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select" required>
                    <option selected disabled>Select one</option>
                    <option value="Đặt đơn">Đặt đơn</option>
                    <option value="Dí món">Dí món</option>
                    <option value="Chưa rõ">Chưa rõ</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                <div class="col-sm-9"><select class="form-control" name="tag" style="width: 100%;" required>
                    <option selected disabled>Select one</option>
                    <option value="thân thiết">thân thiết</option>
                    <option value="ăn nhóm">ăn nhóm</option>
                    <option value="khách có bệnh lý">khách có bệnh lý</option>
                    <option value="khách hãm">khách hãm</option>
                    <option value="bảo lưu">bảo lưu</option>
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
          <input type="submit" value="Add new Customer" class="btn btn-primary float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var locationFields = document.getElementById('location-fields');
    var addButton = document.getElementById('add-location-button');
    var fieldCount = 1;
    var maxFields = 5;

    // Fetching data from the new API endpoint
    fetch('https://provinces.open-api.vn/api/?depth=3')
      .then(response => response.json())
      .then(data => {

        // Function to populate the province dropdown
        function populateProvinces(selectElement, selectedValue) {
          selectElement.innerHTML = '<option value="">Select Tỉnh/Thành phố</option>';
          data.forEach(province => {
            var option = document.createElement('option');
            option.value = province.name;
            option.text = province.name;
            if (selectedValue && selectedValue === province.name) {
              option.selected = true;
            }
            selectElement.appendChild(option);
          });
        }

        // Function to handle cascading changes in province, district, and ward
        function handleLocationChange(provinceSelect, districtSelect, wardSelect) {
          provinceSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">Select Quận/Huyện</option>';
            wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';
            wardSelect.disabled = true;

            var selectedProvince = data.find(p => p.name === this.value);

            if (selectedProvince) {
              selectedProvince.districts.forEach(district => {
                var option = document.createElement('option');
                option.value = district.name;
                option.text = district.name;
                districtSelect.appendChild(option);
              });
              districtSelect.disabled = false;
            } else {
              districtSelect.disabled = true;
            }
          });

          districtSelect.addEventListener('change', function() {
            wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';

            var selectedProvince = data.find(p => p.name === provinceSelect.value);
            var selectedDistrict = selectedProvince.districts.find(d => d.name === this.value);

            if (selectedDistrict) {
              selectedDistrict.wards.forEach(ward => {
                var option = document.createElement('option');
                option.value = ward.name;
                option.text = ward.name;
                wardSelect.appendChild(option);
              });
              wardSelect.disabled = false;
            } else {
              wardSelect.disabled = true;
            }
          });
        }

        // Initialize existing address groups
        document.querySelectorAll('.address-group').forEach(function(group, index) {
          var provinceSelect = group.querySelector('.province-select');
          var districtSelect = group.querySelector('.district-select');
          var wardSelect = group.querySelector('.ward-select');

          populateProvinces(provinceSelect, provinceSelect.value);
          handleLocationChange(provinceSelect, districtSelect, wardSelect);
        });

        // Add new address group functionality
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
      });
  });
</script>




<?php
get_footer('customer');
