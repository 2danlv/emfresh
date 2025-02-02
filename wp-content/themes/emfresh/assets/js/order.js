const SHIP = 5000;
$(document).ready(function () {
  $(document).click(function (event) {
    if (!$(event.target).closest(".search-cus, .results, .no-results").length) {
      $(".results, .no-results").hide();
    }
  });
  $(".search-result .results").on("click", function () {
    $(this).hide();
    $(".history-order .history").show();
  });
  
  $(document).on('click', '.tooltip-icon', function (e) {
    $(this).siblings(".tooltip-content").show();
  });
  $(document).on('click', '.overlay-drop-menu,.other-address,.tooltip-content .close', function (e) {
    $('.overlay-drop-menu').hide();
    $('.dropdown-menu').hide();
    $(".tooltip-content").hide();
  });
  
  $('.history-item summary').click(function (e) { 
    $(this).toggleClass('is-active');
  });
  
  $(".order .search-result .result-item").click(function (e) { 
    var name = $(this).find(".name").text();
    var phone = $(this).find(".phone").text();
    var address = $(this).find(".address").text();
    var note_shiper = $(this).find(".note_shiper").text();

    $(".input-order input.fullname").val(name);
    $(".input-order input.phone").val(phone);
    $('.input-location_id').val($(this).data('location_id'));
    $(".input-order input.address_delivery,.input-location_name").val(address);
    if(note_shiper.length != 0) {
      $('.note-shipper').removeClass('hidden');
    } else {
      $('.note-shipper').addClass('hidden');
    }
    $(".note-shipper .note_shiper").text(note_shiper);
    
    $(".results").hide();
    $(".dropdown").css("pointer-events", "all");
    $(".history-order").find(".show").removeClass("show");
    $(".history-order").find(".history").addClass("show");
  });
  $(".close-toast").on("click", function () {
    $(".toast").removeClass("show");
  });
  $(document).on('click', '.order .order-card-ship .dropdown-menu .item', function (e) {
    let $deliveryItem = $(this).closest('.delivery-item');
    
    var other_address = $(this).find(".other-address").text();
    var note_shiper = $(this).find(".note_shiper").text();
    
    $deliveryItem.find(".dropdown input.address_delivery").val(other_address);
    $deliveryItem.find('.ship_location_id').val($(this).data('location_id'));
    
    if(note_shiper.length != 0) {
      $deliveryItem.find('.note-shipper').removeClass('hidden');
    } else {
      $deliveryItem.find('.note-shipper').addClass('hidden');
    }
    $deliveryItem.find(".note-shipper .note_shiper").text(note_shiper);
  });
  
  $(document).on('click', '.order .input-order .dropdown-menu .item', function (e) {
    let $deliveryItem = $(this).closest('.locations-container');
    
    var other_address = $(this).find(".other-address").text();
    var note_shiper = $(this).find(".note_shiper").text();
    $('.info-customer .customer-address,.info-customer .address').text(other_address);
    $('.input-location_name,.address_delivery').val(other_address);
    
    $deliveryItem.find('.ship_location_id').val($(this).data('location_id'));
    
    if(note_shiper.length != 0) {
      $deliveryItem.find('.note-shipper').removeClass('hidden');
    } else {
      $deliveryItem.find('.note-shipper').addClass('hidden');
    }
    $deliveryItem.find(".note-shipper .note_shiper").text(note_shiper);
  });
  
  $(document).on('click', '.dropdown', function (e) {
    $(this).closest(".dropdown-address").find('.dropdown-menu').show();
    $(".overlay-drop-menu").show();
  });

  $(".explain-icon img").on("click", function () {
    $(".explain-block").addClass("show");
    $(".overlay-drop-menu").show();
  });
  $(".close-explain, .overlay-drop-menu").on("click", function () {
    $(".explain-block").removeClass("show");
    $(".overlay-drop-menu").hide();
  });
  $('.start-day').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: true,
    autoApply: true,
    minDate: new Date(),
    opens: 'left',
    locale: {
      format: "DD/MM/YYYY",daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
      monthNames: [
        "Tháng 1,",
        "Tháng 2,",
        "Tháng 3,",
        "Tháng 4,",
        "Tháng 5,",
        "Tháng 6,",
        "Tháng 7,",
        "Tháng 8,",
        "Tháng 9,",
        "Tháng 10,",
        "Tháng 11,",
        "Tháng 12,",
      ],
      firstDay: 1,
    },
    ranges: {
      'Hôm nay': new Date()
    }
  }).on('show.daterangepicker', function() {
    $(this).data('daterangepicker').container.addClass('daterangepicker-open');
  }).on('hide.daterangepicker', function() {
    $(this).data('daterangepicker').container.removeClass('daterangepicker-open');
  }).on('apply.daterangepicker', function(ev, picker) {
    var today = $('.start-day').val();
    if (today == moment().format('DD/MM/YYYY')) {
      $(".toast").addClass("show");
    }
  });
  $('.js-calendar.date').each(function() {
    var today_calendar;
    if ($(this).val() != '') {
      today_calendar = $(this).val();
    } else {
      today_calendar = new Date();
    }

    $(this).daterangepicker({
      singleDatePicker: true,
      autoUpdateInput: true,
      autoApply: true,
      minDate: today_calendar,
      opens: 'left',
      locale: {
        format: "DD/MM/YYYY",daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        monthNames: [
          "Tháng 1,",
          "Tháng 2,",
          "Tháng 3,",
          "Tháng 4,",
          "Tháng 5,",
          "Tháng 6,",
          "Tháng 7,",
          "Tháng 8,",
          "Tháng 9,",
          "Tháng 10,",
          "Tháng 11,",
          "Tháng 12,",
        ],
        firstDay: 1,
      },
      ranges: {
        'Hôm nay': new Date()
      }
    }).on('show.daterangepicker', function() {
      $(this).data('daterangepicker').container.addClass('daterangepicker-open');
    }).on('hide.daterangepicker', function(ev, picker) {
      $(this).data('daterangepicker').container.removeClass('daterangepicker-open');
      var inputElement = $(this);
      var formattedDate = picker.startDate.format('YYYY-MM-DD');
      var targetInput = inputElement.siblings('.input-date_start');
      targetInput.val(formattedDate);
    }).on('apply.daterangepicker', function(ev, picker) {
      var inputElement = $(this);
      var today = $('.js-calendar.date').val();
      var formattedDate = picker.startDate.format('YYYY-MM-DD');
      var targetInput = inputElement.siblings('.input-date_start');
      targetInput.val(formattedDate);
      if (today == moment().format('DD/MM/YYYY')) {
        $(".toast").addClass("show");
      }
      showdate();
      });
    if($(this).siblings('.input-date_start').val() === '') {
      $(this).val('');
    }
  });
function showdate() {
  let values = $(".js-order-item .input-date_start").map(function () {
    return $(this).val();
  }).get().filter(date => date);
  if (values.length === 0) {
      return;
  }
  let dates = values.map(date => new Date(date));
  let minDate = new Date(Math.min(...dates));
  let day = String(minDate.getDate()).padStart(2, '0');
  let month = String(minDate.getMonth() + 1).padStart(2, '0');
  let year = minDate.getFullYear();
  let minDateStr = `${day}/${month}/${year}`;
  $(".order-details .date-start").text(minDateStr);
}
let tabCount = 1;
function activateTab(tabId) {
  $(".tab-button").removeClass("active");
  $(".js-order-item").hide();
  
  $(`[data-tab="${tabId}"]`).addClass("active");
  $(`#${tabId}`).show();
}

$(document).on('click', '.add-tab', function (e) {
  e.preventDefault();
$('.js-show-order-item .remove-tab').removeClass("hidden");
  let html = $('.js-order-item:first').prop('outerHTML');
  var type = $('.js-order-item:first').find('.input-type').val()
  if (typeof html != 'string') return;

  let index = parseInt($('.order_item_total').val()),
    id = index + 1,
    new_item = $(html.replace(/(\[0\])/g, '[' + index + ']')).show();

  
  new_item.find('.text-amount').text('0');
  new_item.attr('id', 'order_item_' + id);
  new_item.find('input, select, textarea').val('');
  new_item.find('.special-request').html('');
  $('.js-order-item').hide();
  $('.js-order-items').append(new_item);
  $('.btn-add_order').removeClass('active');
  $(this).before(`<span class="btn btn-add_order active tab-button js-show-order-item" data-tab="order_item_${id}" data-id="order_item_${id}">Sản phẩm ${id}<span class="remove-tab"></span></span>`);

  $('.order_item_total').val(id);
  new_item.find('.js-calendar.date').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: true,
    autoApply: true,
    minDate: new Date(),
    opens: 'left',
    locale: {
      format: "DD/MM/YYYY",daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
      monthNames: [
        "Tháng 1,",
        "Tháng 2,",
        "Tháng 3,",
        "Tháng 4,",
        "Tháng 5,",
        "Tháng 6,",
        "Tháng 7,",
        "Tháng 8,",
        "Tháng 9,",
        "Tháng 10,",
        "Tháng 11,",
        "Tháng 12,",
      ],
      firstDay: 1,
    },
    ranges: {
      'Hôm nay': new Date()
    }
  }).on('show.daterangepicker', function() {
    $(this).data('daterangepicker').container.addClass('daterangepicker-open');
  }).on('hide.daterangepicker', function(ev, picker) {
    $(this).data('daterangepicker').container.removeClass('daterangepicker-open');
    var inputElement = $(this);
      var formattedDate = picker.startDate.format('YYYY-MM-DD');
      var targetInput = inputElement.siblings('.input-date_start');
      targetInput.val(formattedDate);
  }).on('apply.daterangepicker', function(ev, picker) {
    var inputElement = $(this);
    var today = $('.js-calendar.date').val();
    var formattedDate = picker.startDate.format('YYYY-MM-DD');
    var targetInput = inputElement.siblings('.input-date_start');
    targetInput.val(formattedDate);
    if (today == moment().format('DD/MM/YYYY')) {
      $(".toast").addClass("show");
    }
    showdate();
  });
  new_item.find('.js-calendar.date').val('');
  $('.order-details').find('.order-wapper').append(generateInfoProduct('order_item_' + id));
});

$(document).on("click", ".tab-button", function () {
  const tabId = $(this).data("tab");
  activateTab(tabId);
});

$(document).on('change', '.input_loop', function () {
  let $deliveryItem = $(this).closest('.delivery-item');
  
  if ($(this).is(":checked")) {
      $deliveryItem.find(".repeat-weekly").addClass("show");
      $deliveryItem.find('.calendar').hide();
      $deliveryItem.find('.calendar input').val('');
      $deliveryItem.find(".js-note-ship").hide();
  } else {
      $deliveryItem.find(".repeat-weekly").removeClass("show");
      $deliveryItem.find(".js-note-ship").show();
      $deliveryItem.find('.calendar').show();
      $deliveryItem.find('.repeat-weekly input').prop("checked", false);
  }
});


$(".js-input-field").on("input", "input, select", function () {
  $(".order-details").fadeIn();
});
$('.js-btn-save.out-line').click(function (e) { 
  $('.edit--order').submit();
});
$('.js-create-order').click(function (e) { 
  $('.form-add-order').submit();
});
});
var original_total_cost = parseFloat(
  $(".price-product").text().replace(/\./g, "")
);
var total_cost = original_total_cost;

// $(".ship_fee_days, .discount, .total_ship").on("change", function (e) {
//   updateTotalCost(e.target);
//   var ship = parseInt($(".total_ship").val(), 10) || 0;
//   var discount = parseInt($(".fee-item .discount").val(), 10) || 0;
//   var price = parseFloat($(".price-order").text().replace(/\./g, "")) || 0;
//   //$(".info-pay .discount").text(formatCurrency(discount));
//   $(".info-pay .ship").text(formatCurrency(ship));
//   $(".info-pay .total").text(formatCurrency(price));
// });

$(".status-pay-menu .status-pay-item").on("click", function () {
  updateStatus($(this));
});

$(".input-paymented").on("change", function () {
  updatePaymentRequired();
});

// function updateTotalCost(target) {
//   var ship_fee_days = parseInt($(".ship_fee_days").val(), 10) || 0;
//   var user_input_ship_fee = parseInt($(".total_ship").val(), 10);
//   var calculated_ship_fee = ship_fee_days * SHIP;

//   if (target.classList.contains("total_ship")) {
//     calculated_ship_fee = !isNaN(user_input_ship_fee)
//       ? user_input_ship_fee
//       : calculated_ship_fee;
//   }
//   $(".total_ship").val(calculated_ship_fee);
//   var discount = parseInt($("input.discount").val(), 10) || 0;
//   total_cost = original_total_cost + calculated_ship_fee - discount;
//   var formattedCurrency = formatCurrency(total_cost);
//   $(".price-order").text(formattedCurrency);
//   updatePaymentRequired();
// }

function updateStatus(selectedItem) {
  $(".paymented").hide();
  $(".status-pay").html(selectedItem.html());

  var status = selectedItem.data("status");
  $(".status-pay").attr("data-status", status);

  if (status === "pending") {
    $(".paymented").css("display", "flex");
    updatePaymentRequired();
  } else if (status === "yes") {
    $(".payment-required").text("0");
  } else {
    $(".payment-required").text(formatCurrency(total_cost));
  }
}
$(".status-payment").on("click", function () {
  $(this).find(".status-pay-menu").slideToggle(0);
});

function updatePaymentRequired() {
  var status = $(".status-pay").attr("data-status");
  var paymented = parseInt($(".input-paymented").val(), 10) || 0;

  if (status === "no") {
    $(".payment-required").text(formatCurrency(total_cost));
  } else if (status === "yes") {
    $(".payment-required").text("0");
  } else if (status === "pending") {
    var remaining = total_cost - paymented;
    $(".payment-required").text(formatCurrency(remaining));
  }
}

function formatCurrency(value) {
  //return new Intl.NumberFormat("vi-VN").format(value);
}
function generateInfoProduct(item_id) {
  return `
  <div class="info-order hidden line" data-id="${item_id}">
  <div class="d-f jc-b pt-8 hidden">
          <span class="tlt fw-bold ">Phân loại đơn hàng:</span>
          <span class="type"></span>
      </div>
      <div class="d-f jc-b pt-8 hidden">
          <span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
          <span class="date-start"></span>
      </div>
      <div class="tlt fw-bold  pt-8 hidden">Thông tin sản phẩm:</div>
  <div class="info-product pt-8">
          <div class="d-f jc-b">
              <div class="d-f"><span class="name"></span>&nbsp;x&nbsp;<span class="quantity"></span></div>
              <div class="price"></div>
          </div>
          <div class="note-box pb-20">
              </div>
      </div></div>`;
}
$(document).on('change', '.input-note_values', function () {
  var item = $(this).closest('.js-order-item');
  var id = item.attr('id')
  var noteHtml = ''
  const allNotes = getAllNotesValues(item);
  $.each(allNotes, function (indexInArray, valueOfElement) {
    var textValue = ''
    $.each(valueOfElement.noteValues, function (indexInArray, valueNote) { 
      if (textValue) {
        textValue += ', ' + valueNote["value"];
    } else {
        textValue = valueNote["value"];
    }
    });
    noteHtml += `<p><span class="note">Note ${valueOfElement['noteName']}</span>:&nbsp;<span class="value">${textValue}</span></p>`
  });
  $('.order-details').find(`[data-id="${id}"] .note-box`).html(noteHtml);
})
function getAllNotesValues(item) {
  const notesData = [];
  
  item.find('.row-note').each(function() {
      const noteRow = $(this);
      const noteName = noteRow.find('.input-note_name').val(); 
      let noteValues = []; 

      noteRow.find('.input-note_values').each(function() {
          const tagifyInstance = $(this).data('tagify');
          if (tagifyInstance && tagifyInstance.value.length > 0) {
              noteValues = tagifyInstance.value;
          }
      });
      
      notesData.push({
          noteName: noteName,
          noteValues: noteValues
      });
  });
  return notesData;
}

