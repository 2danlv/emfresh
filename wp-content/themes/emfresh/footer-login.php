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
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/assets/js/adminlte.min.js?v=3.2.0"></script>
<script>
    $(document).ready(function () {
        localStorage.setItem('DataTables_list-customer_/customer/', '');
		for (let i = 1; i <= 18; i++) {
			localStorage.removeItem('column_' + i);
		}
        localStorage.setItem('DataTables_list-order_/list-order/', '');
		for (let i = 1; i <= 23; i++) {
			localStorage.removeItem('column_order_' + i);
		} 
    });
</script>
</body>
</html>
