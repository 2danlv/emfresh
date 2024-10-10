  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="/assets/dist/img/emfresh_logo.jpg" alt="emfresh" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">emfresh</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <?php global $current_user; wp_get_current_user(); ?>
      
        <div class="image">
          <img src="<?php echo esc_url( get_avatar_url( get_current_user_id() ) ); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $current_user->display_name; ?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Customer Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/customer/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/add-customer" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="search.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Search</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="chart.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chart</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
