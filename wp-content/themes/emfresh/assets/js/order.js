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
