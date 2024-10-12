<?php

/**
 * Template Name: Detail-customer
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('customer');
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            // Ensure user is logged in (optional - you can use capabilities check instead)
            if (!is_user_logged_in()) {
                echo '<p>You need to log in to edit this content.</p>';
                return;
            }
            $status = $em_customer->get_statuses();
            $gender = $em_customer->get_genders();
            $tag = $em_customer->get_tags();
            // lấy 1 customer
            $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
            if($customer_id == 0) {
                die('customer_id is null!');
              } 
            $customer_filter = [
                'id' => $customer_id
            ];
            $response_customer = em_api_request('customer/item', $customer_filter);
            // lấy danh sách location
            $location_filter = [
                'customer_id' => $customer_id,
                'limit' => 5,
            ];
            $response_get_location = em_api_request('location/list', $location_filter);
            ?>
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="/assets/dist/img/user4-128x128.jpg"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">
                                <?php echo $response_customer['data']['fullname'] ?>
                            </h3>
                            <ul class="list-group list-group-unbordered mb-0">
                                <li class="list-group-item">
                                    <b>Tổng số lượng đơn hàng đã đặt</b>: <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tổng số ngày đã dùng bữa</b>: <a class="float-right">543</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Customer</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-coins mr-1"></i> Điểm tích lũy</strong>: <?php echo $response_customer['data']['point'] ?>
                            <hr>
                            <strong><i class="fas fa-venus-mars mr-1"></i> Giới tính</strong>: <br><?php echo $response_customer['data']['gender_name'] ?><br>
                            <hr>
                            <strong><i class="fas fa-signal mr-1"></i> Trạng thái khách hàng</strong>: <br><?php echo $response_customer['data']['status_name'] ?><br>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Số điện thoại</strong>: <br><?php echo $response_customer['data']['phone'] ?>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <?php
                            foreach ($response_get_location['data'] as $index => $record) { ?>
                                <p>
                                    <?php echo $record['address'] ?>,
                                    <?php echo $record['ward'] ?>,
                                    <?php echo $record['district'] ?>,
                                    <?php echo $record['city'] ?>
                                </p>
                            <?php }
                            ?>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Tag phân loại</strong>: <br><?php echo $response_customer['data']['tag_name'] ?><br>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Ghi chú đặc biệt</strong>:
                            <p class="text-muted">
                                <?php echo $response_customer['data']['note'] ?>
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Lịch sử giao dịch</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Ngày bắt đầu đơn hàng</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">
                                                    #
                                                </th>
                                                <th>
                                                    Tên giao dịch
                                                </th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày dự kiến kết thúc</th>
                                                <th>
                                                    Giá trị đơn hàng
                                                </th>
                                                <th style="width: 8%" class="text-center">
                                                    Status
                                                </th>
                                                <th style="width: 10%">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    #
                                                </td>
                                                <td>
                                                    <a href="#">
                                                        AdminLTE v3
                                                    </a>
                                                    <br>
                                                    <small>
                                                        Created 01.01.2019
                                                    </small>
                                                </td>
                                                <td>01.01.2019</td>
                                                <td>02.01.2019</td>
                                                <td class="project_progress">
                                                    100.000
                                                </td>
                                                <td class="project-state">
                                                    <span class="badge badge-success">Success</span>
                                                </td>
                                                <td class="project-actions text-right">
                                                    <a class="btn btn-primary btn-sm" href="#">
                                                        <i class="fas fa-folder">
                                                        </i>
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                10 Feb. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-envelope bg-primary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                                <div class="timeline-body">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                    quora plaxo ideeli hulu weebly balihoo...
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                                <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-comments bg-warning"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                                <div class="timeline-body">
                                                    Take me to your leader!
                                                    Switzerland is small and neutral!
                                                    We are more like Germany, ambitious and misunderstood!
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="settings">
                                    <?php
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
                                        $nickname   = sanitize_text_field($_POST['nickname']);
                                        $fullname   = sanitize_text_field($_POST['fullname']);
                                        $phone    = sanitize_text_field($_POST['phone']);
                                        $gender_post = sanitize_text_field($_POST['gender']);
                                        $status_post = sanitize_text_field($_POST['status']);
                                        $tag_post = sanitize_text_field($_POST['tag']);
                                        $point = sanitize_text_field($_POST['point']);
                                        $note = sanitize_textarea_field($_POST['post_content']);


                                        // cập nhật data cho customer
                                        $customer_data = [
                                            'id'            => $customer_id,
                                            'nickname'          => $nickname,
                                            'fullname'      => $fullname,
                                            'phone'         => $phone,
                                            'status'        => $status_post,
                                            'gender'        => $gender_post,
                                            'note'          => $note,
                                            'tag'           => $tag_post,
                                            'point'         => $point,
                                        ];
                                        $response_update = em_api_request('customer/update', $customer_data);
                                        
                                        if($customer_id == 0) {
                                            die('customer_id is null!');
                                          } 
                                        
                                          foreach ($_POST['locations'] as $location) {
                                            // thêm data cho location
                                            if (isset($location['address'])) {
                                              $address       = sanitize_text_field($location['address']);
                                            }
                                            if (isset($location['ward'])) {
                                              $ward       = sanitize_text_field($location['ward']);
                                            }
                                            if (isset($location['district'])) {
                                              $district       = sanitize_text_field($location['district']);
                                            }
                                            if (isset($location['province'])) {
                                              $city       = sanitize_text_field($location['province']);
                                            }
                                            
                                            $location_data = [
                                              'customer_id'   => $customer_id,
                                              'address'       => $address,
                                              'ward'          => $ward,
                                              'district'      => $district,
                                              'city'          => $city
                                            ];
                                        
                                            if (isset($location['id']) && intval($location['id']) > 0) {
                                              $location_data['id'] = $location['id'];
                                              $response_location = em_api_request('location/update', $location_data);
                                            } else {
                                              $response_location = em_api_request('location/add', $location_data);
                                            }
                                            var_dump($location['id']);
                                          }
                                          // xóa location
                                        //   $location_data = [
                                        //     'id' => 1
                                        // ];
                                        // $response = em_api_request('location/delete', $location_filter);
                                    }
                                    ?>
                                    <form class="form-horizontal" method="POST" action="<?php the_permalink() ?>?customer_id=<?php echo $customer_id ?>">
                                        <?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputName">Tên khách hàng (*)</label></div>
                                            <div class="col-sm-9">
                                                <input type="text" name="nickname" class="form-control" value="<?php echo $response_customer['data']['nickname'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="fullname">Tên đầy đủ</label></div>
                                            <div class="col-sm-9"><input type="text" id="fullname" name="fullname" value="<?php echo $response_customer['data']['fullname'] ?>" class="form-control"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="phone">Số điện thoại (*)</label></div>
                                            <div class="col-sm-9"><input type="number" id="phone" name="phone" class="form-control" value="<?php echo $response_customer['data']['phone'] ?>" required></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label>Giới tính (*)</label></div>
                                            <div class="col-sm-9">

                                                <?php
                                                foreach ($gender as $key => $value) { ?>
                                                    <div class="icheck-primary d-inline mr-2">
                                                        <input type="radio" id="radioPrimary<?php echo $key; ?>" value="<?php echo $key; ?>" <?php checked($response_customer['data']['gender_name'], $value); ?> name="gender" required>
                                                        <label for="radioPrimary<?php echo $key; ?>">
                                                            <?php echo $value; ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>


                                            </div>
                                        </div>
                                        <div id="location-fields">
                                            <?php foreach ($response_get_location['data'] as $index => $record) { ?>
                                                <hr>
                                                <div class="address-group">
                                                    <div class="form-group row">
                                                        <div class="col-sm-9"><input type="hidden" name="locations[<?php echo $index ?>][id]" value="<?php echo $record['id'] ?>" placeholder="id" readonly /></div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="address_<?php echo $record['id'] ?>">Địa chỉ (*):</label></div>
                                                        <div class="col-sm-9"><input id="address_<?php echo $record['id'] ?>" class="form-control" value="<?php echo $record['address']; ?>" name="locations[<?php echo $index ?>][address]" required /></div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="province_<?php echo $record['id'] ?>">Tỉnh/Thành phố:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="province_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][province]" class="province-select form-control" required>
                                                                <option value="<?php echo $record['city']; ?>" selected><?php echo $record['city']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="district_<?php echo $record['id'] ?>">Quận/Huyện:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="district_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][district]" class="district-select form-control" required>
                                                                <option value="<?php echo esc_attr($record['district']); ?>" selected><?php echo $record['district']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="ward_<?php echo $record['id'] ?>">Phường/Xã:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="ward_<?php echo $record['id'] ?>" name="locations[<?php echo $index ?>][ward]" class="ward-select form-control" required>
                                                                <option value="<?php echo esc_attr($record['ward']); ?>" selected><?php echo $record['ward']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <p class="text-right"><span class="btn bg-gradient-danger  delete-location-button">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
                                                </div>



                                            <?php } ?>
                                        </div>
                                        <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="post_content">Ghi chú đặc biệt</label></div>
                                            <div class="col-sm-9"><textarea id="post_content" name="post_content" class="form-control" rows="4"><?php echo $response_customer['data']['note']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                                            <div class="col-sm-9">
                                                <select id="inputStatus" name="status" class="form-control custom-select" required>
                                                    <option selected disabled>Select one</option>
                                                    <?php
                                                    foreach ($status as $key => $value) { ?>
                                                        <option value="<?php echo $key; ?>" <?php selected($response_customer['data']['status_name'], $value); ?>><?php echo $value; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="tag" style="width: 100%;" required>
                                                    <?php
                                                    foreach ($tag as $key => $value) { ?>
                                                        <option value="<?php echo $key; ?>" <?php selected($response_customer['data']['tag_name'], $value); ?>><?php echo $value; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                                            <div class="col-sm-9"><input type="number" id="inputPoint" name="point" value="<?php echo $response_customer['data']['point']; ?>" class="form-control"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary" name="add_post">Update</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<style>
    .success-message {
        color: green;
    }

    .error-message {
        color: red;
    }
</style>


<?php
// endwhile;
get_footer('customer');
?>
<script type="text/javascript">
    $(document).ready(function() {
        var $locationFields = $('#location-fields');
        var $addButton = $('#add-location-button');
        var fieldCount = <?php echo count($response_get_location['data']); ?>;
        var maxFields = 5;
        $(document).on('click', '.delete-location-button', function (e) {
            e.preventDefault();
            $(this).closest('.address-group').remove(); // Remove only the closest address group
            // fieldCount = fieldCount + 1;
            // console.log('log',fieldCount);
        });
        // Fetching data from the new API endpoint
        $.ajax({
            url: 'https://provinces.open-api.vn/api/?depth=3',
            method: 'GET',
            success: function(data) {

                // Function to populate the province dropdown
                function populateProvinces($selectElement, selectedValue) {
                    $selectElement.html('<option value="">Select Tỉnh/Thành phố</option>');
                    $.each(data, function(index, province) {
                        var isSelected = selectedValue && selectedValue === province.name ? 'selected' : '';
                        $selectElement.append(`<option value="${province.name}" ${isSelected}>${province.name}</option>`);
                    });
                }

                // Function to handle cascading changes in province, district, and ward
                function handleLocationChange($provinceSelect, $districtSelect, $wardSelect) {
                    $provinceSelect.on('change', function() {
                        $districtSelect.html('<option value="">Select Quận/Huyện</option>');
                        $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

                        var selectedProvince = data.find(p => p.name === $(this).val());

                        if (selectedProvince) {
                            $.each(selectedProvince.districts, function(index, district) {
                                $districtSelect.append(`<option value="${district.name}">${district.name}</option>`);
                            });
                            $districtSelect.prop('disabled', false);
                        } else {
                            $districtSelect.prop('disabled', true);
                        }
                    });

                    $districtSelect.on('change', function() {
                        $wardSelect.html('<option value="">Select Phường/Xã</option>').prop('disabled', true);

                        var selectedProvince = data.find(p => p.name === $provinceSelect.val());
                        var selectedDistrict = selectedProvince.districts.find(d => d.name === $(this).val());

                        if (selectedDistrict) {
                            $.each(selectedDistrict.wards, function(index, ward) {
                                $wardSelect.append(`<option value="${ward.name}">${ward.name}</option>`);
                            });
                            $wardSelect.prop('disabled', false);
                        } else {
                            $wardSelect.prop('disabled', true);
                        }
                    });
                }

                // Initialize existing address groups
                $('.address-group').each(function(index, group) {
                    var $provinceSelect = $(group).find('.province-select');
                    var $districtSelect = $(group).find('.district-select');
                    var $wardSelect = $(group).find('.ward-select');

                    populateProvinces($provinceSelect, $provinceSelect.val());
                    handleLocationChange($provinceSelect, $districtSelect, $wardSelect);
                });

                // Add new address group functionality
                $addButton.on('click', function(e) {
                    e.preventDefault();
                    if (fieldCount < maxFields) {

                        var newGroup = `
                        <hr>
                    <div class="address-group">
                        <div class="form-group row">
                            <div class="col-sm-3"><label>Địa chỉ (*):</label></div>
                            <div class="col-sm-9">
                                <input id="address_${fieldCount}" class="form-control" name="locations[${fieldCount}][address]" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="province_${fieldCount}">Tỉnh/Thành phố:</label></div>
                            <div class="col-sm-9">
                                <select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
                                    <option value="">Select Tỉnh/Thành phố</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="district_${fieldCount}">Quận/Huyện:</label></div>
                            <div class="col-sm-9">
                                <select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" required disabled>
                                    <option value="">Select Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="ward_${fieldCount}">Phường/Xã:</label></div>
                            <div class="col-sm-9">
                                <select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" required disabled>
                                    <option value="">Select Phường/Xã</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-right"><span class="btn bg-gradient-danger  delete-location-button">Xóa địa chỉ <i class="fas fa-minus"></i></span></p>
                    </div>`;

                        $locationFields.append(newGroup);
                        var $newGroup = $locationFields.find('.address-group').last();
                        populateProvinces($newGroup.find('.province-select'), '');
                        handleLocationChange($newGroup.find('.province-select'), $newGroup.find('.district-select'), $newGroup.find('.ward-select'));
                        fieldCount++;
                    } else {
                        alert('You can only add up to 5 locations.');
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching location data:', error);
            }
        });
    });
</script>