<?php
extract(shortcode_atts(array(
    'hotline'		=> '',
    'address'		=> '',
    'opening_hours'		=> '',
), (array) get_field('contact', 'option') ));
?>
<div class="sidebar">
  <div class="widget widget-menu">
    <ul class="navigation">
      <?php
      switch (get_page_template_slug()) :
        case 'page-templates/doctor.php' :
          break;

        case '' :
          break;

        case 'page-templates/about.php' :
          include get_theme_file_path('parts/sidebar/sidebar-about.php');
          break;

        default:
          include get_theme_file_path('parts/sidebar/sidebar.php');
        break;
      endswitch;
      ?>
    </ul>
  </div>
  <div class="widget widget-block">
    <p><b><?php site_text('Opening Hours');?></b></p>
    <?php echo $opening_hours; ?>
  </div>
  <div class="widget widget-block">
    <p><b><?php site_text('Address');?></b></p>
    <?php echo '<p>'.$address.'</p>'; ?>
  </div>
  <div class="widget widget-hotline">
    <p><b><?php site_text('Hotline');?><a href="tel:<?php echo $hotline; ?>"><?php echo $hotline; ?></a></b></p>
  </div>
</div>
