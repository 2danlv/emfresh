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

		let debug = [];

		if (product_id > 0 && product != null && quantity > 0 && type != '' && days > 0) {
			let meal = 'meal_w_';

			if (type == 'd') {
				// Gia goi an = gia goi tuan 1 bua/ngay*SL/5 + 5k*SL (day la phu thu)

				meal += 1;
				meal_number = 1;

				if (typeof product[meal] != 'undefined') {
					price = parseInt(product[meal]);

					debug.push(`Gia goi tuan 1 bua/ngay: gia = ` + format_money(price));
					
					amount = price * quantity / 5 + 5000 * quantity;

					debug.push(`Cong thuc: gia * quantity / 5 + 5,000 * so luong`);
					debug.push(`Thanh tien: ${format_money(price)} * ${quantity} / 5 + 5,000 * ${quantity} = ` + format_money(amount));
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

						debug.push(`Gia goi tuan ${meal_number} bua/ngay: gia = ` + format_money(price));

						// price / 5 * so phan an
						amount = price / 5 * quantity;

						debug.push(`Cong thuc: gia / 5 * so luong`);
						debug.push(`Thanh tien: ${format_money(price)} / 5 * ${quantity} = ` + format_money(amount));
					}
				} else {
					// Gia goi an = gia goi co so bua/ngay tuong ung tuan/5 * so ngay khach dat
					meal_number = parseInt(quantity / days);
					meal += meal_number;

					if (typeof product[meal] != 'undefined') {
						price = parseInt(product[meal]);

						debug.push(`Gia goi tuan ${meal_number} bua/ngay: gia = ` + format_money(price));

						// price / 5 * so ngay
						amount = price / 5 * days;

						debug.push(`Cong thuc: gia / 5 * so ngay`);
						debug.push(`Thanh tien: ${format_money(price)} / 5 * ${days} = ` + format_money(amount));
					}
				}
			} else if (type == 'm') {
				let quydoi = 0;

				if (quantity <= 20) {
					quydoi = 20;
					meal_number = 1;
				} else if (quantity <= 50) {
					quydoi = 40;
					meal_number = 2;
				} else {
					quydoi = 60;
					meal_number = 3;
				}
				
				price = parseInt(product['meal_m_' + meal_number]);

				amount = price / quydoi * quantity;

				debug.push(`Gia goi tuan ${meal_number} bua/ngay: gia = ` + format_money(price));
				debug.push(`Cong thuc: gia / ${quydoi} * so luong`);
				debug.push(`Thanh tien: ${format_money(price)} / ${quydoi} * ${quantity} = ` + format_money(amount));
			}
		}

		// console.log({type: type, days: days, quantity: quantity, price: price, amount: amount});

		// if(ship_price > 0) {
		// 	amount += days * meal_number * ship_price;
		// }
		
		order_item.find('.console-product').html(debug.join("<br>"));

		order_item.find('.input-product_price').val(price);
		order_item.find('.text-amount').text(format_money(amount));
		order_item.find('.input-amount').val(amount);
		order_item.find('.input-meal_number').val(meal_number);
		order_item.find('.input-date_stop').val(get_date_value(date_start, days));
		order_item.find('.input-ship_price').val(ship_price);

		order_details.find(`[data-id="${data_id}"] .price`).text(format_money(amount));
		order_details.find(`[data-id="${data_id}"] .quantity`).text(quantity);
		order_details.find(`[data-id="${data_id}"] .name`).text(order_item.find('.input-product_id option:selected').text());

		if (date_start != '') {
			var date = new Date(date_start);
			var formattedDate = ('0' + date.getDate()).slice(-2) + '/' +
						('0' + (date.getMonth() + 1)).slice(-2) + '/' +
						date.getFullYear();
		}
		type = type.toUpperCase(); 

		order_details.find(`[data-id="${data_id}"] .date-start`).text(formattedDate);
		order_details.find(`[data-id="${data_id}"] .type`).text(type);
		if (amount && quantity && order_item.find('.input-product_id option:selected').text()) {
			order_details.find(`[data-id="${data_id}"]`).removeClass('hidden')
		}
		if (type) {
			order_details.removeClass('hidden')
		}
	}

	function format_money(number) {
		number = parseFloat(number); 
		if (isNaN(number)) return '0';
		return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').split('.')[0];
	}

	function show_order_item(btn) {
		btn = $(btn);

		let p = $('#' + btn.data('id'));
		if (p.length > 0) {
			$('.js-order-item').hide();
			p.show();

			$('.js-show-order-item').removeClass('btn-primary').addClass('btn-secondary');
			btn.addClass('btn-primary active');
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

			if(value == '') {
				value = [];

				row.find('tag').each(function(){
					if(this.title != '') {
						value.push(this.title);
					}
				})
			}

			// console.log('tag', row.find('tag').attr('title'));
			
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
			type_name = {},
			location_name = '',
			order_note = '',
			order_type = '';

		$('.js-order-item:not(.removed)').each(function () {
			let p = $(this),
				text, 
				quantity = parseInt(p.find('.input-quantity').val()),
				days = parseInt(p.find('.input-days').val()),
				ship_fee = 0;

			ship_days += days;

			// tong ship se lay theo so ngay an lon nhat
			ship_fee = parseInt(p.find('.input-ship_price').val() * days);
			if(ship_amount < ship_fee) {
				ship_amount = ship_fee;
			}

			text = p.find('.input-product_id option:selected').text() || '';
			if (text != '') {
				text = text.split('-')[0].trim();

				if (typeof item_name[text] == 'undefined') {
					item_name[text] = 0;
				}

				item_name[text] += parseInt(quantity / days);
			}

			text = p.find('.input-location_id option:selected').text() || '';
			if (location_name == '' && text != '') {
				location_name = text;
			}

			text = p.find('.input-note').val().trim();
			if (order_note == '' && text != '') {
				order_note = text.split("\n")[0];
			}

			text = p.find('.input-type').val();
			if (order_type == '' && text != '') {
				order_type = text;
			}

			if (text != '') {
				if (typeof type_name[text] == 'undefined') {
					type_name[text] = 0;
				}

				type_name[text] += parseInt(quantity / days);
			}
			
			total_amount += parseInt(p.find('.input-amount').val());
		});

		$('.input-item_name').val(Object.keys(item_name).map(text => `${item_name[text]}${text}`).join('+'));
		$('.input-type_name').val(
			Object.keys(type_name)
				.map(text => `${type_name[text]}`.replace(/\d/g, '') + text.replace(/\d/g, ''))
				.join(' + ')
				.toUpperCase()
		);
		$('.input-order_note').val(order_note);
		counts_type();
		$('.input-ship_days').val(ship_days);
		if (!isNaN(ship_amount)) {
			$('.ip_ship_amount').val(ship_amount);
			$('.input-ship_amount').val(format_money(ship_amount));
			$('.info-pay .ship').text(format_money(ship_amount));
		}
		$('.input-total,.input-total_amount').val(total_amount + ship_amount);
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
	function update_pay() {
		let total = 0;
		let ship = parseFloat($('.info-pay').find('.ship').text().replace(/[^0-9.-]+/g, '')) || 0;
		let discount = parseFloat($('.info-pay').find('.discount').text().replace(/[^0-9.-]+/g, '')) || 0;
		let ip_preorder = parseFloat($('.paymented').find('.ip_preorder').val().replace(/[^0-9.-]+/g, '')) || 0;
		
		if ($('.paymented .input-preorder').val() =='') {
			$('.paymented .input-preorder').val(0)
		}
		$('.info-order:not(.hidden)').find('.price').each(function () {
		    let value = parseFloat($(this).text().replace(/[^0-9.-]+/g, ''));
		
		    if (!isNaN(value)) {
		        total += value;
		    }
		});
		total_1 = total + ship - discount;
		total_2 = total + ship - discount - ip_preorder;
		if ($('.input-total_amount').val() != 0) {
			$('.info-pay .total-price,.total-pay .price-order').text(format_money(total_1));
			$('.order-payment .payment-required,.total-cost .cost-txt').text(format_money(total_2));
		}
		$('.total-pay .price-product').text(format_money(total));
		$('.input-total,.input-total_amount').val(total_2);
		if ($('.input_status-payment').val() == 1) {
			$('.order-payment .payment-required,.total-cost .cost-txt').text(0);
		} else if ($('.input_status-payment').val() == 0){
			$('.order-payment .payment-required,.total-cost .cost-txt').text(format_money(total_2));
		}
		
	}

	update_pay();
	$(document).on("click", ".status-pay-menu .status-pay-item span", function () {

		$(".paymented").hide();
		$(".status-pay").html($(this).closest('.status-pay-item').html());
		$(".input_status-payment").val($(this).attr('data-status'));
		var status = $(this).attr('data-status');
		
		if (status == 3) {
		  $(".paymented").css("display", "flex");
		  $(".ip_preorder,.input-preorder").val(0);
		  update_pay();
		} else if (status == 1){
		  $(".payment-required").text("0");
		  $('.payment-required,.total-cost .cost-txt').text(0);
		  $(".input-total_amount").val(0);
		  $(".paymented").css("display", "none");
		} else if (status == 2){
			$(".ip_preorder,.input-preorder").val(0);
			update_pay();
		}else if (status == 0){
			$(".ip_preorder,.input-preorder").val(0);
			update_pay();
		}
	  });
	  
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

			update_pay();
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
		var idTabRemove = $(this).closest("[data-tab]").data('tab');
		$("#modal-remove-tab").addClass("is-active");
		let btn = $(this).closest('[data-id]'),
			order_item = $('#' + btn.data('id'));
	
		if (btn.length > 0 && order_item.length > 0) {
			$(document).off('click', '.js-remove-order-item').on('click', '.js-remove-order-item', function (e) {
				e.preventDefault();
				$('.order-details').find(`[data-id="${idTabRemove}"]`).addClass('hidden');
				btn.remove();
				$('.order-details').find('.info-order.remove').remove();
				order_item.addClass('removed').hide().find('.input-remove').val(1);
				if ($(".btn-add_order.tab-button").length == 1) {
					$(".remove-tab").addClass("hidden");
				}
				
				setTimeout(function () {
					let p = $('.js-show-order-item:first');
					show_order_item(p);
					update_order_info();
					update_pay();
				}, 300);
			});
			$(document).off('click', 'btn.btn-secondary.modal-close').on('click', 'btn.btn-secondary.modal-close', function (e) {
				$('.order-details').find(`[data-id="${idTabRemove}"]`).removeClass('remove');
			});
		}
	});
	

	$(document).on('click', '.js-show-order-item', function () {
		show_order_item(this);
	});

	$('.js-order-item:not(.removed)').each(function () {
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
	$('.input-ship_amount, .input-discount, .paymented .input-preorder').each(function() {
		$(this).val(format_money($(this).val()));
	});
	
	$('.input-ship_amount').on('keyup', function () {
		let ship_amount = $(this).val().replace(/,/g, '');
		$('.shipping-fee .ip_ship_amount').val(ship_amount);
		$(this).val(format_money(ship_amount));
		$('.info-pay .ship').text(format_money(ship_amount));
		update_pay();
	});
	$('.input-discount').on('keyup', function () {
		let discount = $(this).val().replace(/,/g, '');
		$('.shipping-fee .ip_discount').val(discount);
		$(this).val(format_money(discount));
		$('.info-pay .discount').text(format_money(discount));
		update_pay();
	});
	$('.paymented .input-preorder').on('keyup', function () {
		let preorder = $(this).val().replace(/,/g, '');
		$('.paymented .ip_preorder').val(preorder);
		$(this).val(format_money(preorder));
		//$('.info-pay .discount').text(format_money(preorder));
		let input_preorder = parseFloat($(this).val().replace(/[^0-9.-]+/g, '')) || 0;
		let total_amount = parseFloat($('.total-pay .price-order').text().replace(/[^0-9.-]+/g, '')) || 0;
		
		let preorder_val = total_amount - input_preorder;
		$('.payment-required,.total-cost .cost-txt').text(format_money(preorder_val));
		update_pay();
	});
});
$(document).on("change", ".input-type", function() {
	counts_type();
	
  });
function counts_type() {
		var counts = { d: 0, w: 0, m: 0 };
	  
		$(".js-order-item:not(.removed) .input-type").each(function() {
			var selectedValue = $(this).find("option:selected").val();
			if (selectedValue && counts[selectedValue] !== undefined) {
				counts[selectedValue]++;
			}
		});
	  
		var result = [];
		if (counts.m > 0) {
		  result.push(`M`);
		}
		if (counts.w > 0) {
		  result.push(`W`);
		}
		if (counts.d > 0) {
		  result.push(`D`);
		}
		$(".info-order .type-total").text(result.join(' + '));
		
}