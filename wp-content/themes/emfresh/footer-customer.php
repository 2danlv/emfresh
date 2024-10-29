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
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/natural.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.8.1/js/dataTables.searchBuilder.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js"></script>
<script>
  $(function () {
    var url = location.href.replace(/\/+$/, ''), //rtrim `/`
        parts = url.split("/"),
        last_part = parts[parts.length - 1];
    if (last_part != "") {
        
            $('.nav-treeview a[href*="/' + last_part + '/"]:first').addClass('active');
        
    }
    

  });
  
</script>
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