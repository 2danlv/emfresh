var SHIP = 10000;
$(".search-cus").on("input", function () {
  var value = $(this).val();
  console.log(value);
  if (value == "123") {
    $(".results").show();
    $(".no-results").hide();
  } else {
    $(".results").hide();
    $(".no-results").show();
  }
});

$(document).click(function (event) {
  if (!$(event.target).closest(".search-cus, .results, .no-results").length) {
    $(".results, .no-results").hide();
  }
});

$(".dropdown.active").on("click", function () {
  $(this).siblings(".dropdown-menu").slideToggle();
});
$(".btn-add-address").on("click", function () {
  $("#modal-add-address").toggleClass("is-active");
});
$(".tooltip-icon").on("click", function () {
  $(this).siblings(".tooltip-content").slideToggle();
});

$(document).click(function (event) {
  if (!$(event.target).closest(".tooltip-content, .tooltip-icon").length) {
    $(".tooltip-content").slideUp();
  }
});
$(".tooltip-content .close").on("click", function () {
  $(this).closest(".tooltip-content").slideUp();
});
let tabCount = 1;

$(document).ready(function () {
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

    var posX = e.pageX;
    var posY = e.pageY;

    $("#modal-remove-tab .modal-dialog").css("top", posY);
    $("#modal-remove-tab .modal-dialog").css("right", posX);
    $("#modal-remove-tab").show();

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
      modal.hide();
    }
  });
  $(".modal-close").on("click", function () {
    $("#modal-remove-tab").hide();
  });

  $(".tabNavigation [rel='customer']").trigger("click");
  $("ul.tabNavigation li").click(function () {
    var rel = $(this).attr("rel");
    if ($(".tabNavigation li.selected [rel='settings-product']")) {
      $(".edit-product [rel='detail-product']").trigger("click");
    }

    if (rel == "product") {
      $(".toast").addClass("show");
    } else {
      $(".toast").removeClass("show");
    }
  });
  $("ul.tab-nav-detail li").click(function () {
    var rel = $(this).attr("rel");
    if (rel == "info") {
      $(".js-group-btn").addClass("show");
    } else {
      $(".js-group-btn").removeClass("show");
    }
    if (rel == 'settings-product') {
      $('.js-btn-clone').hide();
      $('.js-btn-save').show();
    }
    else{
      $('.js-btn-clone').show();
      $('.js-btn-save').hide();
    }
  });
  $(".tag-container").each(function () {
    const $tagContainer = $(this);
    const $tagInput = $tagContainer.find(".tag-input");

    function createTag(tagText) {
      if (tagText.trim() === "") return;
      const tag = `
        <div class="tag d-f ai-center gap-4">
          <span>${tagText}</span>
          <button type="button" class="remove-tag"></button>
        </div>`;
      $tagInput.before(tag);
    }

    $tagInput.on("keypress", function (e) {
      if (e.key === "Enter" || e.key === ",") {
        e.preventDefault();
        const tagText = $tagInput.val().trim();
        if (tagText) {
          createTag(tagText);
          $tagInput.val("");
        }
      }
    });

    $(document).on("click", function (e) {
      if (!$tagContainer.is(e.target) && !$tagContainer.has(e.target).length) {
        const tagText = $tagInput.val().trim();
        if (tagText) {
          createTag(tagText);
          $tagInput.val("");
        }
      }
    });

    $tagContainer.on("click", "button", function () {
      $(this).closest(".tag").remove();
    });
  });

  $(".clone-note").click(function () {
    var clone = `
    <div class="special-item row">
      <div class="col-4">
          <select id="district_0" name="special-note" class="district-select form-control">
              <option value="Note rau củ" selected>Note rau củ</option>
              <option value="Note tinh bột">Note tinh bột</option>
              <option value="Note nước sốt">Note nước sốt</option>
              <option value="Note khác">Note khác</option>
              <option value="Note đính kèm">Note đính kèm</option>
              <option value="Phân loại yêu cầu">Note tinh bột</option>
          </select>
      </div>
      <div class="col-8">
          <div class="tag-container" id="tagContainer">
              <input type="text" class="form-control tag-input" id="tagInput">
          </div>
      </div>
    </div>`;
    $(".special-request").append(clone);
  });
  $(function () {
    $(".js-calendar").on("click", function () {
      var w_calendar = $(this).width();
      $(".daterangepicker").css("width", w_calendar);
    });
    $(".js-calendar").daterangepicker(
      {
        singleDatePicker: true,
        autoApply: true,
        locale: {
          format: "DD/MM/YYYY",
          daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
          monthNames: [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12",
          ],
          firstDay: 1,
        },
        isInvalidDate: function (date) {
          const day = date.day();
          return day === 0 || day === 6;
        },
      },
      function (start, end, label, date) {
        var today = moment().format("DD/MM/YYYY");
        var updatedDate = moment(end).format("DD/MM/YYYY");
        $(".start-day").val(updatedDate);
        $(".toast span").text(updatedDate);
        $(".today-button")
          .off("click")
          .on("click", function () {
            $(".toast span").text(today);
            $(".start-day").val(today);
          });
      }
    );
  });
  $(document).on("show.daterangepicker", function (e, picker) {
    const calendar = picker.container;
    if (!calendar.find(".custom-today-button").length) {
      calendar.append(`
        <div class="custom-today-button">
          <button class="today-button">Hôm nay</button>
        </div>
      `);
    }
    calendar.on("click", ".today-button", function () {
      const today = moment();
      picker.setStartDate(today);
      $("#daterange").val(today.format("DD/MM/YYYY")); // Set the input field value to today's date
      picker.hide(); // Hide calendar after selecting "Today"
    });
  });
  $(".search-result").on("click", ".results", function () {
    const $this = $(this);
    const name = $this.find(".name").text();
    const phone = $this.find(".phone").text();
    const address = $this.find(".address").text();
    const note_shiper = $this.find(".note_shiper").text();

    setOrderInputFields({ name, phone, address });
    $(".results").hide();
    $(".dropdown-address").find(".note_shiper").text(note_shiper);
    $(".dropdown").css("pointer-events", "all");
    $(".history-order").find(".show").removeClass("show");
    $(".history-order").find(".history").addClass("show");
  });

  $(".dropdown-menu").on("click", ".item", function () {
    const $this = $(this);
    const other_address = $this.find(".other-address").text();
    const note_shiper = $this.find(".note_shiper").text();

    setDropdownFields({ other_address, note_shiper });
    $(".dropdown-menu").hide();
  });

  $(".add-address").on("click", function () {
    const addressData = {
      district: $("#modal-add-address .district-select").val(),
      ward: $("#modal-add-address .ward-select").val(),
      address: $("#modal-add-address .address").val(),
      note_shiper: $("#modal-add-address .note_shiper input").val(),
      note_admin: $("#modal-add-address .note_admin input").val(),
    };

    $(".dropdown-menu .item").after(addAddressHtml(addressData));
    $(".modal").removeClass("is-active");
  });

  function setOrderInputFields({ name, phone, address }) {
    $(".input-order input.fullname").val(name);
    $(".input-order input.phone").val(phone);
    $(".input-order input.address_delivery").val(address);
    $(".input-order .note-shipper").show();
  }

  function setDropdownFields({ other_address, note_shiper }) {
    $(".dropdown input").val(other_address);
    $(".dropdown-address").find(".note_shiper").text(note_shiper);
  }

  function addAddressHtml({
    district,
    ward,
    address,
    note_admin,
    note_shiper,
  }) {
    return `
      <div class="item">
        <p class="fs-16 color-black other-address">${address}, ${ward}, ${district}</p>
        <div class="group-management-link d-f jc-b ai-center pt-8">
          <div class="tooltip d-f ai-center">
            <p class="fs-14 fw-regular color-gray">(${note_admin})</p>
            <p class="note_shiper hidden">${note_shiper}</p>
            <span class="fas fa-info-gray"></span>
          </div>
          <a class="management-link" href="#">Đi đến Quản lý nhóm</a>
        </div>
      </div>`;
  }
  toggleOrderDetails();

  $("ul.tabNavigation li").on("click", function () {
    toggleOrderDetails();
  });
});

$(".status-payment").on("click", function () {
  $(this).find(".status-pay-menu").slideToggle();
});
$(".status-pay-menu .status-pay-item").on("click", function () {
  $(".paymented").hide();
  $(".status-pay").html($(this).html());
  var status = $(this).data("status");
  if (status === "pending") {
    $(".paymented").css("display", "flex");
  } else if (status === "yes") {
    $(".payment-required").text("0");
  }
});
$(".paymented").on("input", function () {
  var text = $(".price-order").text();
  var total_order = parseFloat(text.replace(/\./g, ""));
  var total_paid = parseInt($(".paymented").find("input").val(), 10) || 0;
  var payment_required = total_order - total_paid;
  var formattedCurrency = new Intl.NumberFormat("vi-VN").format(
    payment_required
  );
  $(".payment-required").text(formattedCurrency);
});
$(".delivery-item .dropdown").on("click", function () {
  $(".delivery-item").find(".dropdown-menu").slideToggle();
});
$("#loop").change(function () {
  if ($(this).is(":checked")) {
    $(".repeat-weekly").addClass("show");
    $(".js-note").removeClass("show");
  } else {
    $(".repeat-weekly").removeClass("show");
    $(".js-note").addClass("show");
  }
});
var price_order = parseFloat($(".price-order").text().replace(/\./g, ""));
$(".ship_fee_days, .discount").on("change", function () {
  var ship_fee_days = parseInt($(".ship_fee_days").val(), 10) || 0;
  var calculated_ship_fee = ship_fee_days * SHIP;
  var discount = parseInt($(".discount").val(), 10) || 0;

  $(".total_ship").val(calculated_ship_fee);
  var total_cost = price_order - calculated_ship_fee - discount;
  var formattedCurrency = new Intl.NumberFormat("vi-VN").format(total_cost);
  $(".price-order").text(formattedCurrency);
});
function toggleOrderDetails() {
  var tab_id = $("ul.tabNavigation li.selected").attr("rel");
  if (tab_id !== "customer") {
    $(".order-details").show();
  } else {
    $(".order-details").hide();
  }
}

$(".remove-tab").on("click", function () {
  $(".modal-remove-tab").addClass("is-active");
});
$("ul.edit-product li").click(function () {
  jQuery("ul.edit-product li").removeClass("selected");
  $(".tab-pane-2").stop().fadeOut(1);
  var id = $(this).attr("rel");
  $("#" + id)
    .stop()
    .fadeIn(300);
  // $('#'+id).show();
  $(this).addClass("selected");
});
$(".close-toast").on("click", function () {
  $(".toast").removeClass("show");
});
$('.explain-icon').on('click', function(){
  $('.explain-block').addClass('show')
})
$('.close-explain').on('click', function(){
  $('.explain-block').removeClass('show')
})