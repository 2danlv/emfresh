$(document).ready(function () {
  $('.detail-customer.order .search-cus').keyup(function (e) { 
    e.preventDefault();
    var search_cus_val = $(this).val();
    if (search_cus_val != 123) {
      $('.detail-customer.order .search-result .no-results').show();
    } else {
      $('.detail-customer.order .search-result .no-results').hide();
      $('.detail-customer.order .search-result .results').show();
    }
  });
});