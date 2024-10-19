<?php
/*
 * https://contactform7.com/2015/03/28/custom-validation/
 * 
 */ 
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

add_filter('wpcf7_validate_email*', 'site_custom_email_confirmation_validation_filter', 20, 2);

function site_custom_email_confirmation_validation_filter($result, $tag) {
    if ('your-email-confirm' == $tag->name) {
        $your_email = isset($_POST['your-email']) ? trim($_POST['your-email']) : '';
        $your_email_confirm = isset($_POST['your-email-confirm']) ? trim($_POST['your-email-confirm']) : '';

        if ($your_email != $your_email_confirm) {
            $result->invalidate($tag, site_text( "E-mail Address don't match.", false ) );
        }
    }

    return $result;
}