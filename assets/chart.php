<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name ="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | ChartJS</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "sidebar.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
            <h3 class="card-title">DataTable with default features</h3>
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
                <tr>
                  <td>Name 1</td>
                  <td>0909090904</td>
                  <td>Tag</td>
                  <td>1003</td>
                </tr>
                <tr>
                  <td>Name 2</td>
                  <td>0909090902</td>
                  <td>Tag</td>
                  <td>1001</td>
                </tr>
                <tr>
                  <td>Name 3</td>
                  <td>0909090903</td>
                  <td>Tag</td>
                  <td>1002</td>
                </tr>
                <tr>
                  <td>Name 4</td>
                  <td>0909090901</td>
                  <td>Tag</td>
                  <td>1000</td>
                </tr>
                <tr>
                  <td>Name 5</td>
                  <td>0909090905</td>
                  <td>Tag</td>
                  <td>1004</td>
                </tr>
                <tr>
                  <td>Name 6</td>
                  <td>0909090906</td>
                  <td>Tag</td>
                  <td>1005</td>
                </tr>
                <tr>
                  <td>Name 7</td>
                  <td>0909090907</td>
                  <td>Tag</td>
                  <td>1006</td>
                </tr>
                <tr>
                  <td>Name 8</td>
                  <td>0909090908</td>
                  <td>Tag</td>
                  <td>1007</td>
                </tr>
                <tr>
                  <td>Name 9</td>
                  <td>0909090909</td>
                  <td>Tag</td>
                  <td>1008</td>
                </tr>
                <tr>
                  <td>Name 10</td>
                  <td>0909090910</td>
                  <td>Tag</td>
                  <td>1009</td>
                </tr>
                <tr>
                  <td>Name 11</td>
                  <td>0909090911</td>
                  <td>Tag</td>
                  <td>1010</td>
                </tr>
                <tr>
                  <td>Name 12</td>
                  <td>0909090912</td>
                  <td>Tag</td>
                  <td>1011</td>
                </tr>
                <tr>
                  <td>Name 13</td>
                  <td>0909090913</td>
                  <td>Tag</td>
                  <td>1012</td>
                </tr>
                <tr>
                  <td>Name 14</td>
                  <td>0909090914</td>
                  <td>Tag</td>
                  <td>1013</td>
                </tr>
                <tr>
                  <td>Name 15</td>
                  <td>0909090915</td>
                  <td>Tag</td>
                  <td>1014</td>
                </tr>
                <tr>
                  <td>Name 16</td>
                  <td>0909090916</td>
                  <td>Tag</td>
                  <td>1015</td>
                </tr>
                <tr>
                  <td>Name 17</td>
                  <td>0909090917</td>
                  <td>Tag</td>
                  <td>1016</td>
                </tr>
                <tr>
                  <td>Name 18</td>
                  <td>0909090918</td>
                  <td>Tag</td>
                  <td>1017</td>
                </tr>
                <tr>
                  <td>Name 19</td>
                  <td>0909090919</td>
                  <td>Tag</td>
                  <td>1018</td>
                </tr>
                
              </tbody>
              <tfoot>
              <tr>
                <th>Tên đầy đủ</th>
                <th>Số điện thoại</th>
                <th>Tag phân loại</th>
                <th>Điểm tích lũy (cuối cùng)</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2024.</strong> All rights reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/natural.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- Page specific script -->
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
</body>
</html>
