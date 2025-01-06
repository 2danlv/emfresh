$( document ).ready( function () {
  $(".order-search").on("change", function () {
      var value = $( this ).val();
    if (value == "0123456789") {
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
});
