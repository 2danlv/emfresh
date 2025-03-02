<?php

/**
 * Template Name: Page detail meal
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

$data = site_order_get_meal_plans($_GET);
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
      <table id="list-select-meal" class="table table-detail-meal js-meal-plan mt-16">
        <thead>
          <tr class="nowrap">
            <th data-number="1" class="text-left"><span>Tên khách hàng</span></th>
            <th data-number="2" class="text-center">Mã <br>sản phẩm</th>
            <th data-number="3" class="text-center">Phân <br>loại</th>
            <th data-number="4" class="text-center">Trạng thái <br>đặt đơn</th>
            <th data-number="5">
              <ul class="d-f date-group">
              <?php
                foreach($data['schedule'] as $date) : ?>
                  <li data-date="<?php echo $date ?>"><?php echo date('d', strtotime($date)) ?></li>
                <?php endforeach; ?>
              </ul>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php 
                foreach($data['orders'] as $order) : 
                    $meal_plan_items = $order['meal_plan_items'];
                    // var_dump($order);
            ?>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td><?php echo $order['customer_name'] ?></td>
            <td class="text-center"><?php echo $order['item_name'] ?></td>
            <td class="text-center"><?php echo $order['type_name'] ?></td>
            <td class="text-center"><span class="status_order status_order-meal-<?php echo $order['order_status'] ?>"><?php echo $order['order_status_name'] ?></span></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
              <?php
                foreach($data['schedule'] as $date) : 
                  $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : '';
                  if($value != ''){
                    $class_date  = '';
                  } else {
                    $class_date = 'empty';
                  }
              ?>
                <li data-date="<?php echo $date ?>" class="<?php echo $class_date; ?>"><span><?php echo $value ?></span></li>
              <?php endforeach; ?>
              </ul>
            </td>
          </tr>
          <?php foreach($order['order_items'] as $i => $order_item) : 
                $meal_plan_items = $order_item['meal_plan_items'];
                $total = array_sum($meal_plan_items);
            ?>
          <tr class="blank">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="accordion-tit_table order-<?php echo $order['id'] ?>" data-order_id="<?php echo $order['id'] ?>">
            <td class="nowrap">Sản phẩm <?php echo $i + 1 ?></td>
            <td class="nowrap"><?php echo $order_item['product_name'] ?></td>
            <td class="text-center"><?php echo strtoupper($order_item['type']) ?></td>
            <td class="text-center"><span class="status_order status_order-meal-<?php echo $order['order_status'] ?>"><?php echo $order['order_status_name'] ?></span></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <?php foreach($data['schedule'] as $date) : 
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : ''; 
                    if($value != ''){
                      $class_date  = '';
                    } else {
                      $class_date = 'empty';
                    }
                ?>
                <li class="<?php echo $class_date; ?>"><span><?php echo $value ?></span</li>
                <?php endforeach; ?>
              </ul>
            </td>
          </tr>
          <tr class="accordion-content_table order-<?php echo $order['id'] ?> order-item" 
              data-order_id="<?php echo $order['id'] ?>" 
              data-order_item_id="<?php echo $order_item['id'] ?>"
              data-total="<?php echo $total ?>"
          >
            <td><span class="hidden title">Sản phẩm <?php echo $i + 1 ?></span>Vy (Vy Vy)</td>
            <td class="text-center"><?php echo $order_item['product_name'] ?></td>
            <td class="text-center"><?php echo strtoupper($order_item['type']) ?></td>
            <td></td>
            <td class="wrap-date">
              <ul class="d-f date-group">
                <?php foreach($data['schedule'] as $date) : 
                    $value = isset($meal_plan_items[$date]) ? $meal_plan_items[$date] : ''; 
                    if($value != ''){
                      $class_date  = '';
                    } else {
                      $class_date = 'empty';
                    }
                ?>
                <li class="<?php echo $class_date; ?>"><span><input type="text" 
                        class="input-meal_plan<?php echo $value == '' ? ' empty' : '' ?>" 
                        value="<?php echo $value ?>"
                        max="<?php echo $order_item['meal_number'] ?>" 
                        data-date="<?php echo $date ?>" 
                        data-old="<?php echo $value ?>" 
                    /></span></li>
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
        <span class="count-close"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
      </div>
    </div>
    <hr>
    <div class="card-primary pt-16">
      <div class="row">
        <div class="col-6">
          <div class="row pb-16">
            <div class="col-6">
              <input type="text" placeholder="Tên người nhận (chọn ô ở trên)">
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-6"><input type="text" placeholder="Mã đơn hàng"></div>
                <div class="col-6"><input type="text" placeholder="Mã sản phẩm"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <input type="text" placeholder="Ngày bắt đầu (chọn ô ở trên)">
            </div>
            <div class="col-6">
              <input type="text" placeholder="Ngày kết thúc">
            </div>
          </div>
        </div>
        <div class="col-2 col-btn ai-end d-f">
          <div class="btn btn-primary  openmodal" data-target="#modal-warning-input">Xác nhận</div>
        </div>
        <div class="col-4 d-f col-txt text-right">
          <p>Tổng ngày ăn: <span>-</span></p>
          <p>Tổng phần ăn: <span>-</span></p>
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
          <p>Bạn nhập thiếu phần ăn: 02 <br>
          Vui lòng kiểm tra lại.</p>
          </div>
          
        </div>
        
      </div>
      <div class="modal-footer text-center pt-16 pb-8">
        <p class="pb-16"><button type="button" class="btn btn-primary modal-close">Quay lại chỉnh sửa</button></p>
        <p class="pb-16"><button type="button" class="btn btn-secondary modal-close">Tạo đơn mới & giảm giá</button></p>
        <p><button type="button" class="btn btn-secondary modal-close">Chuyển sang bảo lưu</button></p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-plan-history" id="modal-plan-history">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-header">
        <h4 class="modal-title">Vy (Vy Vy)</h4>
        <span class="modal-close"><img src="<?php echo site_get_template_directory_assets();?>/img/icon/delete-svgrepo-com.svg" alt=""></span>
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
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
              <td>Chọn món</td>
              <td>cập nhật</td>
              <td>#0001 - SM</td>
              <td>Thứ 2 (02/01) từ Sườn non chay thành Heo xào riềng sả</td>
              <td class="text-center">01:00</td>
              <td class="text-center">29/10/24</td>
            </tr>
            <tr>
              <td class="text-left"><img class="avatar" src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" width="24" alt="<?php echo $current_user->display_name; ?>"> Nhu Quynh</td>
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
                    <p>Vui lòng kiểm tra số bữa ăn:<span class="txt_append"></span></p>
                </div>
            </div>
            <div class="modal-footer text-center pb-8 pt-16">
                <button type="button" class="btn btn-secondary modal-close">Đóng</button>
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
    
    function accordion_table() {
      $('table .accordion-tit_table')
      .off()
      .on('click', function () {
        var item = $(this).toggleClass('on')
        while (item.next().hasClass('accordion-content_table')) {
          item = item.next()
          
          item.toggleClass('is-active').find('td > div').slideToggle(400)
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
    jQuery(function($){
      $(document).on('change','.input-meal_plan', function(){
        let input = $(this), value = input.val();
        $('.save-meal-plan').removeClass('hidden');
        input.closest('.order-item').toggleClass('changed', value != input.data('old'));
      });
      $('.js-save-meal-plan').on('click', function(e){
        e.preventDefault();

        let list_meal = [], errors = [];

        $('.js-meal-plan .order-item.changed').each(function(){
            let p = $(this), meal_plan = {}, 
                total = parseInt(p.data('total')),
                count = 0;
                
            p.find('.input-meal_plan').each(function(){
                let input = $(this)

                if(input.val() > 0) {
                    meal_plan[input.data('date')] = input.val();

                    count += input.val();
                }
            })
            
            if(total == count) {
                list_meal.push({
                    order_id : p.data('order_id'),
                    order_item_id : p.data('order_item_id'),
                    meal_plan : meal_plan
                });
            } else {
                errors.push(p.find('.title').text());
            }
        });

        if(errors.length > 0) {
          $('#modal-alert').addClass('is-active'); 
          $('body').addClass('overflow');
          $('.modal-warning .modal-body p span.txt_append').text(errors.join(", "));
          return;
      }


        if(list_meal.length == 0) return ;

        $.post('?', {
            ajax: 1,
            save_meal_plan: 1,
            list_meal: list_meal
        }, function(res){

            console.log('res', res);

            if(res.code == 200) {
                $('#modal-alert').addClass('is-active');
                $('body').addClass('overflow');
                $('.modal-warning .modal-body p span.txt_append').text('Lưu thành công!');
            } else {
              $('#modal-alert').addClass('is-active'); 
              $('body').addClass('overflow');
              $('.modal-warning .modal-body p span.txt_append').text("Lưu không thành công!");
            }
        }, 'JSON');
    })
      accordion_table();
      $('.btn-show-count').click(function (e) { 
        e.preventDefault();
        $(this).addClass('selected');
        $('.count-group').show();
      });
      $('.count-group .count-close').click(function (e) { 
        e.preventDefault();
        $('.count-group').hide();
        $('.btn-show-count').removeClass('selected');
      });
    });
  </script>