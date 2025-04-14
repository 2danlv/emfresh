<script>
  $(document).ready(function () {
    var numberOfRows = $('.table-member tbody tr').length;
    let index;
    if (numberOfRows > 0) {
      index = numberOfRows;
    } else {
      index = 1;
    }
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
      $(".modal-addnew_member .card-primary .alert").hide();
      $('.modal-addnew_member .card-primary .group-locations-container').text('');
      $('.modal-addnew_member .card-primary input').val('');
      $('.modal-addnew_member .card-primary input.bag').prop('checked', false);
      $('.modal-addnew_member .card-primary input.no_order').val(index + 1);
      $(".modal-addnew_member .card-primary input.no_order").attr({
        "min" : index + 1
      });
    });
    $(document).on("blur", ".modal-addnew_member .card-primary input.no_order", function () {
      let $input = $(this).val();
      let $input_min = $(this).attr('min');
      if ($input < $input_min) {
        $(".modal-addnew_member .card-primary input.no_order").val($input_min);
        $(".modal-addnew_member .card-primary .alert").text('Số thứ tự phải lớn hơn số ' + $input_min);
        $(".modal-addnew_member .card-primary .alert").show();
      }
    });
    $('.modal-addnew_member .btn-primary').click(function (e) { 
      e.preventDefault();
      var idMember = $(this).closest('.modal-dialog').find('.input-customer_id').val();
      var nameMember = $(this).closest('.modal-dialog').find('.fullname').val();
      var phoneMember = $(this).closest('.modal-dialog').find('.phone.form-control').val();
      var order = $(this).closest('.modal-dialog').find('.no_order').val();
      if (nameMember == "" ) {
        $(".modal-addnew_member .card-primary .alert").text('Hãy chọn tên khách hàng để thêm');
        $(".modal-addnew_member .card-primary .alert").show();
        return false;
      }
      if (order == '') {
        var order = index + 1;
      } else {
        var order = order;
      }
      if ($(this).closest('.modal-dialog').find('.bag').prop('checked')) {
        var bagMember = 1;
        var checkbox = `<input type="checkbox" checked class="mt-4">`;
      } else {
        var bagMember = 0;
        var checkbox = `<input type="checkbox" class="mt-4">`;
      }
      let newInput = `<tr data-member="${idMember}">
                          <td class="text-center"><input type="number" name="customers[${index}][order]" class="input-order text-center" value="${order}" /></td>
                          <td>
                              <div class="nameMember">${nameMember}</div>
                              <input type="hidden" name="customers[${index}][order]" value="${order}" />
                              <input type="hidden" name="customers[${index}][id]" value="${idMember}" />
                              <input type="hidden" name="customers[${index}][phone]" value="${phoneMember}" />
                              <input type="hidden" name="customers[${index}][bag]" class="input-bag" value="${bagMember}" />
                          </td>
                          <td><span class="copy modal-button" data-target="#modal-copy" title="Copy">${phoneMember}</span></td>
                          <td class="text-center"><span class="status_order status_order-1">Đang dùng</span></td>
                          <td class="text-center">
                              ${checkbox}
                          </td>
                          <td class="text-center"><img src="<?php site_the_assets('img/icon/delete-svgrepo-com-red.svg'); ?>" class="openmodal remove-member mt-2"  data-target="#modal-delete-member" alt=""></td>
                      </tr>`;
      
      // Append the new input field to the container
      $('.table-member tbody').append(newInput);
      // Increment the index for the next input field
      $('.modal').removeClass('is-active');
      $('body').removeClass('overflow');
      index++;
      $('.navigation-bottom .btn-primary').show();
    });
    $(document).on('click', '.table-member tbody td .remove-member', function (e) {
      var nameMember = $(this).closest('.table-member tbody tr').find('.nameMember').text();
      var idMember = $(this).closest('.table-member tbody tr').attr('data-member');
      $('#modal-delete-member .delete_group').hide();
      $('#modal-delete-member .delete_member').show();
      $('#modal-delete-member .modal-body p span').text(nameMember);
      $('#modal-delete-member .modal-body .idMember').val(idMember);
    });
    $(document).on('click', '.table-member tbody td input', function (e) {
       if ($(this).prop('checked')) {
        $(this).closest('.table-member tbody tr').find('.input-bag').val(1);
       } else {
        $(this).closest('.table-member tbody tr').find('.input-bag').val(0);
       }
    });
    $(document).on('click', '#modal-delete-member .modal-footer .btn-remove', function (e) {
      var removeMember = $('#modal-delete-member .modal-body .idMember').val();
      $('.table-member tbody tr').filter(function() {
        return $(this).attr('data-member') == removeMember;
      }).remove();
      index = index - 1 ;
      if (index < 2) {
        $('.navigation-bottom .btn-primary').hide();
      } else {
        $('.navigation-bottom .btn-primary').show();
      }
    });
    $(document).on('click', '.btn-remove_group', function (e) {
      var removeGroup = $(this).attr('data_href');
      $('#modal-delete-member .delete_member').hide();
      $('#modal-delete-member .delete_group').show();
      $('#modal-delete-member .modal-body .delete_group p').text('Bạn có chắc muốn xóa nhóm không?');
      $('#modal-delete-member .modal-footer .delete_group a').attr('href',removeGroup);
      
      
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
      $(this).closest('.card-body').find('.group-locations .location_id').val(location_id);
      $(this).closest('.card-body').find('.group-locations .location_field').val(other_address);
      $(".overlay-drop-menu,.group-locations-container").hide();
    });
    $(".overlay-drop-menu").on("click", function () {
      $('.overlay-drop-menu,.group-locations-container,.group-search-results').hide();
    });
    $('.btn-reload').click(function() {
      location.reload();
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
          // console.log('customer', response.data);
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
                  <p class="status_name d-none">${customer.status_name}</p>
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
  $(document).on('click', 'form .autocomplete-results .result-item', function () {
    $('.overlay-drop-menu,.group-locations-container,.group-search-results').hide();
    var name = $(this).find('.name').text();
    var phone = $(this).find('.phone').text();
    var address = $(this).find('.address').text();
    var customer_id = $(this).data('id') || 0;
    var location_id = 0;
    $(this).closest('.card-body').find('.form-control.fullname,.box-search .search-cus').val(name);
    $(this).closest('.card-body').find('.form-control.phone').val(phone);
    $(this).closest('.card-body').find('.group-locations .location_field').val(address);
    $(this).closest('.card-body').find('.input-customer_id').val(customer_id);
    
    $(this).closest('.card-primary form').find('.first_item_group .nameMember').text(name);
    $(this).closest('.card-primary form').find('.first_item_group .copy').text(phone);
    $(this).closest('.card-primary form').find('.first_item_group .input-customer_id').val(customer_id);
    
    $('.group-search-results').hide();
    $('.group_list-member').show();
    
    if (customer_id > 0) {
      getLocation(customer_id, 0);
    }
  });
  $(document).on('click', '.modal-body .autocomplete-results .result-item', function () {
    $('.overlay-drop-menu,.group-locations-container,.group-search-results').hide();
    var name = $(this).find('.name').text();
    var phone = $(this).find('.phone').text();
    var customer_id = $(this).data('id') || 0;
    $(this).closest('.card-body').find('.form-control.fullname,.box-search .search-cus').val(name);
    $(this).closest('.card-body').find('.form-control.phone').val(phone);
    $(this).closest('.card-body').find('.input-customer_id').val(customer_id);
    
    $('.group-search-results').hide();
    $('.group_list-member').show();
    
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
            container.closest('.group-locations').find('.location_id').val(location_id);
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