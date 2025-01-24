<div class="card card-no_border">
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
                <input type="text" name="address_delivery" class="address_delivery is-disabled form-control" placeholder="Địa chỉ giao hàng">
            </div>
            <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
            <div class="dropdown-menu">
                <div class="locations-container"></div>
                <div data-target="#modal-add-address-1" class="btn-add-address modal-button d-f ai-center pb-16 pt-8 pl-8">
                    <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                </div>
            </div>
        </div>
    </div>
    <?php include get_template_directory() . '/parts/order/customer-history.php'; ?>
    
</div>
<script>
$(document).ready(function() {

    $('.js-show-order-item:first .remove-tab').addClass("hidden");

    $('.search-cus').keyup(function() {
        var query = $(this).val();
        if (query.length > 2) {  
            $.ajax({
                url: '<?php echo home_url('em-api/customer/list/'); ?>',  
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    //console.log('customer', response.data);
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
                                <p class="color-black fs-14 fw-regular address">${customer.address + ', ' + customer.ward + ', ' + customer.district }</p>
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
        var location_id = 0;

        $('#search').val(name); 
        $('.input-order .fullname').val(name); 
        $('.input-order .phone').val(phone);
        $('.address_delivery').val(address);
        $('.info-customer .customer-name').text(name);
        $('.info-customer .customer-phone').text(phone);
        $('.info-customer .customer-address').text(address);
        if(note_shiper.length != 0) {
            $('.note-shipper').removeClass('hidden');
        } else {
            $('.note-shipper').addClass('hidden');
        }
        $('.input-order .note_shiper').val(note_shiper);
        $('.result,.info-customer').show(); 
        $('#autocomplete-results,.no-result').hide();
        
        $('.input-customer_id').val(customer_id);
        $('.input-location_name').val(address);

        if(customer_id > 0) {
            $.ajax({
                url: '<?php echo home_url('em-api/location/list/'); ?>?customer_id=' + customer_id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const container = $('.locations-container');
                    container.empty();
                    // console.log('location', response.data);
                    
                    response.data.forEach(location => {
                        if(location.active == 1 && location_id == 0) {
                            location_id = location.id;

                            $('.input-location_id').val(location_id);
                        }

                        const template = `
                            <div class="item" data-location_id="${location.id}">
                                <p class="fs-16 color-black other-address">${location.location_name}</p>
                                <div class="group-management-link d-f jc-b ai-center pt-8">
                                    <div class="tooltip d-f ai-center">
                                        <p class="fs-14 fw-regular color-gray">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                                        <p class="note_shiper hidden">${location.note_shipper}</p>
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
                        `;
                        container.append(template);
                    });
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
