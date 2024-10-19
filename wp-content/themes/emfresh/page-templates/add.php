<?php
/*
Template Name: Add Post
*/

get_header();

global $em_customer;

$response_customer = em_api_request('customer/list', []);

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();

$list = [];
if(isset($response_customer['data'])) {
    $list = $response_customer['data'];
}

$response_customer = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
    // $nickname   = sanitize_text_field($_POST['nickname']);
    // $fullname   = sanitize_text_field($_POST['fullname']);
    // $phone    = sanitize_textarea_field($_POST['phone']);
    // $address    = sanitize_textarea_field($_POST['address']);
    // $gender_post = sanitize_text_field($_POST['gender']);
    // $status_post = sanitize_text_field($_POST['status']);
    // $tag_post = sanitize_text_field($_POST['tag']);
    // $point = sanitize_text_field($_POST['point']);
    // $note = sanitize_textarea_field($_POST['note']);
    // $data = [
    //     'nickname'          => $nickname,
    //     'fullname'      => $fullname,
    //     'phone'         => $phone,
    //     'status'        => $status,
    //     'gender'        => $gender_post,
    //     'note'          => $note,
    //     'tag'           => $tag,
    //     'point'         => $point,
    //     'address'       => $address,
    // ];

    //$response_customer = em_api_request('customer/add', $data);
    
    foreach ($_POST['locations'] as $location) {
      // thêm data cho location
      var_dump($location);
      $location_data = [
        'customer_id'   => 0,
        'address'       => sanitize_text_field($location['address']),
        'ward'          => sanitize_text_field($location['ward']),
        'district'      => sanitize_text_field($location['district']),
        'city'          => sanitize_text_field($location['province']),
      ];
      $response_location = em_api_request('location/add', $location_data);
      }
    
}


?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container mt-3">
    <?php if(count($list) > 0) : ?>
        <h3>List</h3>
    <ul>
        <?php foreach($list as $item) :?>
        <li><?php echo $item['id'] . ') ' . $item['fullname'] ;?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif;?>
    <?php 
        if(isset($response_customer['code'])) {
            echo '<div class="alert alert-success mt-3" role="alert">'.$response_customer['message'].'</div>';
        }
    ?>
    <h3 class="mt-3">Form</h3>
    <form class="add-post-form mt-3" method="post" action="<?php the_permalink() ?>">
    <!-- <div class="form-group row">
                <div class="col-sm-3"><label>Tên khách hàng (*)</label></div>
                <div class="col-sm-9">
                  <input type="text" name="nickname" class="form-control" required>
                </div>
              </div>
        <div class="mb-3">
            <label for="fullname" class="form-label">Fullname</label>
            <input type="text" class="form-control" name="fullname" id="fullname" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
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
        <div class="mb-3">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
        </div> -->
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
        <!-- <div class="card-body">
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
            </div> -->
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" name="add_post" value="Submit">
        </div>
    </form>
    <?php 
        global $em_customer;
        var_export($em_customer->get_statuses());
        var_export($em_customer->get_genders());
        var_export($em_customer->get_tags());
    ?>
</div>

<?php get_footer(); ?>
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