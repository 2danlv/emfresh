<div class="card rounded-b-r">
    <div class="box-search">
        <input class="search-cus mb-16" id="search" placeholder="Tìm khách hàng bằng tên / SĐT" type="text">
        <div class="search-result">
            <div class="no-results active">
                <img class="pt-18 pb-8" src="<?php site_the_assets(); ?>/img/icon/no-results.svg" alt="">
                <p class="color-gray fs-12 fw-regular pb-8">Không tìm thấy SĐT phù hợp</p>
                <p class="color-gray fs-12 fw-regular pb-16">Hãy thử thay đổi từ khoá tìm kiếm hoặc thêm khách hàng mới với SĐT này</p>
                <a href="/customer/add-customer/" class="btn-add-customer">
                    <span class="d-f ai-center"><i class="fas mr-4"><img src="<?php site_the_assets(); ?>img/icon-hover/plus-svgrepo-com_white.svg" alt=""></i>Thêm khách hàng mới với SĐT này</span>
                </a>
            </div>
            <div class="results" id="autocomplete-results"></div>
        </div>
    </div>
    <div class="row input-order">
        <div class="col-8 pb-16">
            <input type="text" name="nickname" class="fullname is-disabled form-control" maxlength="50" placeholder="Tên khách hàng">
        </div>
        <div class="col-4 pb-16">
            <input type="text" name="phone" class="phone is-disabled form-control" maxlength="50" placeholder="SĐT">
        </div>
        <div class="col-12 pb-32 dropdown-address">
            <div class="dropdown active">
                <input type="text" name="address_delivery" class="address_delivery is-disabled form-control" maxlength="50" placeholder="Địa chỉ giao hàng">
            </div>
            <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
            <div class="dropdown-menu">
                <div class="item active">
                    <p class="fs-16 color-black other-address">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</p>
                    <div class="group-management-link d-f jc-b ai-center pt-8">
                        <div class="tooltip d-f ai-center">
                            <p class="fs-14 fw-regular color-gray">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                            <p class="note_shiper hidden">gửi lễ tân/bảo vệ rồi nhắn tin khách</p>
                            <span class="fas tooltip-icon fa-info-gray"></span>
                            <div class="tooltip-content">
                                <div class="close fas fa-trash"></div>
                                <ul>
                                    <li>Thien Phuong Bui</li>
                                    <li>Dieu Linh (zalo)</li>
                                    <li>Nguyen Hai Minh Thi</li>
                                    <li>Dinh Thi Hien Ly</li>
                                </ul>
                            </div>
                        </div>
                        <a class="management-link" href="#">Đi đến Quản lý nhóm</a>
                    </div>
                </div>
                <div class="item">
                    <p class="fs-16 color-black other-address">45 Hoa Lan, Phường 3, Quận Phú Nhuận</p>
                </div>
                <div data-target="#modal-add-address-1" class="btn-add-address modal-button d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                </div>
            </div>
        </div>
    </div>
    <h3 class="card-title title-order d-f ai-center">
        <span class="fas fa-clock mr-8"></span>
        Đơn hàng gần đây
    </h3>
    <div class="history-order">
        <div class="no-history show">
            <img src="<?php site_the_assets(); ?>/img/icon/cart.svg" alt="">
            <div class="pt-8 color-gray fs-12 fw-regular">Chưa có lịch sử mua hàng</div>
        </div>
        <div class="history">
            <details class="history-item using">
                <summary class="d-f jc-b ai-center history-header">
                    <div class="d-f ai-center history-id gap-8">
                        <span class="fas fa-dropdown"></span>
                        <span class="number">123456</span>
                    </div>
                    <div class="d-f history-status gap-16">
                        <span class="status_order">Đang dùng</span>
                        <span class="copy"></span>
                    </div>
                </summary>
                <div class="history-content">
                    <div class="info">
                        <div class="d-f ai-center gap-10 address">
                            <span class="fas fa-location"></span>
                            <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                        </div>
                        <p class="color-gray-2 fs-14 fw-regular pl-26 pt-8">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                        <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt">2EM+1PM+1EP</span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt-green fw-bold ">400.000</span>
                        </div>
                    </div>
                    <div class="note">
                        <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                            <div class="d-f ai-center gap-10">
                                <span class="fas fa-note"></span>
                                <span class="txt">Yêu cầu đặc biệt:</span>
                            </div>
                            <span class="txt">Note rau củ: cà rốt, bí đỏ, củ dền, bí ngòi</span>
                        </div>
                        <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                            <div class="d-f ai-center gap-10">
                                <span class="fas fa-note"></span>
                                <span class="txt">Giao hàng:</span>
                            </div>
                            <span class="txt">Thứ 3 - Thứ 5: 45 Hoa Lan, Phường 3, Quận Phú Nhuận</span>
                        </div>
                    </div>
                </div>
            </details>
            <details class="history-item">
                <summary class="d-f jc-b ai-center history-header">
                    <div class="d-f ai-center history-id gap-8">
                        <span class="fas fa-dropdown"></span>
                        <span class="number">123456</span>
                    </div>
                    <div class="d-f history-status gap-16">
                        <span class="status_order">Hoàn tất</span>
                        <span class="copy"></span>
                    </div>
                </summary>
                <div class="history-content">
                    <div class="info">
                        <div class="d-f ai-center gap-10 address">
                            <span class="fas fa-location"></span>
                            <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt">2EM+1PM+1EP</span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt-green fw-bold ">400.000</span>
                        </div>
                    </div>
                </div>
            </details>
            <details class="history-item">
                <summary class="d-f jc-b ai-center history-header collapsed">
                    <div class="d-f ai-center history-id gap-8">
                        <span class="fas fa-dropdown"></span>
                        <span class="number">123456</span>
                    </div>
                    <div class="d-f history-status gap-16">
                        <span class="status_order">Hoàn tất</span>
                        <span class="copy"></span>
                    </div>
                </summary>
                <div class="history-content">
                    <div class="info">
                        <div class="d-f ai-center gap-10 address">
                            <span class="fas fa-location"></span>
                            <span class="txt">44L đường số 11, KDC Miếu Nổi, Phường 3, Quận Bình Thạnh</span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt">2EM+1PM+1EP</span>
                        </div>
                        <div class="d-f ai-center gap-10 pt-8">
                            <span class="fas fa-shopping-cart"></span>
                            <span class="txt-green fw-bold ">400.000</span>
                        </div>
                    </div>
                </div>
            </details>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    $('.search-cus').keyup(function() {
        var query = $(this).val();
        if (query.length > 2) {  
            $.ajax({
                url: '<?php echo home_url('em-api/customer/list/'); ?>',  
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var suggestions = '';
                    var results = response.data.filter(function(customer) {
                        return customer.customer_name.toLowerCase().includes(query.toLowerCase()) ||
                               customer.phone.includes(query)
                    });

                    if (results.length > 0) {
                        suggestions = results.map(customer => 
                            `<div class="result-item" data-id="${customer.id}">
                                <p class="name">${customer.customer_name}</p>
                                <p class="color-black fs-14 fw-regular phone pt-8 pb-8">${customer.phone}</p>
                                <p class="color-black fs-14 fw-regular address">${customer.address + ' ' + customer.ward + ' ' + customer.district }</p>
                                <p class="note_shiper hidden">${customer.note_shipping}</p>
                            </div>`
                        ).join("\n");
                        
                        $('#autocomplete-results').html(suggestions).show();
                        $('.detail-customer.order .search-result .no-results,.history-order .history,.history-order .no-history').hide();
                        $('.detail-customer.order .search-result .results,.title-order,.history-order').show();
                        $(".dropdown").css("pointer-events", "all");
                    } else {
                        $('#autocomplete-results').hide();
                        $('.detail-customer.order .search-result .no-results').show();
                        $('.detail-customer.order .title-order,.detail-customer.order .history-order,.detail-customer.order .search-result .results').hide();
                        $(".dropdown").css("pointer-events", "none");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data from API');
                    $('#autocomplete-results').hide();
                }
            });
        } else {
            $('#autocomplete-results').hide();  
        }
    });

    
    $(document).on('click', '.result-item', function() {
        var name = $(this).find('.name').text();
        var phone = $(this).find('.phone').text();
        var address = $(this).find('.address').text();
        var note_shiper = $(this).find('.note_shiper').text();
        var customer_id = $(this).data('id') || 0;

        $('#search').val(name); 
        $('.input-order .fullname').val(name); 
        $('.input-order .phone').val(phone); 
        $('.input-order .address_delivery').val(address);
        $('.input-order .note_shiper').val(note_shiper);
        $('.result').show(); 
        $('#autocomplete-results,.no-result').hide();
        
        $('.input-customer_id').val(customer_id);
        $('.input-location_name').val(address);
        if(customer_id > 0) {
            $.ajax({
                url: '<?php echo home_url('em-api/location/list/'); ?>?customer_id=' + customer_id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('location', response.data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data from API', error);
                }
            });
        }
    });

    
    $(document).click(function(e) {
        if (!$(e.target).closest('#search').length) {
            $('#autocomplete-results').hide();
        }
    });
});
</script>
