$(".order-search").on("input", function () {
  var value = $(this).val();
  if (value == "0123456789") {
    console.log("object");
    $(".results").addClass("active");
    $(".no-results").removeClass("active");
  } else {
    $(".results").removeClass("active");
    $(".no-results").addClass("active");
  }
});

$(document).click(function (event) {
  if (!$(event.target).is(".order-search")) {
    $(".search-result, .results, .no-results").removeClass("active");
  }
});
$(".dropdown.active").on("click", function () {
  $(this).siblings(".dropdown-menu").toggleClass("show");
});
$(".btn-add-address").on("click", function () {
  $("#modal-add-address").toggleClass("is-active");
})