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
  $(".dropdown").on("click", function () {
    $(this).closest(".dropdown-address").find('.dropdown-menu').show();
    $(".overlay-drop-menu").show();
  });
  $(".tooltip-icon").on("click", function () {
    $(this).siblings(".tooltip-content").show();
  });
  $(document).on('click', '.overlay-drop-menu,.other-address', function (e) {
    $('.overlay-drop-menu').hide();
    $('.dropdown-menu').hide();
    $(".tooltip-content").hide();
  });
  $(".tooltip-content .close").on("click", function () {
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
  $(document).on('click', '.order .dropdown-menu .item', function (e) {
    var other_address = $(this).find(".other-address").text();
    var note_shiper = $(this).find(".note_shiper").text();
    $(".dropdown input").val(other_address);
    $('.info-customer .customer-address').text(other_address);
    console.log('log',note_shiper.length);
    if(note_shiper.length != 0) {
      $('.note-shipper').removeClass('hidden');
    } else {
      $('.note-shipper').addClass('hidden');
    }
    $(".note-shipper .note_shiper").text(note_shiper);
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
    $('.js-calendar.date').daterangepicker({
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
      var inputElement = $(this);
      var today = $('.js-calendar.date').val();
      var formattedDate = picker.startDate.format('YYYY-MM-DD');
      var targetInput = inputElement.siblings('.input-date_start');
      targetInput.val(formattedDate);
      if (today == moment().format('DD/MM/YYYY')) {
        $(".toast").addClass("show");
      }
    });
  
let tabCount = 1;
function activateTab(tabId) {
  $(".tab-button").removeClass("active");
  $(".js-order-item").hide();
  
  $(`[data-tab="${tabId}"]`).addClass("active");
  $(`#${tabId}`).show();
}

$(document).on('click', '.add-tab', function (e) {
  e.preventDefault();

  let html = $('.js-order-item:first').prop('outerHTML');
  if (typeof html != 'string') return;

  let index = parseInt($('.order_item_total').val()),
    id = index + 1,
    new_item = $(html.replace(/(\[0\])/g, '[' + index + ']')).show();

  
  new_item.find('.text-amount').text('0');
  new_item.attr('id', 'order_item_' + id);
  new_item.find('input, select, textarea').val('');
  $('.js-order-item').hide();
  $('.js-order-items').append(new_item);
  $('.btn-add_order').removeClass('active');
  $(this).before(`<span class="btn btn-add_order active tab-button js-show-order-item" data-tab="order_item_${id}">Sản phẩm ${id}<span class="remove-tab"></span></span>`);

  $('.order_item_total').val(id);
  $('.js-calendar.date').daterangepicker({
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
    var inputElement = $(this);
    var today = $('.js-calendar.date').val();
    var formattedDate = picker.startDate.format('YYYY-MM-DD');
    var targetInput = inputElement.siblings('.input-date_start');
    targetInput.val(formattedDate);
    if (today == moment().format('DD/MM/YYYY')) {
      $(".toast").addClass("show");
    }
  });
  new_item.find('.js-calendar.date').val('');
});

$(document).on("click", ".tab-button", function () {
  const tabId = $(this).data("tab");
  activateTab(tabId);
});
// $(".add-tab").click(function () {
//   tabCount++;

//   const newTabButton = $(
//     `<a href="#tab-${tabCount}" class="btn btn-add_order tab-button" data-tab="tab-${tabCount}">Sản phẩm ${tabCount}<span class="remove-tab"></a>`
//   );
//   $("#tabNav .add-tab").before(newTabButton);

//   const content = $("#tabContents .tab-content-wrapper:first")
//     .clone(true)
//     .prop("id", `tab-${tabCount}`);
//   content.find("input").each(function () {
//     const type = $(this).attr("type");
//     if (type === "checkbox" || type === "radio") {
//       $(this).prop("checked", false); // Reset checkboxes/radios
//     } else {
//       $(this).val(""); // Clear text inputs
//     }
//   });
//   content.find('.start-day').daterangepicker({
//     singleDatePicker: true,
//     autoUpdateInput: true,
//     autoApply: true,
//     minDate: new Date(),
//     opens: 'left',
//     locale: {
//       format: "DD/MM/YYYY",daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
//       monthNames: [
//         "Tháng 1,",
//         "Tháng 2,",
//         "Tháng 3,",
//         "Tháng 4,",
//         "Tháng 5,",
//         "Tháng 6,",
//         "Tháng 7,",
//         "Tháng 8,",
//         "Tháng 9,",
//         "Tháng 10,",
//         "Tháng 11,",
//         "Tháng 12,",
//       ],
//       firstDay: 1,
//     },
//     ranges: {
//       'Hôm nay': new Date()
//     }
//   }).on('show.daterangepicker', function() {
//     $(this).data('daterangepicker').container.addClass('daterangepicker-open');
//   }).on('hide.daterangepicker', function() {
//     $(this).data('daterangepicker').container.removeClass('daterangepicker-open');
//   }).on('apply.daterangepicker', function(ev, picker) {
//     var today = $('.start-day').val();
//     if (today == moment().format('DD/MM/YYYY')) {
//       $(".toast").addClass("show");
//     }
//   });
//   content.find("select").each(function () {
//     $(this).val(""); // Reset select fields
//   });

//   content.find(".price").text("0");
//   $("#tabContents").append(content);
  
//   activateTab(`tab-${tabCount}`);
//   $(".tab-button").find(".remove-tab").addClass("show");
// });
$(document).on("click", ".remove-tab", function (e) {
  e.stopPropagation();
  $("#modal-remove-tab").addClass("is-active");
  var tabToRemove = $(this).closest("[data-tab]");
  $("#modal-remove-tab").data("tabToRemove", tabToRemove);
});

$('#modal-remove-tab button[name="remove"]').on("click", function () {
  var modal = $("#modal-remove-tab");
  var tabToRemove = modal.data("tabToRemove");
  tabCount = $(".tab-button").length - 1;
  if (tabToRemove) {
    const dataId = tabToRemove.data("tab");

    $(`#${dataId}`).remove();
    tabToRemove.remove();

    const firstTab = $(".tab-button").first();
    if (firstTab.length > 0) {
      activateTab(firstTab.data("tab"));
    }

    if ($(".tab-button").length == 1) {
      $(".remove-tab").removeClass("show");
    }
    $(".tab-button").each(function (index) {
      $(this).html(
        `Sản phẩm ${index + 1}<span class="remove-tab ${
          $(".tab-button").length == 1 ? "" : "show"
        }">`
      );
    });
    modal.removeClass("is-active");
  }
});

$(".status-pay-menu .status-pay-item span").on("click", function () {
  $(".paymented").hide();
  $(".status-pay").html($(this).closest('.status-pay-item').html());
  $(".input_status-payment").val($(this).attr('data-status'));
  var status = $(this).attr('data-status');
  if (status === "4") {
    $(".paymented").css("display", "flex");
  } else if (status === "yes") {
    $(".payment-required").text("0");
  }
});
$("#loop").change(function () {
  if ($(this).is(":checked")) {
    $(".repeat-weekly").addClass("show");
    $(this).closest('.delivery-item').find('.calendar').hide();
    $(this).closest('.delivery-item').find('.calendar input').val('');
  } else {
    $(".repeat-weekly").removeClass("show");
    $(this).closest('.delivery-item').find('.calendar').show();
  }
});
$(".delivery-field .add-new-note").click(function () {
    $('.delivery-item.js-note').show();
    $(this).hide();
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

$(".ship_fee_days, .discount, .total_ship").on("change", function (e) {
  updateTotalCost(e.target);
  var ship = parseInt($(".total_ship").val(), 10) || 0;
  var discount = parseInt($(".fee-item .discount").val(), 10) || 0;
  var price = parseFloat($(".price-order").text().replace(/\./g, "")) || 0;
  $(".info-pay .discount").text(formatCurrency(discount));
  $(".info-pay .ship").text(formatCurrency(ship));
  $(".info-pay .total").text(formatCurrency(price));
});

$(".status-pay-menu .status-pay-item").on("click", function () {
  updateStatus($(this));
});

$(".input-paymented").on("change", function () {
  updatePaymentRequired();
});

function updateTotalCost(target) {
  var ship_fee_days = parseInt($(".ship_fee_days").val(), 10) || 0;
  var user_input_ship_fee = parseInt($(".total_ship").val(), 10);
  var calculated_ship_fee = ship_fee_days * SHIP;

  if (target.classList.contains("total_ship")) {
    calculated_ship_fee = !isNaN(user_input_ship_fee)
      ? user_input_ship_fee
      : calculated_ship_fee;
  }
  $(".total_ship").val(calculated_ship_fee);
  var discount = parseInt($("input.discount").val(), 10) || 0;
  total_cost = original_total_cost + calculated_ship_fee - discount;
  var formattedCurrency = formatCurrency(total_cost);
  $(".price-order").text(formattedCurrency);
  updatePaymentRequired();
}

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
  return new Intl.NumberFormat("vi-VN").format(value);
}
