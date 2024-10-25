<?php

global $em_customer;


$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();

$args = [];

if(!empty($_GET['edit'])) {
    $args['id'] = intval($_GET['edit']);
}

$response = em_api_request('customer/item', $args);

?>
<?php
if (isset($_GET['code'])) {
    echo '<div class="alert alert-success mt-3" role="alert">' . $_GET['message'] . '</div>';
}
?>
<form method="post" action="<?php the_permalink() ?>">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">General</h3>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3"><label>Tên khách hàng (*)</label></div>
                        <div class="col-sm-9">
                            <input type="text" name="nickname" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label>Tên đầy đủ</label></div>
                        <div class="col-sm-9"><input type="text" name="fullname" class="form-control"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label>Số điện thoại (*)</label></div>
                        <div class="col-sm-9"><input type="number" name="phone" class="form-control" required></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label>Giới tính (*)</label></div>
                        <div class="col-sm-9">
                            <?php
                            foreach ($gender as $key => $value) { ?>
                                <div class="icheck-primary d-inline mr-2">
                                    <input type="radio" id="radioPrimary<?php echo $key; ?>" value="<?php echo $key; ?>" name="gender" required>
                                    <label for="radioPrimary<?php echo $key; ?>">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="location-fields">
                        <div class="address-group">
                            <div class="form-group row">
                                <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
                                <div class="col-sm-9">
                                    <input id="address_0" class="form-control" name="address" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="province_0">Tỉnh/Thành phố:</label>

                                </div>
                                <div class="col-sm-9">
                                    <select id="province_0" name="locations[0][province]" class="province-select form-control">
                                        <option value="">Select Tỉnh/Thành phố</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="district_0">Quận/Huyện:</label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="district_0" name="locations[0][district]" class="district-select form-control" disabled>
                                        <option value="">Select Quận/Huyện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="ward_0">Phường/Xã:</label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="ward_0" name="locations[0][ward]" class="ward-select form-control" disabled>
                                        <option value="">Select Phường/Xã</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Ghi chú đặc biệt</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3"><label>Ghi chú đặc biệt</label></div>
                        <div class="col-sm-9"><textarea name="note" class="form-control" rows="4"></textarea></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                        <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select" required>
                                <option selected disabled>Select one</option>
                                <?php
                                foreach ($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                        <div class="col-sm-9"><select class="form-control" name="tag" style="width: 100%;" required>
                                <option selected disabled>Select one</option>
                                <?php
                                foreach ($tag as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                        <div class="col-sm-9"><input type="number" id="inputPoint" name="point" class="form-control"></div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="#" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Add new Customer" name="add_post" class="btn btn-primary float-right">
        </div>
    </div>
</form>