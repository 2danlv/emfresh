<script>
  $(document).ready(function () {
    $('.navigation-bottom .btn-primary').click(function (e) {
      e.preventDefault();
      $('.card-body button.btn-primary').trigger('click');
    });
    $('.content-header .input-search').attr('placeholder', 'Tên khách hàng / SĐT');
    $('.content-header .wrap-search .clear-input').click(function (e) {
      e.preventDefault();
      $('.content-header .wrap-search .input-search').val('');
      $('.content-header .top-results,.content-header .wrap-search .clear-input').hide();
    });
    $('.add-new-member.openmodal').click(function (e) { 
      e.preventDefault();
      $('.modal-addnew_member .card-primary .group-locations-container').text('');
      $('.modal-addnew_member .card-primary input').val('');
    });
    $(document).on('click', '.group-locations .location_field', function (e) {
      var resultItem_length = $(this).closest('.group-locations').find(".location_id");
      if (resultItem_length.val() != '') {
        $(this).closest('.group-locations').find(".group-locations-container").show();
        $(".overlay-drop-menu").show();
      }
    });
    $(document).on('click', '.group-locations .group-locations-container .result-item', function (e) {
      var location_id = $(this).data('location_id');
      var other_address = $(this).find(".other-address").text();
      $(this).closest('.card-body').find('.group-locations .location_id,.group-locations .location_field').val(other_address);
      $(".overlay-drop-menu,.group-locations-container").hide();
    });
    $(".overlay-drop-menu").on("click", function () {
      $('.overlay-drop-menu,.group-locations-container,.group-search-results').hide();
    });
  });
  $('.box-search .search-cus').keyup(function () {
    var query = $(this).val();
    //$('.no-results .btn-add-customer').attr('href', '/customer/add-customer/?phone='+query);
    $(this).closest('.box-search').find('.group-search-results').show();
    if (query.length > 2) {
      $(".overlay-drop-menu").show();
      $.ajax({
        url: '<?php echo home_url('em-api/customer/list/?limit=-1'); ?>',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          //console.log('customer', response.data);
          var suggestions = '';
          var results = response.data.filter(function (customer) {
            return customer.customer_name.toLowerCase().includes(query.toLowerCase()) ||
              customer.phone.includes(query)
          });

          if (results.length > 0) {
            suggestions = results.map(customer =>
              `<div class="result-item pb-4 pt-4" data-id="${customer.id}">
                  <p class="name">${customer.customer_name}</p>
                  <p class="phone">${customer.phone}</p>
                  <p class="address d-none">${customer.address + ', ' + customer.ward + ', ' + customer.district}</p>
              </div>`
            ).join("\n");


            $('.group-search-autocomplete-results').html(suggestions);
          } else {
            $('.group-search-results').hide();
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data from API');
          $('.group-search-results').hide();
        }
      });
    } else {
      $('.group-search-results').hide();
    }
  });
  $(document).on('click', '.autocomplete-results .result-item', function () {
    $('.overlay-drop-menu,.group-locations-container,.group-search-results').hide();
    var name = $(this).find('.name').text();
    var phone = $(this).find('.phone').text();
    var address = $(this).find('.address').text();
    var note_shiper = $(this).find('.note_shiper').text();
    var note_admin = $(this).find('.note_admin').text();
    var customer_id = $(this).data('id') || 0;
    var location_id = 0;
    $(this).closest('.card-body').find('.form-control.fullname,.box-search .search-cus').val(name);
    $(this).closest('.card-body').find('.form-control.phone').val(phone);
    $(this).closest('.card-body').find('.group-locations .location_id,.group-locations .location_field').val(address);

    $('.group-search-results').hide();
    $('.form-add-order .input-customer_id').val(customer_id);

    if (customer_id > 0) {
      getLocation(customer_id, location_id);
    }
  });
  function getLocation(customer_id, location_id) {
    $.ajax({
      url: '<?php echo home_url('em-api/location/list/'); ?>?customer_id=' + customer_id,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        const container = $('.group-locations-container');
        container.empty();

        response.data.forEach(location => {
          if (location.active == 1 && location_id == 0) {
            location_id = location.id;
            $('.input-location_id').val(location_id);
          }

          const template = `
                        <div class="result-item" data-location_id="${location.id}">
                            <p class="fs-16 color-black other-address">${location.location_name}</p>
                        </div>
                    `;
          container.append(template);
        });
      },
      error: function (xhr, status, error) {
        console.error('Error fetching data from API', error);
      }
    });
  }
</script>