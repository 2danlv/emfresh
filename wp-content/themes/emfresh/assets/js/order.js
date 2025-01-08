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
$(document).ready(function () {
  let tabCount = 1;

  // Function to activate a tab
  function activateTab(tabId) {
    $(".tab-button").removeClass("active");
    $(".tab-content").removeClass("active");
    $(`[data-tab="${tabId}"]`).addClass("active");
    $(`#${tabId}`).addClass("active");
  }

  // Click event for tab buttons
  $(document).on("click", ".tab-button", function () {
    const tabId = $(this).data("tab");
    activateTab(tabId);
  });

  $(".add-tab").click(function () {
    tabCount++;

    // Create new tab button
    const newTabButton = $(
      `<button class="btn btn-primary btn-add_order tab-button active" data-tab="tab-${tabCount}">Sản phẩm ${tabCount}</button>`
    );
    $("#tabNav .add-tab").before(newTabButton);

    const content = $("#tabContents .tab-content-wraper .tab-content:first").clone().html();
    const newTabContent =`<div class="tab-content-wraper tab-content" id="tab-${tabCount}">${content}</div>`;

    $("#tabContents").append(newTabContent);

    activateTab(`tab-${tabCount}`);
  });

  $(document).on("click", ".remove-tab-button", function () {
    const tabContent = $(this).closest(".tab-content");
    const tabId = tabContent.attr("id");
    const tabButton = $(`[data-tab="${tabId}"]`);

    // Remove tab and content
    tabContent.remove();
    tabButton.remove();

    // Activate the first available tab
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
