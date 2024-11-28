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

?>
</div>
</div>
<div class="fade modal modal-copy-phone" id="modal-copy">
  <div class="modal-dialog">
    <div class="modal-content pt-6">
      <div class="form-group d-f ai-center">
        <i class="fas fa-check-circle mr-8"></i>
        <span>Đã sao chép SĐT</span> <span class="phone-copy"></span>
        <i class="fas fa-trash modal-close"></i>
      </div>
    </div>
  </div>
</div>
</div>
<footer class="main-footer">

</footer>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="<?php echo site_get_template_directory_assets();?>/js/select2/js/select2.full.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/natural.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.8.1/js/dataTables.searchBuilder.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.3/js/dataTables.fixedColumns.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.3/js/fixedColumns.dataTables.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script src="<?php echo site_get_template_directory_assets();?>/js/script.js"></script>

<?php
global $site_scripts;

if(is_array($site_scripts)) {
  foreach($site_scripts as $src) {
    echo '<script src="'.$src.'"></script>' . "\n";
  }
}
?>
</body>
</html>