  <aside class="main-sidebar sidebar col-3">
    <!-- Brand Logo -->
    <div class="text-center">
      <a href="index.php" class="brand-link">
      <img src="<?php echo site_get_template_directory_assets();?>/img/logo.svg" alt="em.fresh" class="brand-image img-circle elevation-3" style="opacity: .8">
      </a>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => 'main-menu',
        'menu_class' => 'nav-menu',
      ));
      ?>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>