<?php
$cates = get_the_category();
$category = $cates && isset($cates[0]) ? $cates[0] : false;
?>
<article class="section section-bg-sup section-page post-single post-detail">
  <div class="page_header">
    <div class="page_title text-center">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
  <div class="container">
    <div class="row page_content">
      <div class="col--4 sidebar_wrapper">
        <?php include get_theme_file_path('sidebar.php'); ?>
      </div>
      <div class="col--8 main_wrapper">
        <div class="main_content">
          <?php the_content();?>
        </div>
      </div>
    </div>
  </div>
</article>
