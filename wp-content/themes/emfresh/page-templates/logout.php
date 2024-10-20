<?php

/**
 * Template Name: Logout
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

?>
    <?php get_header('login');?>
    <form style="display: none;" method="post" action="<?php echo wp_logout_url( home_url() ); ?>">
    <button type="submit" class="logout"></button>
</form>
<!-- <a href="<?php echo wp_logout_url( home_url()); ?>"></a> -->
<?php get_footer('login');
 ?>
 <script>
 $(document).ready(function(){
    //$(".logout").click();
    $(".logout").trigger('click');
});
 </script>