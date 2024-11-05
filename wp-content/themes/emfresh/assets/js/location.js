var ass = new Assistant();
$(document).ready(function () {
  $('#location-fields').on('change','[name="location_active"]', function(){
    $('.location_active').val(0);
    $('.address-group').removeClass('address_active');
    if(this.checked) {
      $(this).next('.location_active').val(1);
      $(this).parents('.address-group').addClass('address_active');
    }
  });
});
$('.btn-primary[name="add_post"]').on('click', function(e) {
    if (!ass.checkPhone($('input[type="tel"]').val())) {
        // $('input[type="tel"]').addClass('error');
        alert("Số điện thoại không đúng định dạng !");
        return false;
    } else {
        $('input[type="tel"]').removeClass('error');
    }
    if ($('#phone_status').html() == "OK") {
      e.stopPropagation();
      $('.btn-primary[name="add_post"]').css({
        "display": "none"
      });
      setTimeout(() => {
        $('.btn-primary[name="add_post"]').css({
          "display": "inline"
        });
      }, 2000);
      //document.getElementById('customer-form').submit();
    } else {
      alert('Số điện thoại đã tồn tại!');
      e.preventDefault();
      return false;
    }
    if($('.gender').val() == 0) {
      alert('Chưa chọn giới tính');
      return false;
    }
});

var $locationFields = $('#location-fields');
var $addButton = $('.add-location-button');
var fieldCount = 1;
var maxFields = 5;
$(document).on('click', '.delete-location-button', function(e) {
  e.preventDefault();
  $(this).closest('.address-group').remove();
  fieldCount--;
});
// Fetching data from the new API endpoint
$.getJSON('/assets/data/city.json', function(data) {

   // Function to populate the province (Thành phố Hồ Chí Minh) dropdown
   function populateProvinces($selectElement, selectedValue) {
      $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
      var option = `<option value="${data[0].Name}" selected>${data[0].Name}</option>`;
      $selectElement.append(option);
      $selectElement.prop('disabled', true);
    }

    // Function to handle cascading changes in province, district, and ward
    function handleLocationChange($provinceSelect, $districtSelect, $wardSelect) {
      // Auto-select "Thành phố Hồ Chí Minh" and populate districts on load
      $districtSelect.html('<option value="">Select Quận/Huyện</option>');
      $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

      $.each(data[0].Districts, function(index, district) {
        $districtSelect.append(`<option value="${district.Name}">${district.Name}</option>`);
      });
      $districtSelect.prop('disabled', false);

      $districtSelect.on('change', function() {
        $wardSelect.html('<option value="">Select Phường/Xã</option>');

        var selectedDistrict = data[0].Districts.find(d => d.Name === $(this).val());

        if (selectedDistrict) {
          $.each(selectedDistrict.Wards, function(index, ward) {
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
    if (fieldCount < maxFields) {
      var newGroup = `
        <div class="address-group location_${fieldCount}">
        <div class="row">
								<div class="city col-12 pb-16">
									<select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
										<option value="">Select Tỉnh/Thành phố</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" required disabled>
										<option value="">Quận/Huyện*</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" required disabled>
										<option value="">Phường/Xã*</option>
									</select>
								</div>
								<div class="col-4 pb-16">
									<input id="address_${fieldCount}" type="text" class="form-control" placeholder="Địa chỉ cụ thể*" name="locations[${fieldCount}][address]" required />
								</div>
								</div>
                <div class="note_ship row pb-8">
									<div class="col-4">
										<select id="note_ship_[${fieldCount}]" name="locations[${fieldCount}][note_ship]">
											<option value="">Note với shipper</option>
										</select>
									</div>
									<div class="col-8">
										<input type="text" id="note_ship_[${fieldCount}]" name="locations[${fieldCount}][note_ship]">
									</div>
								</div>
								<div class="col-12 pb-16">
									<p class="d-f ai-center pb-8"><i class="fas fa-plus"></i><span class="bg-gradient-primary" id="add-location-button">Thêm ghi chú giao hàng</span></p>
									<hr>
									<div class="row pt-8">
										<div class="col-6">
											<div class="icheck-primary">
                        <input type="radio" name="location_active" id="active_${fieldCount}" value="0">
                        <input type="hidden" class="location_active" name="locations[${fieldCount}][active]" value="0" />
                        <label for="active_${fieldCount}">
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
        `;

      $locationFields.append(newGroup);
      var $newProvinceSelect = $(`#province_${fieldCount}`);
      var $newDistrictSelect = $(`#district_${fieldCount}`);
      var $newWardSelect = $(`#ward_${fieldCount}`);

      populateProvinces($newProvinceSelect, '');
      handleLocationChange($newProvinceSelect, $newDistrictSelect, $newWardSelect);
      fieldCount++;
    } else {
      alert('Chỉ được thêm tối đa 5 địa chỉ.');
    }
  });
  // Remove address group functionality
  
}).fail(function() {
  console.error('Error fetching location data');
});