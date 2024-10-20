var ass = new Assistant();
$(document).ready(function () {
  $('#location-fields').on('change','[name="location_active"]', function(){
    $('.location_active').val(0);
    $('.address-group').removeClass('location_1');
    if(this.checked) {
      $(this).next('.location_active').val(1);
      $(this).parents('.address-group').addClass('location_1');
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
});

var $locationFields = $('#location-fields');
var $addButton = $('#add-location-button');
var fieldCount = 1;
var maxFields = 5;
$(document).on('click', '.delete-location-button', function(e) {
  e.preventDefault();
  $(this).closest('.address-group').remove();
});
// Fetching data from the new API endpoint
$.getJSON('/assets/data/city.json', function(data) {

   // Function to populate the province (Thành phố Hồ Chí Minh) dropdown
   function populateProvinces($selectElement, selectedValue) {
      $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
      var option = `<option value="${data[0].Name}" ${selectedValue === data[0].Name ? 'selected' : ''}>${data[0].Name}</option>`;
      $selectElement.append(option);
    }

    // Function to handle cascading changes in province, district, and ward
    function handleLocationChange($provinceSelect, $districtSelect, $wardSelect) {
      $provinceSelect.on('change', function() {
        $districtSelect.html('<option value="">Select Quận/Huyện</option>');
        $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

        if ($(this).val() === data[0].Name) {
          $.each(data[0].Districts, function(index, district) {
            $districtSelect.append(`<option value="${district.Name}">${district.Name}</option>`);
          });
          $districtSelect.prop('disabled', false);
        } else {
          $districtSelect.prop('disabled', true);
        }
      });

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
      <div class="address-group">
      <hr>
          <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                      <div class="icheck-primary d-inline mr-2">
                        <input type="radio" name="location_active" id="active_${fieldCount}" value="0">
                        <input type="hidden" class="location_active" name="locations[${fieldCount}][active]" value="0" />
                        <label for="active_${fieldCount}">
                          Mặc định
                        </label>
                      </div>
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
          <div class="form-group row">
            <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
            <div class="col-sm-9">
              <input id="address_${fieldCount}" class="form-control" name="locations[${fieldCount}][address]" required />
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