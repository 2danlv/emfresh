<?php

$js_duplicate_url = add_query_arg(['dupnonce' => wp_create_nonce('dupnonce')], get_permalink());

?>
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
            <input type="text" name="nickname" class="fullname is-disabled form-control" placeholder="Tên khách hàng">
        </div>
        <div class="col-4 pb-16">
            <input type="text" name="phone" class="phone is-disabled form-control" placeholder="SĐT">
        </div>
        <div class="col-12 pb-16">
            <input type="text" class="name_2nd form-control" placeholder="Tên người nhận">
        </div>
        <div class="col-12 pb-32 dropdown-address">
            <div class="dropdown active">
                <input type="text" name="address_delivery" class="address_delivery is-disabled form-control" placeholder="Địa chỉ giao hàng">
            </div>
            <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
            <p class="fs-14 fw-regular note-admin hidden color-gray pt-4 pl-8">Note với admin: <span class="note_admin"></span></p>
            <div class="dropdown-menu">
                <div class="locations-container"></div>
                <div data-target="#modal-add-address" class="btn-add-address modal-button d-f ai-center pb-16 pt-8 pl-8">
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
    $('.input-order .name_2nd').keyup(function() {
        var input_name_2nd = $(this).val();
        var input_fullname = $('.input-order .fullname').val();
        var split_fullname = input_fullname.match(/\((.*?)\)/);
        if (split_fullname && input_name_2nd !='') {
            $('.info-customer .customer-name_2nd').addClass('pt-8');
            $('.form-add-order .input-customer_name_2nd').val(input_name_2nd + " " + split_fullname[0]);
            $('.info-customer .customer-name_2nd').text(input_name_2nd + " " + split_fullname[0]);
        } else {
            $('.info-customer .customer-name_2nd').removeClass('pt-8');
            $('.form-add-order .input-customer_name_2nd').val(input_name_2nd);
            $('.info-customer .customer-name_2nd').text(input_name_2nd);
        }
    });
    $('.search-cus').keyup(function() {
        var query = $(this).val();
        $('.no-results .btn-add-customer').attr('href', '/customer/add-customer/?phone='+query);
        if (query.length > 2) {  
            $.ajax({
                url: '<?php echo home_url('em-api/customer/list/?limit=-1'); ?>',  
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
                                <p class="note_shiper hidden">${customer.note_shipper}</p>
                                <p class="note_admin hidden">${customer.note_admin}</p>
                            </div>`
                        ).join("\n");
                        
                        $('#autocomplete-results').html(suggestions).show();
                        $('.detail-customer.order .search-result .no-results,.history-order .history,.history-order .no-history').hide();
                        $('.detail-customer.order .search-result .results,.title-order,.history-order').show();
                        $(".input-order .dropdown").css("pointer-events", "all");
                    } else {
                        $('#autocomplete-results').hide();
                        $('.detail-customer.order .search-result .no-results').show();
                        $('.detail-customer.order .title-order,.detail-customer.order .history-order,.detail-customer.order .search-result .results').hide();
                        $(".input-order .dropdown").css("pointer-events", "none");
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
    
    $(document).on('click', '.results .result-item', function() {
        var name = $(this).find('.name').text();
        var phone = $(this).find('.phone').text();
        var address = $(this).find('.address').text();
        var note_shiper = $(this).find('.note_shiper').text();
        var note_admin = $(this).find('.note_admin').text();
        var customer_id = $(this).data('id') || 0;
        var location_id = 0;
        $('.form-add-order .input-customer_name_2nd,.input-order .name_2nd').val("");
        $('.info-customer .customer-name_2nd').text("");
        $('#search').val(name); 
        $('.input-order .fullname').val(name); 
        $('.input-order .phone').val(phone);
        $('.input-order .address_delivery').val(address);
        $('.info-customer .customer-name').text(name);
        $('.info-customer .customer-phone').text(phone);
        $('.info-customer .customer-address').text(address);
        if(note_shiper.length != 0) {
            $('.input-order .note-shipper').removeClass('hidden');
            $(".input-order .note-shipper .note_shiper").text(note_shiper);
            $('.form-add-order .note_shiper').val(note_shiper);
        } else {
            $('.input-order .note-shipper').addClass('hidden');
            $('.form-add-order .note_shiper').val('');
        }
        if(note_admin.length != 0) {
            $('.input-order .note-admin').removeClass('hidden');
            $(".input-order .note-admin .note_admin").text(note_admin);
            $('.form-add-order .note_admin').val(note_admin);
        } else {
            $('.input-order .note-admin').addClass('hidden');
            $('.form-add-order .note_admin').val('');
        }
        $('.result,.info-customer').show(); 
        $('#autocomplete-results,.no-result').hide();
        
        $('.input-customer_id').val(customer_id);
        $('.input-location_name').val(address);

        if(customer_id > 0) {
            getLocation(customer_id,location_id);

            // Don hang gan day
            $.ajax({
                url: '<?php echo home_url('em-api/order/list/'); ?>?customer_id=' + customer_id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log('don hang', response.data);
                    let container = document.getElementById('order-container');
                    container.innerHTML = '';
                    if(response.data == ''){
                        $('.history-order .no-history').show();
                        return;
                    }
                    response.data.forEach((order, index) => {
                        let locationName = order.location_name;
                        let locationInParams = locationName;
                        let schedule = "Không có thông tin";

                        try {
                            
                            let locationInParamsMatch = order.params.match(/s:\d+:"location_name";s:\d+:"(.*?)";/);
                            if (locationInParamsMatch && locationInParamsMatch.length > 1) {
                                locationInParams = locationInParamsMatch[1]; 
                            }

                            
                            let daysMatch = order.params.match(/s:\d+:"days";a:\d+:\{(.*?)\}/);
                            let calendarMatch = order.params.match(/s:\d+:"calendar";s:\d+:"(.*?)";/);

                            let days = "";
                            let calendar = "";

                            
                            if (daysMatch && daysMatch.length > 1) {
                                days = daysMatch[1]
                                    .replace(/i:\d+;/g, "")
                                    .replace(/s:\d+:"/g, "")
                                    .replace(/";/g, ", ")
                                    .slice(0, -2); 
                            }

                            
                            if (calendarMatch && calendarMatch.length > 1) {
                                calendar = calendarMatch[1];
                            }

                            
                            if (calendar && calendar !== "") {
                                schedule = `${moment(calendar).format('DD/MM/YYYY')}`; 
                            } else if (days && days !== "") {
                                schedule = `${days}`; 
                            }
                        } catch (error) {
                            console.error("Lỗi xử lý params:", error);
                        }

                        
                        let orderHtml = `
                            <details class="history-item using">
                                <summary class="d-f jc-b ai-center history-header header_${order.status}">
                                    <div class="d-f ai-center history-id gap-8">
                                        <span class="fas fa-dropdown"></span>
                                        <span class="number">${order.order_number}</span>
                                    </div>
                                    <div class="d-f history-status gap-16">
                                        <span class="status_order">${order.status_name}</span>
                                        <a href="<?php echo $js_duplicate_url; ?>&duplicate_order=${order.order_number}" target="_blank"><span class="copy"></span></a>
                                    </div>
                                </summary>
                                <div class="history-content">
                                    <div class="info">
                                        <div class="d-f ai-center gap-10 address">
                                            <span class="fas fa-location"></span>
                                            <span class="txt">${locationName}</span>
                                        </div>
                                        <div class="d-f ai-center gap-10 pt-8 purchase-summary">
                                            <span class="fas fa-shopping-cart"></span>
                                            <span class="txt">${order.item_name}</span>
                                        </div>
                                        <div class="d-f ai-center gap-10 pt-8">
                                            <span class="fas fa-shopping-money"></span>
                                            <span class="txt-green fw-bold">${format_money(order.total_amount.toLocaleString())}</span>
                                        </div>
                                    </div>
                                    <div class="note-group">
                        `;

                        
                        if (order.note && order.note !== '') {
                            orderHtml += `
                                <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                                    <div class="d-f ai-center gap-10">
                                        <span class="fas fa-note"></span>
                                        <span class="txt">Yêu cầu đặc biệt:</span>
                                    </div>
                                    <span class="txt">${order.note}</span>
                                </div>`;
                        }

                        
                        if (locationInParams && locationInParams !== '') {
                            orderHtml += `
                                <div class="note">
                                    <div class="note-item d-f jc-b ai-center gap-10 pt-8">
                                        <div class="d-f ai-center gap-10">
                                            <span class="fas fa-note"></span>
                                            <span class="txt">Giao hàng:</span>
                                        </div>
                                        <span class="txt">${schedule} - ${locationInParams}</span>
                                    </div>
                                </div>`;
                        }

                        orderHtml += `</div></div></details>`;

                        
                        $(container).append(orderHtml);

                        
                        let noteGroup = $(container).find('.note-group').last();  
                        if (!noteGroup.text().trim()) { 
                            noteGroup.addClass('empty');
                        }
                        if (index < 3) {
                            $(container).find('details.history-item').eq(index).attr('open', true);
                        }
                    });

                    var maxDateStop = response.data.reduce(function (maxDate, item) {
                        return (new Date(item.date_stop) > new Date(maxDate)) ? item.date_stop : maxDate;
                    }, "1970-01-01");
                    
                    $('.toast.warning .order_date_stop').text(maxDateStop);
                    // $('.toast.warning .order_date_stop_show').text(moment(maxDateStop).format('DD/MM/YYYY'));
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data from API', error);
                }
            });
        }
    });
function format_money(number) {
	number = parseFloat(number); 
	if (isNaN(number)) return '0';
	return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').split('.')[0];
}
    $(document).click(function(e) {
        if (!$(e.target).closest('#search').length) {
            $('#autocomplete-results').hide();
        }
    });
});

</script>
