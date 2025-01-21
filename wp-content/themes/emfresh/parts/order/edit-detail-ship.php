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
                <input type="hidden" class="form-control input-date_start" name="calendar-schedule" value="" />
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
                    <select name="ship_location_id" class="form-control select-location_id input-location_id">
                        <?php
                        foreach ($list_locations as $location) {
                            printf('<option value="%s" %s>%s</option>', $location['id'], 0 == $location['id'] ? 'selected' : '', $location['location_name']);
                        }
                        ?>
                    </select>
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
        <div class="js-note delivery-item">
            <div class="row pt-16 ai-center">
                <div class="col-4">Note shipper theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="note_shipper_by_day" class="form-control note_shipper_by_day">
                </div>
            </div>
            <div class="row pt-16 ai-center">
                <div class="col-4">Note admin theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="note_admin_by_day" class="form-control note_admin_by_day">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-f ai-center pb-16 pt-24 add-new-note">
    <span class="fas fa-plus mr-8"></span> Thêm note giao hàng mới
</div>