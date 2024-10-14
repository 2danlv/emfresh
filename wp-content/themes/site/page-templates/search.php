<?php

/**
 * Template Name: Search
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('customer');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?php the_title(); ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content pb-5">
        <div class="container-fluid">
            <?php
            $response_filter['code'] = 0;
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_post'])) {
                $fullname = sanitize_text_field($_POST['fullname']);
                $phone    = sanitize_text_field($_POST['phone']);
                $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
                $point = sanitize_text_field($_POST['point']);
                $address = sanitize_text_field($_POST['address']);
                $ward = isset($_POST['ward']) ? sanitize_text_field($_POST['ward']) : '';
                $district = isset($_POST['district']) ? sanitize_text_field($_POST['district']) : '';
                $city = isset($_POST['province']) ? sanitize_text_field($_POST['province']) : '';
                $customer_filter = [
                    'fullname'  => $fullname,
                    'phone' => $phone,
                    'point' => $point,
                    'status' => $status,
                    'paged' => 1,
                    //'limit' => 10,
                    'address' => $address,
                    'ward' => $ward,
                    'district' => $district,
                    'city' => $city,
                ];
                $response_filter = em_api_request('customer/list', $customer_filter);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
                $customer_id   = sanitize_text_field($_POST['customer_id']);
                $customer_data = [
                  'id' => $customer_id,
                ];
                $response = em_api_request('customer/delete', $customer_data);
              }
            
            ?>
            <form method="post" action="<?php the_permalink() ?>">
                <div class="row address-group">

                    <div class="col-4">
                        <div class="form-group">
                            <label>Tên hoặc một phần tên khách hàng:</label>
                            <input type="text" class="form-control" name="fullname" placeholder="Type your keywords here" value="<?php echo isset($customer_filter['fullname']) ? ($customer_filter['fullname']):'' ?>">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Số điện thoại:</label>
                            <input type="number" class="form-control" name="phone" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" value="<?php echo isset($customer_filter['phone']) ? ($customer_filter['phone']):'' ?>">
                        </div>
                    </div>
                    <!-- <div class="col-4">
                        <div class="form-group">
                            <label>Tổng giá trị các đơn hàng:</label>
                            <input type="number" class="form-control" placeholder="Type your keywords here" value="">
                        </div>
                    </div> -->
                    <!-- <div class="col-3">
                        <div class="form-group">
                            <label>Số lượng đơn hàng đã đặt:</label>
                            <input type="number" class="form-control" placeholder="Type your keywords here" value="">
                        </div>
                    </div> -->
                    <!-- <div class="col-3">
                        <div class="form-group">
                            <label>Khách hàng đang có đơn hàng diễn ra:</label>
                            <select class="form-control custom-select" style="width: 100%;">
                                <option selected disabled>Select one</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-3">
                        <div class="form-group">
                            <label>Trạng thái khách hàng:</label>
                            <select class="form-control custom-select" name="status" style="width: 100%;">
                                <option selected disabled>Select one</option>
                                <?php
                                $status = $em_customer->get_statuses();
                                foreach ($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>" <?php isset($customer_filter['status']) ? selected ($customer_filter['status'], $key):''; ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Điểm tích lũy:</label>
                            <input type="number" class="form-control" name="point" placeholder="Type your keywords here" value="<?php echo isset($customer_filter['point']) ? ($customer_filter['point']):'' ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-12"><label>Địa chỉ (*):</label></div>
                            <div class="col-sm-12">
                                <input id="address_0" class="form-control" name="address"value="<?php echo isset($customer_filter['address']) ? ($customer_filter['address']):'' ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="province_0">Tỉnh/Thành phố:</label>

                            </div>
                            <div class="col-sm-12">
                                <select id="province_0" name="province" class="province-select form-control">
                                    <option value="">Select Tỉnh/Thành phố</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="district_0">Quận/Huyện:</label>
                            </div>
                            <div class="col-sm-12">
                                <select id="district_0" name="district" class="district-select form-control" disabled>
                                    <option value="">Select Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="ward_0">Phường/Xã:</label>
                            </div>
                            <div class="col-sm-12">
                                <select id="ward_0" name="ward" class="ward-select form-control" disabled>
                                    <option value="">Select Phường/Xã</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-center">
                    <button type="submit" name="submit_post" class="btn btn-lg btn-primary ">
                        Search <i class="fa fa-search"></i>
                    </button>
                </div>

            </form>
            <?php
            if ($response_filter['code'] == 200 && $response_filter['total'] != 0) {
                var_dump($response_filter);
                if (isset($response_filter['data']) && is_array($response_filter['data'])) {
            ?>
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1">
                            <div class="list-group">
                                <?php
                                foreach ($response_filter['data'] as $record) {
                                    if (is_array($record)) { // Check if each record is an array
                                ?>
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col px-4">
                                                    <div>
                                                        <div class="float-right"></div>
                                                        <h3><a href="/customer/detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['fullname']; ?></a></h3>
                                                        <p>Số điện thoại: <?php echo $record['phone']; ?></p>
                                                        <p>Địa chỉ: <?php echo $record['address']; ?>, <?php echo $record['ward']; ?>, <?php echo $record['district']; ?>,  <?php echo $record['city']; ?></p>
                                                        <p>Trạng thái khách hàng: <?php echo $record['status_name']; ?></p>
                                                        <p>Điểm tích lũy: <?php echo $record['point']; ?></p>
                                                    </div>
                                                    <div>
                                                        <a class="btn btn-info btn-sm" href="/customer/detail-customer/?customer_id=<?php echo $record['id'] ?>#settings">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            Edit
                                                        </a>

                                                        <button type="button" class="btn btn-danger remove-customer btn-sm" data-toggle="modal" data-target="#modal-default">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
                                                            <span class="d-none"><?php echo $record['id'] ?></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php }
                                }
                            }
                            ?>
                            </div>
                            <!-- <div class="card-footer">
                                <nav aria-label="Contacts Page Navigation">
                                    <ul class="pagination justify-content-center m-0">
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                                    </ul>
                                </nav>
                            </div> -->
                        </div>
                    </div>
                <?php } ?>
        </div>
    </section>
    <!-- /.card-body -->
<div class="modal fade" id="modal-default" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thông báo!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="list-customer" action="<?php the_permalink() ?>">
          <input type="hidden" class="customer_id" name="customer_id" value="">
          <p>Bạn muốn xóa khách hàng này?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="remove" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>

  </div>

</div>
</div>
</div>
<?php
// endwhile;
get_footer('customer');
?>
<script type="text/javascript">
    $(document).ready(function() {
        // Fetching data from the new API endpoint
        $.ajax({
            url: 'https://provinces.open-api.vn/api/?depth=3',
            method: 'GET',
            success: function(data) {
                // Move the province with code 79 to the top of the data array
                var topProvince = data.find(p => p.code === 79);
                if (topProvince) {
                    data = [topProvince].concat(data.filter(p => p.code !== 79));
                }

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


            },
            error: function(error) {
                console.error('Error fetching location data:', error);
            }
        });
    });
</script>
<script>
  $(document).ready(function() {
    $(document).on('click', '.remove-customer', function(e) {
        var val = $(this).children('span').text();
      $('#list-customer').find('.customer_id').val(val);
    });
  });
</script>