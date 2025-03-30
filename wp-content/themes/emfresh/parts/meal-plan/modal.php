<div class="modal fade modal-warning" id="modal-delete-member">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-8 pb-16">
                <div class="d-f">
                    <i class="fas fa-warning mr-8"></i>
                    <p>Bạn có chắc muốn xoá khách hàng <span></span> ra <br> khỏi nhóm này không?</p>
                    <input type="hidden" class="idMember">
                </div>
            </div>
            <div class="modal-footer d-f jc-b pb-8 pt-16">
                <button type="button" class="btn btn-secondary modal-close">Đóng</button>
                <button type="button" class="btn btn-remove btn-danger modal-close">Xóa</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-addnew_member" id="modal-addnew_member">
        <div class="overlay"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm thành viên</h4>
                </div>
                <div class="modal-body pt-16 pb-16">
                    <div class="card-primary">
                        <p class="col-12 d-none alert alert-warning mb-16 "></p>
                        <div class="card-body">
                            <div class="box-search">
                                <input class="search-cus mb-16 form-control" id="search" value="" placeholder="Tìm khách hàng bằng tên / SĐT" type="text">
                                <div class="group-search-results">
                                    <div class="group-search-autocomplete-results autocomplete-results"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 pb-16">
                                    <input type="hidden" value="" class="input-customer_id">
                                    <input type="text" name="nickname" value="" class="fullname is-disabled form-control" placeholder="Tên khách hàng">
                                </div>
                                <div class="col-4 pb-16">
                                    <input type="tel" name="phone" class="phone is-disabled form-control" value="" placeholder="SĐT">
                                </div>
                                <div class="col-12">
                                    <hr class="dashed pb-16">
                                    <p class="mb-4">Thứ tự</p>
                                </div>
                            </div>
                            <div class="row ai-center jc-b">
                                <div class="col-2">
                                    <p><input type="number" class="form-control no_order"></p>
                                </div>
                                <div class="col-8 text-right">
                                    <div class="d-f ai-center jc-end">
                                        <span class="pt-6 mr-10"><input type="checkbox" class="bag"></span>
                                        <span>Yêu cầu túi riêng</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right pt-16 pb-8 pr-12">
                <button type="button" class="btn btn-secondary modal-close">Huỷ</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>