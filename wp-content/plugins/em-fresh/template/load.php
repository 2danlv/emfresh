<?php

function em_template_load()
{
    $manager = isset($_GET['manager']) ? sanitize_text_field($_GET['manager']) : '';
    if ($manager != '') {
        $page_url = add_query_arg(['manager' => $manager], home_url());

        $page = false;

        if ($manager == 'customer') {
            require_once(em_path() . '/classes/customer.php');

            $page = new EM_Customer();
        }

        if ($page != false) {
            if (count($_POST) > 0) {
                $result = $page->submit($_POST);
                if(is_string($result)) {
                    wp_redirect(add_query_arg(['result' => $result], $page_url));
                    exit();
                }
            }

            require_once(em_path() . '/template/index.php');
        }

        exit();
    }
}
// add_action('wp', 'em_template_load');