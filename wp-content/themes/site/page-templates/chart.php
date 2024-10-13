<?php
/**
* Template Name: Chart
*
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/

get_header('customer');

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
        <h1>Chart</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Chart</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
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
      </div>
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
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Thống kê phân loại khách hàng dựa trên tag phân loại</h3>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col (RIGHT) -->
       <div class="col-md-6"><!-- DONUT CHART -->
       <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Báo cáo về khu vực</h3>
        </div>
        <div class="card-body">
          <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      </div>
       <div class="col-md-6"><!-- PIE CHART -->
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Thống kê phân loại số lượng khách hàng theo giới tính</h3>
        </div>
        <div class="card-body">
          <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      </div>
      
    </div>
    <!-- /.row -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List customer</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Tên đầy đủ</th>
            <th>Số điện thoại</th>
            <th>Tag phân loại</th>
            <th>Điểm tích lũy (cuối cùng)</th>
          </tr>
          </thead>
          <tbody>
          <?php
            
            if (isset($response_customer['data']) && is_array($response_customer['data'])) {
              // Loop through the data array and print each entry
              foreach ($response_customer['data'] as $record) {
                if (is_array($record)) { // Check if each record is an array
            ?>
                  <tr>
                    <td><a href="/customer/detail-customer/?customer_id=<?php echo $record['id'] ?>"><?php echo $record['fullname']; ?></a></td>
                    <td><?php echo $record['phone']; ?></td>
                    <td><?php echo $record['tag_name']; ?></td>
                    <td><?php echo $record['point']; ?>
                      <div class="float-sm-right">
                        <a class="btn btn-info btn-sm" href="/customer/detail-customer/?customer_id=<?php echo $record['id'] ?>">
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
                    </td>
                  </tr>
            <?php  } else {
                  echo "Invalid record format.\n";
                }
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<?php
// endwhile;
get_footer('customer');
?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": true,
      "buttons": ["csv", "excel", "pdf"],
      "columnDefs": [
        { type: 'natural', targets: 0 }
     ],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //--------------
    //- AREA CHART -
    //--------------
    // Get context with jQuery - using jQuery's .get() method.
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }
    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
    // This will get the first returned node in the jQuery collection.

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Hcm',
          'Hanoi'
      ],
      datasets: [
        {
          data: [800,300],
          backgroundColor : ['#f39c12', '#00c0ef'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Nam',
          'Nữ',
          'Không có thông tin'
      ],
      datasets: [
        {
          data: [700,500,200],
          backgroundColor : ['#f56954', '#00a65a','#00c0ef'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })
</script>