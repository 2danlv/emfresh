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
            // Get the post ID (you can dynamically retrieve this in context)
            $post_id = get_the_ID(); // Adjust based on where you're using this form
            // Fetch the current post data (title, content, and locations)
            $selected_locations = get_post_meta($post_id, 'location', false); // Fetch all location entries
            $fullname = get_post_meta($post_id, 'fullname', true);
            $phone = get_post_meta($post_id, 'phone', true);
            $gender = get_post_meta($post_id, 'gender', true);
            $status = get_post_meta($post_id, 'status', true);
            $tag = get_post_meta($post_id, 'tag', true);
            $point = get_post_meta($post_id, 'point', true);
            $locations = get_post_meta($post_id, 'location', false); // Fetch all location entries
            // If $locations is not an array, make it an empty array
            if (!is_array($locations)) {
                $locations = array();
            }
            // Check if the form is submitted and save the data
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_locations_nonce'])) {
                // Verify nonce for security
                if (wp_verify_nonce($_POST['edit_locations_nonce'], 'save_locations')) {
                    // Save the post title and content
                    if (isset($_POST['post_title'])) {
                        $updated_post = array(
                            'ID'           => $post_id,
                            'post_title'   => sanitize_text_field($_POST['post_title']),
                            'post_content' => wp_kses_post($_POST['post_content']), // Sanitize content with allowed HTML
                        );
                        // Update the post in the database
                        wp_update_post($updated_post);
                    }
                    // Add full name
                    if (isset($_POST['fullname'])) {
                        update_post_meta($post_id, 'fullname', sanitize_text_field($_POST['fullname']));
                    }
                    // Add phone number
                    if (isset($_POST['phone'])) {
                        update_post_meta($post_id, 'phone', preg_replace('/[^0-9]/', '', $_POST['phone'])); // Sanitize phone number
                    }
                    // Add gender
                    if (isset($_POST['gender'])) {
                        update_post_meta($post_id, 'gender', sanitize_text_field($_POST['gender']));
                    }
                    // Add customer status
                    if (isset($_POST['status'])) {
                        update_post_meta($post_id, 'status', sanitize_text_field($_POST['status']));
                    }
                    // Add customer tag
                    if (isset($_POST['tag'])) {
                        update_post_meta($post_id, 'tag', sanitize_text_field($_POST['tag']));
                    }
                    // Add point field
                    if (isset($_POST['point'])) {
                        update_post_meta($post_id, 'point', sanitize_text_field($_POST['point']));
                    }
                    // Save multiple locations
                    // Get existing locations
                    $existing_locations = get_post_meta($post_id, 'location', false); // Use false to retrieve all entries

        // Prepare an associative array for easy comparison (keyed by a unique identifier)
        $existing_locations_map = [];
        foreach ($existing_locations as $index => $loc) {
            $key = json_encode($loc); // Create a unique key for each existing location
            $existing_locations_map[$key] = $loc; // Map the key to the existing location
        }

        // Check if new locations are provided
        if (isset($_POST['locations']) && is_array($_POST['locations'])) {
            foreach ($_POST['locations'] as $index => $location) {
                // Prepare location data with checks for each field
                $location_data = array(
                    'address'  => isset($location['address']) ? sanitize_text_field($location['address']) : '',
                    'province' => isset($location['province']) ? sanitize_text_field($location['province']) : '',
                    'district' => isset($location['district']) ? sanitize_text_field($location['district']) : '',
                    'ward'     => isset($location['ward']) ? sanitize_text_field($location['ward']) : '',
                );

                // Ensure required fields are filled
                if (!empty($location_data['province']) && !empty($location_data['district']) && !empty($location_data['ward'])) {
                    // Create a unique key for the new location
                    $new_key = json_encode($location_data);

                    if (array_key_exists($new_key, $existing_locations_map)) {
                        // Location exists, update it
                        print_r($existing_locations_map);
                        update_post_meta($post_id, 'location', $location_data, $existing_locations_map[$new_key]);
                    } else {
                        // Location does not exist, so add it
                        // add_post_meta($post_id, 'location', $location_data);
                        print_r($_POST['locations']);
                    }
                } else {
                    //echo '<p class="error-message">Location data is incomplete for index ' . $index . '.</p>';
                }
            }
            echo '<p class="success-message">Locations processed successfully!</p>';
        } else {
            echo '<p class="error-message">No new locations provided.</p>';
        }
                    
                } else {
                    echo '<p class="error-message">There was a security error. Please try again.</p>';
                }
            }
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
                            <h3 class="profile-username text-center"><?php echo esc_attr($post->post_title); ?></h3>
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
                            <strong><i class="fas fa-coins mr-1"></i> Điểm tích lũy</strong>: <?php echo esc_html($point); ?>
                            <hr>
                            <strong><i class="fas fa-venus-mars mr-1"></i> Giới tính</strong>: <br> <?php echo esc_html($gender); ?>
                            <hr>
                            <strong><i class="fas fa-signal mr-1"></i> Trạng thái khách hàng</strong>: <br> <?php echo esc_html($status); ?>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Số điện thoại</strong>: <?php echo esc_html($phone); ?>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <?php
                            if (!empty($locations)) {
                                foreach ($locations as $index => $location) {
                                    // Ensure $location is an array
                                    $address = isset($location['address']) ? esc_attr($location['address']) : '';
                                    $province = isset($location['province']) ? esc_attr($location['province']) : '';
                                    $district = isset($location['district']) ? esc_attr($location['district']) : '';
                                    $ward     = isset($location['ward']) ? esc_attr($location['ward']) : '';
                            ?>
                                    <p>Addess <?php echo $index + 1; ?>: <?php echo $address; ?>, <?php echo $ward; ?>, <?php echo $district; ?>, <?php echo $province; ?></p>
                            <?php
                                }
                            }
                            ?>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Tag phân loại</strong>: <br> <?php echo esc_html($tag); ?>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Ghi chú đặc biệt</strong>
                            <p class="text-muted">
                                <?php the_content(); ?>
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
                                    <form class="form-horizontal" method="POST">
                                        <?php wp_nonce_field('save_locations', 'edit_locations_nonce'); ?>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputName">Tên khách hàng</label></div>
                                            <div class="col-sm-9">
                                                <input type="text" name="post_title" class="form-control" value="<?php the_title(); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="fullname">Tên đầy đủ</label></div>
                                            <div class="col-sm-9"><input type="text" id="fullname" name="fullname" value="<?php echo esc_html($fullname); ?>" class="form-control"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="phone">Số điện thoại (*)</label></div>
                                            <div class="col-sm-9"><input type="number" id="phone" name="phone" class="form-control" value="<?php echo esc_html($phone); ?>" required></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label>Giới tính (*)</label></div>
                                            <div class="col-sm-9">
                                                <div class="icheck-primary d-inline mr-2">
                                                    <input type="radio" id="radioMale" value="Nam" name="gender" <?php checked($gender, 'Nam'); ?> required>
                                                    <label for="radioMale">Nam</label>
                                                </div>
                                                <div class="icheck-primary d-inline mr-2">
                                                    <input type="radio" id="radioFemale" value="Nữ" name="gender" <?php checked($gender, 'Nữ'); ?> required>
                                                    <label for="radioFemale">Nữ</label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="radioUnknown" value="Không có thông tin" name="gender" <?php checked($gender, 'Không có thông tin'); ?> required>
                                                    <label for="radioUnknown">Không có thông tin</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="location-fields">
                                            <?php foreach ($selected_locations as $index => $location): ?>
                                                <div class="address-group">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="address_<?php echo $index; ?>">Address:</label></div>
                                                        <div class="col-sm-9"><input id="address_<?php echo $index; ?>" class="form-control" value="<?php echo esc_attr($location['address']); ?>" name="locations[<?php echo $index; ?>][address]" required /></div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="province_<?php echo $index; ?>">Tỉnh/Thành phố:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="province_<?php echo $index; ?>" name="locations[<?php echo $index; ?>][province]" class="province-select form-control" required>
                                                                <option value="<?php echo esc_attr($location['province']); ?>" selected><?php echo esc_html($location['province']); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="district_<?php echo $index; ?>">Quận/Huyện:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="district_<?php echo $index; ?>" name="locations[<?php echo $index; ?>][district]" class="district-select form-control" required disabled>
                                                                <option value="<?php echo esc_attr($location['district']); ?>" selected><?php echo esc_html($location['district']); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"><label for="ward_<?php echo $index; ?>">Phường/Xã:</label></div>
                                                        <div class="col-sm-9">
                                                            <select id="ward_<?php echo $index; ?>" name="locations[<?php echo $index; ?>][ward]" class="ward-select form-control" required disabled>
                                                                <option value="<?php echo esc_attr($location['ward']); ?>" selected><?php echo esc_html($location['ward']); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <p><span class="btn bg-gradient-primary" id="add-location-button">Thêm địa chỉ <i class="fas fa-plus"></i></span></p>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="post_content">Ghi chú đặc biệt</label></div>
                                            <div class="col-sm-9"><textarea id="post_content" name="post_content" class="form-control" rows="4"><?php echo esc_html(get_the_content()); ?></textarea></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                                            <div class="col-sm-9">
                                                <select id="inputStatus" name="status" class="form-control custom-select" required>
                                                    <option selected disabled>Select one</option>
                                                    <option value="Đặt đơn" <?php selected($status, 'Đặt đơn'); ?>>Đặt đơn</option>
                                                    <option value="Dí món" <?php selected($status, 'Dí món'); ?>>Dí món</option>
                                                    <option value="Chưa rõ" <?php selected($status, 'Chưa rõ'); ?>>Chưa rõ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="tag" style="width: 100%;" required>
                                                    <option value="thân thiết" <?php selected($tag, 'thân thiết'); ?>>thân thiết</option>
                                                    <option value="ăn nhóm" <?php selected($tag, 'ăn nhóm'); ?>>ăn nhóm</option>
                                                    <option value="khách có bệnh lý" <?php selected($tag, 'khách có bệnh lý'); ?>>khách có bệnh lý</option>
                                                    <option value="khách hãm" <?php selected($tag, 'khách hãm'); ?>>khách hãm</option>
                                                    <option value="bảo lưu" <?php selected($tag, 'bảo lưu'); ?>>bảo lưu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                                            <div class="col-sm-9"><input type="number" id="inputPoint" name="point" value="<?php echo esc_html($point); ?>" class="form-control"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-danger">Update</button>
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var locationFields = document.getElementById('location-fields');
        var addButton = document.getElementById('add-location-button');
        var fieldCount = locationFields.querySelectorAll('.location-group').length;
        var maxFields = 5;
        // Fetch the JSON data from the provided URL
        fetch('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json')
            .then(response => response.json())
            .then(data => {
                // Function to populate province select
                function populateProvinces(selectElement, selectedValue) {
                    selectElement.innerHTML = '<option value="">Select  Tỉnh/Thành phố</option>';
                    data.forEach(province => {
                        var option = document.createElement('option');
                        option.value = province.Name;
                        option.text = province.Name;
                        if (selectedValue && selectedValue === province.Name) {
                            option.selected = true;
                        }
                        selectElement.appendChild(option);
                    });
                }
                // Function to handle district and ward population
                function handleLocationChange(provinceSelect, districtSelect, wardSelect) {
                    provinceSelect.addEventListener('change', function() {
                        districtSelect.innerHTML = '<option value="">Select Quận/Huyện</option>';
                        wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';
                        wardSelect.disabled = true;
                        var selectedProvince = data.find(p => p.Name === this.value);
                        if (selectedProvince) {
                            selectedProvince.Districts.forEach(district => {
                                var option = document.createElement('option');
                                option.value = district.Name;
                                option.text = district.Name;
                                districtSelect.appendChild(option);
                            });
                            districtSelect.disabled = false;
                        } else {
                            districtSelect.disabled = true;
                        }
                    });
                    districtSelect.addEventListener('change', function() {
                        wardSelect.innerHTML = '<option value="">Select Phường/Xã</option>';
                        var selectedProvince = data.find(p => p.Name === provinceSelect.value);
                        var selectedDistrict = selectedProvince.Districts.find(d => d.Name === this.value);
                        if (selectedDistrict) {
                            selectedDistrict.Wards.forEach(ward => {
                                var option = document.createElement('option');
                                option.value = ward.Name;
                                option.text = ward.Name;
                                wardSelect.appendChild(option);
                            });
                            wardSelect.disabled = false;
                        } else {
                            wardSelect.disabled = true;
                        }
                    });
                }
                // Initialize existing locations
                document.querySelectorAll('.address-group').forEach(function(group, index) {
                    var provinceSelect = group.querySelector('.province-select');
                    var districtSelect = group.querySelector('.district-select');
                    var wardSelect = group.querySelector('.ward-select');
                    populateProvinces(provinceSelect, provinceSelect.value);
                    handleLocationChange(provinceSelect, districtSelect, wardSelect);
                });
                // Add new location field set
                addButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (fieldCount < maxFields) {
                        var newGroup = document.createElement('div');
                        newGroup.classList.add('address-group');
                        newGroup.innerHTML = `
                        <div class="form-group row">
                          <div class="col-sm-3"><label>Địa chỉ (*) </label></div>
                          <div class="col-sm-9">
                              <input id="address_${fieldCount}" class="form-control" name="locations[${fieldCount}][address]" required />
                          </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="province_${fieldCount}">Tỉnh/Thành phố:</label>
                        </div>
                        <div class="col-sm-9">
                            <select id="province_${fieldCount}" name="locations[${fieldCount}][province]" class="province-select form-control" required>
                                <option value="">Select Tỉnh/Thành phố</option>
                            </select>
                        </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-3">
                                <label for="district_${fieldCount}">Quận/Huyện:</label>
                                </div>
                                <div class="col-sm-9">
                                <select id="district_${fieldCount}" name="locations[${fieldCount}][district]" class="district-select form-control" required disabled>
                                    <option value="">Select Quận/Huyện</option>
                                </select>
                            </div>
                            </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="ward_${fieldCount}">Phường/Xã:</label>
                                </div>
                                <div class="col-sm-9">
                                <select id="ward_${fieldCount}" name="locations[${fieldCount}][ward]" class="ward-select form-control" required disabled>
                                    <option value="">Select Phường/Xã</option>
                                </select>
                            </div>
                        </div>
                    `;
                        locationFields.appendChild(newGroup);
                        populateProvinces(newGroup.querySelector('.province-select'), '');
                        handleLocationChange(newGroup.querySelector('.province-select'), newGroup.querySelector('.district-select'), newGroup.querySelector('.ward-select'));
                        fieldCount++;
                    } else {
                        alert('You can only add up to 5 locations.');
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching location data:', error);
                //alert('There was an error loading the location data. Please try again later.');
            });
    });
</script>