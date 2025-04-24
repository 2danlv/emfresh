<?php

/**
 * Template Name: List Meal plan
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


$args = wp_unslash($_GET);

if(empty($args['groupby'])) {
  $args['groupby'] = 'customer';
}

$data = site_order_get_meal_plans($args);

$group_id = !empty($args['group_id']) ? intval($args['group_id']) : 0;

if(isset($_GET['statistics'])) {
  header('Content-type: application/json');
  die(json_encode($data['statistics']));
}

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<!-- Main content -->
<section class="content">
  <?php
  if ( isset($_GET[ 'message' ]) && $_GET[ 'message' ] == 'Delete Success' && !empty($_GET[ 'expires' ]) && intval($_GET[ 'expires' ]) > time() ) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
  }
  if ( !empty($_GET[ 'code' ]) && !empty($_GET[ 'expires' ]) && intval($_GET[ 'expires' ]) > time() ) {
    // echo '<div class="alert alert-success mt-3 mb-16" role="alert">'
    //     . sprintf('Cập nhật%s thành công', $_GET['code'] != 200 ? ' không' : '')
    //     .'</div>';
  }
  ?>
  <?php if ( count($data) > 0 ) : ?>
    <div class="card list-customer list-order">
      <div class="card-body">
        <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
          <div class="row ai-center">
            <div class="col-8">
              <ul class="d-f ai-center">
                <li class="group-icon mr-8"><span class="btn btn-fillter">&nbsp;</span></li>
                <li class="group-icon mr-8"><span class="btn btn-copy">&nbsp;</span></li>
                <li class="has-child mr-8">
                  <span class="btn btn-action">Thao tác</span>
                  <ul>
                    <li>
                      <div class="d-f ai-center">
                        <i class="fas fa-eye"></i><span class="openmodal pl-10" data-target="#modal-default">Cài đặt hiển
                          thị</span>
                      </div>
                    </li>
                    <li>
                      <div class="d-f ai-center">
                        <i class="fas fa-layer"></i><span class="openmodal pl-10" data-target="#modal-warning-edit">Cập
                          nhật nhanh</span>
                      </div>
                    <li>
                      <div class="d-f ai-center">
                        <i class="fas fa-chart-horizontal"></i><span class="openmodal pl-10"
                          data-target="#modal-static">Thống kê trạng thái</span>
                      </div>
                    </li>
                    <li><button type="button" name="action" value="export" class="js-export">Xuất dữ liệu</button></li>
                  </ul>
                </li>
                <li class="status"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
              </ul>
            </div>
            <div class="col-4 text-right">

            </div>
          </div>
          <?php wp_nonce_field('importoken', 'importoken', false); ?>
        </form>
        <table id="list-meal-plan" class="table table-list-meal-plan" style="width:100%">
          <thead>
            <tr class="nowrap">
              <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
              <th data-number="1"><span class="nowrap">Tên khách hàng</span></th>
              <th data-number="2" class="text-left">SĐT</th>
              <th data-number="3" class="text-center">Số đơn</th>
              <th data-number="4">Mã sản phẩm</th>
              <th data-number="5" class="text-center">Phân loại</th>
              <th data-number="6">Trạng thái <br>đặt đơn</th>
              <th data-number="7" class="text-center">Hình thức <br>thanh toán</th>
              <th data-number="8">Trạng thái <br>thanh toán</th>
              <th data-number="9">Số tiền <br>còn lại</th>
              <th data-number="10">
                <ul class="d-f date-group date-ttl">
                  <?php
                  foreach ($data['schedule'] as $date) : ?>
                    <li data-date="<?php echo $date ?>">
                      <?php echo date('d', strtotime($date)) ?> 
                      <span class="hidden"><?php echo date('m', strtotime($date)) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            foreach ($data[ 'customers' ] as $index => $order) :
              $meal_plan_items = $order[ 'meal_plan_items' ];
              $class = ($i % 2 == 0) ? 'green' : 'orange';
              
              if(isset($order['group_name'])) {
                $params = ['group_id' => $order['id']];
                $phone = $order['group_phone'];
                $link = add_query_arg($params, site_meal_plan_list_link());
              } else {
                $params = ['customer_id' => $order['id']];
                $phone = $order['phone'];
                $link = add_query_arg($params, site_meal_plan_detail_link());
              }

            ?>
              <tr class="order-<?php echo $order[ 'id' ] ?>" data-order_id="<?php echo $order[ 'id' ] ?>">
                <td data-number="0"><input type="checkbox" class="checkbox-element"
                    data-number="<?php echo $order[ 'order_number' ]; ?>" value="<?php echo $order[ 'order_number' ] ?>"></td>
                <td data-number="1" class=" nowrap wrap-td">
                  <div class="ellipsis">
                    <a href="<?php echo $link ?>" <?php echo $group_id > 0 ? 'target="_blank"' : '' ?>>
                      <?php
                        echo isset($order['group_name']) ? $order['group_name'] : $order['customer_name']
                      ?>
                    </a>
                  </div>
                </td>
                <td data-number="2"><span class="copy modal-button" data-target="#modal-copy"
                    title="Copy: <?php echo $phone ?>">
                    <?php echo $phone ?>
                  </span></td>
                <td data-number="3" class="text-center">
                  <?php echo $order[ 'count_order' ] // $order['order_number'] ?>
                </td>
                <td data-number="4" class="nowrap">
                <?php 
                  $result = site_order_group_item_name($order['item_name']);
                  echo implode('+', $result);
                ?>
                </td>
                <td data-number="5">
                  <?php echo $order['type_name']; ?>
                </td>
                <td data-number="6"><span class="status_order status_order-meal-<?php echo $order[ 'order_status' ] ?>">
                    <?php echo $order[ 'order_status_name' ] ?>
                  </span></td>
                <td data-number="7" class="nowrap text-center">
                  <?php echo $order[ 'payment_method_name' ] ?>
                </td>
                <td data-number="8"><span class="status_order status_pay-<?php echo $order[ 'payment_status' ] ?>">
                    <?php echo $order[ 'payment_status_name' ] ?>
                  </span></td>
                <td data-number="9">
                  <?php
                  $total_money = $order[ 'total' ] - $order[ 'paid' ];
                  echo $total_money > 0 ? number_format($total_money) : 0 ?>
                </td>
                <td data-number="10" class="wrap-date">
                  <ul class="d-f date-group">
                    <?php
                    foreach ($data[ 'schedule' ] as $date) :
                      $value = isset($meal_plan_items[ $date ]) ? $meal_plan_items[ $date ] : '';
                      if ( $value != '' ) {
                        $class_date = '';
                      }
                      else {
                        $class_date = 'empty';
                      }
                      ?>
                      <li data-date="<?php echo $date ?>" class="<?php echo $class_date; ?> <?php echo $class; ?>"><span>
                          <?php echo $value ?>
                        </span></li>
                    <?php endforeach; ?>
                  </ul>
                </td>
              </tr>
            <?php
            $i++;
             endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif ?>
</section>

<div class="modal fade modal-warning" id="modal-warning-edit">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body pt-8 pb-16">
        <div class="d-f ai-center">
          <i class="fas fa-warning mr-8"></i>
          <p>Hãy chọn đơn hàng để <span class="txt_append">in</span>!</p>
        </div>
      </div>
      <div class="modal-footer text-center pt-16 pb-8">
        <button type="button" class="btn btn-secondary modal-close">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-default">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Hiển thị</h4>
      </div>
      <div class="modal-body pt-16">
        <div class="row">
          <div class="col-12 card-primary" style="background: none; padding: 0;">
          <p>Chế độ hiển thị</p>
          <p class="pt-8">
            <select name="" class="" onchange="window.location.href = this.value;">
              <option value="/meal-plan/" <?php echo (!empty($args[ 'groupby' ]) && $args[ 'groupby' ] === 'customer') ? 'selected' : ''; ?>>Cá nhân</option>
              <option value="/meal-plan/?groupby=group" <?php echo (!empty($args[ 'groupby' ]) && $args[ 'groupby' ] === 'group') ? 'selected' : ''; ?>>Phân nhóm gộp tụ ship</option>
            </select>
          </p>
          <p class="pt-24 pb-8">Cột hiển thị</p>
          <hr>
          </div>
          <div class="col-6 pt-16">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="0" value="" disabled checked>Tên khách hàng</label></li>
              <li><label><input type="checkbox" data-column="2" value="" disabled checked>Số điện thoại</label></li>
              <li><label><input type="checkbox" data-column="3" value="" disabled checked>Số đơn</label></li>
              <li><label><input type="checkbox" data-column="6" value="" disabled checked>Mã sản phẩm</label></li>
            </ul>
          </div>
          <div class="col-6 pt-16">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="5" value="5">Phân loại đơn hàng</label></li>
              <li><label><input type="checkbox" data-column="6" value="6">Trạng thái đặt đơn</label></li>
              <li><label><input type="checkbox" data-column="7" value="7">Hình thức thanh toán</label></li>
              <li><label><input type="checkbox" data-column="8" value="8">Trạng thái thanh toán</label></li>
              <li><label><input type="checkbox" data-column="9" value="9">Số tiền còn lại</label></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="form-group pt-16 text-right">
        <!-- <button type="button" class="button btn-default modal-close">Huỷ</button> -->
        <button type="button" class="button btn-default modal-close">Đóng</button>
      </div>
    </div>
  </div>
</div>
<?php include( get_template_directory().'/parts/meal-plan/modal-static.php');?>
<?php

global $site_scripts;

if ( empty($site_scripts) ) $site_scripts = [];
$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer');
?>

<script>
  $(document).ready(function () {
    $('.content-header .input-search').attr('placeholder', 'Tên khách hàng / SĐT');
    setTimeout(() => {
      var targetOffset = $('#target').offset().left;
      var offsetWithMargin = targetOffset - 490;
      $(".dt-scroll-body").animate({scrollLeft: offsetWithMargin}, 1000);
    }, 300);
    $('.content-header .wrap-search .clear-input').click(function (e) {
      e.preventDefault();
      $('.content-header .wrap-search .input-search').val('');
      $('.content-header .top-results,.content-header .wrap-search .clear-input').hide();
    });
    // let $activeElement = $("table.table tr .date-group li.active");

    // if ($activeElement.length) {
    //     let $weekElements = $();
    //     let $firstDayElement = $activeElement;

    //     // Find the start of the week (element with class "first-day")
    //     while ($firstDayElement.prev().length && !$firstDayElement.hasClass("first-day")) {
    //         $firstDayElement = $firstDayElement.prev();
    //     }

    //     // Collect all elements for the current week
    //     let $currentElement = $firstDayElement;
    //     while ($currentElement.length && (!$currentElement.hasClass("first-day") || $currentElement.is($firstDayElement))) {
    //         $weekElements = $weekElements.add($currentElement);
    //         $currentElement = $currentElement.next();
    //     }

    //     // Hide all other elements
    //     $(".date-group li").not($weekElements).hide();
    // }
  });
  $('.input-search').keyup(function () {
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

            $('.top-results,.overlay').show();
            $('.top-results #top-autocomplete-results').html(suggestions);
          } else {
            $('.top-results').hide();
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data from API');
          $('#autocomplete-results').hide();
        }
      });
    } else {
      $('.top-results').hide();
    }
  });
</script>