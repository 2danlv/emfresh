<?php

/**
 * Template Name: Page detail meal
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
} else {
  wp_redirect('/meal-plan/');
  exit();
}

$data = site_order_get_meal_plans($args);

get_header();
// Start the Loop.

if ( count($data) > 0 && isset($data[ 'orders' ]) ) :

  $first_order              = $data[ 'orders' ][ 0 ];
  $schedule_meal_plan_items = $data[ 'meal_plan_items' ];

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

    <!-- Default box -->
    <div class="card list-customer detail-meal">
      <div class="card-body">
        <div class="em-importer" data-name="customer">
          <div class="row ai-center">
            <div class="col-6">
              <ul class="d-f  ai-center">
                <li>
                  <span class="btn btn-show-count">Bộ đếm</span>
                </li>
              </ul>
            </div>
            <div class="col-6">
              <ul class="d-f ai-center jc-end">
                <li class="hidden save-meal-plan">
                  <span class="btn btn-primary js-save-meal-plan">Lưu</span>
                </li>
              </ul>
            </div>
          </div>
          <?php wp_nonce_field('importoken', 'importoken', false); ?>
        </div>
        <table class="table table-detail-meal js-meal-plan mt-16">
          <thead>
            <tr class="nowrap">
              <th data-number="1" class="text-left"><span>Tên khách hàng</span></th>
              <th data-number="2" class="text-center">Mã <br>sản phẩm</th>
              <th data-number="3" class="text-center">Phân <br>loại</th>
              <th data-number="4" class="text-center">Trạng thái <br>đặt đơn</th>
              <th data-number="5">
                <ul class="d-f date-group date-ttl">
                  <?php
                  foreach ($data[ 'schedule' ] as $date) : ?>
                    <li data-date="<?php echo $date ?>">
                      <?php echo date('d', strtotime($date)) ?> <span class="hidden">
                        <?php echo date('m', strtotime($date)) ?>
                      </span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="blank">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr class="top">
              <td>
                <?php echo $first_order[ 'customer_name' ] ?>
              </td>
              <td class="text-center">
                <?php echo $first_order[ 'item_name' ] ?>
              </td>
              <td class="text-center">
                <?php echo $first_order[ 'type_name' ] ?>
              </td>
              <td class="text-center"><span
                  class="status_order status_order-meal-<?php echo $first_order[ 'order_status' ] ?>">
                  <?php echo $first_order[ 'order_status_name' ] ?>
                </span></td>
              <td class="wrap-date">
                <ul class="d-f date-group group-date-top">
                  <?php
                  foreach ($data[ 'schedule' ] as $date) :
                    $value = isset($schedule_meal_plan_items[ $date ]) ? $schedule_meal_plan_items[ $date ] : '';
                    if ( $value != '' ) {
                      $class_date = '';
                    }
                    else {
                      $class_date = 'empty';
                    }
                    ?>
                    <li data-date="<?php echo $date ?>" class="<?php echo $class_date; ?>"><span>
                        <?php echo $value ?>
                      </span></li>
                  <?php endforeach; ?>
                </ul>
              </td>
            </tr>

            <?php
            foreach ($data[ 'orders' ] as $index => $order) :
              $meal_plan_items   = $order[ 'meal_plan_items' ];
              $class             = ($index % 2 == 0) ? 'green' : 'orange';
              $class_payment     = ($order[ 'payment_status' ] == '2') ? 'payment' : '';
              $customer_name_2nd = !empty($first_order[ 'customer_name_2nd' ]) ? $first_order[ 'customer_name_2nd' ] : $first_order[ 'customer_name' ];
              ?>
              <tr class="blank">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="accordion-tit_table order-<?php echo $order[ 'id' ]; ?>"
                data-customer_name="<?php echo $customer_name_2nd; ?>" data-order_id="<?php echo $order[ 'id' ] ?>">
                <td class="nowrap td-calc order-number"><?php echo $order[ 'order_number' ] ?></td>
                <td class="nowrap text-center td-calc order-prod"><?php echo $order[ 'item_name' ] ?></td>
                <td class="text-center nowrap td-calc"><?php echo $order[ 'type_name' ] ?></td>
                <td class="text-center td-calc order_status"><span
                    class="status_order status_order-meal-<?php echo $order[ 'order_status' ] ?>">
                    <?php echo $order[ 'order_status_name' ] ?>
                  </span></td>
                <td class="wrap-date">
                  <ul class="d-f date-group">
                    <?php foreach ($data[ 'schedule' ] as $date) :
                      $value = isset($meal_plan_items[ $date ]) ? $meal_plan_items[ $date ] : '';
                      if ( $value != '' ) {
                        $class_date = '';
                        $class_cl   = $class;
                      }
                      else {
                        $class_date = 'empty';
                        $class_cl   = '';
                      }
                      ?>
                      <li class="<?php echo $class_date; ?> <?php echo $class_cl; ?> <?php echo $class_payment; ?>"><span
                          data-date="<?php echo $date; ?>">
                          <?php echo $value ?>
                          </span>
                        </li>
                        <?php endforeach; ?>
                  </ul>
                </td>
              </tr>
              <?php

              foreach ($order[ 'order_items' ] as $i => $order_item) :
                $meal_plan_items = $order_item[ 'meal_plan_items' ];
                $total           = array_sum($meal_plan_items);
                ?>
                <tr
                  class="accordion-content_table order-<?php echo $order[ 'id' ]; ?> order-item order-item-<?php echo $i + 1 ?>"
                  data-order_id="<?php echo $order[ 'id' ] ?>" data-order_item_id="<?php echo $order_item[ 'id' ] ?>"
                  data-total="<?php echo $total ?>">
                  <td class="sub-td-calc"><span class="title">
                      <?php echo $customer_name_2nd ?>
                    </span></td>
                  <td class="text-center sub-td-calc nowrap wrap-td" style="width: 87px;">
                    <div class="ellipsis"><?php echo $order_item[ 'product_name' ] ?></div>
                  </td>
                  <td class="text-center sub-td-calc">
                    <?php echo strtoupper($order_item[ 'type' ]) ?>
                  </td>
                  <td></td>
                  <td class="wrap-date">
                    <ul class="d-f date-group" data-date_stop="<?php echo $order_item[ 'date_stop' ] ?>">
                      <?php foreach ($data[ 'schedule' ] as $date) :
                        $value = isset($meal_plan_items[ $date ]) ? $meal_plan_items[ $date ] : '';

                        if ( $value != '' ) {
                          $class_date = '';
                          $class_cl   = $class;
                        }
                        else {
                          $class_date = 'empty';
                          $class_cl   = '';
                        } ?>
                        <li class="<?php echo $class_date; ?> <?php echo $class_cl; ?> <?php echo $class_payment; ?>">
                          <span>
                            <input type="text" class="input-meal_plan<?php echo $value == '' ? ' empty' : '' ?>"
                              value="<?php echo $value; ?>" max="<?php echo $order_item[ 'meal_number' ]; ?>"
                              data-date="<?php echo $date; ?>" data-old="<?php echo $value; ?>" />
                          </span>
                        </li>
                      <?php endforeach; ?>

                    </ul>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="group-btn-bottom">
      <div class="count-group">
        <div class="row">
          <div class="col-10">
            <div class="ttl pb-8">
              Bộ đếm
            </div>
          </div>
          <div class="col-2 text-right">
            <span class="count-close"><img
                src="<?php echo site_get_template_directory_assets(); ?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
          </div>
        </div>
        <hr>
        <div class="card-primary pt-16">
          <div class="row">
            <div class="col-6">
              <div class="row pb-16">
                <div class="col-6">
                  <input type="text" class="customer_name" placeholder="Tên người nhận (chọn ô ở trên)">
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-6"><input type="text" class="count-number" placeholder="Mã đơn hàng"></div>
                    <div class="col-6"><input type="text" class="count-prod_name" placeholder="Mã sản phẩm"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <input type="text" class="count-start_day" placeholder="Ngày bắt đầu (chọn ô ở trên)">
                </div>
                <div class="col-6">
                  <input type="text" class="count-end_day" placeholder="Ngày kết thúc">
                </div>
              </div>
            </div>
            <div class="col-2 col-btn ai-end d-f">
              <div class="btn btn-primary confirm-calc">Xác nhận</div>
            </div>
            <div class="col-4 d-f col-txt count-result text-right">
              <p>Tổng ngày ăn: <span class="date-use">-</span></p>
              <p>Tổng phần ăn: <span class="number-use">-</span></p>
            </div>
          </div>
        </div>

      </div>
      <div class="bottom-btn row ">
        <div class="col-6">
          <span class="btn btn-secondary openmodal" data-target="#modal-plan-history">Lịch sử thao tác</span>
        </div>
        <div class="col-6 text-right">
          <span class="btn btn-primary">Đi đến chọn món</span>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <div class="modal fade modal-warning-input" id="modal-warning-input">
    <div class="overlay"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body pt-8 pb-16">
          <div class="d-f">
            <i class="fas fa-warning mr-8"></i>
            <div>
              <p class="pb-4"><b>Cảnh báo</b></p>
              <p class="notice_warning">Bạn nhập thiếu phần ăn: 02</p>
              <p>Vui lòng kiểm tra lại.</p>
            </div>

          </div>

        </div>
        <div class="modal-footer text-center pt-16 pb-8">
          <p class="pb-16"><button type="button" class="btn btn-primary modal-close">Quay lại chỉnh sửa</button></p>
          <p><button type="button" class="btn btn-secondary modal-close nowrap">Chỉnh sửa số lượng đơn hàng này</button></p>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-plan-history" id="modal-plan-history">
    <div class="overlay"></div>
    <div class="modal-dialog modal-wide">
      <div class="modal-header">
        <h4 class="modal-title">Vy (Vy Vy)</h4>
        <span class="modal-close"><img
            src="<?php echo site_get_template_directory_assets(); ?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
      </div>
      <div class="modal-content">
        <div class="modal-body pb-16">
          <table class="table regular_pay">
            <thead class="text-left">
              <tr>
                <th>
                  Người thực hiện
                </th>
                <th>
                  Trang
                </th>
                <th>
                  Hành động
                </th>
                <th>
                  Đối tượng
                </th>
                <th>
                  Mô tả
                </th>
                <th class="text-center">
                  Thời gian
                </th>
                <th class="text-center">
                  Ngày
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>
              <tr>
                <td class="text-left"><img class="avatar"
                    src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24"
                    alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
                <td>Chọn món</td>
                <td>cập nhật</td>
                <td>#0001 - SM</td>
                <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
                <td class="text-center">01:00</td>
                <td class="text-center">29/10/24</td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-warning" id="modal-alert">
    <div class="overlay"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body pt-8 pb-16">
          <div class="d-f">
            <i class="fas fa-warning mr-8"></i>
            <p><span class="txt_append"></span></p>
          </div>
        </div>
        <div class="modal-footer text-center pb-8 pt-16">
          <button type="button" class="btn btn-secondary modal-close">Đóng</button>
        </div>
      </div>
    </div>
  </div>
  <?php
endif;

global $site_scripts;

if ( empty($site_scripts) ) $site_scripts = [];
get_footer('customer');
?>
<script>
  function accordion_table() {
    $('table .accordion-tit_table')
      .off()
      .on('click', function () {
        if (!$('.count-group').hasClass('is-show')) {
          var item = $(this).toggleClass('on');
          while (item.next().hasClass('accordion-content_table')) {
            item = item.next()
            item.toggleClass('is-active').find('td > div').slideToggle(400)
          }
        }

      })

    $('table .accordion-content_table')
      .addClass('d-table-row')
      .find('td')
      .each(function () {
        let td = $(this)

        if (td.find('> div').length == 0) {
          td.html('<div>' + td.html() + '</div>')
        }
      })
  }
  jQuery(function ($) {
    $('.content-header .input-search').attr('placeholder', 'Tên khách hàng / SĐT');
    setTimeout(() => {
      if ($('#target').length > 0) {
        var targetOffset = $('#target').offset().left;
        var offsetWithMargin = targetOffset - 736;
        $(".dt-scroll-body").animate({scrollLeft: offsetWithMargin}, 1000);
      }
    }, 300);
    $('.accordion-content_table .wrap-date li').each(function () {
      var emptyDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
      var data_date_stop = $(this).closest('ul.date-group').attr('data-date_stop');
      var dateStop = new Date(data_date_stop);
      if ($(this).find('.input-meal_plan').val() != '' && dateStop < emptyDate) {
        $(this).addClass('just-edit');
      }
    });
    $('.accordion-content_table .wrap-date li.empty').each(function () {
      var emptyDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
      var shouldEdit = false;

      // Loop through sibling li elements that have class green or orange
      $(this).siblings('li.green, li.orange').each(function () {
        var filledDate = new Date($(this).find('.input-meal_plan').attr('data-date'));
        if (emptyDate > filledDate) {
          shouldEdit = true;
          return false; // Exit loop early when condition is met
        }
      });

      if (shouldEdit) {
        $(this).addClass('edit');
      } else {

      }
    });

    $('.accordion-tit_table').each(function () {

      $(this).find('.wrap-date li:not(.empty) span').each(function () {
        var dateAttrValue = $(this).attr('data-date');
        if (dateAttrValue) {

          var count = $('.accordion-tit_table .wrap-date li:not(.empty) span[data-date="' + dateAttrValue + '"]').length;

          if (count > 1) {
            $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('purple');
          }
        }
      });
      $(this).find('.wrap-date li:not(.empty)').each(function () {
        var classAttrValue = $(this).attr('class'); // Get all class names

        if ($(this).hasClass('payment')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('payment');
        }
        if ($(this).hasClass('orange')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').addClass('orange');
        }
        if ($(this).hasClass('green')) { // Check if "payment" is one of the classes
          var dateAttrValue = $(this).find('span').attr('data-date'); // Get the data-date
          $('tr.top .wrap-date li[data-date="' + dateAttrValue + '"]').removeClass('orange');
        }
      });

    });


    $(document).on('change', '.input-meal_plan', function () {
      let input = $(this),
        value = input.val();
      $('.save-meal-plan').removeClass('hidden');
      input.closest('.order-item').toggleClass('changed', value != input.data('old'));
    });
    $('.js-save-meal-plan').on('click', function (e) {
      e.preventDefault();

      let list_meal = [],
        errors = [];

      $('.js-meal-plan .order-item.changed').each(function () {
        let p = $(this),
          meal_plan = {},
          total = parseInt(p.data('total')),
          count = 0;

        p.find('.input-meal_plan').each(function () {
          let input = $(this), value = +input.val();

          if (value > 0) {
            meal_plan[input.data('date')] = value;

            count += value;
          }
        })

        if (total == count) {
          list_meal.push({
            order_id: p.data('order_id'),
            order_item_id: p.data('order_item_id'),
            meal_plan: meal_plan
          });
        } else {
          errors.push(p.find('.title').text());
        }
        if (total > count) {
          $('#modal-warning-input').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning-input .modal-body p.notice_warning').text('Bạn nhập thiếu phần ăn: ' + (total - count));
          return;
        }
        if (total < count) {
          $('#modal-warning-input').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning-input .modal-body p.notice_warning').text('Bạn nhập dư phần ăn: ' + (count - total));
          return;
        }
      });

      if (errors.length > 0) {
        // $('#modal-alert').addClass('is-active');
        // $('body').addClass('overflow');
        // $('.modal-warning .modal-body p span.txt_append').text('Vui lòng kiểm tra số bữa ăn: ' + errors.join(", "));
        return;
      }


      if (list_meal.length == 0) return;

      $.post('?', {
        ajax: 1,
        save_meal_plan: 1,
        list_meal: list_meal
      }, function (res) {

        console.log('res', res);

        if (res.code == 200) {
          $('#modal-alert').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning .modal-body p span.txt_append').text('Lưu thành công!');
          $('#modal-alert .modal-close, #modal-alert .overlay').click(function (e) { 
            e.preventDefault();
            location.reload();
          });
        } else {
          $('#modal-alert').addClass('is-active');
          $('body').addClass('overflow');
          $('.modal-warning .modal-body p span.txt_append').text("Lưu không thành công!");
        }
      }, 'JSON');
    })

    $('.btn-show-count').click(function (e) {
      e.preventDefault();
      $(this).addClass('selected');
      $('.count-group input').val('');
      $('.count-group').addClass('is-show');
      $('table.table tbody tr td.wrap-date .date-group li input').addClass('is-disabled');
    });
    $('.count-group .count-close').click(function (e) {
      e.preventDefault();
      $('.count-group').removeClass('is-show');
      $('.btn-show-count').removeClass('selected');
      $('.count-group .count-result').removeClass('have-result');
      $('table.table tbody tr td.wrap-date .date-group li input').removeClass('is-disabled');
      $('.count-group .count-result span').text('-');
      $('.accordion-tit_table').removeClass('select');
      $('.accordion-content_table').removeClass('sub_select');
    });
    $(document).on('click', '.accordion-tit_table td.td-calc', function (e) {
      e.preventDefault();
      var row = $(this).closest('.accordion-tit_table');
      var customer_name = row.attr('data-customer_name');
      var order_number = row.find('.order-number').text();
      var order_name = row.find('.order-prod').text();
      if ($('.count-group').hasClass('is-show')) {
        $('.count-group .customer_name').val(customer_name);
        $('.count-group .count-number').val(order_number);
        $('.count-group .count-prod_name').val(order_name);
        $('.accordion-tit_table').removeClass('select');
        $('.accordion-content_table').removeClass('sub_select');
        row.addClass('select');
        $('.count-group .count-start_day,.count-group .count-end_day').val('');
        $('.count-group .count-result').removeClass('have-result');
        $('.count-group .count-result span').text('-');
      }
    });
    $(document).on('click', '.accordion-content_table td.sub-td-calc', function (e) {
      e.preventDefault(); // Prevent the default action
      var sub_row = $(this).closest('.accordion-content_table');
      var prevRow = sub_row.prevAll('.accordion-tit_table').first();
      var sub_customer_name = prevRow.attr('data-customer_name');
      var sub_order_number = prevRow.find('.order-number').text();
      var sub_order_name = sub_row.find('.ellipsis').text();
      console.log('log',sub_order_name);
      if ($('.count-group').hasClass('is-show')) {
        $('.count-group .customer_name').val(sub_customer_name);
        $('.count-group .count-number').val(sub_order_number);
        $('.count-group .count-prod_name').val(sub_order_name);
        $('.accordion-tit_table').removeClass('select');
        $('.accordion-content_table').removeClass('sub_select');
        sub_row.addClass('sub_select');
        $('.count-group .count-start_day,.count-group .count-end_day').val('');
        $('.count-group .count-result').removeClass('have-result');
        $('.count-group .count-result span').text('-');
      }
    });
    $(document).on('click', '.accordion-tit_table.select .wrap-date li:not(.empty)', function (e) {
      e.preventDefault();
      var day = $(this).find('span').attr('data-date');
      $('.wrap-date').removeClass('tit-count');
      $('.wrap-date').removeClass('sub_tit-count');
      $(this).closest('.wrap-date').addClass('tit-count');
      if ($('.count-group .count-start_day').val() == '') {
        $('.count-group .count-start_day').val(day);
      } else {
        $('.count-group .count-end_day').val(day);
      }
    });
    $(document).on('click', '.accordion-content_table.sub_select .wrap-date li:not(.empty)', function (e) {
      e.preventDefault();
      var sub_day = $(this).find('.input-meal_plan').attr('data-date');
      $('.wrap-date').removeClass('sub_tit-count');
      $('.wrap-date').removeClass('tit-count');
      $(this).closest('.wrap-date').addClass('sub_tit-count');
      if ($('.count-group .count-start_day').val() == '') {
        $('.count-group .count-start_day').val(sub_day);
      } else {
        $('.count-group .count-end_day').val(sub_day);
      }
    });
    $('.count-group .confirm-calc').click(function (e) {
      e.preventDefault();
      var startDate = $('.count-group .count-start_day').val();
      var endDate = $('.count-group .count-end_day').val();
      if (!startDate || !endDate) {
        $('#modal-alert').addClass('is-active');
        $('body').addClass('overflow');
        $('.modal-warning .modal-body p span.txt_append').text('Hãy chọn ngày bắt đầu và kết thúc!');
        return;
      }
      var start = new Date(startDate);
      var end = new Date(endDate);
      if (start > end) {
        $('#modal-alert').addClass('is-active');
        $('body').addClass('overflow');
        $('.modal-warning .modal-body p span.txt_append').text('Ngày bắt đầu không thể nhỏ hơn ngày kết thúc.');
        return;
      }
      var totalPortions = 0;
      var totalDays = 0;
      if ($('.accordion-tit_table.select .wrap-date').hasClass('tit-count')) {
        $('.accordion-tit_table.select .wrap-date li span').each(function () {
          var date = $(this).data('date');
          if (new Date(date) >= start && new Date(date) <= end && $(this).text() !== '') {
            totalDays++;
            totalPortions += parseInt($(this).text()) || 0;
          }
        });
      }
      if ($('.accordion-content_table.sub_select .wrap-date').hasClass('sub_tit-count')) {
        $('.accordion-content_table.sub_select .wrap-date li').each(function () {
          var date = $(this).find('.input-meal_plan').data('date');
          if (new Date(date) >= start && new Date(date) <= end && $(this).text() !== '') {
            totalDays++;
            totalPortions += parseInt($(this).find('.input-meal_plan').val()) || 0;
          }
        });
      }
      $('.count-group .count-result').addClass('have-result');
      $('.count-group .date-use').text(totalDays);
      $('.count-group .number-use').text(totalPortions);
    });
    accordion_table();
    $('.content-header .wrap-search .clear-input').click(function (e) { 
      e.preventDefault();
      $('.content-header .wrap-search .input-search').val('');
      $('.content-header .top-results,.content-header .wrap-search .clear-input').hide();
    });
    $("ul").each(function() {
  var $ul = $(this);
  var startIndex = null; // Stores the index of the first clicked <li> for the current <ul>

  $ul.find("li").on('click',function() {
    // Remove classes from all <li> elements in other <ul>s
    $("ul").not($ul).find("li").removeClass("selected in-between");
    
    var index = $(this).index();
    
    // If no start date is selected in this <ul>, treat the click as the start date.
    if (startIndex === null) {
      // Clear any previous selections in this <ul> as well.
      $ul.find("li").removeClass("selected in-between");
      
      // Mark this cell as the start date.
      startIndex = index;
      $(this).addClass("selected");
    } else {
      // Second click: treat as the end date.
      // Determine the proper range between the start date and this clicked cell.
      var s = Math.min(startIndex, index);
      var e = Math.max(startIndex, index);
      
      // Highlight the range by applying the "in-between" class,
      // and ensure that the start and end dates have the "selected" class.
      $ul.find("li").slice(s, e + 1).addClass("in-between");
      $ul.find("li").eq(s).addClass("selected");
      $ul.find("li").eq(e).addClass("selected");
      
      // Reset the startIndex so that the next click starts a new selection.
      startIndex = null;
    }
  });
});

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