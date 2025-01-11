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
						<a class="btn btn-primary btn-add_order" href="#"><span class="d-f ai-center"><i class="fas mr-4"><img
										src="<?php echo site_get_template_directory_assets(); ?>img/icon-hover/plus-svgrepo-com_white.svg" alt=""></i>Tạo đơn mới</span></a>
						<span class="btn btn-primary btn-disable btn-save_edit hidden">Lưu thay đổi</span>
					</div>
				</div>
				<div class="card-header">
					<ul class="nav tab-nav tabNavigation pt-16">
						<li class="nav-item selected" rel="info">Thông tin khách hàng</li>
						<li class="nav-item" rel="note">Ghi chú</li>
						<li class="nav-item" rel="settings-product">Chỉnh sửa thông tin</li>
						<li class="nav-item" rel="history">Lịch sử thao tác</li>
					</ul>
				</div>
			</div>
			<div class="card-primary">
				<!-- Content Header (Page header) -->
				<h1 class="pt-8">#12345</h1>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane" id="info">
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="note">
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="settings-product">
							<div class="card row row32">
								<div class="col-4">
									<!-- About Me Box -->
									<div class="card">
										<!-- /.card-header -->
										<div class="card-body">
											<div class="ttl">
												Thông tin đơn hàng
											</div>
											<div class="info-customer line-dots">
												<p class="pt-16">Linh (Nu Kenny)</p>
												<p class="copy modal-button pt-8" data-target="#modal-copy" title="Copy: 0909739506">0909739506</p>
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
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
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
											<div class="tab-add-product d-f" id="tabNav">
												<button class="d-f jc-b ai-center gap-8 btn btn-add_order tab-button active" data-tab="tab-1">Sản phẩm 1 <span class="remove-tab"></span></button>
												<button class="add-tab" id="addTabButton"></button>
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
																			<label class="auto-fill-checkbox">
																				<input type="checkbox">
																				<span class="slider"></span>
																			</label>
																			<span class="fs-16 color-gray">Tự chọn món</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="special-request pt-16">
																<div class="special-item row">
																	<div class="col-4">
																		<select id="district_0" name="locations[0][district]" class="district-select form-control">
																			<option value="Note rau củ" selected>Note rau củ</option>
																			<option value="Note tinh bột">Note tinh bột</option>
																			<option value="Note nước sốt">Note nước sốt</option>
																			<option value="Note khác">Note khác</option>
																			<option value="Note đính kèm">Note đính kèm</option>
																			<option value="Phân loại yêu cầu">Note tinh bột</option>
																		</select>
																	</div>
																	<div class="col-8">
																		<div class="tag-container" id="tagContainer">
																			<input type="text" class="form-control tag-input" id="tagInput">
																		</div>
																	</div>
																</div>
															</div>
															<div class="d-f ai-center pt-20 clone-note">
																<span class="fas fa-plus mr-8"></span>Thêm yêu cầu phần ăn đặc biệt
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane tab-pane-2" id="detail-pay">pay</div>
									<div class="tab-pane tab-pane-2" id="detail-delivery">pay</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="history">
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

// endwhile;
get_footer('customer');
?>
<script src="<?php site_the_assets(); ?>js/assistant.js"></script>
<script src="<?php site_the_assets(); ?>js/location.js"></script>
<script src="<?php site_the_assets(); ?>js/order.js"></script>
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