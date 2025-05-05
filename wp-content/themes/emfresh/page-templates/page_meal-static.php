<?php

/**
 * Template Name: Page static meal
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_menu;

$menu_select = $em_menu->get_select();

$nowtime = time();
// change Friday to Monday
if (date('w', $nowtime) == 5 && date('H', $nowtime) >= 12) {
  $nowtime += 2 * DAY_IN_SECONDS;
}

$days = site_get_days_week_by(date('Y-m-d', $nowtime - 7 * DAY_IN_SECONDS));

$statistic = site_statistic_menu($days);

$columns = [
  'SL' => 'orange',
  'SM' => 'orange',
  'EM' => 'green',
  'EL' => 'green',
  'PM' => 'red',
  'PL' => 'red'
];

$column_keys = array_keys($columns);

// $static_days = $statistic['static_days'];

extract($statistic);

$total_products = [];

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();

?>
<!-- Main content -->
<section class="content">
  <?php
  if (isset($_GET['message']) && $_GET['message'] == 'Delete Success' && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    echo '<div class="alert alert-success mt-3 mb-16" role="alert">Xóa khách hàng thành công</div>';
  }
  if (!empty($_GET['code']) && !empty($_GET['expires']) && intval($_GET['expires']) > time()) {
    // echo '<div class="alert alert-success mt-3 mb-16" role="alert">'
    //     . sprintf('Cập nhật%s thành công', $_GET['code'] != 200 ? ' không' : '')
    //     .'</div>';
  }
  ?>
  <!-- Default box -->
  <div class="card list-customer static-meal">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-6">
            <ul class="d-f ai-center">
              <li class="status mr-16"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
              <li class="has-child">
                <span class="btn btn-default openmodal" data-target="#modal-calc">Công cụ tính phần dự trù</span>
              </li>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <div class="section-wapper mt-16">
        <table class="table table-static" style="width: 100%;">
          <thead>
            <tr>
              <th colspan="2"> </th>
              <th class="ttl-orange">SL</th>
              <th class="ttl-orange">SM</th>
              <th class="ttl-green">EM</th>
              <th class="ttl-green">EL</th>
              <th class="ttl-red">PM</th>
              <th class="ttl-red">PL</th>
              <th>Số <br> đạm</th>
              <th>Số <br>hộp</th>
              <th>Tổng <br>phần</th>
              <th>Tổng hợp <br>mã khác</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($days as $i => $day) :
              if(empty($static_days[$day])) continue;

              $time = strtotime($day); 
              $day_data = $static_days[$day];

              $menu_items = $day_data['menu_items'];

              $rowspan = count($menu_items);

              $j = 0;
              foreach($menu_items as $menu_id => $menu_item) :
                $menu_name = isset($menu_select[$menu_id]) ? $menu_select[$menu_id] : 'Menu - '. $menu_id;
                $products = $menu_item['products'];

                if(empty($total_products[$menu_id])) {
                  $total_products[$menu_id] = 0;
                }

                $total_products[$menu_id] += $menu_item['total'];

                if($j++ == 0) :
              ?>
              <tr>
                <td rowspan="<?php echo $rowspan ?>" class="text-center">
                  Thứ <?php echo $i + 2 ?> <br>
                  (<?php echo date('d/m', $time) ?>)
                </td>
                <td class="text-left"><?php echo $menu_name ?></td>
                <?php
                  foreach($columns as $code => $color) :
                    $value = isset($products[$code]) ? $products[$code] : 0;
                ?>
                <td class="cl-<?php echo $color ?>"><?php echo $value ?></td>
                <?php endforeach ?>
                <td><?php echo $menu_item['dam']; ?></td>
                <td><?php echo $menu_item['total']; ?></td>
                <td rowspan="<?php echo $rowspan ?>"><?php echo $day_data['total'] ; ?></td>
                <td rowspan="<?php echo $rowspan ?>" class="text-left" style="align-content:normal">
                  <p><?php
                    $k = 0;
                    foreach($products as $code => $value) {
                      if(!in_array($code, $column_keys)) {
                        echo "$code: $value ";

                        if(++$k % 2 == 0){
                          echo '</p><p>';
                        }
                      }
                    }
                  ?></p>
                </td>
              </tr>
              <?php else: ?>
              <tr>
                <td class="text-left"><?php echo $menu_name ?></td>
                <?php
                  foreach($columns as $code => $color) :
                    $value = isset($products[$code]) ? $products[$code] : 0;
                ?>
                <td class="cl-<?php echo $color ?>"><?php echo $value ?></td>
                <?php endforeach ?>
                <td><?php echo $menu_item['dam']; ?></td>
                <td><?php echo $menu_item['total']; ?></td>
              </tr>
              <?php
                endif;
              endforeach;
              ?>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</section>
<div class="modal fade modal-calc" id="modal-calc">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-header d-f jc-b">
      <h4 class="modal-title pl-16 ">Tính toán phần ăn dự trù</h4>
      <span class="modal-close pr-16"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
    </div>
    <div class="modal-content">
      <div class="modal-body pt-16">
        <table class="table tb-horizontal">
          <tbody>
            <tr class="purple">
              <td>Dí món</td>
              <?php foreach($days as $day) : ?>
              <td><?php 
                echo isset($tong_di_mon_chinh[$day]) ? $tong_di_mon_chinh[$day] : 0;
                echo '/' . (isset($tong_di_mon_dam[$day]) ? $tong_di_mon_dam[$day] : 0);
                echo '/' . (isset($tong_di_mon_nuoc[$day]) ? $tong_di_mon_nuoc[$day] : 0);
              ?></td>
              <?php endforeach ?>
            </tr>
            <tr class="orange">
              <td>Chưa rõ</td>
              <?php foreach($days as $day) : ?>
              <td><?php echo isset($tong_chua_ro[$day]) ? $tong_chua_ro[$day] : 0 ?></td>
              <?php endforeach ?>
            </tr>
          </tbody>
        </table>
        <div class="container card-primary pt-20 pb-20">
          <div class="row">
            <div class="col-8 mb-8">Số phần ăn dí món đang chờ:</div>
            <div class="col-4 mb-8"><input type="text" placeholder="-" class="text-center form-control"></div>
            <div class="col-8">Số phần ăn chưa rõ đang chờ:</div>
            <div class="col-4"><input type="text" placeholder="-" class="text-center form-control"></div>
            <hr class="col-12 mt-16 pb-16">
            <div class="col-8 ttl-total">Tổng phần ăn dự trù:</div>
            <div class="col-4 text-center">-</div>
          </div>
        </div>
        <table class="table tb-vertical">
          <thead>
            <tr>
              <th>Món</th>
              <th>Đã đặt</th>
              <th>Dự trù</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($total_products as $menu_id => $total) :
                $menu_name = isset($menu_select[$menu_id]) ? $menu_select[$menu_id] : 'Menu - '. $menu_id;
            ?>
            <tr>
              <td><?php echo $menu_name ?></td>
              <td><?php echo $total ?></td>
              <td>-</td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
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
?>
<script>
  $(document).ready(function() {
    
  });
</script>