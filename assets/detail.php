<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Customer Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">Nina Mcintire</h3>

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
                <strong><i class="fas fa-coins mr-1"></i> Điểm tích lũy</strong>: 888
                <hr>
                <strong><i class="fas fa-venus-mars mr-1"></i> Giới tính</strong>: Nam
                <hr>
                <strong><i class="fas fa-signal mr-1"></i> Trạng thái khách hàng</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> Số điện thoại</strong>: 09009090909
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>
                <p class="text-muted">Malibu, California</p>
                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Tag phân loại</strong>: Javascript

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Ghi chú đặc biệt</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <div class="col-sm-3"><label for="inputName">Tên khách hàng</label></div>
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
                            <div class="icheck-primary d-inline">
                              <input type="radio" id="radioPrimary2" name="r1">
                              <label for="radioPrimary2">
                                Nữ
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
                      <hr>
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
                      <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9">
                          <button type="submit" class="btn btn-danger">Submit</button>
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
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2024.</strong> All rights reserved.
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
