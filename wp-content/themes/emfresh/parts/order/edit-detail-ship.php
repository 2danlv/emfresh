<?php
global $em_order, $em_location;

$order_ships = $em_order->get_ships($order_detail);

?>
<div class="card order-card-ship card-no_border">
    <?php     
        $count = 0;    
        if (!empty($order_ships)) { 
        foreach($order_ships as $item) :
            $data = [];
            foreach($item as $key => $value) {
                $data['ship_'. $key] = $value;
            }
            extract($data);
    ?>
    <div class="card-ship-item pl-16 pr-16 pb-32">
        <div class="row delivery-item">
            <div class="col-4">Đặt lịch:</div>
            <div class="col-8">
                <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                    <input type="checkbox" name="ship[<?php echo $count; ?>][loop]" class="input_loop" <?php echo $ship_loop == 'on' ? 'checked' : '' ?>>
                    Lặp lại hàng tuần
                </label>
                <div class="calendar pt-8">
                    <input type="hidden" class="form-control input-date_start" name="ship[<?php echo $count; ?>][calendar]" value="<?php echo !empty($ship_calendar) != '' ? $ship_calendar : ''; ?>" />
                    <input type="text" placeholder="DD/MM/YYYY" class="form-control js-calendar date" value="<?php echo !empty($ship_calendar) ? date("d/m/Y", strtotime($ship_calendar)) : ''; ?>">
                </div>
                <div class="repeat-weekly pt-8">
                    <input type="checkbox" id="monday_<?php echo $count; ?>" hidden name="ship[<?php echo $count; ?>][days][]" value="Thứ Hai" <?php echo in_array('Thứ Hai', $ship_days) ? 'checked' : '' ?>>
                    <label for="monday_<?php echo $count; ?>">Thứ Hai</label>
                    <input type="checkbox" id="tuesday_<?php echo $count; ?>" hidden name="ship[<?php echo $count; ?>][days][]" value="Thứ Ba" <?php echo in_array('Thứ Ba', $ship_days) ? 'checked' : '' ?>>
                    <label for="tuesday_<?php echo $count; ?>"> Thứ Ba</label>
                    <input type="checkbox" id="wednesday_<?php echo $count; ?>" hidden name="ship[<?php echo $count; ?>][days][]" value="Thứ Tư" <?php echo in_array('Thứ Tư', $ship_days) ? 'checked' : '' ?>>
                    <label for="wednesday_<?php echo $count; ?>"> Thứ Tư</label>
                    <input type="checkbox" id="thursday_<?php echo $count; ?>" hidden name="ship[<?php echo $count; ?>][days][]" value="Thứ Năm" <?php echo in_array('Thứ Năm', $ship_days) ? 'checked' : '' ?>>
                    <label for="thursday_<?php echo $count; ?>"> Thứ Năm</label>
                    <input type="checkbox" id="friday_<?php echo $count; ?>" hidden name="ship[<?php echo $count; ?>][days][]" value="Thứ Sáu" <?php echo in_array('Thứ Sáu', $ship_days) ? 'checked' : '' ?>>
                    <label for="friday_<?php echo $count; ?>"> Thứ Sáu</label>
                </div>
            </div>
        </div>
        <div class="row delivery-item pt-16 ai-center">
            <div class="col-4">Địa chỉ giao:</div>
            <div class="col-8">
                <input type="hidden" name="ship[<?php echo $count; ?>][location_id]" class="ship_location_id" value="<?php echo $ship_location_id; ?>">
                <div class="dropdown-address">
                    <div class="dropdown active" style="pointer-events: all;">                    
                        <input type="text" name="ship[<?php echo $count; ?>][location_name]" class="address_delivery is-disabled form-control" value="<?php echo $ship_location_name; ?>" placeholder="Địa chỉ giao hàng">
                    </div>
                    <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
                    <div class="dropdown-menu">
                        <div class="locations-container">
                            <?php foreach ($list_locations as $location) : ?>
                            <div class="item" data-location_id="<?php echo $location['id']; ?>">
                                <p class="fs-16 color-black other-address"><?php echo $location['location_name']; ?></p>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div data-target="#modal-add-address" class="btn-add-address modal-button d-f ai-center pb-8 pt-8 pl-8">
                            <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="delivery-item js-note-ship">
            <div class="row pt-16 ai-center">
                <div class="col-4">Note shipper theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[<?php echo $count; ?>][note_shipper]" value="<?php echo $data['ship_note_shipper']; ?>" class="form-control note_shipper_by_day">
                </div>
            </div>
            <div class="row pt-16 ai-center">
                <div class="col-4">Note admin theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[<?php echo $count; ?>][note_admin]" value="<?php echo $data['ship_note_admin']; ?>" class="form-control note_admin_by_day">
                </div>
            </div>
        </div>
    </div>
    <?php 
    $count++;
    endforeach ;
} else { ?>
    <div class="card-ship-item pl-16 pr-16 pb-32">
        <div class="row delivery-item">
            <div class="col-4">Đặt lịch:</div>
            <div class="col-8">
                <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                    <input type="checkbox" name="ship[0][loop]" class="input_loop">
                    Lặp lại hàng tuần
                </label>
                <div class="calendar pt-8">
                    <input type="hidden" class="form-control input-date_start" name="ship[0][calendar]" value="" />
                    <input type="text" placeholder="DD/MM/YYYY" class="form-control js-calendar date" value="">
                </div>
                <div class="repeat-weekly pt-8">
                    <input type="checkbox" id="monday_0" hidden name="ship[0][days][]" value="Thứ Hai">
                    <label for="monday_0">Thứ Hai</label>
                    <input type="checkbox" id="tuesday_0" hidden name="ship[0][days][]" value="Thứ Ba">
                    <label for="tuesday_0"> Thứ Ba</label>
                    <input type="checkbox" id="wednesday_0" hidden name="ship[0][days][]" value="Thứ Tư">
                    <label for="wednesday_0"> Thứ Tư</label>
                    <input type="checkbox" id="thursday_0" hidden name="ship[0][days][]" value="Thứ Năm">
                    <label for="thursday_0"> Thứ Năm</label>
                    <input type="checkbox" id="friday_0" hidden name="ship[0][days][]" value="Thứ Sáu">
                    <label for="friday_0"> Thứ Sáu</label>
                </div>
            </div>
        </div>
        <div class="row delivery-item pt-16 ai-center">
            <div class="col-4">Địa chỉ giao:</div>
            <div class="col-8">
                <input type="hidden" name="ship[0][location_id]" class="ship_location_id" value="">
                <div class="dropdown-address">
                    <div class="dropdown active" style="pointer-events: all;">                    
                        <input type="text" name="ship[0][location_name]" class="address_delivery is-disabled form-control" value="" placeholder="Địa chỉ giao hàng">
                    </div>
                    <p class="fs-14 fw-regular note-shipper hidden color-gray pt-4 pl-8">Note với shipper: <span class="note_shiper"></span></p>
                    <div class="dropdown-menu">
                        <div class="locations-container">
                        </div>
                        <div data-target="#modal-add-address" class="btn-add-address modal-button d-f ai-center pb-8 pt-8 pl-8">
                            <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="delivery-item js-note-ship">
            <div class="row pt-16 ai-center">
                <div class="col-4">Note shipper theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[0][note_shipper]" value="" class="form-control note_shipper_by_day">
                </div>
            </div>
            <div class="row pt-16 ai-center">
                <div class="col-4">Note admin theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[0][note_admin]" value="" class="form-control note_admin_by_day">
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<div class="d-f ai-center pb-16 pt-24 add-new-note">
    <span class="fas fa-plus mr-8"></span> Thêm yêu cầu giao hàng mới
</div>
<!-- submit add location-->
<script>
$(document).ready(function () {
    let count = $(".card-ship-item").length;
    
    $(".delivery-item .btn-add-address").on('click', function () {
        $('.modal-add-address .show-group-note').hide();
    });
    
    $(".btn-add-address").on('click', function () {
        $('.modal-add-address .alert-warning').hide();
        $('.modal-add-address').find("input,select:not(#province)").each(function () {
            if ($(this).is(":checkbox")) {
                $(this).prop("checked", false);
            } else if ($(this).is("select")) {
                $(this).val("");
            } else {
                $(this).val("");
            }
        });
        $("#district").val(""); 
        $("#ward").html('<option selected="">Phường/Xã*</option>').prop("disabled", true);
    });
    $(".delivery-field .add-new-note").click(function () {
        let newItem = $(".card-ship-item").first().clone();
        newItem.find("input, select, textarea").each(function () {
            let name = $(this).attr("name");
            let id = $(this).attr("id");
            if (name) {
                name = name.replace(/\[0\]/g, "[" + count + "]");
                $(this).attr("name", name);
            }
            if (id) {
                let newId = id + "_" + count;
                $(this).attr("id", newId);
                $(this).next("label").attr("for", newId);
            }
            
            if ($(this).is(":checkbox")) {
                $(this).prop("checked", false);
            } else {
                $(this).val("");
            }
        });
        newItem.find('.repeat-weekly').removeClass('show');
        newItem.find('.js-note-ship').show();
        newItem.find('.js-note-ship').show();
        newItem.find('.note-shipper').addClass('hidden');
        $(".card-ship-item").last().after(newItem);
        newItem.find('.js-calendar.date').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: true,
            autoApply: true,
            minDate: new Date(),
            opens: 'left',
            locale: {
            format: "DD/MM/YYYY",daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            monthNames: [
                "Tháng 1,",
                "Tháng 2,",
                "Tháng 3,",
                "Tháng 4,",
                "Tháng 5,",
                "Tháng 6,",
                "Tháng 7,",
                "Tháng 8,",
                "Tháng 9,",
                "Tháng 10,",
                "Tháng 11,",
                "Tháng 12,",
            ],
            firstDay: 1,
            },
            ranges: {
            'Hôm nay': new Date()
            }
        }).on('show.daterangepicker', function() {
            $(this).data('daterangepicker').container.addClass('daterangepicker-open');
        }).on('hide.daterangepicker', function(ev, picker) {
            $(this).data('daterangepicker').container.removeClass('daterangepicker-open');
            var inputElement = $(this);
            var formattedDate = picker.startDate.format('YYYY-MM-DD');
            var targetInput = inputElement.siblings('.input-date_start');
            targetInput.val(formattedDate);
        }).on('apply.daterangepicker', function(ev, picker) {
            var inputElement = $(this);
            var today = $('.js-calendar.date').val();
            var formattedDate = picker.startDate.format('YYYY-MM-DD');
            var targetInput = inputElement.siblings('.input-date_start');
            targetInput.val(formattedDate);
            if (today == moment().format('DD/MM/YYYY')) {
            $(".toast").addClass("show");
            }
            showdate();
        });
        newItem.find('.js-calendar.date').val('');
        count++;
});
$('.modal-add-address .add-address').on('click', function (e) {
        e.preventDefault();
        let customerId = $('.input-customer_id').val();
        let address = $('.modal-add-address .address').val();
        let ward = $('.modal-add-address #ward').val();
        let district = $('.modal-add-address #district').val();
        let city = $('.modal-add-address #province').val();
        let noteShipper = $('.modal-add-address .locations_note_shipper').val();
        let noteAdmin = $('.modal-add-address .locations_note_admin').val();
        let locations_active = $('.modal-add-address .location_active').prop('checked') ? 1 : 0;
        if (!district || !ward || !address ) {
            $('.modal-add-address .alert-warning').show();
            return;
        }
        $.post('<?php echo home_url('em-api/location/add'); ?>', {
            'customer_id': customerId,
            'address': address,
            'ward': ward,
            'district': district,
            'city': city,
            'note_shipper': noteShipper,
            'note_admin': noteAdmin,
            'active':locations_active
        }, function (res) {
            // console.log('location.add.res', res);

            if (res.code == 200) {
                res.data.insert_id;
                let insertId = res.data.insert_id;
                let delivery_newLocationHTML = `
                    <div class="item" data-location_id="${res.data.insert_id}">
                        <p class="fs-16 color-black other-address">${address}, ${ward}, ${district}</p>
                    </div>
                `;
                let customer_newLocationHTML = `<div class="item" data-location_id="${res.data.insert_id}">
                                <p class="fs-16 color-black other-address">${address}, ${ward}, ${district}</p>
                                <div class="group-management-link d-f jc-b ai-center pt-8">
                                    <div class="tooltip d-f ai-center">
                                        <p class="fs-14 fw-regular color-gray">(Đã đăng ký chung nhóm ship: Thien Phuong Bui)</p>
                                        <p class="note_shiper hidden">${noteShipper}</p>
                                        <p class="note_admin hidden">${noteAdmin}</p>
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
                            </div>`;
                $('.delivery-item .locations-container').append(delivery_newLocationHTML);
                $('.input-order .locations-container').append(customer_newLocationHTML);
                $('.modal').removeClass('is-active');
		        $('body').removeClass('overflow');
            } else {
                alert("Lỗi: " + res.message);
            }
        }, 'json');
    });
});

// $.post('<?php echo home_url('em-api/location/add'); ?>', {
//     'customer_id'   : 0,
//     'address'       : '',
//     'ward'          : '',
//     'district'      : '',
//     'city'          : '',
//     'note_shipper'  : '',
//     'note_admin'    : '',
// }, function(res){
//     console.log('location.add.res', res);

//     if(res.code == 200) {
//         res.data.insert_id;
//     }
// });

</script>
