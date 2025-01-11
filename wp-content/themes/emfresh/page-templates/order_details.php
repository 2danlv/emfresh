<?php

/**
 * Template Name: Detail-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer pt-16">

	<section class="content">
		<div class="container-fluid">
			<div class="scroll-menu pt-8">
				<div class="row">
					<div class="col-6 backtolist d-f ai-center">
						<a href="/customer/" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại danh sách khách hàng</span></a>
					</div>
					<div class="col-6 d-f ai-center jc-end group-button_top">
						<?php
						$admin_role = wp_get_current_user()->roles;
						if (!empty($admin_role)) {
							if ($admin_role[0] == 'administrator') {
						?>
								<span class="btn btn-danger remove-customer modal-button" data-target="#modal-default">
									Xoá khách này
								</span>
						<?php }
						} ?>
						<a class="btn btn-primary btn-add_order" href="#"><span class="d-f ai-center"><i class="fas mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com_white.svg" alt=""></i>Tạo đơn mới</span></a>
						<span class="btn btn-primary btn-disable btn-save_edit hidden">Lưu thay đổi</span>
					</div>
				</div>
				<div class="card-header">
					<ul class="nav tabNavigation pt-16">
						<li class="nav-item" rel="info">Thông tin khách hàng</li>
						<li class="nav-item" rel="note">Ghi chú</li>
						<li class="nav-item" rel="settings">Chỉnh sửa thông tin</li>
						<li class="nav-item" rel="history">Lịch sử thao tác</li>
					</ul>
				</div>
			</div>
			<div class="card-primary">
				<!-- Content Header (Page header) -->
				<h1 class="pt-8"><?php echo $response_customer['data']['customer_name'] ?></h1>
				<!-- Main content -->
				<div class="row">
					<div class="col-4 about-box">
						<!-- About Me Box -->
						<div class="card ">
							<!-- /.card-header -->
							<div class="card-body">
								<div class="ttl">
									Thông tin chi tiết
								</div>
								<div class="d-f jc-b pt-16">
									<span>Số điện thoại:</span>
									<span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $response_customer['data']['phone']; ?>"><?php echo $response_customer['data']['phone'] ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Giới tính:</span>
									<span><?php echo $response_customer['data']['gender_name']; ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Trạng thái khách hàng:</span>
									<span><?php echo $response_customer['data']['status_name'] ?></span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số đơn:</span>
									<span>12</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số ngày ăn:</span>
									<span>60</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Số phần ăn:</span>
									<span>60</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Tổng tiền đã chi:</span>
									<span>4.000.000</span>
								</div>
								<div class="d-f jc-b pt-8">
									<span>Điểm tích luỹ:</span>
									<span><?php echo $response_customer['data']['point'] ?></span>
								</div>
								<div class="d-f jc-b pt-8 pb-4">
									<span>Lịch sử đặt gần nhất:</span>
									<span>08:31 29/09/2024</span>
								</div>
								<hr>
								<div class="d-f jc-b pt-8">
									<span>Ghi chú dụng cụ ăn:</span>
									<span><?php echo $response_customer['data']['note_cook']; ?></span>
								</div>
								<div class="pt-8 d-f">
									<span class="nowrap pt-4">Tag phân loại:</span>
									<div class="list-tag text-right jc-end col-item-right">
										<?php foreach ($customer_tags as $item) : $tag = $item['tag_id']; ?>
											<span class="tag btn btn-sm tag_<?php echo $tag; ?> mb-4"><?php echo isset($list_tags[$tag]) ? $list_tags[$tag] : ''; ?></span>
										<?php endforeach; ?>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>
					</div>
					<!-- /.col -->
					<div class="col-8">
						<div class="card-body">
							<div class="tab-content">
								<div class="tab-pane" id="info">
									<div class="card mb-16">
										<div class="ttl">
											Địa chỉ
										</div>
										<?php
										foreach ($response_get_location['data'] as $index => $record) {
										?>
											<div class="row pt-16">
												<div class="col-10"><?php echo $record['address'] ?>,
													<?php echo $record['ward'] ?>,
													<?php echo $record['district'] ?>
												</div>
												<?php if ($record['active'] == 1) { ?>
													<div class="col-2 text-right">
														<span class="badge badge-warning">Mặc định</span>
													</div>
												<?php } ?>
											</div>
										<?php
										}
										?>
									</div>
									<div class="card card-history">
										<div class="ttl">
											Lịch sử đặt đơn
										</div>
										<div class="history-order" style="margin: 0;">
											<table class="nowrap-bak">
												<tr>
													<th>Mã đơn</th>
													<th>Mã gói sản phẩm</th>
													<th>Ngày <br>
														bắt đầu
													</th>
													<th>Ngày<br>
														kết thúc
													</th>
													<th>Tổng tiền</th>
													<th>Trạng thái<br>
														thanh toán</th>
													<th>Trạng thái<br>
														đơn hàng</th>
												</tr>
												<tr>
													<td>97</td>
													<td>2SM+1ET+1EP+1TA</td>
													<td>22/09/24</td>
													<td align="center">-</td>
													<td>400.000</td>
													<td align="center"><span class="status_pay">Rồi</td>
													<td align="center" class="status-order"><span class="status_order">Đang dùng</span></td>
												</tr>
												<tr>
													<td>97</td>
													<td>2SM+1ET+1EP+1TA</td>
													<td>22/09/24</td>
													<td>22/09/24</td>
													<td>400.000</td>
													<td align="center"><span class="status_pay">Rồi</td>
													<td align="center" class="status-order"><span class="status_order">Đang dùng</< /td>
												</tr>
											</table>
										</div>
										<div class="d-f ai-center jc-b pt-16">
											<div class="btn btn-export d-f ai-center">
												<span class="fas fa-export"></span> Xuất Excel
											</div>
											<div class="dt-paging">
												<nav aria-label="pagination">
													<button class="dt-paging-button disabled previous" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1"><i class="fas fa-left"></i></button>
													<button class="dt-paging-button current" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">1</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">2</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">3</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">4</button>
													<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">5</button>
													<button class="dt-paging-button disabled next" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Next" data-dt-idx="next" tabindex="-1"><i class="fas fa-right"></i></button>
												</nav>
											</div>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="note">
									<div class="card">
										<div class="ttl">
											Ghi chú
										</div>
										<div class="note-wraper pt-16">
											<?php
											$comments = get_comments(array(
												'type' => 'customer',
												'status' => 'any', // 'any', 'pending', 'approve'
												'post_id' => $customer_id,  // Use post_id, not post_ID, fwHR58J87Xc503mt1S
												'order' => 'comment_approved DESC, comment_date_gmt DESC',
												'parent' => 0
											));

											// Tu dong xoa sau 30 ngay
											$time_to_delete = strtotime('-30 days');

											foreach ($comments as $comment) :
												$comment_status = sanitize_title(get_comment_meta($comment->comment_ID, 'status', true));
												$delete_author = $comment->comment_author;
												$delete_by = (int) get_comment_meta($comment->comment_ID, 'delete_by', true);
												if($delete_by > 0) {
													$delete_author = get_the_author_meta('display_name', $delete_by);

													$delete_time = strtotime($comment->comment_date_gmt);
													if($delete_time < $time_to_delete) {
														wp_delete_comment($comment->comment_ID, true);

														continue;
													}
												}

												$comment->childs = get_comments(array(
													'type' => 'customer',
													'status' => 'any', // 'any', 'pending', 'approve'
													'post_id' => $customer_id,  // Use post_id, not post_ID, fwHR58J87Xc503mt1S
													'order' => 'comment_date_gmt DESC',
													'parent' => $comment->comment_ID
												));
												$show_childs = count($comment->childs) > 0;
											?>
												<div class="js-comment-row pb-16 <?php 
														echo ($comment->comment_approved == 0 ? ' status-trash' : '')
														. (get_comment_meta($comment->comment_ID, 'pin', true) == 1 ? ' comment-pin' : '');
													?>">
													<div class="row row-comment">
														<div class="account-name d-f ai-center col-6">
															<div class="avatar">
																<img src="<?php echo get_avatar_url($comment->user_id) ?>" alt="" width="40">
															</div>
															<div><?php echo $comment->comment_author ?></div>
														</div>
														<div class="edit col-3">
															<span class="pen">
																<?php if (site_comment_can_edit($comment->comment_ID) && $comment->comment_approved > 0) : ?>
																	<a href="#editcomment" data-id="<?php echo $comment->comment_ID ?>"><img src="<?php site_the_assets(); ?>/img/icon/edit-2-svgrepo-com.svg" alt=""></a>
																<?php endif ?>
															</span>
															<?php if ($comment->comment_approved > 0) : ?>
															<span class="pin"><a href="<?php echo site_comment_get_pin_link($comment->comment_ID) ?>"><img src="<?php site_the_assets(); ?>img/icon/pin-svgrepo-com.svg" alt=""></a></span>
															<?php endif ?>
															<span class="remove">
																<?php if (site_comment_can_edit($comment->comment_ID) && $comment->comment_approved > 0) : ?>
																	<a class="modal-remove-note modal-button" data-target="#modal-note" href="<?php echo site_comment_get_delete_link($comment->comment_ID) ?>"><img src="<?php site_the_assets(); ?>/img/icon/bin.svg" alt=""></a>
																<?php endif ?>
															</span>
														</div>
														<div class="time col-3"><?php echo get_comment_date('d/m/Y', $comment->comment_ID) ?></div>
													</div>
													<div class="note-content <?php echo $comment_status ?>">
														<span class="comment_content"><?php echo nl2br($comment->comment_content) ?></span>
														<?php
															$modal = '';
															
															if($show_childs) {
																$modal = ' modal-button" data-target="#modal-history' . $comment->comment_ID;
															}

															if ($comment->comment_approved == 0) {
																$delete_at = get_comment_meta($comment->comment_ID, 'delete_at', true);
																$ago = human_time_diff(strtotime($delete_at), current_time( 'U' ));

																echo '<span class="comment_status status-edited status-deleted' . $modal . '">&#8226; Đã xóa bởi <b>'.$delete_author.'</b> ';
																echo ($ago > 0 ? $ago . ' trước' : '');
																echo '</span>';
															} else if ($comment_status == 'cap-nhat') {
																echo '<span class="comment_status status-edited' . $modal . '">&#8226; Đã sửa</span>';
															}
														?>
													</div>
												</div>
											<?php endforeach; ?>
										</div>										
										<div class="note-form">
											<form action="<?php echo add_query_arg(['tab' => 'note'], $detail_customer_url) ?>" method="post" enctype="multipart/form-data" class="js-comment-form" id="editcomment">
												<div class="binhluan-moi">
													<div class="box-right">
														<div class="form-group">
															<textarea name="comment" maxlength="65525" class="form-control comment-box" placeholder="Viết bình luận"></textarea>
														</div>
														<button class="btn-common-fill hidden" type="submit" name="submit" value="submit">Send</button>
													</div>
													<input type="hidden" name="url" value="<?php echo $detail_customer_url ?>" />
													<input type="hidden" name="comment_post_ID" value="<?php echo $customer_id ?>" />
													<input type="hidden" name="comment_parent" value="0" />
													<input type="hidden" name="comment_ID" value="0" />
													<?php wp_nonce_field('comtoken', 'comtoken'); ?>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane customer detail-customer" id="settings">
									<div class="alert valid-form alert-warning hidden error mb-16"></div>
									<form class="form-horizontal" method="POST" action="<?php echo add_query_arg(['tab' => 'settings'], $detail_customer_url) ?>">
										<?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
										<div class="row pb-16">
											<div class="col-6">
												<div class="card-body">
													<div class="card-header">
														<h3 class="card-title d-f ai-center"><span class="fas fa-info mr-4"></span> Thông tin cơ bản</h3>
													</div>
													<div class="row">
														<div class="col-6 pb-16">
															<input type="text" name="nickname" class="nickname form-control" maxlength="50" value="<?php echo $response_customer['data']['nickname'] ?>" placeholder="Tên tài khoản*">
														</div>
														<div class="col-6 pb-16">
															<input type="text" name="fullname" class="fullname form-control" maxlength="50" value="<?php echo $response_customer['data']['fullname'] ?>" placeholder="Tên thật (nếu có)">
														</div>
														<div class="col-6 pb-16">
															<input type="tel" id="phone" name="phone" class="phone_number form-control" value="<?php echo $response_customer['data']['phone'] ?>" >
															<p id="phone_status" class="status text-danger"></p>
														</div>
														<div class="col-6 pb-16">
															<select name="gender" class="gender text-titlecase" required>
																<option value="0" selected>Giới tính*</option>
																<?php
																foreach ($list_gender as $value => $label) { ?>
																	<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['gender'], $value); ?> name="gender" >
																		<?php echo $label; ?>
																	</option>
																<?php } ?>
															</select>
														</div>
														<div class="col-12 ">
															<div class="review" style="display: block;">
																<p><span class="customer_name"><?php echo $response_customer['data']['customer_name'] ?></span></p>
																<p><span class="customer_phone"><?php echo $response_customer['data']['phone'] ?></span></p>
																<div class="info0">
																	<?php foreach ($response_get_location['data'] as $index => $location) {
																	?><?php if ($location['active'] == 1) { ?>
																	<span class="address"><?php echo $location['address'] ?>,</span>
																	<span class="ward"><?php echo $location['ward'] ?>,</span>
																	<span class="city"><?php echo $location['district'] ?></span>
																<?php } ?>
															<?php
																	}
															?>

																</div>
															</div>
														</div>
														<div class="col-12 pb-16">
															<p class="pb-8">Ghi chú dụng cụ ăn</p>
															<select name="note_cook">
																<option value=""></option>
																<?php foreach ($list_cook as $value) { ?>
																	<option value="<?php echo $value; ?>" <?php selected($response_customer['data']['note_cook'], $value); ?>><?php echo $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-12 pb-16">
															<p class="pb-8">Tag phân loại</p>
															<select class="form-control select2" multiple="multiple" name="tag_ids[]" style="width: 100%;">
																<?php
																foreach ($list_tags as $value => $label) { ?>
																	<option value="<?php echo $value; ?>" <?php echo in_array($value, $tag_ids) ? 'selected' : ''; ?>><?php echo $label; ?></option>
																<?php } ?>
															</select>
															<?php
															$admin_role = wp_get_current_user()->roles;
															if (!empty($admin_role)) {
																if ($admin_role[0] == 'administrator') {
															?>
																	<div class="form-group row pt-16 hidden">
																		<div class="col-sm-3"><label>Trạng thái khách hàng</label></div>
																		<div class="col-sm-9 text-titlecase">
																			<?php
																			foreach ($list_actives as $value => $label) { ?>
																				<div class="icheck-primary d-inline mr-2 text-titlecase">
																					<input type="radio" id="radioActive<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked($response_customer['data']['active'], $value); ?> name="active" required>
																					<label for="radioActive<?php echo $value; ?>">
																						<?php echo $label; ?>
																					</label>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
															<?php }
															} ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-6 ">
												<div id="location-fields">
													<?php
													foreach ($response_get_location['data'] as $index => $record) {
														if ($record['active'] == '1') {
															$address_active = " address_active";
														} else {
															$address_active = "";
														}
													?>
														<div class="address-group current-address pb-16 location_<?php echo ($record['active']);
																							echo $address_active; ?> " data-index="<?php echo $index ?>">
															<input type="hidden" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" />
															<div class="card-body">
																<div class="card-header">
																	<h3 class="card-title d-f ai-center"><span class="fas fa-location mr-4"></span>Địa chỉ</h3>
																</div>
																<div class="row">
																	<div class="city col-4 pb-16">
																		<select id="province_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][province]" class="province-select form-control" >
																			<option value="<?php echo $record['city']; ?>" selected><?php echo $record['city']; ?></option>
																		</select>
																	</div>
																	<div class="col-4 pb-16">
																		<select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control text-capitalize" >
																			<option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
																		</select>
																	</div>
																	<div class="col-4 pb-16">
																		<select id="ward_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][ward]" class="ward-select form-control disabled" >
																			<option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
																		</select>
																	</div>
																	<div class="col-12 pb-16">
																		<input id="address_<?php echo $record['id'] ?>" type="text" class="form-control address" value="<?php echo $record['address']; ?>" placeholder="Địa chỉ cụ thể*" name="locations[<?php echo $index ?>][address]"  />
																	</div>
																</div>
																<?php
																if ($record['note_shipper'] != '') {
																	$class_note_shipper = '';
																} else {
																	$class_note_shipper = 'hidden';
																}
																if ($record['note_admin'] != '') {
																	$class_note_admin = '';
																} else {
																	$class_note_admin = 'hidden';
																}
																if ($record['note_shipper'] && $record['note_admin']) {
																	$class_hidden = 'hidden';
																} else {
																	$class_hidden = '';
																}
																?>
																<div class="group-note">
																	<div class="note_shiper <?php echo $class_note_shipper ?> pb-16">
																		<input type="text" name="locations[<?php echo $index ?>][note_shipper]" value="<?php echo $record['note_shipper'] ?>" placeholder="Note với shipper" />
																	</div>
																	<div class="note_admin <?php echo $class_note_admin ?> pb-16">
																		<input type="text" name="locations[<?php echo $index ?>][note_admin]" value="<?php echo $record['note_admin'] ?>" placeholder="Note với admin" />
																	</div>
																</div>

																<div class="show-group-note d-f ai-center pb-16 pt-8 <?php echo $class_hidden ?>">
																	<span class="fas fa-plus mr-8"></span> Thêm ghi chú giao hàng
																</div>

																<div class="col-12 pb-16">
																	<hr>
																	<div class="row pt-16">
																		<div class="col-6">
																			<div class="icheck-primary d-f ai-center">
																				<input type="radio" name="location_active" id="active_<?php echo $record['id'] ?>" value="<?php echo $record['id'] ?>" <?php checked($record['active'], 1) ?>>
																				<input type="hidden" class="location_active" name="locations[<?php echo $index ?>][active]" value="<?php echo $record['active'] ?>" />
																				<label class="pl-4" for="active_<?php echo $record['id'] ?>">
																					Đặt làm địa chỉ mặc định
																				</label>
																			</div>
																		</div>
																		<div class="col-6 text-right delete-location-button" data-id="<?php echo $record['id'] ?>">
																			<p class="d-f ai-center jc-end"><span>Xóa địa chỉ </span><i class="fas fa-bin-red"></i></p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													<?php } ?>
												</div>


												<p class="d-f ai-center pb-16 add-location-button"><i class="fas fa-plus"></i><span>Thêm địa chỉ mới</span></p>
												<!-- /.card-body -->
												<!-- /.card -->

											</div>
										</div>
										<div class="row pt-16 hidden">
											<div class="col-12 text-right">
												<button type="submit" class="btn btn-primary" name="add_post">Cập nhật</button>
											</div>
										</div>
										<input type="hidden" name="customer_name" readonly class="customer_name form-control" value="<?php echo $response_customer['data']['customer_name'] ?>">
										<input type="hidden" name="customer_id" value="<?php echo $customer_id ?>" />
										<input type="hidden" name="location_delete_ids" value="" class="location_delete_ids" />
									</form>
								</div>
								<div class="tab-pane" id="history">
									<div class="card history-action">
										<table class="regular">
											<thead>
												<tr>
													<th>Người thực hiện</th>
													<th>Hành động</th>
													<th class="descript">Mô tả</th>
													<th>Thời gian</th>
													<th>Ngày</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$list_logs = $em_log->get_items([
													'module' => 'em_customer',
													'module_id' => $customer_id,
													// 'orderby'   => 'id DESC',
												]);

												// Tu dong xoa sau 7 ngay
												$time_to_delete = strtotime('-7 days');
												
												foreach ($list_logs as $item) :
													$item_time = strtotime($item['created']);

													if($item_time < $time_to_delete) {
														$em_log->delete($item['id']);

														continue;
													}
												?>
													<tr data-id="<?php echo $item['id'] ?>">
														<td class="avatar">
															<img src="<?php echo get_avatar_url($item['created_at']) ?>" width="24" alt="">
															<?php echo $item['created_author'] ?>
														</td>
														<td><?php echo $item['action'] ?></td>
														<td>
															<div class="descript-note nowrap">
																<?php $brString = nl2br($item['content']); ?>
																<?php echo str_replace('<br />', '<hr>', $brString) ?>
															</div>
														</td>
														<td><?php echo date('H:i', $item_time) ?></td>
														<td><?php echo date('d/m/Y', $item_time) ?></td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<div class="modal fade modal-warning" id="modal-default">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="list-customer" action="<?php the_permalink() ?>">
				<div class="modal-body pt-8 pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $response_customer['data']['id'] ?>">
					<div class="d-f ai-center">
						<i class="fas fa-warning mr-4"></i>
						<p>Bạn có chắc muốn xoá khách hàng này không?</p>
					</div>
					
				</div>
				<div class="modal-footer d-f jc-b pb-8 pt-16">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="submit" name="remove" class="btn btn-danger modal-close">Xóa</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-warning" id="modal-note">
	<div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
	<form method="post" class="form-remove-note" action="">
		<div class="modal-body pt-8 pb-16">
			<div class="d-f ai-center">
				<i class="fas fa-warning mr-4"></i>
				<p>Bạn có chắc muốn xoá ghi chú này không?</p>
			</div>
		</div>
		<div class="modal-footer d-f jc-b pb-8 pt-16">
			<button type="button" class="btn btn-secondary modal-close">Đóng</button>
			<button type="submit" name="remove" class="btn btn-danger modal-close">Xóa</button>
		</div>
	</form>
    </div>
  </div>
</div>
<div class="modal fade modal-warning" id="modal-confirm">
	<div class="overlay"></div>
  <div class="modal-dialog">
    <div class="modal-content">
	<form method="post" class="form-remove-note" action="">
		<div class="modal-body pt-8 pb-16">
			<div class="d-f ai-center">
				<i class="fas fa-warning mr-4"></i>
				<p>Bạn có chắc muốn huỷ thay đổi này không?</p>
			</div>
		</div>
		<div class="modal-footer d-f jc-b pb-8 pt-16">
			<button type="button" class="btn btn-secondary modal-close">Đóng</button>
			<button type="submit" onclick="hook = false;" class="btn btn-danger modal-close">Xóa</button>
		</div>
	</form>
    </div>
  </div>
</div>
<?php

get_template_part('parts/comment/comment', 'childs', ['comments' => $comments]);

// endwhile;
get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		
		$('.current-address .delete-location-button').click(function (e) { 
			e.preventDefault();
			$(".scroll-menu .btn-disable").removeClass('btn-disable');
		});
		
		$('.form-horizontal').each(function(){
			let p = $(this), data = p.serialize();
			
			p.on('input', function(){
				var hook = true;
				// $('[type="submit"]', p).prop('disabled', data == p.serialize())
				$(".scroll-menu .btn-disable").removeClass('btn-disable');
				// window.onbeforeunload = function() {
				// 	if (hook) {
				// 		$('.modal-confirm').addClass('is-active');
				// 		$('body').addClass('overflow');
				// 		return false;
				// 	}
				// }
			})
		});
		function unhook() {
			hook=false;
		}
		<?php
			if($tab_active != '') {
				echo '$(".tabNavigation [rel='.$tab_active.']").trigger("click");';
			}
		?>

		$('.modal-remove-note').click(function (e) { 
			e.preventDefault();
			var href = $(this).attr('href');
			$('#modal-note form.form-remove-note').attr('action', href);
		});
		$('#modal-note form.form-remove-note .btn-secondary').click(function (e) { 
			e.preventDefault();
			$('#modal-note form.form-remove-note').attr('action', '');
		});

		$('.js-comment-form').each(function() {
			let $form = $(this);

			$('.js-comment-row').each(function() {
				let row = $(this);

				row.find('a[href="#editcomment"]').on('click', function(e) {
					let id = $(this).data('id') || 0,
						value = row.find('.comment_content').text();

					if (id > 0 && value != '') {
						let title = 'Bạn đang chỉnh sửa ghi chú - ' + value;

						$form.find('[name="comment"]').val(value).attr('placeholder', title).attr('title', title).attr('data-value', value)
						$form.find('[name="comment_ID"]').val(id);
					}
				});
			});

			$('.comment-box').on("keypress", function (evt){
				if (evt.keyCode == 13) {
					let box = $(evt.target);
					
					if(evt.shiftKey == false && box.val().trim().length > 0) {
						evt.preventDefault();

						$form.find('[type="submit"]').trigger('click');
					}
				}
			}).on('input', function(evt){
				let box = $(evt.target),
					rows = box.val().split("\n").length;
				
				if(rows < 1) {
					rows = 1;
				}
				
				box.attr('rows', rows + 1);
			});
		});

		$('.nickname').keyup(updatetxt);
		$('.fullname').keyup(updatetxt);
		$('.phone_number').keyup(updatephone);
		$('.address-group select.district-select').each(function() {
			$(this).on('change', function() {
				$(this).closest('.address-group').find('.ward-select').removeClass('disabled');
			});
		});
		$(document).on('change', '.address_active select', function() {
			$('.review').show();
			//$(this).parents('.address-group').find($('.form-control.address')).val('');
			var selectItem = $(this).closest('.address_active'); // Get the closest select-item div
			var infoIndex = 0; // Get the data-index attribute from select-item
			var city = selectItem.find('.district-select').val(); // Get the city value from select
			var ward = selectItem.find('.ward-select').val(); // Get the ward value from select
			// Update the corresponding .info div based on index
			var infoDiv = $('.review .info' + infoIndex);
			infoDiv.children('.city').text(city);
			if (ward) {
				infoDiv.children('.ward').text(ward + ',');
			} else {
				infoDiv.children('.ward').text('');
			}
		});

		$(document).on('keyup', '.address_active .address', function() {
			$('.review').show();
			var selectItem = $(this).closest('.address_active'); // Find the closest parent .address-group
			var infoIndex = 0; // Get the index from data attribute
			var address = $(this).val(); // Get the current value of the address input field
			var infoDiv = $('.review .info' + infoIndex);
			if (address) {
				infoDiv.children('.address').text(address + ','); // Update the address text
			} else {
				infoDiv.children('.address').text(''); // Clear the address if the input is empty
			}
		});

		function updatetxt() {
			$('.review').show();
			if ($('.nickname').val() != '' && $('.fullname').val() != '') {
				$('input.customer_name').val($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
				$('span.customer_name').text($('.fullname').val() + ' (' + $('.nickname').val() + ') ');
			}
			if ($('.fullname').val() == '') {
				$('input.customer_name').val($('.nickname').val());
				$('span.customer_name').text($('.nickname').val());
			}
		}

		function updatephone() {
			$('span.customer_phone').text($('.phone_number').val());
		}
		var ass = new Assistant();
		$('.btn-primary[name="add_post"]').on('click', function(e) {
			if ($('.nickname').val() == '') {
				$(".alert.valid-form").show();
				$(".alert.valid-form").text('Chưa nhập tên tài khoản');
				$("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			} else {
				$(".alert.valid-form").hide();
			}
			if (!ass.checkPhone($('input[type="tel"]').val())) {
				// $('input[type="tel"]').addClass('error');
				$(".alert.valid-form").show();
				$(".alert.valid-form").text("Số điện thoại không đúng định dạng");
				$("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			} else {
				$(".alert.valid-form").hide();
				$('input[type="tel"]').removeClass('error');
			}
			if ($('.gender').val() == 0) {
				$(".alert.valid-form").show();
				$(".alert.valid-form").text('Chưa chọn giới tính');
				$("html, body").animate({ scrollTop: 0 }, 600);
				e.preventDefault();
				return false;
			} else {
				$(".alert.valid-form").hide();
			}
			$('.address-group select,.address-group .address').each(function() {
				var selectedValues = $(this).val();
				if (selectedValues == '') {
					$(".alert.valid-form").show();
					$(".alert.valid-form").text('Kiểm tra mục địa chỉ');
					$("html, body").animate({ scrollTop: 0 }, 600);
					e.preventDefault();
					return false;
				} else {
					$(".alert.valid-form").hide();
				}
			});
		});
		$('.js-list-note').each(function() {
			let p = $(this);
			$('.btn', p).on('click', function() {
				let input = $('textarea', p),
					list = input.val() || '',
					btn = $(this),
					text = btn.text();
				list = (list != '' ? list.split(',') : []).map(v => v.trim());
				if (btn.hasClass('active')) {
					let tmp = [];
					list.forEach(function(v, i) {
						if (v != text) {
							tmp.push(v);
						}
					})
					list = tmp;
					btn.removeClass('active');
				} else {
					list.push(text);
					btn.addClass('active');
				}
				input.val(list.join(", "));
			});
		});

		var fieldCount = <?php echo count($response_get_location['data']); ?>;
		var maxFields = 5;
		$(document).on('click', '.delete-location-button', function(e) {
			e.preventDefault();
			let btn = $(this),
				id = parseInt(btn.data('id') || 0);
			btn.closest('.address-group').remove(); // Remove only the closest address group
			// fieldCount = fieldCount + 1;
			// console.log('log',fieldCount);
			if (id > 0) {
				let l_d = $('.location_delete_ids');
				l_d.val(id + (l_d.val() != '' ? ',' + l_d.val() : ''));
			}
		});
		// Fetching data from the new API endpoint
		
	});
</script>