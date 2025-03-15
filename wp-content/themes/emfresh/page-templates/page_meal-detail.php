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
                          data-date="<?php echo $date; ?>"><?php echo $value ?></span>
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
                  <td class="sub-td-calc"><span class="title"><?php echo $customer_name_2nd ?></span></td>
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
<?php include( get_template_directory().'/parts/meal-plan/meal-detail.php');?>