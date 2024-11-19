<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

// site_get_options in inc/admin/setting
// extract( site_get_options() );


?>
<div class="fade modal modal-copy-phone" id="modal-copy">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="form-group d-f ai-center pt-8">
        <i class="fas fa-check-circle mr-8"></i>
        <span>Đã sao chép SĐT</span> <span class="phone-copy"></span>
        <i class="fas fa-trash modal-close"></i>
      </div>
    </div>
  </div>
</div>
</div>
<footer>
    
</footer>
<?php wp_footer(); ?>
</body>
</html>
