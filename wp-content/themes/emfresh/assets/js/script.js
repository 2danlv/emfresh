jQuery(document).ready(function () {
    $('.select2').select2();
  if (!DataTable.isDataTable('.table-list-customer')) {
    var table = $('.table-list-customer').DataTable({
      scrollX: true,
        language: {
            paginate: {
                previous: '<i class="fas fa-left"></i>',
                next: '<i class="fas fa-right"></i>',
            },
            searchBuilder: {
                button: {
                    0: '<i class="fas fa-filter"></i> Bộ lọc',
                    _: '<i class="fas fa-filter"></i> Bộ lọc (%d)',
                },
                add: '<i class="fas fa-plus"></i> Thêm điều kiện',
                condition: 'Chọn biểu thức',
                clearAll: 'Xóa tất cả bộ lọc',
                delete: '<i class="fas fa-trash"></i>',
                deleteTitle: 'Xóa lọc',
                data: 'Chọn cột',
                //left: 'Left',
                //leftTitle: 'Left Title',
                logicAnd: 'Và',
                logicOr: 'Hoặc',
                //right: 'Right',
                //rightTitle: 'Right Title',
                title: {
                    0: 'Điều kiện lọc',
                    _: 'Điều kiện lọc (%d)',
                },
                value: 'Giá trị',
                valueJoiner: '-',
                conditions: {
                    date: {
                        between: 'Trong khoản',
                        empty: 'Rỗng',
                        equals: 'Bằng',
                        after: 'Trước ngày',
                        before: 'Sau ngày',
                        gt: 'Lớn hơn',
                        gte: 'Lớn hơn bằng',
                        lt: 'Nhỏ hơn',
                        lte: 'Nhỏ hơn bằng',
                        not: 'Khác',
                        notBetween: 'Ngoài khoản',
                        notEmpty: 'Không rỗng',
                    },
                    number: {
                        between: 'Trong khoản',
                        empty: 'Rỗng',
                        equals: 'Bằng',
                        gt: 'Lớn hơn',
                        gte: 'Lớn hơn bằng',
                        lt: 'Nhỏ hơn',
                        lte: 'Nhỏ hơn bằng',
                        not: 'Khác',
                        notBetween: 'Ngoài khoản',
                        notEmpty: 'Không rỗng',
                    },
                    string: {
                        between: 'Trong khoản',
                        empty: 'Rỗng',
                        equals: 'Bằng',
                        gt: 'Lớn hơn',
                        gte: 'Lớn hơn bằng',
                        lt: 'Nhỏ hơn',
                        lte: 'Nhỏ hơn bằng',
                        not: 'Khác',
                        notBetween: 'Ngoài khoản',
                        notEmpty: 'Không rỗng',
                        contains: 'Chứa',
                        endsWith: 'Kết thúc với',
                        notContains: 'Không chứa',
                        notEndsWith: 'Không kết thúc với',
                        notStartsWith: 'Không bắt đầu với',
                        startsWith: 'Bắt đầu với',
                    },
                },
            },
        },
        layout: {
            //top1: 'searchBuilder',
            //  topStart: {
            //      buttons: [
            //          {
            //              extend: 'searchBuilder',
            //              config: {
            //                  depthLimit: 0,
            //                  columns: [1,2,4,5,6,7,8,9,10,11]
            //              }
            //          }
            //      ]
            //  }
        },
        buttons: [
            // {
            //   text: "Date range",
            //   attr: {
            //       id: "reportrange",
            //   },
            // },
            {
                extend: 'searchBuilder',
                attr: {
                    id: 'searchBuilder',
                },
                config: {
                    depthLimit: 0,
                    columns: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12,13,14,15,16]
                },
            },
        ],
        dom: 'Bfrtip<"bottom"pl>',
        responsive: true,
        autoWidth: true,
        //"buttons": ["csv", "excel", "pdf"],
        order: [[16, 'desc']],
        lengthChange: true,
        lengthMenu: [
            [50, 100, 200],
            ['50 / trang', '100 / trang', '200 / trang'],
        ],
        
        columnDefs: [
            {
                type: 'natural',
                targets: [0, 1, 2, 3,5,6,7,8,15,16],
                orderable: false,
            },
            { visible: false, targets: [4,6,7,8,12,14] },
        ],
    });
    $('.filter input[type="checkbox"]').on('change', function (e) {
        var column = table.columns([$(this).attr('data-column')]);

        // if checked hide else show
        if ($(this).is(":checked")) {
          column.visible(true);
        } else {
          column.visible(false);
        }
    });

    $('#checkall').change(function () {
        $('.checkbox-element').prop('checked', this.checked);
    });
    $('.checkbox-element').change(function () {
        if ($('.checkbox-element:checked').length == $('.checkbox-element').length) {
            $('#checkall').prop('checked', true);
        } else {
            $('#checkall').prop('checked', false);
        }
    });

    // $('.box').hide();
    // $('.field')
    //     .change(function () {
    //         $('.box').hide();
    //         $('.box select').prop('selectedIndex', 0);
    //         $('.' + $(this).val()).show();
    //     })
    //     .change();
    $('.checkbox-element').change(function () {
        updateAllChecked();
    });

    $('#checkall').change(function () {
        if (this.checked) {
            $('.checkbox-element').prop('checked', true).change();
        } else {
            $('.checkbox-element').prop('checked', false).change();
        }
    });

    $('.quick-edit').click(function (e) {
        e.preventDefault();
        if ($('.list_id').val() == '') {
            alert('Hãy chọn ô khách hàng để chỉnh sửa nhanh!');
            return false;
        }
        open_modal(this);
    });
    $('#modal-edit .add_post').click(function (e) {
        //e.preventDefault();
        var status_order = $('#modal-edit .status_order select').val();
        var status_pay = $('#modal-edit .status_pay select').val();
        var tag = $('#modal-edit .tag select').val();
        if (tag == 0) {
            alert('Hãy chọn value!');
            return false;
        }
    });

    $('.modal-button').click(function (ev) {
        ev.preventDefault();
        open_modal(this);
    });

    $('.modal-close').click(function () {
        $('.modal').removeClass('is-active');
        $('body').removeClass('overflow');
    });
    $('.btn-fillter').click(function () {
        $('button.dt-button').trigger('click');
    });

    $('.input-search').keyup(function () {
        table.search($(this).val()).draw();
    });
    

    function updateAllChecked() {
        $('.list_id').val('');
        $('.checkbox-element').each(function () {
            if (this.checked) {
                let old_text = $('.list_id').val() ? $('.list_id').val() + ',' : '';
                $('.list_id').val(old_text + $(this).val());
            }
        });
    }
    $(document).on('click', '.daterangepicker .ranges ul li:first', function (e, picker) {
      e.preventDefault();
      table.draw();
      // daterangepicker.ranges({
      //   start: null,
      //   end: null
      // });
      return false;
  });
  $('.btn-time').daterangepicker({
      maxDate: moment().startOf('day'),
      timePicker: false,
      opens: 'center',
      singleDatePicker: false,
      showCustomRangeLabel: false,
      ranges: {
          'All time (Tối đa)': '',
          '1 tuần qua': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
          '2 tuần qua': [moment().subtract(13, 'days').startOf('day'), moment().endOf('day')],
          '1 tháng qua': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          '3 tháng qua': [moment().subtract(3, 'months').startOf('month'), moment().endOf('month')],
          '6 tháng qua': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
          '1 năm qua': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
      },
      locale: { cancelLabel: 'Hủy', applyLabel: 'Áp dụng' },
  });

  $('.btn-time').on('apply.daterangepicker', function (ev, picker) {
      var start = picker.startDate;
      var end = picker.endDate;
      $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
          var min = start;
          var max = end;
          var startDate = new Date(data[16]);

          if (min == null && max == null) {
              return true;
          }
          if (min == null && startDate <= max) {
              return true;
          }
          if (max == null && startDate >= min) {
              return true;
          }
          if (startDate <= max && startDate >= min) {
              return true;
          }
          return false;
      }); //external search ends here

      table.draw();
      $.fn.dataTable.ext.search.pop();
  });
  var $checkboxes = $('.table-list-customer td input[type="checkbox"]');
  $checkboxes.change(function () {
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      if (countCheckedCheckboxes > 0) {
          $('li.status').show();
          $('.count-checked').text(countCheckedCheckboxes);
          $('li.status').on('click', function (e) {
              $('.table-list-customer input[type="checkbox"]').prop('checked', false);
              $(this).hide();
          });
      } else {
          $('li.status').hide();
      }
  });
  }
    $('.copy').on('click', function () {
        const textToCopy = $(this).text();

        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(textToCopy).select();

        document.execCommand('copy');

        tempInput.remove();

        //alert('Đã copy số điện thoại: ' + textToCopy);
    });
    function open_modal(el) {
      var modaltarget = $(el).data('target');
      $(modaltarget).addClass('is-active');
      $('body').addClass('overflow');
  }
  $('.resize').click(function (e) { 
    e.preventDefault();
    $(this).toggleClass('active');
    $('.sidebar').toggleClass('width-10');;
    $('.content-wrapper').toggleClass('width-90');;
  });
  jQuery('ul.tabNavigation li').click(function() {
    switch_tabs(jQuery(this));
    $('.card-primary').removeClass('width-100');
    });
    switch_tabs(jQuery('.defaulttab'));
    jQuery('ul.tabNavigation li[rel="settings"],ul.tabNavigation li[rel="history"]').click(function() {
        $('.card-primary').addClass('width-100');
    });
});
function switch_tabs(obj) {
    jQuery('.tab-pane').stop().fadeOut(1);
    jQuery('ul.tabNavigation li').removeClass("selected");
    var id = obj.attr("rel");
    jQuery('#' + id).stop().fadeIn(300);
    //jQuery('#'+id).show();
    obj.addClass("selected");
}