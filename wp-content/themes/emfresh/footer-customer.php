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
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/natural.js"></script>
<script>
  $(function () {
    var url = location.href.replace(/\/+$/, ''), //rtrim `/`
        parts = url.split("/"),
        last_part = parts[parts.length - 1];
    if (last_part != "") {
        
            $('.nav-treeview a[href*="/' + last_part + '/"]:first').addClass('active');
        
    }
    const table = new DataTable('#example1', {
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": true,
      //"buttons": ["csv", "excel", "pdf"],
      'order': [[8, 'desc']],
      "lengthChange": true,
      'lengthMenu': [50, 100, 200],
      "columnDefs": [
        { type: 'natural', 
          "targets": [0,1,2,3],
          "orderable": false
        }
     ],
    });
    $('.filter input[type="checkbox"]').on('change', function(e) {
      
      
      // Get the column API object
      var col = table.column($(this).attr('data-column'));
      
      // Toggle the visibility
      col.visible(!col.visible());
    });

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