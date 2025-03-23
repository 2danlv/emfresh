<?php

/**
 * Template Name: List Group
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $em_customer, $em_group, $em_location;

$detail_group_url = site_group_edit_link();


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
  <div class="card list-customer list-order">
    <div class="card-body">
      <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
        <div class="row ai-center">
          <div class="col-8">
            <ul class="d-f ai-center">
              <li class="add"><a href="<?php echo home_url('/add-group') ?>"><img src="<?php echo site_get_template_directory_assets(); ?>/img/icon/plus-svgrepo-com.svg" alt=""></a></li>
              <li class="group-icon ml-8 mr-8"><span class="btn btn-fillter">Bộ lọc</span></li>
              <li class="group-icon mr-8"><span class="btn btn-export">Bộ lọc</span></li>
              <li class="status"><span class="btn btn-status"><span class="count-checked"></span> đã chọn</span></li>
            </ul>
          </div>
          <div class="col-4">
            <ul class="d-f ai-center jc-end">
             
              <li><span class="btn modal-button btn-column" data-target="#modal-default">Cột hiển thị</span></li>
            </ul>
          </div>
        </div>
        <?php wp_nonce_field('importoken', 'importoken', false); ?>
      </form>
      <table id="list-group-plan" class="table table-group-plan" style="width:100%">
        <thead>
          <tr class="nowrap">
            <th data-number="0" class="text-center"><input type="checkbox" name="checkall" id="checkall" /></th>
            <th data-number="1"><span class="nowrap">Tên nhóm</span></th>
            <th data-number="2" class="text-left">SĐT <br>trưởng nhóm</th>
            <th data-number="3" class="text-left">Địa chỉ nhóm</th>
            <th data-number="4" class="text-center">Thành viên</th>
            <th data-number="5">Số đơn</th>
            <th data-number="6">Trạng thái <br>nhóm</th>
            <th data-number="7">Ghi chú</th>
            <th data-number="8" class="text-center"><span class="nowrap">Nhân </span>viên</th>
            <th data-number="9">Nhân viên</th>
            <th data-number="10" class="text-left"><span class="nowrap">Lần cập </span><span class="nowrap">nhật cuối</span></th>
            <th data-number="11" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
            <th data-number="12" class="text-left"><span class="nowrap">Lần cập nhật cuối</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $response = em_api_request('group/list', [
              'paged' => 1,
              'limit' => -1,
            ]);
          if (isset($response['data']) && is_array($response['data'])) {
            // Loop through the data array and print each entry
            foreach ($response['data'] as $record) {
              // var_dump($record);
              if (is_array($record)) {
                  // $link = "detail-group";
                  $link = add_query_arg(['group_id' => $record["id"]], $detail_group_url);
                  $location_list = explode(',', $record['location_name']);
                ?>
                  <tr class="nowrap">
                    <td data-number="0" class="text-center"><input type="checkbox" class="checkbox-element" data-number="<?php echo $record['phone']; ?>" value="<?php echo $record['id'] ?>"></td>
                    <td data-number="1" class="text-capitalize nowrap wrap-td"><div class="ellipsis"><a href="<?php echo $link ?>"><?php echo $record['name']; ?></a></div></td>
                    <td data-number="2" class="text-left"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $record['phone']; ?>"><?php echo $record['phone']; ?></span></td>
                    <td data-number="3" class="text-capitalize wrap-td" style="min-width: 300px;">
                      <div class="nowrap ellipsis"><?php echo $record['location_name'] ?></div>
                    </td>
                    <td data-number="4" class="text-center">
                      <?php ?>
                    </td>
                    <td data-number="5"><?php ?></td>
                    <td data-number="6"><span><?php ?></span></td>
                    <td data-number="7"><?php  ?></td>
                    <td data-number="8" class="text-right"><span class="avatar"><img src="<?php echo get_avatar_url($record['modified_at']); ?>" width="24" alt="<?php echo get_the_author_meta('display_name', $record['modified_at']); ?>"></span></td>
                    <td data-number="9"><?php echo get_the_author_meta('display_name', $record['modified_at']); ?></td>
                    <td data-number="10" style="min-width: 146px;"><?php echo date('H:i d/m/Y', strtotime($record['modified'])); ?></td>
                    <td data-number="11"><?php echo date('Y/m/d', strtotime($record['modified'])); ?></td>
                    <td data-number="12"><?php echo date('d/m/Y', strtotime($record['modified'])); ?></td>
                  </tr>
          <?php
              } else {
                echo "Không tìm thấy dữ liệu!\n";
              }
            }
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
              <li><label><input type="checkbox" data-column="0" value="" disabled checked>Tên nhóm</label></li>
              <li><label><input type="checkbox" data-column="1" value="" disabled checked>SĐT trưởng nhóm</label></li>
              <li><label><input type="checkbox" data-column="2" value="" disabled checked> Địa chỉ nhóm</label></li>
              <li><label><input type="checkbox" data-column="3" value="" disabled checked> Trạng thái nhóm</label></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="filter list-unstyled">
              <li><label><input type="checkbox" data-column="4" value="4">Thành viên</label></li>
              <li><label><input type="checkbox" data-column="5" value="5">Số đơn</label></li>
              <li><label><input type="checkbox" data-column="7" value="7">Ghi chú</label></li>
              <li class="check_2"><label><input type="checkbox" value="" disabled checked>Nhân viên + Lần cập nhật cuối</label></li>
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


<script>
  //let list_tags = ['1 phần','Chưa','Rồi'];
</script>

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
    // Load checkbox states when the page loads
    // console.log('log',localStorage);
   
  });
</script>