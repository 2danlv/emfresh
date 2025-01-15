$(document).ready(function () {
  $('.detail-customer.order .search-cus').keyup(function (e) { 
    e.preventDefault();
    var search_cus_val = $(this).val();
    if (search_cus_val != 123) {
      $('.detail-customer.order .search-result .no-results').show();
      $('.detail-customer.order .title-order,.detail-customer.order .history-order,.detail-customer.order .search-result .results').hide();
      $(".dropdown").css("pointer-events", "none");
    } else {
      $('.detail-customer.order .search-result .no-results,.history-order .history,.history-order .no-history').hide();
      $('.detail-customer.order .search-result .results,.title-order,.history-order').show();
      $(".dropdown").css("pointer-events", "all");
    }
  });
  $(document).click(function (event) {
    if (!$(event.target).closest(".search-cus, .results, .no-results").length) {
      $(".results, .no-results").hide();
    }
  });
  $(".search-result .results").on("click", function () {
    $(this).hide();
    $(".history-order .history").show();
  });
  $(".dropdown.active").on("click", function () {
    $(this).closest(".dropdown-address").find('.dropdown-menu').show();
    $(".overlay-drop-menu").show();
  });
  $(".tooltip-icon").on("click", function () {
    $(this).siblings(".tooltip-content").show();
  });
  $(".overlay-drop-menu,.other-address").click(function () {
    $('.overlay-drop-menu').hide();
    $('.dropdown-menu').hide();
  });
  $(document).click(function () {
    if (!$(event.target).closest(".tooltip-content, .tooltip-icon").length) {
      $(".tooltip-content").hide();
    }
  });
  $(".tooltip-content .close").on("click", function () {
    $(this).closest(".tooltip-content").hide();
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
    $(".input-order input.address_delivery").val(address);
    $(".input-order .note-shipper").show();
    $(".input-order .note-shipper .note_shiper").text(note_shiper);
    
    $(".results").hide();
    $(".dropdown").css("pointer-events", "all");
    $(".history-order").find(".show").removeClass("show");
    $(".history-order").find(".history").addClass("show");
  });
  $(".close-toast").on("click", function () {
    $(".toast").removeClass("show");
  });
  $(".order .dropdown-menu .item").click(function (e) {
    var other_address = $(this).find(".other-address").text();
    var note_shiper = $(this).find(".note_shiper").text();
    $(".dropdown input").val(other_address);
    $(".input-order .note-shipper .note_shiper").text(note_shiper);
  });
  $(".explain-icon img").on("click", function () {
    $(".explain-block").addClass("show");
    $(".overlay-drop-menu").show();
  });
  $(".close-explain, .overlay-drop-menu").on("click", function () {
    $(".explain-block").removeClass("show");
    $(".overlay-drop-menu").hide();
  });
 
    $('.start-day,.js-calendar.date').daterangepicker({
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
  
let tabCount = 1;
function activateTab(tabId) {
  $(".tab-button").removeClass("active");
  $(".tab-content-wrapper").removeClass("active");

  $(`[data-tab="${tabId}"]`).addClass("active");
  $(`#${tabId}`).addClass("active");
}

$(document).on("click", ".tab-button", function () {
  const tabId = $(this).data("tab");
  activateTab(tabId);
});
$(".add-tab").click(function () {
  tabCount++;

  const newTabButton = $(
    `<a href="#tab-${tabCount}" class="btn btn-add_order tab-button" data-tab="tab-${tabCount}">Sản phẩm ${tabCount}<span class="remove-tab"></a>`
  );
  $("#tabNav .add-tab").before(newTabButton);

  const content = $("#tabContents .tab-content-wrapper:first")
    .clone(true)
    .prop("id", `tab-${tabCount}`);
  content.find("input").each(function () {
    const type = $(this).attr("type");
    if (type === "checkbox" || type === "radio") {
      $(this).prop("checked", false); // Reset checkboxes/radios
    } else {
      $(this).val(""); // Clear text inputs
    }
  });
  content.find('.start-day').daterangepicker({
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
  content.find("select").each(function () {
    $(this).val(""); // Reset select fields
  });

  content.find(".price").text("0");
  $("#tabContents").append(content);
  
  activateTab(`tab-${tabCount}`);
  $(".tab-button").find(".remove-tab").addClass("show");
});
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
$(".status-payment").on("click", function () {
  $(this).find(".status-pay-menu").slideToggle(0);
});
$(".status-pay-menu .status-pay-item").on("click", function () {
  $(".paymented").hide();
  $(".status-pay").html($(this).html());
  $(".input_status-payment").val($(this).attr('data-status'));
  var status = $(this).data("status");
  if (status === "pending") {
    $(".paymented").css("display", "flex");
  } else if (status === "yes") {
    $(".payment-required").text("0");
  }
});
$("#loop").change(function () {
  if ($(this).is(":checked")) {
    $(".repeat-weekly").addClass("show");
  } else {
    $(".repeat-weekly").removeClass("show");
  }
});
$(".delivery-field .add-new-note").click(function () {
    $('.delivery-item.js-note').show();
    $(this).hide();
});
});