  <aside class="main-sidebar pt-16 sidebar col-3">
    <!-- Brand Logo -->
    <div class="text-center pt-16">
      <a href="index.php" class="brand-link">
      <img src="<?php echo site_get_template_directory_assets();?>/img/logo.svg" alt="em.fresh" class="brand-image img-circle elevation-3" style="opacity: .8">
      </a>
    </div>
      <!-- Sidebar Menu -->
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => 'main-menu',
        'menu_class' => 'nav-menu',
      ));
      ?>
      <!-- /.sidebar-menu -->
       <div class="resize text-center">
         <p><img src="<?php echo site_get_template_directory_assets();?>/img/icon/left-arrow-to-left-svgrepo-com.svg" alt=""> <span class="mini">Thu gọn</span><span class="zoom">Phóng to</span></p>
       </div>
    <!-- /.sidebar -->
  </aside>