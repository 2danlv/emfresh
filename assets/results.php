<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Enhanced Search Results</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
   <?php include "sidebar.php"; ?>
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Result</h1>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="results.html">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="Lorem ipsum">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group">
                                    <label>Số lượng đơn hàng đã đặt:</label>
                                    <input type="number" class="form-control" placeholder="Type your keywords here" value="0">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tổng giá trị các đơn hàng:</label>
                                    <input type="number" class="form-control" placeholder="Type your keywords here" value="0">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Khách hàng đang có đơn hàng diễn ra:</label>
                                    <select class="form-control custom-select" style="width: 100%;">
                                        <option selected disabled>Select one</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label>Địa chỉ hoặc theo khu vực (Quận -> Phường):</label>
                                    <select class="select2" style="width: 100%;">
                                        <option selected disabled>Select one</option>
                                        <option>Text only</option>
                                        <option>Images</option>
                                        <option>Video</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Trạng thái khách hàng:</label>
                                    <select class="form-control custom-select" style="width: 100%;">
                                        <option selected disabled>Select one</option>
                                        <option>On Hold</option>
                                        <option>Canceled</option>
                                        <option>Success</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Điểm tích lũy:</label>
                                    <input type="number" class="form-control" placeholder="Type your keywords here" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-primary ">
                                Search <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col px-4">
                                    <div>
                                        <div class="float-right">2021-04-20 04:04pm</div>
                                        <h3><a href="detail.php">Lorem ipsum dolor sit amet</a></h3>
                                        <p class="mb-0">consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col px-4">
                                    <div>
                                        <div class="float-right">2021-04-20 10:14pm</div>
                                        <h3><a href="detail.php">Lorem ipsum dolor sit amet</a></h3>
                                        <p class="mb-0">consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
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
                      </div>
                </div>
            </div>
        </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
    $(function () {
      $('.select2').select2()
    });
</script>
</body>
</html>
