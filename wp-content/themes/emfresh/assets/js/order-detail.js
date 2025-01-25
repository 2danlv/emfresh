$(document).ready(function () {
    // $(".tabNavigation [rel='activity-history']").trigger("click");
    
    
    $("ul.edit-product li").click(function () {
        switch_tabs_order(jQuery(this))
      });
      switch_tabs_order(jQuery('.defaulttab_order'));
      
    });
$('.js-cancel').on('click', function(){
    $('#modal-cancel').addClass("is-active");
    $("body").addClass("overflow");
});
$('.js-end').on('click', function(){
    $('#modal-end').addClass("is-active");
    $("body").addClass("overflow");
});
$('.js-continue').on('click', function(){
    $('#modal-continue').addClass("is-active");
    $("body").addClass("overflow");
});
function switch_tabs_order(obj) {
	jQuery('.tab-pane-2').stop().fadeOut(1);
	jQuery('ul.tab-order li').removeClass("selected");
	var id_order = obj.attr("rel");
	jQuery('#' + id_order).stop().fadeIn(300);
	//jQuery('#'+id).show();
	obj.addClass("selected");
}

if (typeof orderDetailSettings != 'undefined') {
	Object.keys(orderDetailSettings).forEach(key => {
		window[key] = orderDetailSettings[key];
	});
}

jQuery(function ($) {

	function update_order_item_info(order_item) {
		order_item = $(order_item);
		data_id = order_item.closest('.js-order-item').attr('id');
		order_details = $('.order-details')

		let product_id = parseInt(order_item.find('.input-product_id').val());
		let product = em_products.find(item => item.id == product_id);
		let quantity = parseInt(order_item.find('.input-quantity').val());
		let days = parseInt(order_item.find('.input-days').val());
		// let type = order_item.find('.input-type').val().toLowerCase();
		let type = order_item.find('.input-type').val();
		let amount = 0;
		let meal_number = 0; // so bua an
		let price = 0;
		let date_start = order_item.find('.input-date_start').val() || '';

		// let ship_price = get_ship_price(order_item.find('.input-location_id option:selected').text());
		let ship_price = get_ship_price($('.input-location_name').val());

		if (product_id > 0 && product != null && quantity > 0 && type != '' && days > 0) {
			let meal = 'meal_w_';

			if (type == 'd') {
				// Gia goi an = gia goi tuan 1 bua/ngay*SL/5 + 5k*SL (day la phu thu)

				meal += 1;
				meal_number = 1;

				if (typeof product[meal] != 'undefined') {
					price = parseInt(product[meal]);

					amount = price * quantity / 5 + 5000 * quantity;
				}
			} else if (type == 'w') {
				if (days <= 5) {
					// Gia goi an = gia goi tuan có tong so phan an tiem can/ tong so phan an tuong ung cua goi nay * SL
					if (quantity < 8) {
						meal_number = 1;
					} else if (quantity <= 12) {
						meal_number = 2;
					} else {
						meal_number = 3;
					}
					meal += meal_number;

					if (typeof product[meal] != 'undefined') {
						price = parseInt(product[meal]);

						// price / 5 * so phan an
						amount = price / 5 * quantity;
					}
				} else {
					// Gia goi an = gia goi co so bua/ngay tuong ung tuan/5 * so ngay khach dat
					meal_number = parseInt(quantity / days);
					meal += meal_number;

					if (typeof product[meal] != 'undefined') {
						price = parseInt(product[meal]);

						// price / 5 * so ngay
						amount = price / 5 * days;
					}
				}
			} else if (type == 'm') {
				if (quantity <= 20) {
					meal_number = 1;
					amount = (price = parseInt(product['meal_m_1'])) / 20 * quantity;
				} else if (quantity <= 50) {
					meal_number = 2;
					amount = (price = parseInt(product['meal_m_2'])) / 40 * quantity;
				} else {
					meal_number = 3;
					amount = (price = parseInt(product['meal_m_3'])) / 60 * quantity;
				}
			}
		}

		// console.log({type: type, days: days, quantity: quantity, price: price, amount: amount});

		if(ship_price > 0) {
			amount += days * meal_number * ship_price;
		}

		order_item.find('.input-product_price').val(price);
		order_item.find('.text-amount').text(format_money(amount));
		order_item.find('.input-amount').val(amount);
		order_item.find('.input-date_stop').val(get_date_value(date_start, days));
		order_item.find('.input-ship_price').val(ship_price);

		order_details.find(`[data-id="${data_id}"] .price`).text(format_money(amount));
		order_details.find(`[data-id="${data_id}"] .quantity`).text(quantity);
		order_details.find(`[data-id="${data_id}"] .name`).text(order_item.find('.input-product_id option:selected').text());

		var date = new Date(date_start);
		var formattedDate = ('0' + date.getDate()).slice(-2) + '/' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '/' +
                    date.getFullYear();
		order_details.find('.date-start').text(formattedDate);
		type = type.toUpperCase();
		order_details.find('.type').text(type);
	}

	function format_money(number) {
		return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').split('.')[0];
	}

	function show_order_item(btn) {
		btn = $(btn);

		let p = $('#' + btn.data('id'));
		if (p.length > 0) {
			$('.js-order-item').hide();
			p.show();

			$('.js-show-order-item').removeClass('btn-primary').addClass('btn-secondary');
			btn.addClass('btn-primary');
		}
	}

	

	function note_get_input(items) {
		let input = $('<input type="text" class="form-control input-note_values" />');

		if (typeof items != 'undefined' && typeof items.values != 'undefined') {
			input = $('<input type="text" class="form-control input-note_values" />');

			input.html(items.values.map(text => `<option value="${text}">${text}</option>`).join("\n"));
		}

		return input;
	}

	function update_order_item_note(order_item) {
		let notes = [];

		order_item.find('.js-note-list .row-note').each(function () {
			let row = $(this),
				name = row.find('.input-note_name').val(),
				value = row.find('.input-note_values').val();

			if (name != '' && value) {
				if (typeof value == 'string') {
					if (value == '') return;

					value = [value];
				}

				if (value.length == 0) return;

				notes.push(name + ' : ' + value.join(', '));
			}
		})

		order_item.find('.input-note').val(notes.join("\n"));
		
	}

	function update_order_info() {
		let ship_days = 0,
			total_amount = 0,
			ship_amount = 0,
			item_name = {},
			location_name = '',
			order_note = '',
			order_type = '';

		$('.js-order-item').each(function () {
			let p = $(this),
				text, days = parseInt(p.find('.input-days').val());

			ship_days += days;

			ship_amount += parseInt(p.find('.input-ship_price').val() * days);

			text = p.find('.input-product_id option:selected').text() || '';
			if (text != '') {
				text = text.split('-')[0].trim();

				if (typeof item_name[text] == 'undefined') {
					item_name[text] = 0;
				}

				item_name[text] += 1;
			}

			text = p.find('.input-location_id option:selected').text() || '';
			if (location_name == '' && text != '') {
				location_name = text;
			}

			text = p.find('.input-note_list').val();
			if (order_note == '' && text != '') {
				order_note = text.split("\n")[0];
			}

			text = p.find('.input-type').val();
			if (order_type == '' && text != '') {
				order_type = text;
			}
			
			total_amount += parseInt(p.find('.input-amount').val());
		});

		$('.input-item_name').val(Object.keys(item_name).map(text => `${item_name[text]}${text}`).join('+'));
		$('.input-order_note').val(order_note);
		$('.input-order_type').val(order_type);
		$('.input-ship_days').val(ship_days);
		$('.input-ship_amount').val(ship_amount);
		$('.input-total_amount').val(total_amount);
		$('.input-total').val(total_amount + ship_amount);
		$('.text-total_amount').text(format_money(total_amount));
	}

	function get_date_value(date_string, days) {
		if (days > 0) {
			let date = new Date(date_string);

			//date.setDate(date.getDate() + days);

			//return date.toISOString().substring(0, 10);
		}

		return date_string;
	}

	function get_ship_price(location_label) 
	{
		let list = location_label.split(',').map(v => v.trim()), n = list.length,
			district = n > 2 ? list[n - 1] : '',
			ward = n > 2 ? list[n - 2] : '',
			price = 0;

		if(district != '' && ward != '') {
			let fee_all = em_ship_fees.find(o => o.district == district && o.ward.toLowerCase() == 'all');
			let fee_one = em_ship_fees.find(o => o.district == district && o.ward.toLowerCase() == ward);

			if(fee_one) {
				price = +fee_one.price;
			} else if(fee_all){
				price = +fee_all.price;
			}
		}

		// console.log('location', district, ward, price);

		return price;
	}

	function get_order_item_schedule(order_item) {
		order_item = $(order_item);

		let data = {
			location_id: +order_item.find('.input-location_id').val(),
			days: +order_item.find('.input-days').val(),
			date_start: order_item.find('.input-date_start').val(),
			list: []
		};

		if (data.location_id > 0 && data.days > 0 && data.date_start != '') {
			data.list.push(data.date_start);

			for (let i = 1; i < data.days; i++) {
				data.list.push(get_date_value(data.date_start, i));
			}
		}

		return data;
	}

	function check_order_item(type, order_item) {
		let check = true;

		if (type == 'location_date') {
			let my_schedule = get_order_item_schedule(order_item);

			if (my_schedule.list.length == 0) return check;

			$('.js-order-item:not(#' + order_item.attr('id') + ')').each(function () {
				if (check == true) {
					let item = $(this),
						schedule = get_order_item_schedule(item);

					if (my_schedule.location_id == schedule.location_id) {
						check = schedule.list.filter(value => my_schedule.list.indexOf(value) > -1).length == 0
					}
				}
			});
		}

		return check;
	}

	$(document).on('change', '.js-order-item [name]', function () {
		let p = $(this),
			order_item = p.closest('.js-order-item');
		if (order_item.length > 0) {
			if (check_order_item('location_date', order_item) == false) {
				alert('Địa điểm và thời gian đang dùng! Vui lòng chọn lại');

				return;
			}

			update_order_item_info(order_item);

			update_order_item_note(order_item);

			update_order_info();
		}
	});

	$(document).on('click', '.js-search-customer', function () {
		let search = $('.input-customer_search').val();

		if (search == '') return;

		search = 'customer_name=' + search;

		$.get(em_api_url + 'customer/list?' + search, function (res) {
			if (res.code == 200) {
				$('.select-customer_id').html('<option value="0">Vui lòng chọn khách hàng</option>' + res.data.map(item => `<option value="${item.id}">${item.customer_name}</option>`).join("\n"));
			}
		})
	});

	$(document).on('change', '.select-customer_id', function () {
		let customer_id = $(this).val();

		if (customer_id == 0) return;

		search = 'customer_id=' + customer_id;

		$.get(em_api_url + 'location/list?' + search, function (res) {
			if (res.code == 200) {
				$('.select-location_id').html('<option value="0">Vui lòng chọn địa điểm</option>' + res.data.map(item => `<option value="${item.id}">${[item.address, item.ward, item.district].join(', ')}</option>`).join("\n"));

				$('.card-products').show();
			}
		})
	});

	$(document).on('click', '.js-add-order-item', function (e) {
		e.preventDefault();

		let html = $('.js-order-item:first').prop('outerHTML');
		if (typeof html != 'string') return;

		let index = parseInt($('.order_item_total').val()),
			id = index + 1,
			new_item = $(html.replace(/(\[0\])/g, '[' + index + ']')).show();

		new_item.find('input, select, textarea').val('');
		new_item.find('.text-amount').text('0');
		new_item.attr('id', 'order_item_' + id);

		$('.js-order-item').hide();
		$('.js-order-items').append(new_item);
		$('.js-show-order-item').removeClass('btn-primary').addClass('btn-secondary');
		$(this).before(`<span class="btn btn-primary js-show-order-item" data-id="order_item_${id}">Sản phẩm ${id}<em class="js-remove-order-item">&times;</em></span>`);

		$('.order_item_total').val(id);
	});

	$(document).on('click', '.btn-add_order .remove-tab', function (e) {
		e.preventDefault();
		$("#modal-remove-tab").addClass("is-active");
		let btn = $(this).closest('[data-id]'),
			order_item = $('#' + btn.data('id'));
		

		if (btn.length > 0 && order_item.length > 0) {
			$(document).on('click', '.js-remove-order-item', function (e) {
				e.preventDefault();
				btn.remove();
				order_item.addClass('removed').hide().find('.input-remove').val(1);
				if ($(".btn-add_order.tab-button").length == 1) {
					$(".remove-tab").addClass("hidden");
				}
				setTimeout(function () {
					let p = $('.js-show-order-item:first');
					show_order_item(p);
					update_order_info();
				}, 300);
			});
		}
	});
	

	$(document).on('click', '.js-show-order-item', function () {
		show_order_item(this);
	});

	$('.js-order-item').each(function () {
		let order_item = $(this),
			note_list = order_item.find('.input-note_list').val();

		if (note_list != '') {
			note_list = JSON.parse(window.atob(note_list));

			note_add_row(order_item, note_list);
		}
	});


	$(document).on('click', '.js-add-note', function () {
		let order_item = $(this).closest('.js-order-item');
		if (order_item.length > 0) {
			note_add_row(order_item);
			initializeTagify('input.input-note_values');
		}
	});
	function note_add_row(order_item, note_list) {
		// select2
		let html = $('#note_template').html();
		if (typeof html != 'string') return;
	
		if (typeof note_list == 'object') {
			Object.keys(note_list).forEach(name => {
				let item = note_list[name];
	
				if (item.values.length > 0) {
					let note_row = $(html),
						input = note_get_input(em_notes[name]);
	
					note_row.find('.input-note_name').val(name);
	
					input.val(item.values);
	
					note_row.find('.col-note_values').html(input);
	
					order_item.find('.js-note-list').append(note_row);
				}
			});
		} else {
			order_item.find('.js-note-list').append(html);
		}
	}
});