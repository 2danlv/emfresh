<div class="modal fade modal-add-address" id="modal-add-address">
    <div class="overlay"></div>
    <div class="modal-content customer">
        <div class="d-f ai-center gap-10 tlt">
            <span class="fas fa-location"></span>
            <span>Địa chỉ</span>
        </div>
        <div class="alert alert-warning mt-16 mb-8">Chưa nhập địa chỉ</div>
        <form method="post" id="customer-form" action="">
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
                <div class="col-12 pb-16">
                    <hr>
                    <div class="row pt-16">
                        <div class="col-6">
                            <div class="icheck-primary d-f ai-center">
                                <input type="checkbox" name="location_active" id="location_active" class="location_active" value="1">
                                <label class="pl-4" for="location_active">
                                    Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-footer d-f jc-e pb-8 pt-16">
            <button type="button" class="btn btn-secondary modal-close">Huỷ</button>
            <button type="submit" class="btn btn-primary add-address">Áp dụng</button>
        </div>
    </div>
</div>

<div class="modal fade modal-warning" id="modal-remove-tab">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-body pt-8 pb-16">
                    <input type="hidden" class="customer_id" name="customer_id" value="">
                    <div class="d-f">
                        <i class="fas fa-warning mr-4"></i>
                        <p>Bạn có chắc muốn xoá sản phẩm đang thực hiện trên đơn hàng này không?</p>
                    </div>
                </div>
                <div class="modal-footer d-f jc-b pb-8">
                    <button type="button" class="btn btn-secondary modal-close">Đóng</button>
                    <button type="button" name="remove" class="btn btn-danger js-remove-order-item modal-close">Xóa</button>
                </div>
        </div>
    </div>
</div>

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
					<a href="<?php echo $delete_url; ?>" class="btn btn-danger modal-close">Xóa</a>
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