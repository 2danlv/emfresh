<?php

/**
 * Template Name: Page meal search
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

$customer_id = isset($_GET[ 'customer_id' ]) ? intval($_GET[ 'customer_id' ]) : 0;
$order_id    = isset($_GET[ 'order_id' ]) ? intval($_GET[ 'order_id' ]) : 0;

$args = [];

if ( $order_id > 0 ) {
  $args[ 'order_id' ] = $order_id;
}

if ( $customer_id > 0 ) {
  $args[ 'customer_id' ] = $customer_id;
}

$data = site_order_get_meal_plans($args);

get_header();
// Start the Loop.

if ( count($data) > 0 && isset($data[ 'orders' ]) ) :

  $first_order              = $data[ 'orders' ][ 0 ];
  $schedule_meal_plan_items = $data[ 'meal_plan_items' ];

  ?>
  <!-- Main content -->
  <?php
endif;

global $site_scripts;

if ( empty($site_scripts) ) $site_scripts = [];
get_footer('customer');
?>
<script>
  $(document).ready(function () {
    $('.content-header .input-search').attr('placeholder', 'Tên khách hàng / SĐT');
    $('.content-header .wrap-search .clear-input').click(function (e) { 
      e.preventDefault();
      $('.content-header .wrap-search .input-search').val('');
      $('.content-header .top-results,.content-header .wrap-search .clear-input').hide();
    });
  });
  $('.content-header .wrap-search .input-search').keyup(function () {
    var query = $(this).val();
    //$('.no-results .btn-add-customer').attr('href', '/customer/add-customer/?phone='+query);
    $('.content-header .wrap-search .clear-input').show();
    if (query.length > 2) {
      $.ajax({
        url: '<?php echo home_url('em-api/customer/list/?limit=-1'); ?>',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          //console.log('customer', response.data);
          var suggestions = '';
          var results = response.data.filter(function (customer) {
            return customer.customer_name.toLowerCase().includes(query.toLowerCase()) ||
              customer.phone.includes(query)
          });

          if (results.length > 0) {
            suggestions = results.map(customer =>
              `<div class="result-item pb-4 pt-4" data-id="${customer.id}">
                  <p><a href="/meal-detail/?customer_id=${customer.id}" >${customer.customer_name} <br>
                  ${customer.phone}</a></p>
              </div>`
            ).join("\n");

            $('.content-header .top-results').show();
            $('.content-header .top-results #top-autocomplete-results').html(suggestions);
          } else {
            $('.content-header .top-results').hide();
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data from API');
          $('.content-header .wrap-search #autocomplete-results').hide();
        }
      });
    } else {
      $('.content-header .top-results').hide();
    }
  });
</script>