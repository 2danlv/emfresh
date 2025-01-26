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
                <p class="txt"><?php echo $order_detail['customer_name'] ?></p>
                <p class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $order_detail['phone'] ?>"><?php echo $order_detail['phone'] ?></p>
                <p class="txt ellipsis"><?php echo $detail_local; ?></p>
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