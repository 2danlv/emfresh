<?php
/**
 * Template Name: Phần Đặc Biết - DS Tuần
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_order, $em_customer_tag, $em_log, $em_location, $em_product;

$list_order_status = $em_order->get_statuses();
$list_tags = $em_customer->get_tags();

$detail_order_url = site_order_edit_link();
$add_order_url = site_order_add_link();
$admin_role       = wp_get_current_user()->roles;
// cập nhật data cho customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_post'])) {
  $list_id = isset($_POST['list_id']) ? sanitize_textarea_field($_POST['list_id']) : '';
  $array_id = explode(',', $list_id);

  foreach($array_id as $id) {
    $em_order->delete($id);
  }

  $updated = [];

  wp_redirect(add_query_arg([
    'code' => 200,
    'expires' => time() + 3,
    //'message' => 'Update Success',
  ], get_permalink()));
  exit();
}

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
<style>
	.list-customer table.table tbody > tr td .ellipsis{
		text-overflow: unset;
		text-wrap: auto;
		white-space: break-spaces;
		position:relative;
		line-height: 18px;
	}	
	.dt-buttons{display:none}
</style>
  <!-- Default box -->
  <div class="card list-customer list-order">
    <div class="card-body">
      <form class="em-importer" data-name="order" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center" >
			  <li class="group-icon mr-8"><span class="btn btn-export">Bộ lọc</span></li>
              <li class="add" style="display:none"><a href="<?php echo $add_order_url ?>"><img src="<?php echo site_get_assets(); ?>/img/icon/plus-svgrepo-com.svg" alt=""></a></li>
              <li class="ml-8" style="display:none"><span class="btn btn-fillter">Bộ lọc</span></li>
              <li class="has-child ml-8" style="display:none">
                <span class="btn btn-action">Thao tác</span>
                <ul>
                  <li>
                    <span class="copyAllphone" data-target="#modal-copy">Sao chép nhanh SĐT</span>
                  </li>
                  <li>
                    <a href="/import/" class="upload">Nhập dữ liệu</a>
                  </li>
                  <li><button type="button" name="action" value="export" class="js-export">Xuất dữ liệu</button></li>
                </ul>
              </li>
              <li class="ml-8" style="display:none"><span class="btn quick-print" data-target="#modal-print">In đơn</span></li>
              <li class="status" style="display:none"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
            </ul>
          </div>
          <div class="col-4">
            <ul class="d-f ai-center jc-end">
              <li class="has-time">
                <span class="btn btn-time">Thời gian</span>
                <ul>
                  <li><input type="text" id="datetimerange-input1"></li>
                </ul>
              </li>
              <li style="display:none"><span class="btn modal-button btn-column" data-target="#modal-default">Cột hiển thị</span></li>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-order" class="table table-list-order-2" style="width:100%">
        <thead>
          <tr class="nowrap">
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1" class="dt-orderable-none text-left"><span class="nowrap">Mã đơn</span></th>
            <th data-number="2"><span class="nowrap">Tên người nhận</span></th>
            <th data-number="3" class="text-left">SĐT</th>
            <th data-number="4" class="dt-orderable-none">Mã sản phẩm</th>
            <th data-number="5" class="dt-orderable-none">Nhóm yêu cầu đặc biệt</th>
			<th data-number="6" class="dt-orderable-none">Giá trị đặc biệt</th>
			<th data-number="7" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $response = em_api_request('order_item/list', [
              'paged' => 1,
              'limit' => -1,
			  'note_not_null' => 1,
            ]);
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              //var_dump($record);
              if (is_array($record)) {
				  $info_order = $em_order->get_item($record['order_id']);
				  $info_customer = $em_customer->get_item($info_order['customer_id']);
				  $info_product = $em_product->get_item($record['product_id']);
                  $link = add_query_arg(['order_id' => $info_order['id']], $detail_order_url);
                  $location_list = explode(',', $record['location_name']);
                ?>
                <?php
                if ( !empty($admin_role) && $admin_role[0] == 'administrator' ) {
                    $show_row = true;
                  }
                  else {
                    $show_row = ($record['status'] != 2);
                  }
                  if ( $show_row ) { 
					  
				  ?>
                    <tr>
                      <td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element" data-number="<?php echo $info_customer[ 'phone' ]; ?>" value="<?php echo $record[ 'order_id' ] ?>"></td>
                      <td data-number="1" class="text-left"><a href="<?php echo $link ?>"><?php echo $info_order[ 'order_number' ] ?></a></td>
                      <td data-number="2" class="text-capitalize nowrap wrap-td"><div class="ellipsis"><a href="<?php echo $link ?>"><?=($info_order['customer_name_2nd'] !="")?$info_order['customer_name_2nd']:$info_customer['customer_name'];?></a></div></td>
                      <td data-number="3" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $info_customer[ 'phone' ]; ?>"><?php echo $info_customer[ 'phone' ]; ?></span></td>
                      <td data-number="4" class="text-center"><?php echo strtoupper( $info_product[ 'name' ] ) ?></td>
				      <td data-number="5" class="wrap-td" style="min-width: 290px;"><div class="ellipsis"><?=$record[ 'note' ];?></div></td> 
					  <td data-number="6" class="wrap-td" style="min-width: 290px;"><div class="ellipsis"><?=$record[ 'note' ];?></div></td>
					  <td data-number="7" style="min-width: 140px;"><?php echo date( 'H:i d/m/Y', strtotime( $record[ 'modified' ] ) ); ?></td>
                    </tr>
                  <?php }
              }
            } 
          } else {
            echo "Không tìm thấy dữ liệu!\n";
          }
            
          ?>
        </tbody>
      </table>
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
<div class="modal fade" id="modal-default">
  <div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cột hiển thị</h4>
      </div>
      <div class="modal-body pt-16">
        <div class="row">
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="0" value="" disabled checked>Mã đơn</label></li>
              <li><label><input type="checkbox" data-column="1" value="" disabled checked>Tên khách hàng</label></li>
              <li><label><input type="checkbox" data-column="2" value="" disabled checked> Số điện thoại</label></li>
              <li><label><input type="checkbox" data-column="3" value="" disabled checked> Địa chỉ</label></li>
              <li><label><input type="checkbox" data-column="6" value="6">Phân loại</label></li>
              <li><label><input type="checkbox" data-column="7" value="7" checked>Mã gói sản phẩm</label></li>
              <li><label><input type="checkbox" data-column="8" value="8">Ngày bắt đầu</label></li>
              <li><label><input type="checkbox" data-column="9" value="9">Ngày kết thúc</label></li>
              <li><label><input type="checkbox" data-column="10" value="10">Yêu cầu đặc biệt</label></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="11" value="11">Giao hàng</label></li>
              <li><label><input type="checkbox" data-column="12" value="12"checked >Trạng thái đơn hàng</label></li>
              <li><label><input type="checkbox" data-column="13" value="13">Hình thức thanh toán</label></li>
              <li><label><input type="checkbox" data-column="14" value="14">Trạng thái thanh toán</label></li>
              <li><label><input type="checkbox" data-column="15" value="15">Tổng tiền đơn hàng</label></li>
              <li><label><input type="checkbox" data-column="16" value="16">Số tiền còn lại</label></li>
              <li><label><input type="checkbox" data-column="17" value="17">Giá trị đã dùng <!-- (admin only) --></label></li>
              <li><label><input type="checkbox" data-column="18" value="18">Giá trị chưa dùng <!-- (admin only) --></label></li>
              <li class="check_2"><label><input type="checkbox" value="19" data-column="19,21" checked>Nhân viên + Lần cập nhật cuối</label></li>
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
<div class="modal fade modal-print" id="modal-print">
  <div class="overlay"></div>
  <div class="modal-dialog h-200">
      <div class="modal-header container">
          <div class="pl-16 pr-16">
            <h4 class="modal-title pb-16">In đơn</h4>
            <hr>
            <form method="POST" action="<?php the_permalink() ?>">
                <input type="hidden" name="list_id" class="list_id" value="">
                <div class="form-group pt-16 row">
                  <div class="col-12">
                    <p>Chọn mẫu in</p>
                    <div class="form-control field pt-16 pb-16">
                      <select class="">
                        <option value="tag">PHIẾU GIAO HÀNG</option>
                      </select>
                    </div>
                  </div>
                </div>
              </form>
              <div class="row pt-16">
                <div class="col-6">Danh sách in</div>
                <div class="col-6 text-right"><span class="list-print"></span> đơn đã chọn</div>
              </div>          
          </div>
      </div>
      <div class="modal-content">
        <div class="modal-body">
          <?php
          //$status = $em_customer->get_statuses();
          //$list_payment_status = custom_get_list_payment_status();
          ?>
          
          <table class="table table-print nowrap no-border">
            <thead>
            <tr class="text-left">
              <th>ID</th>
              <th class="text-left">Tên khách hàng</th>
              <th class="text-left">SĐT</th>
              <th>Địa chỉ giao hàng</th>
              <th style="width: 70px;" class="text-right">Bản sao</th>
            </tr>
            </thead>
            <tr>
              <td>12345</td>
              <td class="">Linh (Nu Kenny)</td>
              <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12346</td>
              <td>Linh (Nu Kenny)</td>
              <td><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12347</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12348</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12349</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12350</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12351</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12352</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            <tr>
              <td>12353</td>
              <td>Linh (Nu Kenny)</td>
              <td class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0123456789">0123456789</span></td>
              <td  class="wrap-td" style="min-width: 350px;"><div class="nowrap ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</div></td>
              <td class="text-right"><input type="number"></td>
            </tr>
            
          </table>
        </div>
      </div>
      <div class="modal-footer pl-16 pr-16">
        <div class="form-group pt-16 text-right">
          <button type="button" class="button btn-default modal-close">Huỷ</button>
          <button type="submit" class="button btn-primary add_post" name="add_post">In đơn</button>
        </div>
      </div>
    </div>
</div>

<script>
  //let list_tags = ['1 phần','Chưa','Rồi'];
</script>

<?php
// endwhile;

global $site_scripts;

if (empty($site_scripts)) $site_scripts = [];
//$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = "https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js";
$site_scripts[] = "https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js";
$site_scripts[] = "https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js";
$site_scripts[] = "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js";			  
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer');
?>

<script>
  
  // Function to save checkbox states to localStorage
  function saveCheckboxState() {
    $('.filter input[type="checkbox"]').each(function() {
      const columnKey_order = 'column_order_' + $(this).val(); // Create key like "column_1", "column_2"
      localStorage.setItem(columnKey_order, $(this).is(':checked'));
    });
  }
  // Function to load checkbox states from localStorage
  function loadCheckboxState() {
    $('.filter input[type="checkbox"]').each(function() {
      const columnKey_order = 'column_order_' + $(this).val();
      const savedState = localStorage.getItem(columnKey_order);
      if (savedState === null) {
        if (['7', '12','19'].includes($(this).val())) {
          $(this).prop('checked', true);
        }
      } else {
        $(this).prop('checked', savedState === 'true');
        //$('.btn-column').addClass('active');
      }
    });
  }
  $('.btn.btn-export').click(function(){
		$('.dt-button.buttons-excel').eq(0).click();
  })
  $(document).ready(function() {
    // Load checkbox states when the page loads
    // console.log('log',localStorage);
    //loadCheckboxState();
    $('.filter input[type="checkbox"]').on('change', saveCheckboxState);   	
  });
</script>