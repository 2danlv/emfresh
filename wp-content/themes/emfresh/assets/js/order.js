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
  });
  $(".tooltip-icon").on("click", function () {
    $(this).siblings(".tooltip-content").show();
  });
  $(document).click(function (event) {
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
});