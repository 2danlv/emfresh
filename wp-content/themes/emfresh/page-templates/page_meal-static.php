<?php

/**
 * Template Name: Page static meal
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log, $em_location;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();
$detail_order_url = site_order_edit_link();


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
              <th colspan="2"></th>
              <th class="ttl-orange">SL</th>
              <th class="ttl-orange">SM</th>
              <th class="ttl-green">EM</th>
              <th class="ttl-green">EL</th>
              <th class="ttl-red">PM</th>
              <th class="ttl-red">PL</th>
              <th>Số <br> đạm</th>
              <th>Số <br>hộp</th>
              <th>Tinh <br>bột</th>
              <th>Tổng <br>phần</th>
              <th>Tổng hợp <br>mã khác</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td rowspan="3" class="text-center">
              Thứ 2 <br>
              (02/01)</td>
              <td class="text-left">
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
              <td rowspan="3">300</td>
              <td rowspan="3" class="text-left" style="align-content:normal">
                <p>CT: 0 
                  EP: 9
                </p>
                <p>
                  BT: 0 
                  TA: 3
                </p>
                <p>
                  RT: 0 
                  SO: 0 
                </p>
                KT: 0
              </td>
            </tr>
            <tr>
              <td class="text-left">
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
            </tr>
            <tr>
              <td>
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
            </tr>
            <tr class="blank"><td colspan="13"></td></tr>
            <tr>
              <td rowspan="3" class="text-center">
              Thứ 2 <br>
              (02/01)</td>
              <td class="text-left">
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
              <td rowspan="3">300</td>
              <td rowspan="3"  class="text-left" style="align-content:normal">
                <p>CT: 0 
                  EP: 9
                </p>
                <p>
                  BT: 0 
                  TA: 3
                </p>
                <p>
                  RT: 0 
                  SO: 0 
                </p>
                KT: 0
              </td>
            </tr>
            <tr>
              <td>
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
            </tr>
            <tr>
              <td>
                1 - Salad bò sốt mè wasabi <br>
                Khoai tây nướng</td>
              <td class="cl-orange">40</td>
              <td class="cl-orange">40</td>
              <td class="cl-green">40</td>
              <td class="cl-green">40</td>
              <td class="cl-red">40</td>
              <td class="cl-red">40</td>
              <td>111/113</td>
              <td>160</td>
              <td>4.366</td>
            </tr>
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
              <td>40/34/6</td>
              <td>40/34/6</td>
              <td>40/34/6</td>
              <td>40/34/6</td>
              <td>40/34/6</td>
            </tr>
            <tr class="orange">
              <td>Chưa rõ</td>
              <td>68</td>
              <td>68</td>
              <td>68</td>
              <td>68</td>
              <td>68</td>
            </tr>
          </tbody>
        </table>
        <div class="container card-primary pt-20 pb-20">
          <div class="row">
            <div class="col-8 mb-8">Số phần ăn dí món đang chờ:</div>
            <div class="col-4 mb-8"><input type="text" placeholder="-" class="text-center form-control"></div>
            <div class="col-8">Số phần ăn dí món đang chờ:</div>
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
            <tr>
              <td>1 - Salad bò sốt mè wasabi <br>
              Khoai tây nướng</td>
              <td>113</td>
              <td>-</td>
            </tr>
            <tr>
              <td>2 - Salad bò sốt mè wasabi <br>
              Khoai tây nướng</td>
              <td>113</td>
              <td>-</td>
            </tr>
            <tr>
              <td>3 - Salad bò sốt mè wasabi <br>
              Khoai tây nướng</td>
              <td>113</td>
              <td>-</td>
            </tr>
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