var ass = new Assistant();
$(document).ready(function () {
  $('#location-fields').on('change','[name="location_active"]', function(){
    $('.location_active').val(0);
    $('.address-group').removeClass('address_active');
    if(this.checked) {
      $('.review .info0 span').text('');
      $(this).next('.location_active').val(1);
      $(this).parents('.address-group').addClass('address_active');
      var selectItem = $(this).closest('.address_active'); // Get the closest select-item div
      var infoIndex = 0; // Get the data-index attribute from select-item
      var city = selectItem.find('.district-select').val(); // Get the city value from select
      var ward = selectItem.find('.ward-select').val();
      var address = selectItem.find('.address').val();
      var infoDiv = $('.review .info' + infoIndex);
      infoDiv.children('.city').text(city);
      if (ward) {
          infoDiv.children('.ward').text(ward + ',');
      } else {
          infoDiv.children('.ward').text('');
      }
      if (address) {
        infoDiv.children('.address').text(address + ','); // Update the address text
      } else {
          infoDiv.children('.address').text(''); // Clear the address if the input is empty
      }
    }
  });
});


var $locationFields = $('#location-fields');
var $addButton = $('.add-location-button');
var fieldCount = $locationFields.find('> .address-group').length;
var maxFields = 500;
$(document).on('click', '.delete-location-button', function(e) {
  e.preventDefault();
  $(this).closest('.address-group').remove();
});
// Fetching data from the new API endpoint
$.getJSON('/wp-content/themes/emfresh/assets/data/city.json', function(data) {

   // Function to populate the province (Thành phố Hồ Chí Minh) dropdown
   function populateProvinces($selectElement, selectedValue) {
    $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
    var option = `<option value="${data[0].Name}" selected>${data[0].Name}</option>`;
    $selectElement.append(option).prop('disabled', true);
    }

    // Function to handle cascading changes in province, district, and ward
    function handleLocationChange($provinceSelect, $districtSelect, $wardSelect) {
      // Auto-select "Thành phố Hồ Chí Minh" and populate districts on load
      // $districtSelect.html('<option value="">Select Quận/Huyện</option>');
      // $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

      $.each(data[0].Districts, function(index, district) {
        $districtSelect.append(`<option value="${district.Name}">${district.Name}</option>`);
      });
      $districtSelect.prop('disabled', false);

      $districtSelect.on('change', function() {
        $wardSelect.html('<option value="">Select Phường/Xã</option>');

        var selectedDistrict = data[0].Districts.find(d => d.Name === $(this).val());

        if (selectedDistrict) {
          var sortedWards = selectedDistrict.Wards.sort((a, b) => a.Name.localeCompare(b.Name));
          $.each(sortedWards, function (index, ward) {
              $wardSelect.append(`<option value="${ward.Name}">${ward.Name}</option>`);
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
    if ($locationFields.find('> .address-group').length < maxFields) {
      var newGroup = `
        <div class="address-group pb-16 location_${fieldCount}"  data-index="${fieldCount}">
        <div class="card-body">
          <div class="card-header">
            <h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
          </div>
          <div class="row">
								<div class="city col-4 pb-16">
									<select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
										<option value="">Select Tỉnh/Thành phố</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" disabled>
										<option value="">Quận/Huyện*</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" disabled>
										<option value="">Phường/Xã*</option>
									</select>
								</div>
								<div class="col-12 pb-16">
									<input id="address_${fieldCount}" type="text" class="form-control address" placeholder="Địa chỉ cụ thể*" name="locations[${fieldCount}][address]" />
								</div>
								</div>
                <div class="group-note">
                  <div class="note_shipper hidden pb-16">
                    <input type="text" name="locations[${fieldCount}][note_shipper]" placeholder="Note với shipper" />
                  </div>
                  <div class="note_admin hidden pb-16">
                    <input type="text" name="locations[${fieldCount}][note_admin]" placeholder="Note với admin" />
                  </div>
								</div>
                <div class="show-group-note d-f ai-center pt-8 pb-16">
									<span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
								</div>
								<div class="col-12 pb-16">
									<hr>
									<div class="row pt-16">
										<div class="col-6">
											<div class="icheck-primary d-f ai-center">
                        <input type="radio" name="location_active" id="active_${fieldCount}" value="0">
                        <input type="hidden" class="location_active" name="locations[${fieldCount}][active]" value="0" />
                        <label class="pl-4" for="active_${fieldCount}">
                          Đặt làm địa chỉ mặc định
                        </label>
                      </div>
										</div>
										<div class="col-6 text-right delete-location-button">
											<p class="d-f ai-center jc-end"><span>Xóa địa chỉ </span><i class="fas fa-bin-red"></i></p>
										</div>
									</div>
								</div>
							</div>
          </div>
        `;

      $locationFields.append(newGroup);
      var $newProvinceSelect = $(`#province_${fieldCount}`);
      var $newDistrictSelect = $(`#district_${fieldCount}`);
      var $newWardSelect = $(`#ward_${fieldCount}`);

      populateProvinces($newProvinceSelect, '');
      handleLocationChange($newProvinceSelect, $newDistrictSelect, $newWardSelect);
      fieldCount++;
    } else {
      $(".alert.valid-form").show();
      $(".alert.valid-form").text('Chỉ được thêm tối đa 500 địa chỉ.');
      $("html, body").animate({ scrollTop: 0 }, 600);
    }
  });
  // Remove address group functionality
  
}).fail(function() {
  console.error('Error fetching location data');
});