<?php

/**
 * Template Name: Chart
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('customer');

global $em_customer;

// Example filter
$statistic_filter = [
  'date_from' => '2024-10-01',
  'date_to'   => '2024-10-07',
  'date'      => '2024-10-01',
  'month'     => 10,
  'year'      => 2024,
  'week'      => 36
];

$genders = site_statistic_get_customer('gender', []);
$tags = site_statistic_get_customer('tag', []);
$statuses = site_statistic_get_customer('status', []);

$customer_filter = [
  'paged' => 1
];
$response_customer = em_api_request('customer/list', $customer_filter);

?><div class="content-wrapper">
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
  <section class="content">
    <div class="container-fluid">
      <!-- <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Filter</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-4"><label>Date range:</label></div>
                <div class="col-sm-8">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4"><label for="inputEstimatedDuration">Khu vực</label></div>
                <div class="col-sm-8">
                  <select id="inputStatus" class="form-control custom-select">
                    <option selected disabled>Select one</option>
                    <option>HCM</option>
                    <option>Ha Noi</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-4"><label for="inputEstimatedDuration">Số lượng đơn hàng</label></div>
                <div class="col-sm-8"><input type="number" id="inputEstimatedDuration" class="form-control"></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4"><label for="inputEstimatedDuration">Giá trị đơn hàng</label></div>
                <div class="col-sm-8"><input type="number" id="inputEstimatedDuration" class="form-control"></div>
              </div>

            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-primary">Filter</button>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thống kê số lượng khách hàng mới, khách hàng cũ</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <p>Khách hàng mới <i class="fas fa-user-plus"></i></p>
                </div>
                <div class="col-4 text-right">
                  100
                </div>
              </div>

              <div class="progress mb-3">
                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                  <span>40%</span>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <p>Khách hàng cũ <i class="fas fa-users"></i></p>
                </div>
                <div class="col-4 text-right">
                  100
                </div>
              </div>
              <div class="progress">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span>20%</span>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-8">
                  <p>Khách hàng mới chi tiêu <i class="fas fa-coins"></i></p>
                </div>
                <div class="col-4 text-right">
                  123.456.789đ
                </div>
              </div>
              <div class="progress mb-3">
                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                  <span>40%</span>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <p>Khách hàng cũ chi tiêu <i class="fas fa-coins"></i></p>
                </div>
                <div class="col-4 text-right">
                  123.456.789đ
                </div>
              </div>
              <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  <span>60%</span>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <!-- /.card -->
          <!-- BAR CHART -->
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Thống kê phân loại theo trạng thái</h3>
            </div>
            <div class="card-body">
              <div class="chart">
                <div class="card-body">
                  <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col (RIGHT) -->
        <div class="col-md-6"><!-- DONUT CHART -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Báo cáo theo phân loại</h3>
            </div>
            <div class="card-body">
              <canvas id="tagsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6"><!-- PIE CHART -->
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Thống kê phân loại số lượng khách hàng theo giới tính</h3>
            </div>
            <div class="card-body">
              <canvas id="genderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.row -->

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<?php
// endwhile;
get_footer('customer');
?>
<script src="/assets/plugins/chart.js/Chart.min.js"></script>
<script src="/assets/plugins/moment/moment.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
<script>
  $(function() {

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //--------------

    var tagsCanvas = $('#tagsChart').get(0).getContext('2d')
    var tagsData = {
      labels: [<?php
        foreach ($tags as $item) {
          $name = custom_ucwords_utf8($item['name']);
          echo "'{$name}'" . ',';
        } ?>],
      datasets: [{
        data: [
          <?php
          foreach ($tags as $item) {
            echo $item['total'] . ',';
          } ?>],
        backgroundColor: ['#f39c12', '#00c0ef', '#c1c7d1', '#3b8bba', '#f56954'],
      }]
    }
    var tagsOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(tagsCanvas, {
      type: 'doughnut',
      data: tagsData,
      options: tagsOptions
    })
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var genderCanvas = $('#genderChart').get(0).getContext('2d')
    var genderData = {
      labels: [<?php
        foreach ($genders as $item) {
          $name = custom_ucwords_utf8($item['name']);
          echo "'{$name}'" . ',';
        }
        ?>],
      datasets: [{
        data: [<?php
          foreach ($genders as $item) {
            echo $item['total'] . ',';
          }
          ?>],
        backgroundColor: ['#f56954', '#00a65a', '#00c0ef'],
      }]
    }
    var genderOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(genderCanvas, {
      type: 'pie',
      data: genderData,
      options: genderOptions
    })
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var statusCanvas = $('#statusChart').get(0).getContext('2d')
    var statusData = {
      labels: [<?php
        foreach ($statuses as $item) {
          $name = custom_ucwords_utf8($item['name']);
          echo "'{$name}'" . ',';
        }
        ?>],
      datasets: [{
        data: [<?php
          foreach ($statuses as $item) {
            echo $item['total'] . ',';
          }
          ?>],
        backgroundColor: ['#f56954', '#00a65a', '#00c0ef'],
      }]
    }
    var statusOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(statusCanvas, {
      type: 'pie',
      data: statusData,
      options: statusOptions
    })
    //- BAR CHART -

  })
</script>