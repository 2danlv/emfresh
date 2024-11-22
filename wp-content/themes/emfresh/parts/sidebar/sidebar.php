  <aside class="main-sidebar pt-16 col-2">
    <div class="sidebar">
    <!-- Brand Logo -->
     <div class="sidebar-top">
    <div class="text-center sidebar-logo col-12 pt-16">
      <a href="index.php" class="brand-link">
      <img src="<?php echo site_get_template_directory_assets();?>/img/logo.svg" alt="em.fresh" class="brand-image img-circle elevation-3" style="opacity: .8">
      </a>
    </div>
      <!-- Sidebar Menu -->
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => 'main-menu col-12',
        'menu_class' => 'nav-menu',
      ));
      ?>
      <!-- /.sidebar-menu -->
       </div>
       <div class="resize text-center">
         <p><img src="<?php echo site_get_template_directory_assets();?>/img/icon/left-arrow-to-left-svgrepo-com.svg" alt=""> <span class="mini">Thu gọn</span></p>
       </div>
     </div>
  </aside>