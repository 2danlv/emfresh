<script>
  
  jQuery(function ($) {
    var itemCounts = {};
    date_is_today = moment().format("YYYY-MM-DD");
    console.log('log',date_is_today);
    $('.content-header .input-search').attr('placeholder', 'Tên khách hàng / SĐT');
    setTimeout(() => {
      if ($('#target').length > 0) {
        var targetOffset = $('#target').offset().left;
        var offsetWithMargin = targetOffset - 736;
        $(".dt-scroll-body").animate({scrollLeft: offsetWithMargin}, 1000);
      }
    }, 300);
      $('.list-item_name p').each(function() {
        var itemText = $(this).text().trim();
        var items = itemText.split('+');
        items.forEach(function(item) {
          var quantity = parseInt(item.match(/\d+/)[0]);
          var code = item.match(/[A-Za-z]+/)[0];
          if (itemCounts[code]) {
            itemCounts[code] += quantity;
          } else {
            itemCounts[code] = quantity;
          }
        });
      });
      var result = [];
      for (var code in itemCounts) {
        result.push(itemCounts[code] + code); // Format as "count+code"
      }
      $('.list-item_name .item_name').text(result.join('+'));
    $('.accordion-content_table .wrap-date li').each(function () {
      var emptyDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
      var data_date_start = $(this).closest('ul.date-group').attr('data-date_start');
      var data_date_stop = $(this).closest('ul.date-group').attr('data-date_stop');
      var dateStop = new Date(data_date_stop);
      //console.log('log',moment(dateStop).format("YYYY-MM-DD"));
      if ($(this).find('.input-meal_plan').val() != '' && dateStop < emptyDate) {
        $(this).addClass('just-edit');
      }
      if (date_is_today > moment(emptyDate).format("YYYY-MM-DD")) {
        $(this).find('input').addClass('is-disabled');
      }
      if (date_is_today > data_date_start &&  $(this).hasClass('empty') ) {
        //$(this).find('input').addClass('is-disabled');
      }
    });
    $('.accordion-content_table .wrap-date li.empty').each(function () {
      var emptyDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
      var shouldEdit = false;

      // Loop through sibling li elements that have class green or orange
      $(this).siblings('li.green, li.orange').each(function () {
        var filledDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
        if (emptyDate > filledDate) {
          shouldEdit = true;
          return false; // Exit loop early when condition is met
        }
      });

      if (shouldEdit) {
        $(this).addClass('edit');
      } else {

      }
    });

    $('.accordion-tit_table').each(function () {

      $(this).find('.wrap-date li:not(.empty) span').each(function () {
        var dateAttrValue = $(this).attr('data-date');
        if (dateAttrValue) {

          var count_green = $('.accordion-tit_table .wrap-date li.green span[data-date="' + dateAttrValue + '"]').length;
          var count_orange = $('.accordion-tit_table .wrap-date li.orange span[data-date="' + dateAttrValue + '"]').length;
          if (count_green > 0 && count_orange > 0) {
            $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('purple');
          }
        }
      });
      $(this).find('.wrap-date li:not(.empty)').each(function () {
        if ($(this).hasClass('payment')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('payment');
        }
        if ($(this).hasClass('orange')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('orange');
        }
        if ($(this).hasClass('green')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').removeClass('orange');
        }
      });

    });


    $(document).on('change', '.input-meal_plan', function () {
      let input = $(this),
        value = input.val();
      $('.save-meal-plan').removeClass('hidden');
      input.closest('.order-item').toggleClass('changed', value != input.data('old'));
    });
    $('.js-save-meal-plan').on('click', function (e) {
      e.preventDefault();

      let list_meal = [],
        errors = [];

      $('.js-meal-plan .order-item.changed').each(function () {
        let p = $(this),
          meal_plan = {},
          total = parseInt(p.data('total')),
          count = 0;

        p.find('.input-meal_plan').each(function () {
          let input = $(this), value = +input.val();

          if (value > 0) {
            meal_plan[input.data('date')] = value;

            count += value;
          }
        })

        if (total == count) {
          list_meal.push({
            order_id: p.data('order_id'),
            order_item_id: p.data('order_item_id'),
            meal_plan: meal_plan
          });
        } else {
          errors.push(p.find('.title').text());
        }
        if (total > count) {
          $('#modal-warning-input').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning-input .modal-body p.notice_warning').text('Bạn nhập thiếu phần ăn: ' + (total - count));
          $('.modal-warning-input .modal-footer .create_discount').show();
          $('.modal-warning-input .modal-footer .link_order').hide();
          return;
        }
        if (total < count) {
          $('#modal-warning-input').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning-input .modal-body p.notice_warning').text('Bạn nhập dư phần ăn: ' + (count - total));
          $('.modal-warning-input .modal-footer .create_discount').hide();
          $('.modal-warning-input .modal-footer .link_order').show();
          $('.modal-warning-input .modal-footer a.link_order_detail').attr('href', '/list-order/chi-tiet-don-hang/?order_id='+ p.data('order_id'));
          return;
        }
      });

      if (errors.length > 0) {
        // $('#modal-alert').addClass('is-active');
        // $('body').addClass('overflow');
        // $('.modal-warning .modal-body p span.txt_append').text('Vui lòng kiểm tra số bữa ăn: ' + errors.join(", "));
        return;
      }


      if (list_meal.length == 0) return;

      $.post('?', {
        ajax: 1,
        save_meal_plan: 1,
        list_meal: list_meal
      }, function (res) {

        console.log('res', res);

        if (res.code == 200) {
          $('#modal-alert').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning .modal-body p span.txt_append').text('Lưu thành công!');
          $('#modal-alert .modal-close, #modal-alert .overlay').click(function (e) {
            e.preventDefault();
            location.reload();
          });
        } else {
          $('#modal-alert').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning .modal-body p span.txt_append').text("Lưu không thành công!");
        }
      }, 'JSON');
    })

    $('.btn-show-count').click(function (e) {
      e.preventDefault();
      $(this).addClass('selected');
      $('.count-group input').val('');
      $('.count-group').addClass('is-show');
      $('table.table tbody tr td.wrap-date .date-group li input').addClass('is-disabled');
    });
    $('.count-group .count-close').click(function (e) {
      e.preventDefault();
      $('.count-group').removeClass('is-show');
      $('.btn-show-count').removeClass('selected');
      $('.count-group .count-result').removeClass('have-result');
      $('table.table tbody tr td.wrap-date .date-group li input').removeClass('is-disabled');
      $('.count-group .count-result span').text('-');
      $('.accordion-tit_table').removeClass('select');
      $('.accordion-content_table').removeClass('sub_select');
    });
    $(document).on('click', '.accordion-tit_table td.td-calc', function (e) {
      e.preventDefault();
      var row = $(this).closest('.accordion-tit_table');
      var customer_name = row.attr('data-customer_name');
      var order_number = row.find('.order-number').text();
      var order_name = row.find('.order-prod').text();
      $('.wrap-date li').removeClass('select_startday select_endday');
      if ($('.count-group').hasClass('is-show')) {
        $('.count-group .customer_name').val(customer_name);
        $('.count-group .count-number').val(order_number);
        $('.count-group .count-prod_name').val(order_name);
        $('.accordion-tit_table').removeClass('select');
        $('.accordion-content_table').removeClass('sub_select');
        row.addClass('select');
        $('.count-group .count-start_day,.count-group .count-end_day').val('');
        $('.count-group .count-result').removeClass('have-result');
        $('.count-group .count-result span').text('-');
      }
    });
    $(document).on('click', '.accordion-content_table td.sub-td-calc', function (e) {
      e.preventDefault(); // Prevent the default action
      var sub_row = $(this).closest('.accordion-content_table');
      var prevRow = sub_row.prevAll('.accordion-tit_table').first();
      var sub_customer_name = prevRow.attr('data-customer_name');
      var sub_order_number = prevRow.find('.order-number').text();
      var sub_order_name = sub_row.find('.ellipsis').text();
      $('.wrap-date li').removeClass('select_startday select_endday');
      if ($('.count-group').hasClass('is-show')) {
        $('.count-group .customer_name').val(sub_customer_name);
        $('.count-group .count-number').val(sub_order_number);
        $('.count-group .count-prod_name').val(sub_order_name);
        $('.accordion-tit_table').removeClass('select');
        $('.accordion-content_table').removeClass('sub_select');
        sub_row.addClass('sub_select');
        $('.count-group .count-start_day,.count-group .count-end_day').val('');
        $('.count-group .count-result').removeClass('have-result');
        $('.count-group .count-result span').text('-');
      }
    });
    $(document).on('click', '.accordion-tit_table.select .wrap-date li:not(.empty)', function (e) {
      e.preventDefault();
      var day = $(this).find('span').attr('data-date');
      $('.wrap-date').removeClass('tit-count');
      $('.wrap-date').removeClass('sub_tit-count');
      $(this).closest('.wrap-date').addClass('tit-count');
      if ($('.count-group .count-start_day').val() == '') {
        $('.count-group .count-start_day').val(day);
        $(this).addClass('select_startday');
      } else {
        $('.count-group .count-end_day').val(day);
        $('.accordion-tit_table.select .wrap-date li').removeClass('select_endday');
        $(this).addClass('select_endday');
      }
    });
    $(document).on('click', '.accordion-content_table.sub_select .wrap-date li:not(.empty)', function (e) {
      e.preventDefault();
      var sub_day = $(this).find('.input-meal_plan').attr('data-date');
      $('.wrap-date').removeClass('sub_tit-count');
      $('.wrap-date').removeClass('tit-count');
      $(this).closest('.wrap-date').addClass('sub_tit-count');
      if ($('.count-group .count-start_day').val() == '') {
        $('.count-group .count-start_day').val(sub_day);
        $(this).addClass('select_startday');
      } else {
        $('.count-group .count-end_day').val(sub_day);
        $('.accordion-content_table.sub_select .wrap-date li').removeClass('select_endday');
        $(this).addClass('select_endday');
      }
    });
    $('.count-group .confirm-calc').click(function (e) {
      e.preventDefault();
      var startDate = $('.count-group .count-start_day').val();
      var endDate = $('.count-group .count-end_day').val();
      if (!startDate || !endDate) {
        $('#modal-alert').addClass('is-active');
        $('body').addClass('overflow');
        $('.modal-warning .modal-body p span.txt_append').text('Hãy chọn ngày bắt đầu và kết thúc!');
        return;
      }
      var start = new Date(startDate);
      var end = new Date(endDate);
      if (start > end) {
        $('#modal-alert').addClass('is-active');
        $('body').addClass('overflow');
        $('.modal-warning .modal-body p span.txt_append').text('Ngày bắt đầu không thể nhỏ hơn ngày kết thúc.');
        return;
      }
      var totalPortions = 0;
      var totalDays = 0;
      if ($('.accordion-tit_table.select .wrap-date').hasClass('tit-count')) {
        $('.accordion-tit_table.select .wrap-date li:not(.empty) span').each(function () {
          var date = $(this).data('date');
          if (new Date(date) >= start && new Date(date) <= end && $(this).text() !== '') {
            totalDays++;
            totalPortions += parseInt($(this).text()) || 0;
          }
        });
      }
      if ($('.accordion-content_table.sub_select .wrap-date').hasClass('sub_tit-count')) {
        $('.accordion-content_table.sub_select .wrap-date li:not(.empty)').each(function () {
          var date = $(this).find('.input-meal_plan').data('date');
          if (new Date(date) >= start && new Date(date) <= end && $(this).text() !== '') {
            totalDays++;
            totalPortions += parseInt($(this).find('.input-meal_plan').val()) || 0;
          }
        });
      }
      $('.count-group .count-result').addClass('have-result');
      $('.count-group .date-use').text(totalDays);
      $('.count-group .number-use').text(totalPortions);
    });
    
    $('.content-header .wrap-search .clear-input').click(function (e) {
      e.preventDefault();
      $('.content-header .wrap-search .input-search').val('');
      $('.content-header .top-results,.content-header .wrap-search .clear-input').hide();
    });
  });
  $('.input-search').keyup(function () {
    var query = $(this).val();
    //$('.no-results .btn-add-customer').attr('href', '/customer/add-customer/?phone='+query);
    $('.content-header .wrap-search .clear-input').show();
    if (query.length > 2) {
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
                  <p><a href="/meal-detail/?customer_id=${customer.id}" >${customer.customer_name} <br>
                  ${customer.phone}</a></p>
              </div>`
            ).join("\n");

            $('.top-results,.overlay').show();
            $('.top-results #top-autocomplete-results').html(suggestions);
          } else {
            $('.top-results').hide();
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data from API');
          $('#autocomplete-results').hide();
        }
      });
    } else {
      $('.top-results').hide();
    }
  });
</script>