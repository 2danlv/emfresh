<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Project Add</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
   <?php include "sidebar.php"; ?>
  <!-- /.navbar -->


  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Customer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputName">Tên khách hàng (*)</label></div>
                <div class="col-sm-9">
                  <input type="text" id="inputName" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputName">Nickname đặt hàng</label></div>
                <div class="col-sm-9"><input type="text" id="inputName" class="form-control"></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputName">Tên đầy đủ</label></div>
                <div class="col-sm-9"><input type="text" id="inputName" class="form-control"></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputName">Số điện thoại (*)</label></div>
                <div class="col-sm-9"><input type="tel" id="inputName" class="form-control"></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputName">Giới tính (*)</label></div>
                <div class="col-sm-9">
                    <div class="icheck-primary d-inline mr-2">
                      <input type="radio" id="radioPrimary1" name="r1">
                      <label for="radioPrimary1">
                        Nam
                      </label>
                    </div>
                    <div class="icheck-primary d-inline mr-2">
                      <input type="radio" id="radioPrimary2" name="r1">
                      <label for="radioPrimary2">
                        Nữ
                      </label>
                    </div>
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary3" name="r1">
                      <label for="radioPrimary3">
                      Không có thông tin
                      </label>
                    </div>
                    
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputDescription">Địa chỉ (*) </label></div>
                <div class="col-sm-9">
                  <div class="form-group"><textarea id="inputDescription" class="form-control" rows="4"></textarea></div>
                  <span class="btn bg-gradient-primary">Thêm địa chỉ <i class="fas fa-plus"></i></span>
                </div>
              </div>
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
                <div class="col-sm-3"><label for="inputDescription">Ghi chú đặc biệt</label></div>
                <div class="col-sm-9"><textarea id="inputDescription" class="form-control" rows="4"></textarea></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputEstimatedBudget">Trạng thái khách hàng (*)</label></div>
                <div class="col-sm-9"><select id="inputStatus" class="form-control custom-select">
                  <option selected disabled>Select one</option>
                  <option>On Hold</option>
                  <option>Canceled</option>
                  <option>Success</option>
                </select>
              </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputSpentBudget">Tag phân loại (*)</label></div>
                <div class="col-sm-9"><select class="form-control select2" style="width: 100%;">
                  <option selected disabled>Select one</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputEstimatedDuration">Điểm tích lũy</label></div>
                <div class="col-sm-9"><input type="number" id="inputEstimatedDuration" class="form-control"></div>
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
          <input type="submit" value="Add new Customer" class="btn btn-primary float-right">
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2024.</strong> All rights reserved.
  </footer>


  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="dist/js/demo.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
    </script>
</body>
</html>
