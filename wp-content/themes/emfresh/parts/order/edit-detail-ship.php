<?php
global $em_order, $em_location;

$default_params = [
    'loop' => '',
    'calendar' => '',
    'days' => [],
    'location_id' => 0,
    'location_name' => '',
    'note_shipper' => '',
    'note_admin' => '',
];

$order_ships = [];

if(!empty($order_detail['params'])) {
    $data_params = unserialize($order_detail['params']);

    if(isset($data_params['ship'])) {
        $list_ship = $data_params['ship'];

        if(isset($list_ship['location_id'])) {
            $order_ships[] = shortcode_atts($default_params, $list_ship);
        } else if(count($list_ship) > 0 && isset($list_ship[0]['location_id'])) {
            foreach($list_ship as $item) {
                $order_ships[] = shortcode_atts($default_params, $item);
            }
        }
    
        // var_dump($list_ship, $order_ships);
    }
}

if(count($order_ships) == 0) {
    $order_ships[] = $default_params;
}

?>
<div class="card card-no_border">
    <?php         
        foreach($order_ships as $item) :

            $data = [];

            foreach($item as $key => $value) {
                $data['ship_'. $key] = $value;
            }

            extract($data);

            if($ship_location_id > 0) {
                $ship_location_name = $em_location->get_fullname($ship_location_id);
            }
    ?>
    <div class="pl-16 pr-16">
        <div class="row delivery-item">
            <div class="col-4">Đặt lịch:</div>
            <div class="col-8">
                <label for="loop" class="d-f ai-center gap-12 pb-8 loop">
                    <input type="checkbox" name="ship[0][loop]" id="loop" <?php echo $ship_loop == 'on' ? 'checked' : '' ?>>
                    Lặp lại hàng tuần
                </label>
                <div class="calendar">
                    <input type="hidden" class="form-control input-date_start" name="ship[0][calendar]" value="<?php echo !empty($ship_calendar) != '' ? $ship_calendar : ''; ?>" />
                    <input type="text" placeholder="DD/MM/YYYY" class="form-control js-calendar date" value="<?php echo !empty($ship_calendar) ? date("d/m/Y", strtotime($ship_calendar)) : ''; ?>">
                </div>
                <div class="repeat-weekly">
                    <input type="checkbox" id="monday" hidden name="ship[0][days][]" value="monday" <?php echo in_array('monday', $ship_days) ? 'checked' : '' ?>>
                    <label for="monday">Thứ Hai</label>
                    <input type="checkbox" id="tuesday" hidden name="ship[0][days][]" value="tuesday" <?php echo in_array('tuesday', $ship_days) ? 'checked' : '' ?>>
                    <label for="tuesday"> Thứ Ba</label>
                    <input type="checkbox" id="wednesday" hidden name="ship[0][days][]" value="wednesday" <?php echo in_array('wednesday', $ship_days) ? 'checked' : '' ?>>
                    <label for="wednesday"> Thứ Tư</label>
                    <input type="checkbox" id="thursday" hidden name="ship[0][days][]" value="thursday" <?php echo in_array('thursday', $ship_days) ? 'checked' : '' ?>>
                    <label for="thursday"> Thứ Năm</label>
                    <input type="checkbox" id="friday" hidden name="ship[0][days][]" value="friday" <?php echo in_array('friday', $ship_days) ? 'checked' : '' ?>>
                    <label for="friday"> Thứ Sáu</label>
                </div>
            </div>
        </div>
        <div class="row delivery-item pt-24 ai-center">
            <div class="col-4">Địa chỉ giao:</div>
            <div class="col-8">
                <input type="hidden" name="ship[0][location_id]" class="ship_location_id" value="<?php echo $ship_location_id; ?>">
                <div class="dropdown-address">
                    <div class="dropdown active" style="pointer-events: all;">                    
                        <input type="text" name="ship[0][location_name]" class="address_delivery is-disabled form-control" value="<?php echo $ship_location_name; ?>" placeholder="Địa chỉ giao hàng">
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
                        <div data-target="#modal-add-address-1" class="btn-add-address modal-button d-f ai-center pb-8 pt-8 pl-8">
                            <span class="fas fa-plus mr-8"></span>Thêm địa chỉ mới
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="js-note delivery-item">
            <div class="row pt-16 ai-center">
                <div class="col-4">Note shipper theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[0][note_shipper]" class="form-control note_shipper_by_day">
                </div>
            </div>
            <div class="row pt-16 ai-center">
                <div class="col-4">Note admin theo ngày:</div>
                <div class="col-8">
                    <input type="text" name="ship[0][note_admin]" class="form-control note_admin_by_day">
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>
<div class="d-f ai-center pb-16 pt-24 add-new-note">
    <span class="fas fa-plus mr-8"></span> Thêm yêu cầu giao hàng mới
</div>
<!-- submit add location
<script>

$.post('<?php echo home_url('em-api/location/add'); ?>', {
    'customer_id'   : 0,
    'address'       : '',
    'ward'          : '',
    'district'      : '',
    'city'          : '',
    'note_shipper'  : '',
    'note_admin'    : '',
}, function(res){
    console.log('location.add.res', res);

    if(res.code == 200) {
        res.data.insert_id;
    }
});

</script>
-->