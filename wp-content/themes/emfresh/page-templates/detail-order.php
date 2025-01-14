<?php

/**
 * Template Name: Detail-order
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $em_customer, $em_location, $em_order, $em_customer_tag, $em_log;
get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="detail-customer order detail-order pt-16">

	<section class="content">
		<div class="container-fluid">
			<div class="scroll-menu pt-8">
				<div class="row">
					<div class="col-6 backtolist d-f ai-center">
						<a href="/customer/" class="d-f ai-center"><span class="mr-4"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/caretup.svg" alt=""></span><span> Quay lại
								danh sách khách hàng</span></a>
					</div>
					<div class="col-6 d-f ai-center jc-end group-button_top">
						<a class="btn btn-primary js-btn-clone out-line" href="#"><span class="d-f ai-center"><i class="fas mr-4"><img
										src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com.svg" alt=""></i>Tạo bảo sao</span></a>
						<a class="btn btn-primary js-btn-save out-line" href="#">Lưu thay đổi</span></a>
						<span class="btn btn-primary btn-disable btn-save_edit hidden">Lưu thay đổi</span>
					</div>
				</div>
				<div class="card-header">
					<ul class="nav tab-nav tab-nav-detail tabNavigation pt-16">
						<li class="nav-item selected" rel="info">Thông tin đơn hàng</li>
						<li class="nav-item" rel="pay">Thanh toán</li>
						<li class="nav-item" rel="settings-product">Chỉnh sửa thông tin</li>
						<li class="nav-item" rel="activity-history">Lịch sử thao tác</li>
						<li class="nav-item" rel="reserve">Bảo lưu</li>
					</ul>
				</div>
			</div>
			<div class="card-primary">
				<!-- Content Header (Page header) -->
				<div class="head-section d-f jc-b pb-16 ai-center">
					<div class="order-code pl-16">#12345</div>
					<div class="group-btn js-group-btn gap-8 ai-center">
						<div class="print btn btn-secondary d-f gap-8 ai-center"><span class="fas fas-print"></span>In đơn</div>
						<div class="btn btn-danger remove-customer modal-button" data-target="#modal-default">
							Xoá đơn này
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane" id="info">
							<div class="row row32">
								<div class="col-8">
									<div class="section-wapper">
										<div class="tlt-section">Đơn hàng</div>
										<div class="section-content">
											<div class="d-f ai-center jc-b">
												<p class="txt">Phân loại đơn hàng:</p>
												<p class="txt">W</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Mã gói sản phẩm:</p>
												<p class="txt">1SM+1EM</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Ngày bắt đầu:</p>
												<p class="txt">04/11/2024</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Ngày kết thúc:</p>
												<p class="txt">-</p>
											</div>
										</div>
									</div>
									<div class="section-wapper">
										<div class="tlt-section">Sản phẩm</div>
										<div class="section-content">
											<div class="product-item">
												<div class="product-head d-f jc-b ai-center">
													<p class="txt fw-bold">Slimfit M x <span class="quantity">5</span></p>
													<p class="txt">325.000</p>
												</div>
												<div class="product-body">
													<div class="note-txt">Note rau củ: <span>cà rốt, bí đỏ, củ dền, bí ngòi</span></div>
													<div class="note-txt">Note tinh bột: <span>thay bún sang cơm trắng, thay miến sang cơm trắng, 1/2 tinh bột</span></div>
													<div class="note-txt">Note khác: <span>ko rau lá, chỉ củ, 2 sốt</span></div>
													<div class="note-txt">Note đính kèm: <span>thêm 1 tương ớt, thêm 1 ớt, túi riêng</span></div>
												</div>
											</div>
											<div class="product-item">
												<div class="product-head d-f jc-b ai-center">
													<p class="txt fw-bold">Eatclean M x <span class="quantity">5</span></p>
													<p class="txt">325.000</p>
												</div>
											</div>
										</div>
										<div class="section-ship line-dots-top">
											<div class="d-f ai-center jc-b">
												<p class="txt">Là đơn gộp tụ ship?</p>
												<p class="txt">Không</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Số ngày phát sinh phí ship:</p>
												<p class="txt">5</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Tổng tiền phí ship:</p>
												<p class="txt">50.000</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Giảm giá:</p>
												<p class="txt">-</p>
											</div>
											<div class="d-f ai-center jc-b mt-4">
												<p class="txt black fw-bold">Tổng tiền đơn hàng:</p>
												<p class="cost-txt">700.000</p>
											</div>
										</div>
									</div>
									<div class="section-wapper">
										<div class="tlt-section">Thanh toán</div>
										<div class="section-content">
											<div class="d-f ai-center jc-b">
												<p class="txt">Cần thanh toán:</p>
												<p class="txt">700.000</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Đã thanh toán:</p>
												<p class="txt">200.000</p>
											</div>
										</div>
										<div class="section-ship line-dots-top">
											<div class="d-f ai-center jc-b mt-4">
												<p class="txt black fw-bold">Số tiền còn lại:</p>
												<p class="cost-txt red">500.000</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="section-wapper">
										<div class="tlt-section">Khách hàng</div>
										<div class="section-content">
											<p class="txt">Linh (Nu Kenny)</p>
											<p class="copy modal-button fw-bold" data-target="#modal-copy" title="Copy: 0909739506">0909739506</p>
											<p class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
											<p class="note-txt italic">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
										</div>
									</div>
									<div class="section-wapper">
										<div class="tlt-section">Trạng thái</div>
										<div class="section-content status-content">
											<div class="d-f jc-b ai-center">
												<p class="txt">Trạng thái đặt đơn:</p>
												<div class="tag-status purple">Dí món</div>
											</div>
											<div class="d-f jc-b ai-center">
												<p class="txt">Phương thức thanh toán:</p>
												<p class="txt">Chuyển khoản</p>
											</div>
											<div class="d-f jc-b ai-center">
												<p class="txt">Trạng thái thanh toán:</p>
												<div class="tag-status purple">1 phần</div>
											</div>
											<div class="d-f jc-b ai-center">
												<p class="txt">Trạng thái đơn hàng:</p>
												<div class="tag-status green">Đang dùng</div>
											</div>
										</div>
									</div>
									<div class="section-wapper">
										<div class="tlt-section">Giao hàng</div>
										<div class="section-content">
											<p class="txt black ellipsis">Thứ 3 (06/01): 45 Hoa Lan, Phường 3, Quận Phú Nhuận</p>
											<p class="note-txt italic">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="pay">
							<div class="table-container pay-table">
								<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Thời gian</th>
												<th>Ngày</th>
												<th>Nhân viên cập nhật</th>
												<th>Mô tả</th>
												<th>Số tiền</th>
												<th>Còn nợ</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>01:00</td>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>COD</td>
												<td>- 1.000.000</td>
												<td>0</td>
											</tr>
											<tr>
												<td>01:00</td>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>Bổ sung đơn hàng</td>
												<td>+ 500.0000</td>
												<td>+ 1.000.000</td>
											</tr>
											<tr>
												<td>01:00</td>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>Chuyển khoản</td>
												<td>- 200.000</td>
												<td>+ 500.000</td>
											</tr>
											<tr>
												<td>01:00</td>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>Tạo đơn hàng</td>
												<td>+ 700.000</td>
												<td>+ 700.000</td>
											</tr>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="settings-product">
							<div class="row row32">
								<div class="col-4">
									<div class="card section-wapper">
										<div class="card-body">
											<div class="ttl">
												Thông tin đơn hàng
											</div>
											<div class="info-customer line-dots">
												<p class="pt-16">Linh (Nu Kenny)</p>
												<p class="copy modal-button pt-8 fw-bold" data-target="#modal-copy" title="Copy: 0909739506">0909739506</p>
												<p class="pt-8 pb-16 text-ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 07, Quận Bình Thạnh</p>
											</div>
											<div class="order-details show">
												<div class="info-order line-dots">
													<div class="d-f jc-b pt-8">
														<span class="tlt fw-bold ">Phân loại đơn hàng:</span>
														<span>W</span>
													</div>
													<div class="d-f jc-b pt-8">
														<span class="tlt fw-bold ">Ngày bắt đầu đơn hàng:</span>
														<span>04/11/2024</span>
													</div>
													<div class="tlt fw-bold  pt-8">Thông tin sản phẩm:</div>
													<div class="info-product pt-8">
														<div class="d-f jc-b">
															<div class="d-f"><span class="name">Slimfit M</span>&nbsp;x&nbsp;<span class="quantity">5</span></div>
															<div class="price">325.000</div>
														</div>
														<div class="note-box pb-20">
															<p><span class="note">Note rau củ</span>:&nbsp;<span class="value">cà rốt, bí đỏ, củ dền, bí ngòi</span></p>
															<p><span class="note">Note tinh bột</span>:&nbsp;<span class="value">thay bún sang cơm trắng, thay miến sang cơm trắng, 1/2 tinh
																	bột</span></p>
															<p><span class="note">Note khác</span>:&nbsp;<span class="value">ko rau lá, chỉ củ, 2 sốt</span></p>
															<p><span class="note">Note đính kèm</span>:&nbsp;<span class="value">thêm 1 tương ớt, thêm 1 ớt, túi riêng</span></p>
														</div>
													</div>
												</div>
												<div class="info-pay">
													<div class="d-f jc-b pt-18">
														<span class="tlt fw-bold ">Tổng tiền phí ship:</span>
														<span class="ship">-</span>
													</div>
													<div class="d-f jc-b pt-8">
														<span class="tlt fw-bold ">Giảm giá:</span>
														<span class="discount">-</span>
													</div>
													<div class="d-f jc-b pt-8 pb-8">
														<span class="tlt fw-bold ">Tổng tiền đơn hàng:</span>
														<span class="total total-price">325.000</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-8">
									<ul class="nav tab-order edit-product pt-20">
										<li class="nav-item" rel="detail-product">Sản phẩm</li>
										<li class="nav-item" rel="detail-pay">Thanh toán</li>
										<li class="nav-item" rel="detail-delivery">Giao hàng</li>
									</ul>
									<div class="tab-pane tab-pane-2" id="detail-product">
										<div class="card">
											<div class="pl-16 pr-16 tab-products">
												<div class="tab-add-product" id="tabNav">
													<button class="d-f jc-b ai-center gap-8 btn btn-add_order tab-button active" data-tab="tab-1">Sản phẩm 1 <span class="remove-tab"></span></button>
													<button class="add-tab" id="addTabButton"></button>
												</div>
											</div>
											<div class="tab-products">
												<div id="tabContents">
													<div class="tab-content-wrapper active" id="tab-1">
														<div class="tab-content">
															<div class="row24">
																<div class="col-5">
																	<div class="label mb-4">Phân loại:</div>
																	<select id="classify" name="classify" class="classify-select form-control text-capitalize">
																		<option value="" selected="">D/W/M</option>
																		<option value="D">D</option>
																		<option value="W">W</option>
																		<option value="M">M</option>
																	</select>
																</div>
																<div class="col-3">
																	<div class="label mb-4">Số ngày dùng:</div>
																	<input type="text" name="number" placeholder="-" class="form-control number">
																</div>
																<div class="col-4">
																	<div class="label mb-4">Số ngày dùng:</div>
																	<input type="date" name="date" placeholder="DD/MM/YYYY" class="form-control date">
																</div>
															</div>
															<div class="list-product">
																<div class="product-item">
																	<div class="d-f gap-24 item-head">
																		<div class="col-5 label">Tên sản phẩm</div>
																		<div class="col-3 label text-right">Số lượng</div>
																		<div class="col-4 label text-right">Thành tiền</div>
																	</div>
																	<div class="pt-16 item-body">
																		<div class="d-f gap-24">
																			<div class="col-5"><input type="text" name="name" placeholder="Nhập tên/mã sản phẩm" class="form-control name"></div>
																			<div class="col-3"><input type="text" name="number" placeholder="-" class="form-control text-right number"></div>
																			<div class="col-4 text-right">
																				<p class="fs-16 fw-bold price pt-8 pb-8">325.000</p>
																			</div>
																		</div>
																		<p class="note note-no-use pl-8 pt-4">Chưa dùng: <span>3</span></p>
																		<div class="d-f gap-12 ai-center">
																			<label class="auto-fill-checkbox mt-16 mb-16">
																				<input type="checkbox">
																				<span class="slider"></span>
																			</label>
																			Tự chọn món
																			<div class="explain-icon">
																				<img width="16" src="<?php site_the_assets(); ?>img/icon/WarningCircle-gray.svg" alt="">
																				<div class="explain-block d-f ai-center gap-8">
																					Chế độ này bật khi được khách hàng cho phép chọn món giúp họ
																					<i class="fas fa-trash close-explain"></i>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="special-request pt-16">
															</div>
															<div class="d-f ai-center pt-20 clone-note fw-bold">
																<span class="fas fa-plus mr-8"></span>Thêm yêu cầu phần ăn đặc biệt
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane tab-pane-2 pay-field" id="detail-pay">
										<div class="card">
											<div class="total-pay d-f jc-b ai-center">
												<p>Tổng tiền sản phẩm:</p>
												<p class="price-product fw-bold">650.000</p>
											</div>
											<div class="shipping-fee">
												<div class="fee-item d-f jc-b ai-center">
													<p>Là đơn gộp tụ ship?</p>
													<div class="d-f gap-12 ai-center">
														<label class="auto-fill-checkbox">
															<input type="checkbox">
															<span class="slider"></span>
														</label>
														<span class="fs-16 color-gray">Không</span>
													</div>
												</div>
												<div class="fee-item d-f jc-b ai-center">
													<p>Số ngày phát sinh phí ship:</p>
													<input type="number" name="number" placeholder="-" class="form-control text-right ship_fee_days">
												</div>
												<div class="fee-item d-f jc-b ai-center">
													<p>Tổng tiền phí ship:</p>
													<input type="number" name="number" placeholder="-" class="form-control text-right total_ship">
												</div>
												<div class="fee-item d-f jc-b ai-center">
													<p>Giảm giá:</p>
													<input type="number" name="number" placeholder="-" class="form-control text-right discount">
												</div>
											</div>
											<div class="total-pay d-f jc-b ai-center">
												<p>Tổng tiền đơn hàng:</p>
												<p class="price-order fw-bold">650.000</p>
											</div>
											<div class="order-payment">
												<div class="payment-item d-f jc-b ai-center">
													<p>Phương thức thanh toán:</p>
													<div class="d-f jc-b ai-center gap-16">
														<label class="d-f ai-center gap-12">
															<input type="radio" name="payment-method" class="form-control cod" checked="checked">COD
														</label>
														<label class="d-f ai-center gap-12">
															<input type="radio" name="payment-method" class="form-control transfer">Chuyển khoản
														</label>
													</div>
												</div>
												<div class="payment-item d-f jc-b ai-center">
													<p>Trạng thái thanh toán:</p>
													<div class="status-payment">
														<div class="status-pay"><span class="red">Chưa</span></div>
														<ul class="status-pay-menu">
															<li class="status-pay-item" data-status='no'><span class="red">Chưa</span></>
															<li class="status-pay-item" data-status='pending'><span class="purple">1 phần</span></>
															<li class="status-pay-item" data-status='yes'><span class="white">Rồi</span></>
														</ul>
													</div>
												</div>
												<div class="paymented d-f jc-b ai-center pt-8">
													<p>Đã thanh toán:</p>
													<input type="number" name="number" placeholder="-" class="form-control text-right">
												</div>
												<div class="payment-item d-f jc-b ai-center pt-8">
													<p>Cần thanh toán:</p>
													<div class="payment-required fw-bold"> 650.000</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane tab-pane-2 delivery-field" id="detail-delivery">
										<div class="card">
											<div class="pl-16 pr-16">
												<div class="row delivery-item">
													<div class="col-4">Đặt lịch:</div>
													<div class="col-8">
														<label for="loop" class="d-f ai-center gap-12 pb-8 loop">
															<input type="checkbox" name="loop" id="loop">
															Lặp lại hàng tuần
														</label>
														<div class="calendar">
															<input type="text" name="calendar" placeholder="DD/MM/YYYY" class="form-control js-calendar date">
														</div>
														<div class="repeat-weekly">
															<input type="checkbox" id="monday" hidden name="days" value="monday">
															<label for="monday">Thứ Hai</label>
															<input type="checkbox" id="tuesday" hidden name="days" value="tuesday">
															<label for="tuesday"> Thứ Ba</label>
															<input type="checkbox" id="wednesday" hidden name="days" value="wednesday">
															<label for="wednesday"> Thứ Tư</label>
															<input type="checkbox" id="thursday" hidden name="days" value="thursday">
															<label for="thursday"> Thứ Năm</label>
															<input type="checkbox" id="friday" hidden name="days" value="friday">
															<label for="friday"> Thứ Sáu</label>
														</div>
													</div>
												</div>
												<div class="row delivery-item pt-24 ai-center">
													<div class="col-4">Địa chỉ giao:</div>
													<div class="col-8 address">
														<div class="dropdown">
															<input type="text" name="nickname" class="address_delivery is-disabled form-control pb-4" maxlength="50" placeholder="Vui lòng chọn">
															<span class="fs-14 hidden fw-regular note-shipper color-gray pl-8">Note với shipper: <span class="note_shiper"></span></span>
														</div>
														<div class="dropdown-menu">
															<div class="item">
																<p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
																<p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
															</div>
															<a href="#modal-add-address" class="btn-add-address d-f ai-center pb-16 pt-8 pl-8">
																<span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
															</a>
														</div>
													</div>
												</div>
												<div class="row delivery-item js-note show pt-16 ai-center">
													<div class="col-4">Note shipper theo ngày:</div>
													<div class="col-8">
														<input type="text" name="note_shipper_by_day" class="form-control note_shipper_by_day">
													</div>
												</div>
												<div class="row delivery-item js-note show pt-16 ai-center">
													<div class="col-4">Note admin theo ngày:</div>
													<div class="col-8">
														<input type="text" name="note_admin_by_day" class="form-control note_admin_by_day">
													</div>
												</div>
											</div>
										</div>
										<div class="d-f ai-center pb-16 pt-24 add-new-note">
											<span class="fas fa-plus mr-8"></span> Thêm note giao hàng mới
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane activity-history" id="activity-history">
							<div class="table-container activity-history-table">
								<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Ngày thực hiện</th>
												<th>Hành động</th>
												<th>Trường</th>
												<th>Mô tả</th>
												<th>Thời gian</th>
												<th>Ngày</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
											<tr>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>cập nhật</td>
												<td>địa chỉ</td>
												<td class="ellipsis">sản phẩm 1 số lượng 05</td>
												<td>01:00</td>
												<td>29/10/24</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="dt-container pb-16 pr-8">
								<div class="bottom">
									<div class="dt-paging">
										<nav aria-label="pagination">
											<button class="dt-paging-button disabled previous" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Previous"
												data-dt-idx="previous" tabindex="-1"><i class="fas fa-left"></i></button>
											<button class="dt-paging-button current" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">1</button>
											<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">2</button>
											<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">3</button>
											<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">4</button>
											<button class="dt-paging-button" role="link" type="button" aria-controls="list-customer" aria-current="page" data-dt-idx="0">5</button>
											<button class="dt-paging-button disabled next" role="link" type="button" aria-controls="list-customer" aria-disabled="true" aria-label="Next"
												data-dt-idx="next" tabindex="-1"><i class="fas fa-right"></i></button>
										</nav>
									</div>
									<div class="dt-length"><select name="list-customer_length" aria-controls="list-customer" class="dt-input" id="dt-length-0">
											<option value="10">10 / trang</option>
											<option value="50">50 / trang</option>
											<option value="100">100 / trang</option>
											<option value="200">200 / trang</option>
										</select><label for="dt-length-0"> entries per page</label></div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="reserve">
							<div class="row row32 reserve">
								<div class="col-8">
									<div class="section-wapper">
										<div class="tlt-section">Thông tin bảo lưu</div>
										<div class="section-content status-content">
											<div class="d-f ai-center jc-b">
												<p class="txt">Trạng thái đặt đơn:</p>
												<p class="txt tag-status red">Đặt đơn</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Số phần ăn bảo lưu:</p>
												<p class="txt">-</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Số ngày giao hàng bảo lưu:</p>
												<p class="txt">-</p>
											</div>
											<div class="d-f ai-center jc-b">
												<p class="txt">Ngày bắt đầu bảo lưu:</p>
												<p class="txt">-</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="btn btn-secondary btn-reserve js-continue">Tiếp tục đơn hàng</div>
									<div class="btn btn-secondary btn-reserve js-cancel">Huỷ phần bảo lưu & Giảm giá đơn mới</div>
									<div class="btn btn-secondary btn-reserve js-end danger">Kết thúc đơn hàng vì quá hạn (admin only)</div>
								</div>
							</div>
							<div class="table-container">
								<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Ngày thực hiện</th>
												<th>Người thực hiện</th>
												<th>Hành động</th>
												<th>Mô tả</th>
												<th>Ngày bắt đầu</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>xử lý bảo lưu</td>
												<td>Tiếp tục đơn hàng</td>
												<td>30/10/2024</td>
											</tr>
											<tr>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>xử lý bảo lưu</td>
												<td>Tạo đơn mới #23456 từ phần bảo lưu</td>
												<td>-</td>
											</tr>
											<tr>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>xử lý bảo lưu</td>
												<td>Giảm giá đơn mới #23456 từ phần bảo lưu</td>
												<td>-</td>
											</tr>
											<tr>
												<td>29/10/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>xử lý bảo lưu</td>
												<td>kết thúc đơn hàng</td>
												<td>-</td>
											</tr>
											<tr>
												<td>29/09/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>bảo lưu</td>
												<td>Số phần ăn bảo lưu: 15/ Số ngày giao hàng bảo lưu: 5</td>
												<td>04/10/2024</td>
											</tr>
											<tr>
												<td>29/09/24</td>
												<td><img class="mr-8" src="<?php echo site_get_template_directory_assets(); ?>img/icon/User-gray.svg" width="24" alt="">Như Quỳnh</td>
												<td>bảo lưu</td>
												<td>Số phần ăn bảo lưu: 15/ Số ngày giao hàng bảo lưu: 5</td>
												<td>04/10/2024</td>
											</tr>
											<!-- Add more rows if needed -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div><!-- /.card-body -->
			</div>
			<!-- /.card -->

			<!-- /.row -->
		</div>

</div><!-- /.container-fluid -->
<div class="navigation-bottom d-f jc-b ai-center pl-16 pr-16">
	<div class="total-cost txt d-f gap-16 ai-center fw-bold">Cần thanh toán: <span class="cost-txt red fw-bold">500.000</span></div>
	<span class="btn btn-primary btn-next">Đi đến Meal Plan chi tiết</span>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.card-body -->
<div class="modal fade modal-warning" id="modal-cancel">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="list-customer" action="">
				<div class="modal-body pt-8 pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="">
					<div class="d-f">
						<i class="fas fa-warning mr-8"></i>
						<p>Bạn có chắc chắn muốn huỷ phần bảo lưu này và giảm giá cho đơn hàng mới? </p>
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
<div class="modal fade modal-warning" id="modal-end">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" class="form-remove-note" action="">
				<div class="modal-body pt-8 pb-16">
					<div class="d-f ai-center">
						<i class="fas fa-warning mr-4"></i>
						<p>Bạn có chắc chắn muốn kết thúc đơn hàng này ?</p>
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
<div class="modal fade" id="modal-continue">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" class="form-remove-note" action="">
				<div class="modal-body pb-16">
					<div class="tlt pt-16">Sản phẩm</div>
					<p class="pt-16">Vui lòng chọn ngày bắt đầu tiếp diễn cho đơn hàng</p>
					<div class="calendar pt-16">
						<input type="text" value="" name="calendar" placeholder="DD/MM/YYYY" class="form-control start-day js-calendar">
					</div>
				</div>
				<div class="modal-footer d-f jc-end pb-8 pt-16 gap-16">
					<button type="button" class="btn btn-secondary modal-close">Hủy</button>
					<button type="submit" class="btn btn-primary modal-close">Xác nhận</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-warning" id="modal-remove-tab">
	<div class="overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="list-customer" action="">
				<div class="modal-body pt-8 pb-16">
					<input type="hidden" class="customer_id" name="customer_id" value="">
					<div class="d-f ai-center">
						<i class="fas fa-warning mr-4"></i>
						<p>Bạn có chắc muốn xoá sản phẩm đang thực hiện trên đơn hàng này không?</p>
					</div>

				</div>
				<div class="modal-footer d-f jc-end pb-8">
					<button type="button" class="btn btn-secondary modal-close">Đóng</button>
					<button type="button" name="remove" class="btn btn-danger modal-close">Xóa</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php

// endwhile;
get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
<script src="<?php site_the_assets(); ?>js/detail-order.js"></script>
<script type="text/javascript">
	jQuery( function ( $ )
	{

		$( '.current-address .delete-location-button' ).click( function ( e )
		{
			e.preventDefault();
			$( ".scroll-menu .btn-disable" ).removeClass( 'btn-disable' );
		} );

		$( '.form-horizontal' ).each( function ()
		{
			let p = $( this ), data = p.serialize();

			p.on( 'input', function ()
			{
				var hook = true;
				// $('[type="submit"]', p).prop('disabled', data == p.serialize())
				$( ".scroll-menu .btn-disable" ).removeClass( 'btn-disable' );
				// window.onbeforeunload = function() {
				// 	if (hook) {
				// 		$('.modal-confirm').addClass('is-active');
				// 		$('body').addClass('overflow');
				// 		return false;
				// 	}
				// }
			} )
		} );
		function unhook ()
		{
			hook = false;
		}
		<?php
		if ($tab_active != '') {
			echo '$(".tabNavigation [rel=' . $tab_active . ']").trigger("click");';
		}
		?>

		$( '.modal-remove-note' ).click( function ( e )
		{
			e.preventDefault();
			var href = $( this ).attr( 'href' );
			$( '#modal-note form.form-remove-note' ).attr( 'action', href );
		} );
		$( '#modal-note form.form-remove-note .btn-secondary' ).click( function ( e )
		{
			e.preventDefault();
			$( '#modal-note form.form-remove-note' ).attr( 'action', '' );
		} );

		$( '.js-comment-form' ).each( function ()
		{
			let $form = $( this );

			$( '.js-comment-row' ).each( function ()
			{
				let row = $( this );

				row.find( 'a[href="#editcomment"]' ).on( 'click', function ( e )
				{
					let id = $( this ).data( 'id' ) || 0,
						value = row.find( '.comment_content' ).text();

					if ( id > 0 && value != '' ) {
						let title = 'Bạn đang chỉnh sửa ghi chú - ' + value;

						$form.find( '[name="comment"]' ).val( value ).attr( 'placeholder', title ).attr( 'title', title ).attr( 'data-value', value )
						$form.find( '[name="comment_ID"]' ).val( id );
					}
				} );
			} );

			$( '.comment-box' ).on( "keypress", function ( evt )
			{
				if ( evt.keyCode == 13 ) {
					let box = $( evt.target );

					if ( evt.shiftKey == false && box.val().trim().length > 0 ) {
						evt.preventDefault();

						$form.find( '[type="submit"]' ).trigger( 'click' );
					}
				}
			} ).on( 'input', function ( evt )
			{
				let box = $( evt.target ),
					rows = box.val().split( "\n" ).length;

				if ( rows < 1 ) {
					rows = 1;
				}

				box.attr( 'rows', rows + 1 );
			} );
		} );

		$( '.nickname' ).keyup( updatetxt );
		$( '.fullname' ).keyup( updatetxt );
		$( '.phone_number' ).keyup( updatephone );
		$( '.address-group select.district-select' ).each( function ()
		{
			$( this ).on( 'change', function ()
			{
				$( this ).closest( '.address-group' ).find( '.ward-select' ).removeClass( 'disabled' );
			} );
		} );
		$( document ).on( 'change', '.address_active select', function ()
		{
			$( '.review' ).show();
			//$(this).parents('.address-group').find($('.form-control.address')).val('');
			var selectItem = $( this ).closest( '.address_active' ); // Get the closest select-item div
			var infoIndex = 0; // Get the data-index attribute from select-item
			var city = selectItem.find( '.district-select' ).val(); // Get the city value from select
			var ward = selectItem.find( '.ward-select' ).val(); // Get the ward value from select
			// Update the corresponding .info div based on index
			var infoDiv = $( '.review .info' + infoIndex );
			infoDiv.children( '.city' ).text( city );
			if ( ward ) {
				infoDiv.children( '.ward' ).text( ward + ',' );
			} else {
				infoDiv.children( '.ward' ).text( '' );
			}
		} );

		$( document ).on( 'keyup', '.address_active .address', function ()
		{
			$( '.review' ).show();
			var selectItem = $( this ).closest( '.address_active' ); // Find the closest parent .address-group
			var infoIndex = 0; // Get the index from data attribute
			var address = $( this ).val(); // Get the current value of the address input field
			var infoDiv = $( '.review .info' + infoIndex );
			if ( address ) {
				infoDiv.children( '.address' ).text( address + ',' ); // Update the address text
			} else {
				infoDiv.children( '.address' ).text( '' ); // Clear the address if the input is empty
			}
		} );

		function updatetxt ()
		{
			$( '.review' ).show();
			if ( $( '.nickname' ).val() != '' && $( '.fullname' ).val() != '' ) {
				$( 'input.customer_name' ).val( $( '.fullname' ).val() + ' (' + $( '.nickname' ).val() + ') ' );
				$( 'span.customer_name' ).text( $( '.fullname' ).val() + ' (' + $( '.nickname' ).val() + ') ' );
			}
			if ( $( '.fullname' ).val() == '' ) {
				$( 'input.customer_name' ).val( $( '.nickname' ).val() );
				$( 'span.customer_name' ).text( $( '.nickname' ).val() );
			}
		}

		function updatephone ()
		{
			$( 'span.customer_phone' ).text( $( '.phone_number' ).val() );
		}
		var ass = new Assistant();
		$( '.btn-primary[name="add_post"]' ).on( 'click', function ( e )
		{
			if ( $( '.nickname' ).val() == '' ) {
				$( ".alert.valid-form" ).show();
				$( ".alert.valid-form" ).text( 'Chưa nhập tên tài khoản' );
				$( "html, body" ).animate( { scrollTop: 0 }, 600 );
				return false;
			} else {
				$( ".alert.valid-form" ).hide();
			}
			if ( !ass.checkPhone( $( 'input[type="tel"]' ).val() ) ) {
				// $('input[type="tel"]').addClass('error');
				$( ".alert.valid-form" ).show();
				$( ".alert.valid-form" ).text( "Số điện thoại không đúng định dạng" );
				$( "html, body" ).animate( { scrollTop: 0 }, 600 );
				return false;
			} else {
				$( ".alert.valid-form" ).hide();
				$( 'input[type="tel"]' ).removeClass( 'error' );
			}
			if ( $( '.gender' ).val() == 0 ) {
				$( ".alert.valid-form" ).show();
				$( ".alert.valid-form" ).text( 'Chưa chọn giới tính' );
				$( "html, body" ).animate( { scrollTop: 0 }, 600 );
				e.preventDefault();
				return false;
			} else {
				$( ".alert.valid-form" ).hide();
			}
			$( '.address-group select,.address-group .address' ).each( function ()
			{
				var selectedValues = $( this ).val();
				if ( selectedValues == '' ) {
					$( ".alert.valid-form" ).show();
					$( ".alert.valid-form" ).text( 'Kiểm tra mục địa chỉ' );
					$( "html, body" ).animate( { scrollTop: 0 }, 600 );
					e.preventDefault();
					return false;
				} else {
					$( ".alert.valid-form" ).hide();
				}
			} );
		} );
		$( '.js-list-note' ).each( function ()
		{
			let p = $( this );
			$( '.btn', p ).on( 'click', function ()
			{
				let input = $( 'textarea', p ),
					list = input.val() || '',
					btn = $( this ),
					text = btn.text();
				list = ( list != '' ? list.split( ',' ) : [] ).map( v => v.trim() );
				if ( btn.hasClass( 'active' ) ) {
					let tmp = [];
					list.forEach( function ( v, i )
					{
						if ( v != text ) {
							tmp.push( v );
						}
					} )
					list = tmp;
					btn.removeClass( 'active' );
				} else {
					list.push( text );
					btn.addClass( 'active' );
				}
				input.val( list.join( ", " ) );
			} );
		} );

		var fieldCount = <?php echo count($response_get_location['data']); ?>;
		var maxFields = 5;
		$( document ).on( 'click', '.delete-location-button', function ( e )
		{
			e.preventDefault();
			let btn = $( this ),
				id = parseInt( btn.data( 'id' ) || 0 );
			btn.closest( '.address-group' ).remove(); // Remove only the closest address group
			// fieldCount = fieldCount + 1;
			// console.log('log',fieldCount);
			if ( id > 0 ) {
				let l_d = $( '.location_delete_ids' );
				l_d.val( id + ( l_d.val() != '' ? ',' + l_d.val() : '' ) );
			}
		} );
		// Fetching data from the new API endpoint

	} );
</script>