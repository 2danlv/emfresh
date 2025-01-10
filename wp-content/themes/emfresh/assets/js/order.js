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
let tabCount = 1; // Initialize tab count for dynamic tabs

$(document).ready(function () {
  // Function to activate a tab and its content
  function activateTab(tabId) {
    // Remove active class from all tab buttons and contents
    $(".tab-button").removeClass("active");
    $(".tab-content-wrapper").removeClass("active");

    // Add active class to the selected tab and its content
    $(`[data-tab="${tabId}"]`).addClass("active");
    $(`#${tabId}`).addClass("active");
  }

  // Handle tab-button clicks
  $(document).on("click", ".tab-button", function () {
    const tabId = $(this).data("tab");
    activateTab(tabId);
  });

  // Add a new tab and its content
  $(".add-tab").click(function () {
    tabCount++;

    // Create new tab button
    const newTabButton = $(
      `<button class="btn btn-add_order tab-button" data-tab="tab-${tabCount}">Sản phẩm ${tabCount}<span class="remove-tab"></button>`
    );
    $("#tabNav .add-tab").before(newTabButton);

    // Clone the first tab content and reset necessary fields
    const content = $("#tabContents .tab-content-wrapper:first")
      .clone(true) // Clone with event bindings
      .prop("id", `tab-${tabCount}`); // Assign a unique ID

    // Clear input and select values in the cloned content
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

    content.find(".price").text("0"); // Reset price fields

    // Append the new content
    $("#tabContents").append(content);

    // Activate the newly added tab
    activateTab(`tab-${tabCount}`);
  });

  // Remove a tab and its content
  $(document).on("click", ".remove-tab-button", function () {
    const tabContent = $(this).closest(".tab-content");
    const tabId = tabContent.attr("id");
    const tabButton = $(`[data-tab="${tabId}"]`);

    // Remove the tab and its content
    tabContent.remove();
    tabButton.remove();

    // Activate the first available tab, if any
    const firstTab = $(".tab-button").first();
    if (firstTab.length > 0) {
      activateTab(firstTab.data("tab"));
    }
  });
});

$(document).ready(function () {
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
    var clone = $(".special-item:first").clone();
    clone.find("input").val("");
    $(".special-request").append(clone);
  });
});

$(document).ready(function () {
  // Event delegation for search results click
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
  });

  // Event delegation for dropdown menu items
  $(".dropdown-menu").on("click", ".item", function () {
    const $this = $(this);
    const other_address = $this.find(".other-address").text();
    const note_shiper = $this.find(".note_shiper").text();

    setDropdownFields({ other_address, note_shiper });
    $(".dropdown-menu").hide();
  });

  // Add new address
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

  // Helper function to update order input fields
  function setOrderInputFields({ name, phone, address }) {
    $(".input-order input.fullname").val(name);
    $(".input-order input.phone").val(phone);
    $(".input-order input.address_delivery").val(address);
    $(".input-order .note-shipper").show();
  }

  // Helper function to update dropdown fields
  function setDropdownFields({ other_address, note_shiper }) {
    $(".dropdown input").val(other_address);
    $(".dropdown-address").find(".note_shiper").text(note_shiper);
  }

  // Generate address HTML
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
  console.log("object");
  $(".delivery-item").find(".dropdown-menu").slideToggle();
});
$("#loop").change(function () {
  if ($(this).is(":checked")) {
    $(".repeat-weekly").addClass("show");
    $('.note').removeClass("show");
  } else {
    $(".repeat-weekly").removeClass("show");
    $('.note').addClass("show");
  }
});
var price_order = parseFloat($(".price-order").text().replace(/\./g, ""));
$(".ship_fee_days, .discount").on("change", function () {
  var ship_fee_days = parseInt($(".ship_fee_days").val(), 10) || 0;
  var calculated_ship_fee = ship_fee_days * SHIP;
  var discount = parseInt($('.discount').val(), 10) || 0;

  $(".total_ship").val(calculated_ship_fee);
  var total_cost = price_order - calculated_ship_fee - discount;
  var formattedCurrency = new Intl.NumberFormat("vi-VN").format(total_cost);
  $(".price-order").text(formattedCurrency);
});
function toggleOrderDetails() {
  var tab_id = $('ul.tabNavigation li.selected').attr('rel');
  console.log(tab_id)
  if (tab_id !== 'customer') {
    $('.order-details').show();
  } else {
    $('.order-details').hide();
  }
}

$(document).ready(function () {
  toggleOrderDetails();

  $('ul.tabNavigation li').on('click', function () {
    toggleOrderDetails();
  });
});