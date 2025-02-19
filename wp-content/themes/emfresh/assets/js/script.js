jQuery(document).ready(function () {
	setTimeout( function() {
		$('.alert.alert-success,.alert.alert-warning').fadeOut();
	},4000);
	$('.main-menu .nav-menu li a,.em-importer ul li.add a').click(function (e) {
		//e.preventDefault();
		localStorage.setItem('DataTables_list-customer_/customer/', '');
		for (let i = 1; i <= 18; i++) {
			localStorage.removeItem('column_' + i);
		}
		localStorage.setItem('DataTables_list-order_/list-order/', '');
		for (let i = 1; i <= 23; i++) {
			localStorage.removeItem('column_order_' + i);
		} 
	});
	$('.select2').select2({
		templateSelection: function (data, container) {
			var $result = $("<span></span>");
			$result.text(data.text);
			return $result;
		}
	});
	let tagCondition = {
		"=": {
			conditionName: 'Bằng',
			init: function (that, fn, preDefined = null) {
				var el = $('<select/>')
					.addClass([that.classes.value, that.classes.input])
					.on('input', function () {
						fn(that, this);
					});
				// value is tag
				// if ($('.' + that.classes.data).val() == 6 && typeof list_tags == 'object') {
				if (typeof list_tags == 'object') {
					el.append(`<option selected hidden>Giá trị</option>`);
					list_tags.forEach((text) => {
						text = text.trim();
						value = stringToSlug(text);
						if (text != '') {
							el.append(`<option value="${value}">${text}</option>`);
						}
					});
				}
				if (preDefined !== null) {
					$(el).val(preDefined[0]);
				}
				return el;
			},
			inputValue: function (el) {
				return $(el[0]).val();
			},
			isInputValid: function (el, that) {
				return $(el[0]).val() && $(el[0]).val().length !== 0;
			},
			search: function (value, comparison) {
				if (typeof comparison == 'object' && comparison.length > 0) {
					return value != '' && comparison.filter(text => value.search(text) > -1).length > 0;
				}
				return value % comparison === 0;
			},
		},
		'!=': {
			conditionName: 'Khác',
			init: function (that, fn, preDefined = null) {
				return tagCondition['='].init(that, fn, preDefined);
			},
			inputValue: function (el) {
				return $(el[0]).val();
			},
			isInputValid: function (el, that) {
				return $(el[0]).val() && $(el[0]).val().length !== 0;
			},
			search: function (value, comparison) {
				return !tagCondition['='].search(value, comparison);
			},
		},
	};
	$.fn.dataTable.moment( 'DD/MM/YYYY' );
	var table = $('.table-list-customer').on('init.dt', function () {
		//console.log(this, 'init.dt');
    }).DataTable({
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
				add: '<i class="fas fa-plus mr-8"></i> Thêm điều kiện',
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
					//_: 'Điều kiện lọc (%d)',
				},
				value: 'Giá trị',
				valueJoiner: '-',
				conditions: {
					date: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						after: 'Sau ngày',
						before: 'Trước ngày',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
						notEmpty: 'Không rỗng',
					},
					number: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
						notEmpty: 'Không rỗng',
					},
					string: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
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
		layout: {},
		columnDefs: [
			{
				//type: 'string',
				targets: [0,5,9,16],
				orderable: false,
			},
			{
			 type: 'string', targets: [0,2,3,4,5,8,9]
			},
			{ visible: false, targets: [4,6,7,8,9,13,15,17,19,20] },
			{
				targets: 18,
				render: function(data, type, row) {
					if (type === 'sort') {
					var dateParts = data.split(" ");
					var date = dateParts[1].split("/");
					var time = dateParts[0].split(":");
					return new Date(date[2], date[1] - 1, date[0], time[0], time[1]).toISOString();
					}
					return data;
				}
			},
            {
                targets: [19],
                render: function(data) {
                    return moment(data, 'YYYY/MM/DD').format('DD/MM/YYYY');
                  }
              },
              {
                targets: 20, // Target the first column which contains dates
                render: function(data, type, row) {
                  return moment(data, 'DD/MM/YYYY').format('DD/MM/YYYY');
                }
              }
		],
		buttons: [
			// {
			//	 text: "Date range",
			//	 attr: {
			//		 id: "reportrange",
			//	 },
			// },
			{
				extend: 'searchBuilder',
				attr: {
					id: 'searchBuilder',
				},
				config: {
					conditions:{
                        html: tagCondition,
                    },
					depthLimit: 0,
					columns: [4, 5, 6, 8, 9, 10, 11, 12, 13, 14,15,17,19],
					filterChanged: function (count) {
						if (count == 0 || count == 1) {
							$('.btn-fillter').removeClass('current-filter');
							$('.btn-fillter').text('Bộ lọc');
							$('.dtsb-title').html(`Điều kiện lọc`);
							$('.custom-btn.revert').css('display','none');
						}
						if (count > 1) {
							$('.btn-fillter').addClass('current-filter');
							$('.btn-fillter').html(`Bộ lọc <small>${count - 1}</small>`);
							$('.dtsb-title').html(`Điều kiện lọc (${count - 1})`);
							$('.custom-btn.revert').css('display','block');
						}
					}
				}
			},
		],
		dom: 'Bfrtip<"bottom"pl>',
		responsive: true,
		autoWidth: true,
		fixedColumns: {
			start: 3
		},
		searchBuilder: {
            // Tắt bộ lọc tự động (disable the default behavior)
            preDefined: [] // Không xác định bộ lọc mặc định nào
        },
		scrollCollapse: true,
		scrollX: true,
		//"buttons": ["csv", "excel", "pdf"],
		order: [[18, 'desc']],
		iDisplayLength: 50,
		lengthChange: true,
		lengthMenu: [
			[15,50, 100, 200],
			['15 / trang','50 / trang', '100 / trang', '200 / trang'],
		],
		"stateSave": true,
		scrollY: $(window).height() - 227,
	});
	// Custom searchbuilder filter get value
	$(document).on('dtsb-inserted', function (e) {
        let $selectValue = $(e.target);
        if($selectValue.hasClass('dtsb-value') == false) return;
		dtsbCriteriaUpdateSelectValue($selectValue);
    });
	$(document).on('click', '.btn-fillter', function(){
		$('.dtsb-criteria .dtsb-value.dtsb-select').each(function(){
			dtsbCriteriaUpdateSelectValue($(this));
        });
    });
	function dtsbCriteriaUpdateSelectValue($selectValue)
	{
		let dtsb_criteria = $selectValue.closest('.dtsb-criteria'),
			dtsb_data_value = dtsb_criteria.find('.dtsb-data').val(),
			options = [];
        $selectValue.find('option').each(function(){
            let o = $(this), value = o.val();
            if(o.val() == '') {
                o.hide();
            } else {
				// Dia chi
				if(dtsb_data_value == 4 || dtsb_data_value == 5) {
					value = value.split(' ').map(v => {
						if(!isNaN(v)) {
							v = (v > 9 ? v : '0') + v;
						}
						return v;
					}).join(' ');
				}
                options.push({
                    value: value,
                    element: o
                });
            }
        });
        for (let i = 0; i < options.length - 1; i++) {
            for (let j = i + 1; j < options.length; j++) {
                if(options[j].value < options[i].value){
                    options[j].element.after(options[i].element);
                    let tmp = options[j];
                    options[j] = options[i];
                    options[i] = tmp;
                }
            }
        }
	}
	function getSearchState() {
        var local_storge_table = localStorage.getItem('DataTables_list-customer_/customer/');
        if (local_storge_table) {
            var dataTableState = JSON.parse(local_storge_table);
            if (dataTableState && dataTableState.search && dataTableState.search.search) {
                var searchTerm = dataTableState.search.search; // Extract the search term
                return searchTerm;
            }
        }
	}
	$('.input-search').val(getSearchState());
	$('.filter input[type="checkbox"]').on('change', function (e) {
		var column = table.columns([$(this).attr('data-column')]);
		var column_order = table_list_order.columns([$(this).attr('data-column')]);
		// if checked hide else show
		if ($(this).is(":checked")) {
			column.visible(true);
			column_order.visible(true);
			//$('.btn-column').addClass('active');
		} else {
			column.visible(false);
			column_order.visible(false);
			//$('.btn-column').removeClass('active');
		}
	});
	$('#checkall').on('click',function () {
		$('.checkbox-element').prop('checked', this.checked);
	});
	$('.checkbox-element').on('click', function () {
		if ($('.checkbox-element:checked').length == $('.checkbox-element').length) {
			$('#checkall').prop('checked', true);
		} else {
			$('#checkall').prop('checked', false);
		}
	});
	// $('.box').hide();
	// $('.field')
	//	 .change(function () {
	//		 $('.box').hide();
	//		 $('.box select').prop('selectedIndex', 0);
	//		 $('.' + $(this).val()).show();
	//	 })
	//	 .change();
	$(document).on('click','#checkall,.checkbox-element',function () {
		updateAllChecked();
	});
	$('#checkall').on('click',function () {
		if (this.checked) {
			$('.checkbox-element').prop('checked', true).change();
		} else {
			$('.checkbox-element').prop('checked', false).change();
		}
	});
	$('.dt-paging nav,.dt-length').on('click',function (e) {
		$('.checkbox-element').prop('checked', false).change();
		$('li.status').hide();
		$('.list_id').val('');
	});
	$('.quick-edit').click(function (e) {
		e.preventDefault();
        $(".alert-form").hide();
		if ($('.list_id').val() == '') {
            $('#modal-warning-edit').addClass('is-active');
            $('body').addClass('overflow');
			$('.modal-warning .modal-body p span.txt_append').text('cập nhật');
			return false;
		}
		open_modal(this);
	});
	$('.quick-print').click(function (e) {
		e.preventDefault();
        $(".alert-form").hide();
		if ($('.list_id').val() == '') {
            $('#modal-warning-edit').addClass('is-active');
            $('body').addClass('overflow');
			$('.modal-warning .modal-body p span.txt_append').text('in');
			return false;
		}
		open_modal(this);
	});
	$(document).on('click','.modal-button', function (ev) {
		ev.preventDefault();
		open_modal(this);
	});
	$('.modal-close,.overlay').click(function () {
		$('.modal').removeClass('is-active');
		$('body').removeClass('overflow');
	});
	$('.em-importer .btn.btn-fillter').click(function (e) {
		e.preventDefault();
		$('button.dt-button').trigger('click');
		var popup = $('.dtsb-searchBuilder').last();  // Locate the last SearchBuilder popup
		if (popup.find('.dtsb-criteria').length === 1) {
			setTimeout( function() {
				$('.dtsb-clearAll.dtsb-button,.custom-btn.revert').css('display','none');
			},10);
		}
			// Ensure the popup is visible before appending the button
			if (popup.is(':visible') && popup.find('.dtsb-titleRow .title').length === 0) {
				// Create a custom button element
				var title = $('<h3>')
					.text('Bộ lọc')
					.addClass('title')  // Add class for styling
					.click(function () {
						$('.dtsb-clearAll.dtsb-button').trigger('click');
					});
					popup.find('.dtsb-title').before(title);
			}
			if (popup.is(':visible') && popup.find('.popover-close').length === 0) {
				// Create a custom button element
				var customButton1 = $('<div>')
					.text('Xóa tất cả')
					.addClass('custom-btn button btn-default revert')  // Add class for styling
					.click(function () {
						$('.dtsb-clearAll.dtsb-button').trigger('click');
					});
				var customButton2 = $('<div>')
				.text('Đóng')
				.addClass('custom-btn button btn-default popover-close')  // Add class for styling
				.click(function () {
					$('.dtb-popover-close').trigger('click');
				});
				// Append the custom button after the "Add condition" button in the popup
				popup.find('.dtsb-group').after(customButton1);
				popup.find('.dtsb-group').after(customButton2);
			}
	});
	$('.content-header .input-search').keyup(function () {
		var searchValue = stringToSlug(this.value.trim().toLowerCase());
		if ($('body').hasClass('page-template-list-order')) {
			table_list_order.search('').draw();
			$.fn.dataTable.ext.search.push(
				function(settings, data, dataIndex) {
					var col2_order = data[2].toLowerCase();
					var col3_order = data[3].toLowerCase();
					var col4_order = data[4].toLowerCase();
					if (
						col2_order.indexOf(searchValue) !== -1 ||
						col3_order.indexOf(searchValue) !== -1 ||
						col4_order.indexOf(searchValue) !== -1
					) {
						return true;
					}
					return false;
				}
			);
			table_list_order.draw();
			$.fn.dataTable.ext.search.pop();
		} else {
			table.search('').draw();
			table_list_order.search('').draw();
			$.fn.dataTable.ext.search.push(
				function(settings, data, dataIndex) {
					var col1 = data[1].toLowerCase();
					var col2 = data[2].toLowerCase();
					var col3 = data[3].toLowerCase();
					if (
						col1.indexOf(searchValue) !== -1 ||
						col2.indexOf(searchValue) !== -1 ||
						col3.indexOf(searchValue) !== -1
					) {
						return true;
					}
					return false;
				}
			);
			table.draw();
			$.fn.dataTable.ext.search.pop();
		}
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
		table_list_order.draw();
		// daterangepicker.ranges({
		//	 start: null,
		//	 end: null
		// });
        $('.em-importer .btn-time').removeClass('date-filter');
		return false;
	});
	var today = moment().date();
	var yestoday = moment().subtract(1, "days").format("DD");
	function adjustDateForOverflow(date) {
		if (!date.isValid()) {
			date = date.endOf('month');
		}
		return date;
	}
	$('.em-importer .btn-time').daterangepicker({
		maxDate: moment().startOf('day'),
		timePicker: false,
		locale: {
			format: 'DD/MM/YYYY',
			separator: ' - ',
			applyLabel: 'Áp dụng',
			cancelLabel: 'Huỷ',
			fromLabel: 'Từ',
			toLabel: 'tới',
			customRangeLabel: 'Tùy chỉnh',
			weekLabel: 'W',
			daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
			monthNames: ["Tháng 1,", "Tháng 2,", "Tháng 3,", "Tháng 4,", "Tháng 5,", "Tháng 6,", "Tháng 7,", "Tháng 8,", "Tháng 9,", "Tháng 10,", "Tháng 11,", "Tháng 12,"],
			firstDay: 1,
		},
		opens: 'center',
		singleDatePicker: false,
		showCustomRangeLabel: true,
		alwaysShowCalendars: true,
		ranges: {
			'All time (Tối đa)': '',
			'1 tuần qua': [moment().subtract(7, 'days').startOf('day'),moment().date(yestoday).endOf('day')],
			'2 tuần qua': [moment().subtract(14, 'days').startOf('day'),moment().date(yestoday).endOf('day')],
			'1 tháng qua': [
				adjustDateForOverflow(moment().subtract(1, 'month').date(today).startOf('day')),  // Adjust to valid start of 1 month ago
				moment().date(yestoday).endOf('day')  // End of today's date
			],
			'3 tháng qua': [
				adjustDateForOverflow(moment().subtract(3, 'month').date(today).startOf('day')),
				moment().date(yestoday).endOf('day')
			],
			'6 tháng qua': [
				adjustDateForOverflow(moment().subtract(6, 'month').date(today).startOf('day')),
				moment().date(yestoday).endOf('day')
			],
			'1 năm qua': [
				adjustDateForOverflow(moment().subtract(12, 'month').date(today).startOf('day')),
				moment().date(yestoday).endOf('day')
			]
		},
	});
	$('.em-importer .btn-time').on('apply.daterangepicker', function (ev, picker) {
        var start = picker.startDate;
        var end = picker.endDate;
        // Add a class to indicate the filter is applied
        $(this).addClass('date-filter');
        // Push a custom filter to DataTables
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var min = start;
            var max = end;
            // Get the date value from the table (assuming the date is in the 19th column)
            var startDate = moment(data[20], 'DD/MM/YYYY');  // Adjust the format to match your table data
            // Check if the row should be included based on the selected date range
            if (
                (min === null && max === null) ||
                (min === null && startDate <= max) ||
                (min <= startDate && max === null) ||
                (min <= startDate && startDate <= max)
            ) {
                return true;
            }
            return false;
        });
        // Redraw the table to apply the filter
        var table = $('.table-list-customer').DataTable(); // Make sure the table variable is initialized
        table.draw();
        // Remove the custom filter to prevent it from stacking on top of future filters
        $.fn.dataTable.ext.search.pop();
    });
	$('.em-importer .btn-time').on('apply.daterangepicker', function (ev, picker) {
        var start = picker.startDate;
        var end = picker.endDate;
        // Add a class to indicate the filter is applied
        $(this).addClass('date-filter');
        // Push a custom filter to DataTables
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var min = start;
            var max = end;
            // Get the date value from the table (assuming the date is in the 19th column)
            var startDate = moment(data[23], 'DD/MM/YYYY');  // Adjust the format to match your table data
            // Check if the row should be included based on the selected date range
            if (
                (min === null && max === null) ||
                (min === null && startDate <= max) ||
                (min <= startDate && max === null) ||
                (min <= startDate && startDate <= max)
            ) {
                return true;
            }
            return false;
        });
        // Redraw the table to apply the filter
        var table_order = $('.table-list-order').DataTable(); // Make sure the table variable is initialized
        table_order.draw();
        // Remove the custom filter to prevent it from stacking on top of future filters
        $.fn.dataTable.ext.search.pop();
    });
	var $checkboxes = $('table.dataTable td input[type="checkbox"]');
	$(document).on('click',$checkboxes,function () {
		var countCheckedCheckboxes = $('table.dataTable td input[type="checkbox"]:checked').length;
		if (countCheckedCheckboxes > 0) {
			$('.em-importer li.status').show();
			$('.em-importer .count-checked, .modal-copy-phone .form-group .total,.modal-print .list-print').text(countCheckedCheckboxes);
			$('.em-importer li.status').on('click', function (e) {
				$('table.dataTable input[type="checkbox"]').prop('checked', false);
				$(this).hide();
                $('.list_id').val('');
			});
		} else {
			$('li.status').hide();
		}
	});
	$('.copy').on('click', function () {
		const textToCopy = $(this).text();
		const tempInput = $('<input>');
		$('body').append(tempInput);
		tempInput.val(textToCopy).select();
		$('.modal-copy-phone .form-group .phone-copy').text(textToCopy);
		$('.modal-copy-phone .form-group .total').hide();
		document.execCommand('copy');
		setTimeout(() => {
			$('.modal.modal-copy-phone').removeClass('is-active');
			$('body').removeClass('overflow');
		}, 2000);
		tempInput.remove();
	});
	$('.copyAllphone').click(function() {
		$('.modal-copy-phone .form-group .phone-copy').text('');
		$('.modal-copy-phone .form-group .total').show();
		var numbers = '';
		$('.table .checkbox-element[type="checkbox"]:checked').each(function() {
			numbers += $(this).data('number') + '\n';  // Get the value from data-number
		});
		if (numbers.trim() === '') {
			$('#modal-warning-edit').addClass('is-active');
            $('body').addClass('overflow');
			$('.modal-warning .modal-body p span.txt_append').text('sao chép số điện thoại');
			return;
		}
		var $tempTextArea = $('<textarea>');
		$('body').append($tempTextArea);
		$tempTextArea.val(numbers.trim()).select();
		document.execCommand('copy');
		$tempTextArea.remove();
		open_modal(this);
		setTimeout(() => {
			$('.modal.modal-copy-phone').removeClass('is-active');
			$('body').removeClass('overflow');
		}, 2000);
	});
	function open_modal(el) {
		var modaltarget = $(el).data('target');
		$(modaltarget).addClass('is-active');
		$('body').addClass('overflow');
		setTimeout(() => {
			table_print.columns.adjust();
		}, 50);
	}
	var status = localStorage.getItem('sidebar');
	if (status =="active") {
		$('.site').addClass('mini_sidebar');
		$('.sidebar .resize').addClass('active');
	}
	table.columns.adjust();
	$('.sidebar .resize').click(function (e) {
		// localStorage.getItem('sidebar');
		e.preventDefault();
		setTimeout(() => {
			table.columns.adjust();
			table_list_order.columns.adjust();
			table_regular.columns.adjust();
			table_regular_pay.columns.adjust();
		}, 100);
		if ($(this).hasClass('active')) {
			$('.sidebar .resize').removeClass('active');
		} else {
			$('.sidebar .resize').addClass('active');
		}
		$('.site').toggleClass('mini_sidebar');
		$('.sidebar').toggleClass('width-10');
		$('.content-wrapper').toggleClass('width-90');
		var status = localStorage.getItem('sidebar');
		if (status =="active") {
			localStorage.setItem('sidebar', 'deactive');
		} else {
			localStorage.setItem('sidebar', 'active');
		}
	});
	var table_regular = $('table.regular').DataTable({
		autoWidth: true,
		scrollX: true,
		scrollY: '50vh',
		dom: 'Bfrtip<"bottom"pl>',
		order: [[4, 'desc'], [3, 'desc']], // date, time
		columnDefs: [
			{
				type: 'natural',
				targets: [0, 1, 2],
				orderable: false,
			},
		],
		language: {
			paginate: {
				previous: '<i class="fas fa-left"></i>',
				next: '<i class="fas fa-right"></i>',
			},
		}
	});
	var table_regular_pay = $('table.regular_pay').DataTable({
		autoWidth: true,
		scrollX: true,
		scrollY: '50vh',
		dom: 'Bfrtip<"bottom"pl>',
		//order: [[0, 'asc'], [1, 'asc']], // date, time
		ordering: false,
		language: {
			paginate: {
				previous: '<i class="fas fa-left"></i>',
				next: '<i class="fas fa-right"></i>',
			},
		}
	});
	jQuery('ul.tabNavigation li').click(function() {
		switch_tabs(jQuery(this));
		$('.card-primary').removeClass('width-100');
		$('.scroll-menu .btn-save_edit').hide();
		$('.scroll-menu .btn-add_order').show();
		setTimeout(() => {
			table_regular.columns.adjust();
			table_regular_pay.columns.adjust();
		}, 100);
	});
	switch_tabs(jQuery('.defaulttab'));
	jQuery('ul.tabNavigation li[rel="settings"]').click(function() {
		$('.scroll-menu .btn-save_edit').show();
		$('.scroll-menu .btn-add_order').hide();
	});
	$('.scroll-menu .btn-save_edit').click(function (e) {
		e.preventDefault();
		$('.detail-customer .form-horizontal .btn-primary').click();
	});
	jQuery('ul.tabNavigation li[rel="settings"],ul.tabNavigation li[rel="history"]').click(function() {
		$('.card-primary').addClass('width-100');
	});
	$(document).on('click','.show-group-note', function name(params) {
		$(this).hide();
		$(this).prev('.group-note').find('.hidden').show();
	});
    if ($('.scroll-menu').length) {
        var navbarOffset = $('.scroll-menu').offset().top;
        var navbar_h = $('.scroll-menu').height();
        $(window).scroll(function() {
            if ($(window).scrollTop() > navbarOffset) {
            $('.scroll-menu').addClass('fixed');
            $('.detail-customer .content').css('padding-top', navbar_h);
            } else {
            $('.scroll-menu').removeClass('fixed');
			$('.detail-customer .content').css('padding-top', 0);
            }
        });
    }
	$( ".tooltip" ).tooltip({
		position: {
		 my: "left+5 center", at: "right center"
	  },
	  show: { effect: "fade", duration: 200 }
	});
	$('input').on('keydown', function (e) {
        // Check if both Shift and Enter are pressed
        if (e.key === "Enter" && e.shiftKey) {
            e.preventDefault();
        }
    });
	var table_list_order = $('.table-list-order').on('init.dt', function () {
		//console.log(this, 'init.dt');
    }).DataTable({
		autoWidth: true,
		scrollX: true,
		scrollY:  $(window).height() - 227,
		dom: 'Bfrtip<"bottom"pl>',
		order: [[21, 'desc']],
		iDisplayLength: 50,
		lengthChange: true,
		lengthMenu: [
			[15,50, 100, 200],
			['15 / trang','50 / trang', '100 / trang', '200 / trang'],
		],
		columnDefs: [
			{  
				targets: [0,1,2,3,4,7,8,9,10,11,12,13,14,15,16,17,18,19],
				orderable: false,
			},
			{
			 type: 'string', targets: [0,4,5,6,7,10,11,12]
			},
			{ visible: false, targets: [5,6,8,9,10,11,13,14,15,16,17,18,20,22,23] },
			{
				targets: 21,
				render: function(data, type, row) {
					if (type === 'sort') {
					var dateParts = data.split(" ");
					var date = dateParts[1].split("/");
					var time = dateParts[0].split(":");
					return new Date(date[2], date[1] - 1, date[0], time[0], time[1]).toISOString();
					}
					return data;
				}
			},
            {
                targets: [22],
                render: function(data) {
                    return moment(data, 'YYYY/MM/DD').format('DD/MM/YYYY');
                  }
              },
              {
                targets: [8,9,23], // Target the first column which contains dates
                render: function(data, type, row) {
                  return moment(data, 'DD/MM/YYYY').format('DD/MM/YYYY');
                }
              }
		],
		buttons: [
			// {
			//	 text: "Date range",
			//	 attr: {
			//		 id: "reportrange",
			//	 },
			// },
			{
				extend: 'searchBuilder',
				attr: {
					id: 'searchBuilder',
				},
				config: {
					conditions:{
                        html: tagCondition,
                    },
					depthLimit: 0,
					columns: [ 5, 6,7, 8, 9, 10, 11, 12, 13, 14,15,17,19,23],
					filterChanged: function (count) {
						if (count == 0 || count == 1) {
							$('.btn-fillter').removeClass('current-filter');
							$('.btn-fillter').text('Bộ lọc');
							$('.dtsb-title').html(`Điều kiện lọc`);
							$('.custom-btn.revert').css('display','none');
						}
						if (count > 1) {
							$('.btn-fillter').addClass('current-filter');
							$('.btn-fillter').html(`Bộ lọc <small>${count - 1}</small>`);
							$('.dtsb-title').html(`Điều kiện lọc (${count - 1})`);
							$('.custom-btn.revert').css('display','block');
						}
					}
				}
			},
		],
		dom: 'Bfrtip<"bottom"pl>',
		responsive: true,
		autoWidth: true,
		fixedColumns: {
			start: 3
		},
		"stateSave": true,
		searchBuilder: {
            // Tắt bộ lọc tự động (disable the default behavior)
            preDefined: [] // Không xác định bộ lọc mặc định nào
        },
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
				add: '<i class="fas fa-plus mr-8"></i> Thêm điều kiện',
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
					//_: 'Điều kiện lọc (%d)',
				},
				value: 'Giá trị',
				valueJoiner: '-',
				conditions: {
					date: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						after: 'Sau ngày',
						before: 'Trước ngày',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
						notEmpty: 'Không rỗng',
					},
					number: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
						notEmpty: 'Không rỗng',
					},
					string: {
						between: 'Trong khoảng',
						empty: 'Rỗng',
						equals: 'Bằng',
						gt: 'Lớn hơn',
						gte: 'Lớn hơn bằng',
						lt: 'Nhỏ hơn',
						lte: 'Nhỏ hơn bằng',
						not: 'Khác',
						notBetween: 'Ngoài khoảng',
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
	});
	var table_print = $('table.table-print').DataTable({
		scrollX: true,
		scrollY: '20vh',
		dom: 'Bfrtip<"bottom"pl>',
		order: [[0, 'desc']],
		paging: false,
		columnDefs: [
			{
				targets: [1, 2,3,4],
				orderable: false,
			},
		]
	});
});
function stringToSlug(str) {
	// remove accents
	//str = str.toLowerCase();
	str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
	str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
	str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
	str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
	str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
	str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
	str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
	str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
	str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
	str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
	str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
	str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
	str = str.replace(/đ/g, "d");
	str = str.replace(/Đ/g, "D");
	return str;
  }
function switch_tabs(obj) {
	jQuery('.tab-pane').stop().fadeOut(1);
	jQuery('ul.tabNavigation li').removeClass("selected");
	var id = obj.attr("rel");
	jQuery('#' + id).stop().fadeIn(300);
	//jQuery('#'+id).show();
	obj.addClass("selected");
}