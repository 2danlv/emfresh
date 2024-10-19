<?php
/*
Template Name: update location
*/

global $em_customer;

$response_customer = em_api_request('customer/list', []);

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();

$list = [];
if (isset($response_customer['data'])) {
  $list = $response_customer['data'];
}

$response_customer = [];

$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
$location_filter = [
  'customer_id' => $customer_id,
  'limit' => 5
];
$response_get_location = em_api_request('location/list', $location_filter);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
  
  $total_location  = sanitize_text_field($_POST['total_location']);
  
  $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
  if($customer_id == 0) {
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
    var_export($location['id']);
    die();
    if (isset($location['id']) && intval($location['id']) > 0) {
      $location_data['id'] = $location['id'];
      $response_location = em_api_request('location/update', $location_data);
      
      // if ($location_data['id'] || $location['id']) {
      //   # code...
      //   // xóa location
      //   $location_remove = [
      //     'id' => $location['id']
      //   ];
      //   $response_delete_location = em_api_request('location/delete', $location_remove);
      // }
    } else {
      $response_location = em_api_request('location/add', $location_data);
    }
  }

  wp_redirect(add_query_arg(['customer_id' => $customer_id, 'msg' => 'success'], get_permalink()));
  exit();
}

get_header();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container mt-3">
  <?php if (count($list) > 0) : ?>
    <h3>List</h3>
    <ul>
      <?php foreach ($list as $item) : ?>
        <li><?php echo $item['id'] . ') ' . $item['fullname']; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php
  if (isset($response_customer['code'])) {
    echo '<div class="alert alert-success mt-3" role="alert">' . $response_customer['message'] . '</div>';
  }
  ?>
  <h3 class="mt-3">Form</h3>
  <form class="add-post-form mt-3" method="post" action="<?php the_permalink() ?>">
    <div class="form-group row">
      
    <div id="location-fields">
      <?php foreach ($response_get_location['data'] as $index => $record) {?>
        <div class="address-group">
          <p style="color: red;">Nếu có location id thì là update (nhớ dùng type=hidden)</p>
          <div class="form-group row">          
            <div class="col-sm-3"><label>ID:</label></div>
            <div class="col-sm-9"><input type="text" class="location_remove" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" placeholder="id" readonly /></div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3"><label for="address_<?php echo $record['id'] ?>">Address:</label></div>
            <div class="col-sm-9"><input id="address_<?php echo $record['id'] ?>" class="form-control" value="<?php echo $record['address']; ?>" name="locations[<?php echo $index ?>][address]" required /></div>
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
              <select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control" required >
                <option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3"><label for="ward_<?php echo $record['id'] ?>">Phường/Xã:</label></div>
            <div class="col-sm-9">
              <select id="ward_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][ward]" class="ward-select form-control" required >
                <option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
              </select>
            </div>
          </div>
          <p class="text-right"><span class="btn bg-gradient-danger  delete-location-button">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
        </div>
      <?php } ?>
      <input type="text" class="total_location" name="total_location" value="<?php echo count($response_get_location['data']); ?>">
</div>
      <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>

      <p style="color: red;">Cần có customer_id (nhớ dùng type=hidden)</p>
      <div class="form-group row">
        <div class="col-sm-3"><label>Customer ID</label></div>
        <div class="col-sm-9">
          <input type="text" name="customer_id" value="<?php echo $customer_id ?>" placeholder="customer id" />
        </div>
      </div>
      <div class="mb-3">
        <input type="submit" id="add-location-button" class="btn btn-primary" name="add_post" value="Submit">
      </div>
  </form>
  <?php
  global $em_customer;
  var_export($em_customer->get_statuses());
  var_export($em_customer->get_genders());
  var_export($em_customer->get_tags());
  ?>
</div>

<?php get_footer('customer'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var $locationFields = $('#location-fields');
    var $addButton = $('#add-location-button');
    var fieldCount = <?php echo count($response_get_location['data']); ?>;
    var maxFields = 5;
    $(document).on('click', '.delete-location-button', function (e) {
            e.preventDefault();
            var name =  $(this).closest(".address-group .location_remove").attr("name");
            console.log('log',name);
           //$(this).closest('.address-group .location_remove').attr('name', name+'questions');
           
          //  $(this).closest('.address-group').hide(); // Remove only the closest address group
            // fieldCount = fieldCount + 1;
            // console.log('log',fieldCount);
        });
    // Fetching data from the new API endpoint
    $.ajax({
        url: 'https://provinces.open-api.vn/api/?depth=3',
        method: 'GET',
        success: function(data) {

            // Function to populate the province dropdown
            function populateProvinces($selectElement, selectedValue) {
                $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
                $.each(data, function(index, province) {
                    var isSelected = selectedValue && selectedValue === province.name ? 'selected' : '';
                    $selectElement.append(`<option value="${province.name}" ${isSelected}>${province.name}</option>`);
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
                    $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

                    var selectedProvince = data.find(p => p.name === $provinceSelect.val());
                    var selectedDistrict = selectedProvince.districts.find(d => d.name === $(this).val());

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
            $('.address-group').each(function(index, group) {
                var $provinceSelect = $(group).find('.province-select');
                var $districtSelect = $(group).find('.district-select');
                var $wardSelect = $(group).find('.ward-select');

                populateProvinces($provinceSelect, $provinceSelect.val());
                handleLocationChange($provinceSelect, $districtSelect, $wardSelect);
            });

            // Add new address group functionality
            $addButton.on('click', function(e) {
                e.preventDefault();
                if (fieldCount < maxFields) {
                  
                    var newGroup = `
                    <div class="address-group">
                        <div class="form-group row">
                            <div class="col-sm-3"><label>Địa chỉ (*)</label></div>
                            <div class="col-sm-9">
                                <input id="address_${fieldCount}" class="form-control" name="locations[${fieldCount}][address]" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="province_${fieldCount}">Tỉnh/Thành phố:</label></div>
                            <div class="col-sm-9">
                                <select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
                                    <option value="">Select Tỉnh/Thành phố</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="district_${fieldCount}">Quận/Huyện:</label></div>
                            <div class="col-sm-9">
                                <select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" required disabled>
                                    <option value="">Select Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="ward_${fieldCount}">Phường/Xã:</label></div>
                            <div class="col-sm-9">
                                <select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" required disabled>
                                    <option value="">Select Phường/Xã</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-right"><span class="btn bg-gradient-danger  delete-location-button">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
                    </div>`;

                    $locationFields.append(newGroup);
                    var $newGroup = $locationFields.find('.address-group').last();
                    populateProvinces($newGroup.find('.province-select'), '');
                    handleLocationChange($newGroup.find('.province-select'), $newGroup.find('.district-select'), $newGroup.find('.ward-select'));
                    fieldCount++;
                    $('.total_location').val(fieldCount);
                } else {
                    alert('You can only add up to 5 locations.');
                }
            });
        },
        error: function(error) {
            console.error('Error fetching location data:', error);
        }
    });
});
</script>
