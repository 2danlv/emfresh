<?php

/**
 * Template Name: Page select meal
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_order_item, $em_customer_tag, $em_log, $em_location, $em_menu;

$menu_select = $em_menu->get_select();
$menu_compare = $menu_select;
$menu_compare[0] = '-';
$detail_menu_select_url = get_permalink();

$args = wp_unslash($_GET);

$meal_select_number = isset($args['meal_select_number']) ? intval($args['meal_select_number']) : 0;
$meal_select_key = 'meal_select' . ($meal_select_number > 0 ? '_' . $meal_select_number : '');
$order_id = isset($args['order_id']) ? intval($args['order_id']) : 0;


$nowtime = time();
// change Friday to Monday
if (date('w', $nowtime) == 5 && date('H', $nowtime) >= 12) {
  $nowtime += 2 * DAY_IN_SECONDS;
}

$week = isset($args['week']) ? trim($args['week']) : date('Y-m-d', $nowtime);

// $args['groupby'] = 'customer';

// $data = site_order_get_meal_plans($args);

$data = [];

$days = site_get_days_week_by($week);

$weeks = [];

foreach([-7, 0, 7] as $day) {
  $values = site_get_days_week_by(date('Y-m-d', $nowtime + $day * DAY_IN_SECONDS));

  $start = date('d/m', strtotime($values[0]));
  $end = date('d/m', strtotime(end($values)));

  $weeks[$values[0]] = "Tuần $start - $end";
}

$list_copy = [
  'Danh sách chính',
  'Bản sao 1',
  'Bản sao 2'
];

$list_logs = [];

// Tu dong xoa sau 7 ngay
$time_to_delete = strtotime('-7 days');
$lastValue      = '';
foreach ($weeks as $value => $label) {
  $lastValue = $value; 
}
$now               = new DateTime();
$isFridayAfterNoon = ($now->format('N') == 5 && $now->format('H') >= 12);
if ( !isset($_GET[ 'week' ]) && $isFridayAfterNoon ) {
  $redirectUrl = get_permalink() . '?week=' . $lastValue;
  header('Location: ' . $redirectUrl);
  exit;
}
$admin_role = wp_get_current_user()->roles;
get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();

$export_rows = [];
$row = 0;

$default_columns = [
  'Tên người nhận' => '',
  'SĐT' => '',
  'Mã' => '',
];

foreach($days as $day) {
  $default_columns[site_get_meal_week($day)] = '';
}

?>
<!-- Main content -->
<section class="content">
  <?php
  if (isset($_GET['message']) && $_GET['message'] == 'Delete Success' && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
  }
  if (!empty($_GET['code']) && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">'
        . sprintf('Cập nhật%s thành công', $_GET['code'] != 200 ? ' không' : '')
        .'</div>';
  }
  ?>

  <!-- Default box -->
  <div class="card list-customer list-select-meal">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center pb-16">
          <div class="col-6 ai-center">
            <ul class="d-f pr-16">
              <li class="pr-16">
                <select id="week-select" onchange="location.href = '<?php the_permalink(); ?>?week=' + this.value">
                  <?php
                  foreach ($weeks as $value => $label) {
                    echo '<option value="' . $value . '"' . ($value <= $week ? ' selected' : '') . '>' . $label . '</option>';
                  }
                  ?>
                </select>
              </li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="d-f jc-end right-action ai-center">
              <li class="mr-16 group-icon"><span class="btn btn-fillter">&nbsp;</span></li>
              <li class="mr-16 group-icon"><span class="btn btn-copy copyAllphone" data-target="#modal-copy">&nbsp;</span></li>
              <li class="mr-16 group-icon"><span class="btn btn-alert">&nbsp;</span></li>
              <li><span class="btn btn-primary disable js-save-meal-select">Lưu chọn món</span></li>
            </ul>
          </div>
        </div>
        <div class="row ai-center row-revert">
          <div class="col-5">
            <ul class="d-f jc-end ai-center">
              <li class="status mr-16"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
              <li class="has-child">
                <span class="btn btn-action">Thao tác</span>
                <ul>
                  <li>
                    <span class="openmodal btn-compare" data-target="#modal-compare">So sánh nhập liệu</span>
                  </li>
                  <li>
                    <span class="openmodal btn-split" data-target="#modal-split-order">Tách đơn khẩn</span>
                  </li>
                  <?php if ( !empty( $admin_role ) && $admin_role[ 0 ] == 'administrator' ) { ?>
                  <li><button type="button" name="action" value="export" class="js-export-table">Xuất dữ liệu</button></li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </div>
          <div class="col-7">
            <ul class="d-f nav tabNavigation">
              <?php
              $i = 0;
              foreach($list_copy as $number => $name) :?>
              <li class="mr-16 nav-item <?php echo $i == 0 ? 'defaulttab' : ''; ?> <?php echo $meal_select_number >= $i ? '' : 'dn'; ?>" rel="tab_<?php echo $number; ?>">
                <span class="btn"><?php echo $name ?></span>
              </li>
              <?php
              $i++;
              endforeach ?>
              <?php if ( $meal_select_number < 3 ) { ?>
                <li class="add" rel="" style="width: 32px; height: 32px; line-height: 32px; cursor: pointer;"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/plus-svgrepo-com.svg" alt=""></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <div class="tab-content">
      <?php
      $i2 = 0;
      $tab_args = $args;
      foreach($list_copy as $number => $name) :
        $tab_args['meal_select_number'] = $number;
        $data = site_order_get_meal_plans($tab_args);
        $meal_select_key = 'meal_select' . ($number > 0 ? '_' . $number : '');
        $tab_logs = $em_log->get_items([
          'module' => $meal_select_key,
        ]);

        foreach($tab_logs as $i => $log){
          $log['meal_select_number'] = $meal_select_number;
          $log['meal_select_name'] = $list_copy[$meal_select_number];

          $tab_logs[$i] = $log;
        }

        $list_logs = array_merge($list_logs, $tab_logs);
      ?>
      <div class="tab-pane" id="tab_<?php echo $i2; ?>">
        <form id="meal_select_form<?php echo $i2; ?>" action="<?php the_permalink() ?>" method="post">
          <input type="hidden" name="save_meal_select" value="<?php echo uniqid() ?>"/>
          <input type="hidden" name="meal_select_number" value="<?php echo $number ?>"/>
          <input type="hidden" name="order_id" value="<?php echo $order_id ?>"/>
          <input type="hidden" name="week" value="<?php echo $week ?>"/>
          <table id="list-select-meal<?php echo $number ?>" class="table table-select-meal" style="width:100%">
            <thead>
              <tr class="nowrap">
                <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
                <th data-number="1"><span class="nowrap">Tên người nhận</span></th>
                <th data-number="2" class="text-left">SĐT</th>
                <th data-number="3">Mã</th>
                <?php foreach($days as $i => $day) : $time = strtotime($day); ?>
                <th class="text-center" data-number="<?php echo $i + 4 ?>">
                  Thứ <?php echo $i + 2 ?> <br>
                  (<?php echo date('d/m', $time) ?>)
                </th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($data['orders'] as $i => $order) :
                  $link = add_query_arg([
                    'order_id' => $order['id'],
                    'meal_select_number' => $meal_select_number,
                    'week' => $week,
                  ], $detail_menu_select_url);

                  foreach($order['order_items'] as $order_item) :
                    if(empty($order_item['meal_select_items']) || count($order_item['meal_select_items']) == 0) continue;

                    $meal_select_items = $order_item['meal_select_items'];
                    $count = 0;
                    foreach($days as $i => $day) {
                      if(isset($meal_select_items[$day])) {
                        $count++;
                        break;
                      }
                    }

                    if($count==0) continue;

                    $meal_plan_items = $order_item['meal_plan_items'];
                    $product_name = explode('-', $order_item['product_name']);
                    $cell_max = 0;

                    $export_rows[$row] = shortcode_atts($default_columns, [
                      'Tên người nhận' => $order['customer_name'],
                      'SĐT' => $order['phone'],
                      'Mã' => trim($product_name[0]),
                    ]);
              ?>
                <tr class="nowrap" data-order-id="<?php echo $order['id'] ?>" data-order-item-id="<?php echo $order_item['id'] ?>">
                  <td data-number="0" class="text-center"><input type="checkbox" tabindex="-1" class="checkbox-element" data-number="<?php echo $order['phone']; ?>" value="<?php echo $order['id'] ?>"></td>
                  <td data-number="1" class="text-capitalize nowrap wrap-td">
                    <div class="ellipsis"><a href="<?php echo $link ?>" tabindex="-1"><?php echo $order['customer_name'] ?></a></div>
                  </td>
                  <td data-number="2" class="text-left"><span tabindex="-1"class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $order['phone']; ?>"><?php echo $order['phone']; ?></span></td>
                  <td data-number="3"><?php echo trim($product_name[0]) ?></td>
                  <?php foreach($days as $i => $day) : 
                    $meal_select = empty($meal_select_items[$day]) ? [] : $meal_select_items[$day];
                    $meal_plan_value = empty($meal_plan_items[$day]) ? 0 : $meal_plan_items[$day];

                    $count = count($meal_select);
                    if($cell_max < $count) {
                      $cell_max = $count;
                    }
                  ?>
                  <td data-number="<?php echo $i + 4 ?>" class="wrap-td" style="min-width: 140px;">
                    <?php foreach($meal_select as $k => $menu_id) :

                      $row_k = ($row + $k);

                      $columns = isset($export_rows[$row_k]) ? $export_rows[$row_k] : $default_columns;

                      $columns[site_get_meal_week($day)] = $menu_id > 0 && !empty($menu_select[$menu_id]) ? $menu_select[$menu_id] : '';

                      $export_rows[$row_k] = $columns;

                    ?>
                    <div class="mb-6">
                      <select name="list_meal_select[<?php echo $order_item['id'] ?>][<?php echo $day ?>][<?php echo $k ?>]" 
                        class="meal_select<?php echo $k >= $meal_plan_value ? ' meal-plan-waring' : '' ?>" data-old="<?php echo $menu_id ?>"
                      ><?php
                        foreach($menu_select as $value => $name) {
                          echo '<option value="'.$value.'"'.($value == $menu_id ? ' selected' :'').'>' . $name . '</option>';
                        }
                      ?></select>
                    </div>
                    <?php endforeach ?>
                  </td>
                  <?php endforeach;
                    $row += $cell_max;
                  ?>
                </tr>
              <?php endforeach;
              endforeach; ?>
            </tbody>
          </table>
        </form>
      </div>
      <?php $i2++;
      endforeach ?>
      </div>
    </div>
  <div class="navigation-bottom d-f jc-b ai-center pl-16 pr-16">
	<span class="btn btn-secondary openmodal" data-target="#modal-plan-history">Lịch sử thao tác</span>
</div>
</div>
<!-- /.card-body --> 
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
<div class="modal fade modal-compare" id="modal-compare">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
      <h4 class="modal-title">So sánh nhập liệu</h4>
    </div>
    <form id="meal_select_form" action="<?php the_permalink() ?>" method="post">
      <input type="hidden" name="save_meal_select" value="1"/>
      <input type="hidden" name="order_id" value="<?php echo $order_id ?>"/>
      <input type="hidden" name="week" value="<?php echo $week ?>"/>
      <div class="modal-content">
        <div class="modal-body pt-16">
          <?php 
          foreach($days as $day) :
            
            $list_compare = [];

            foreach ($data['orders'] as $i => $order) {
              foreach($order['order_items'] as $order_item) {
                $meal_select_items = $em_order_item->get_meal_select($order_item);
                $meal_select_1_items = $em_order_item->get_meal_select($order_item, 1);
                $meal_select_2_items = $em_order_item->get_meal_select($order_item, 2);
                
                if(count($meal_select_items) == 0 || empty($meal_select_items[$day])) continue;

                $product_name = explode('-', $order_item['product_name']);

                $select_1_values = isset($meal_select_1_items[$day]) ? $meal_select_1_items[$day] : [];
                $select_2_values = isset($meal_select_2_items[$day]) ? $meal_select_2_items[$day] : [];

                foreach($meal_select_items[$day] as $i => $value) {
                  $value_1 = isset($select_1_values[$i]) ? (int) $select_1_values[$i] : 0;
                  $value_2 = isset($select_2_values[$i]) ? (int) $select_2_values[$i] : 0;

                  if($value == 0 || ($value_1 == $value && $value_2 == $value)) continue;
                  
                  $menu_name = isset($menu_compare[$value]) ? $menu_compare[$value] : '-';
                  
                  $compare = [
                    'index' => $i,
                    'day' => $day,
                    'order_item_id' => $order_item['id'],
                    'customer_name' => $order['customer_name'],
                    'phone' => $order['phone'],
                    'product_name' => $product_name[0],
                    'menu_id' => $value,
                    'meal_select' => $menu_name,
                    'meal_select_1' => isset($menu_compare[$value_1]) ? $menu_compare[$value_1] : '-',
                    'meal_select_2' => isset($menu_compare[$value_2]) ? $menu_compare[$value_2] : '-',
                    'is_diff_1' => $value_1 > 0 && $value_1 != $value,
                    'is_diff_2' => $value_2 > 0 && $value_2 != $value,
                  ];
                  
                  $list_compare[] = $compare;
                }
              }
            }
          ?>
          <div class="ttl mb-16"><?php echo site_get_meal_week($day) ?></div>
          <?php if(count($list_compare) == 0) : ?>
          <div class="text-center pt-16 pb-16">
            Không tìm thấy sai lệch nào
          </div>
          <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>Tên khách hàng</th>
                <th>SĐT</th>
                <th>Mã</th>
                <th>Danh sách chính</th>
                <th>Bản sao 1</th>
                <th>Bản sao 2</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($list_compare as $compare) : ?>
              <tr>
                <td><?php echo $compare['customer_name'] ?></td>
                <td><?php echo $compare['phone'] ?></td>
                <td><?php echo $compare['product_name'] ?></td>
                <td>
                  <select name="list_meal_select[<?php echo $compare['order_item_id'] ?>][<?php echo $compare['day'] ?>][<?php echo $compare['index'] ?>]" 
                    class="meal_select" data-old="<?php echo $compare['menu_id'] ?>"
                  ><?php
                      foreach($menu_select as $value => $name) {
                        echo '<option value="'.$value.'"'.($value == $compare['menu_id'] ? ' selected' :'').'>' . $name . '</option>';
                      }
                  ?></select>
                </td>
                <td class="text-center">
                  <div class="<?php echo $compare['is_diff_1'] ? 'is-diff btn-danger' : 'btn-secondary' ?>">
                    <?php echo $compare['meal_select_1'] ?>
                  </div>
                </td>
                <td class="text-center">
                  <div class="<?php echo $compare['is_diff_2'] ? 'is-diff btn-danger' : 'btn-secondary' ?>">
                    <?php echo $compare['meal_select_2'] ?>
                  </div>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <?php endif ?>
          <?php endforeach ?>
        </div>
      </div>
      <div class="modal-footer text-right pt-16 pr-16">
        <button type="button" class="button btn-default modal-close">Huỷ</button>
        <button type="submit" class="button btn-primary">Lưu và đóng</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade modal-plan-history" id="modal-plan-history">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
        <h4 class="modal-title">Lịch sử thao tác</h4>
        <span class="modal-close"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
      </div>
    <div class="modal-content">
      <div class="modal-body pb-16">
        <table class="table regular_pay">
          <thead class="text-left">
            <tr>
              <th>Người thực hiện</th>
              <th>Trang</th>
              <th>Hành động</th>
              <th>Đối tượng</th>
              <th>Mô tả</th>
              <th>Thời gian</th>
              <th>Ngày</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($list_logs as $item) :
                $item_time = strtotime($item['created']);

                if($item_time < $time_to_delete) {
                  $em_log->delete($item['id']);

                  continue;
                }

                $item_content = explode('|', $item['content']);
            ?>
            <tr data-id="<?php echo $item['id'] ?>">
                <td class="wrap-td" style="max-width: 160px;">
                    <div class="nowrap ellipsis">
                        <img class="avatar" src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
                        <?php echo $item['created_author'] ?>
                    </div>
                </td>
                <td><?php echo isset($item['meal_select_name']) ? $item['meal_select_name'] : '' ?></td>
                <td><?php echo $item['action'] ?></td>
                <td><?php echo $item_content[0] ?></td>
                <td>
                  <?php $brString = nl2br($item_content[1]); ?>
                  <?php echo str_replace('<br />', '<hr>', $brString) ?>
                </td>
                <td><?php echo date('H:i', $item_time) ?></td>
                <td><?php echo date('d/m/Y', $item_time) ?></td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-split-order" id="modal-split-order">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-header">
        <h4 class="modal-title">Tách đơn khẩn</h4>
      </div>
    <div class="modal-content">
      <div class="modal-body pb-16 pt-16">
        <div class="order">
        <div class="card-primary" style="background-color: #fff; padding: 0;">
          <div class="dropdown-address  pb-16">
            <p>Chọn địa chỉ giao đến</p>
              <div class="dropdown active pt-16" style="pointer-events: all;">  
                  <input type="hidden" name="ship_location_id" class="ship_location_id">                  
                  <input type="text" name="address_delivery" class="address_delivery is-disabled form-control" value="" placeholder="Vui lòng chọn">
              </div>
              <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
              <p class="fs-14 fw-regular note-admin hidden color-gray pt-4 pl-8">Note với admin: <span class="note_admin"></span></p>
              <div class="overlay-drop-menu"></div>
              <div class="dropdown-menu">
                  <div class="locations-container">
                      <div class="item" data-location_id="1">
                          <p class="fs-16 color-black other-address">45 Hoa Lan, Phường 3, Quận Phú Nhuận</p>
                      </div>
                  </div>
                  <div  class="btn-add-address d-f ai-center pb-8 pt-8 pl-8">
                      <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                  </div>
              </div>
          </div>
          <form method="post" class="hidden meal-add-location" id="meal-add-location" action="">
            <p>Nhập địa chỉ mới</p>
            <div class="row address-group location_0 address_active pt-16">
                <div class="city col-4 pb-16">
                    <select id="province" name="locations_province" class="province-select form-control" disabled="">
                        <option value="">Select Tỉnh/Thành phố</option>
                        <option value="Thành phố Hồ Chí Minh" selected="">Thành phố Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="district" name="" class="district-select form-control text-capitalize">
                        <option value="" selected="">Quận/Huyện*</option>
                    </select>
                </div>
                <div class="col-4 pb-16">
                    <select id="ward" name="locations_ward" class="ward-select form-control" disabled>
                        <option selected="">Phường/Xã*</option>
                    </select>
                </div>
                <div class="col-12 pb-16">
                    <input id="address" type="text" class="form-control address" placeholder="Địa chỉ cụ thể*" name="locations[0][address]">
                </div>
                <div class="group-note col-12">
                    <div class="note_shiper hidden pb-16">
                        <input type="text" name="locations_note_shipper" class="locations_note_shipper" placeholder="Note với shipper">
                    </div>
                    <div class="note_admin hidden pb-16">
                        <input type="text" name="locations_note_admin" class="locations_note_admin" placeholder="Note với admin">
                    </div>
                </div>
                <div class="show-group-note d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
                </div>
            </div>
        </form>
        <div class="row pb-8">
          <div class="col-6">
            Danh sách phần ăn được tách
          </div>
          <div class="col-6 text-right">
            1 đã chọn
          </div>
        </div>
        <hr>
        <div class="pt-16">
          <table class="table table-split-order" style="width: 100%;">
              <thead class="text-left">
                <tr>
                  <th>Tên khách hàng</th>
                  <th>SĐT</th>
                  <th class="text-center">Mã</th>
                  <th class="text-center">Thứ 3 <br>(03/01)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Khách hàng 1</td>
                  <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
                  <td class="text-center">SM</td>
                  <td>1 - Sườn non chay chua ngọt</td>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="modal-footer text-right pt-16 pr-16">
      <button type="button" class="button btn-default modal-close">Huỷ</button>
      <button type="button" class="button btn-primary modal-close">Lưu và đóng</button>
    </div>
  </div>
</div>
<?php
// endwhile;

global $site_scripts;

if (empty($site_scripts)) $site_scripts = [];
$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer');

$rows = [];
foreach($export_rows as $i => $row) {
  if(count(array_filter($row, function($v){ return $v != '';})) > 0) {
    $rows[] = $row;
  }
}

?>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script>
  var $rows = <?php echo json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;

  $('.js-export-table').on('click', function(e){
    e.preventDefault();

    if(typeof $rows == 'undefined' || $rows.length == 0) return;

    // console.log('$rows', $rows);

    var em_name = 'chon-mon';

    const worksheet = XLSX.utils.json_to_sheet($rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, em_name);

    // /* create an XLSX file and try to save to Donwload.xlsx */
    XLSX.writeFile(workbook, `${em_name}-${(new Date()).getTime()}.xlsx`, {compression: true});
  })

  $('.meal_select').on('change', function(){
    let input = $(this);
    
    input.toggleClass('changed', input.val() != input.data('old'));

    $('.js-save-meal-select').toggleClass('disable', $('.meal_select.changed').length == 0);
  });

  $('.js-save-meal-select').on('click', function(){
    let tab_id = $('.tabNavigation .selected').attr('rel');

    if($('.meal_select.changed').length > 0 && tab_id != '') {
      // document.getElementById('meal_select_form').submit();

      $('#' + tab_id + ' form').each(function(){
        this.submit();
      });
    }
  });

  $(document).ready(function() {
    // let now = new Date();
    // const lastWeekValue = '<?php echo $lastValue ?>';
    // const params = new URLSearchParams(window.location.search);

    // if (now.getDay() === 4 && now.getHours() >= 21 && params.get('week') !== lastWeekValue) {
    //     window.location.href = '?week=' + lastWeekValue;
    // }
    $('.list-customer .em-importer ul li.add').click(function(){
      // Tìm phần tử .hidden đầu tiên và hiện nó
      let nextHidden = $('.list-customer .em-importer ul li.dn').first();
      if (nextHidden.length) {
        nextHidden.removeClass('dn');
      }
      
      // Nếu không còn phần tử .hidden nào nữa thì ẩn nút add
      if ($('.list-customer .em-importer ul li.dn').length === 0) {
        $('.list-customer .em-importer ul li.add').hide();
      }
    });

    $('.list-customer .em-importer ul li.group-icon .btn.btn-alert').on('click', function (e) { 
      e.preventDefault();
      var $select = $('.meal-plan-waring');
      $(this).toggleClass('c-red');
      if($(this).hasClass('c-red')) {
        $('.meal-plan-waring.changed').addClass('c-red');
      } else {
        $('.meal_select.changed').removeClass('c-red');
      }
    });
    $('.meal_select').on('change', function () {
      $('.list-customer .em-importer ul li.group-icon .btn.btn-alert,.meal-plan-waring').removeClass('c-red');
    });
  });
</script>