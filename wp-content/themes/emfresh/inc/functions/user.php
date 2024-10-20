<?php

function site_user_admin_init()
{
    $user = wp_get_current_user();
    if (! in_array('administrator', $user->roles) ) {
        wp_redirect(home_url());
        exit();
    }
}
add_action('admin_init', 'site_user_admin_init');

function site_user_init()
{
    if(get_current_user_id() == 0 && !preg_match('/(login)/', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url('login'));
        exit();
    }
}
add_action('init', 'site_user_init');

function site_user_submit()
{
    if (!empty($_POST['changeptoken'])) {
        site_user_submit_change_password();
    }

    if (!empty($_POST['logtoken'])) {
        site_user_submit_login();
    }

    if (!empty($_GET['logout']) && intval($_GET['logout']) > time()) {
        wp_logout();

        wp_redirect(home_url());
        exit();
    }
}
add_action('wp', 'site_user_submit');

function site_user_submit_change_password()
{
    $redirect_to = get_permalink();

    if (empty($_POST['oldpassword']) || empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
        wp_redirect($redirect_to . '?input=not-null');
        exit();
    }

    if (! wp_verify_nonce($_POST['changeptoken'], 'changeptoken')) {
        wp_redirect($redirect_to . '?token=error');
        exit();
    }

    $args = shortcode_atts(array(
        'newpassword' => '',
        'oldpassword' => '',
        'confirmpassword' => '',
    ), $_POST);

    $args = array_map('sanitize_text_field', $args);

    $errors = [];

    $user = wp_get_current_user();
    if($args['oldpassword'] == '' || !wp_check_password($args['oldpassword'], $user->user_pass, $user->ID)) {
        $errors[] = 'Old Password is not the correct';
    } else if($args['newpassword'] == '' || $args['newpassword'] != $args['confirmpassword']) {
        $errors[] = 'Newpassword not null';
    }

    if(count($errors) > 0) {
        wp_redirect($redirect_to . '?input=error');
        exit();
    }
 
    $user_id = wp_update_user([
        'ID' => $user->ID,
        'user_pass' => $args['newpassword']
    ]);

    wp_logout();

    // wp_redirect(add_query_arg(['change' => 'success-' . $user_id], home_url()));
    wp_redirect(add_query_arg(['change' => 'success'], home_url('login')));
    exit();
}

function site_user_submit_login()
{
    $referer = esc_url(isset($_POST['_wp_http_referer']) ? $_POST['_wp_http_referer'] : home_url());

    if (empty($_POST['uname']) || empty($_POST['upass'])) {
        wp_redirect($referer . '?input=not-null');
        exit();
    }

    if (! wp_verify_nonce($_POST['logtoken'], 'logtoken')) {
        wp_redirect($referer . '?token=error');
        exit();
    }

    $_POST['log'] = $_POST['uname'];
    $_POST['pwd'] = $_POST['upass'];
    $_POST['rememberme'] = 1;

    $secure_cookie   = '';

    // If the user wants SSL but the session is not SSL, force a secure cookie.
    if (! force_ssl_admin()) {
        $user_name = sanitize_user(wp_unslash($_POST['log']));
        $user      = get_user_by('login', $user_name);

        if (! $user && strpos($user_name, '@')) {
            $user = get_user_by('email', $user_name);
        }

        if ($user) {
            if (get_user_option('use_ssl', $user->ID)) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
        }
    }

    $user = wp_signon(array(), $secure_cookie);

    $redirect_to = $referer;
    if (empty($user->ID)) {
        $redirect_to = add_query_arg(['login' => 'error'], home_url('login'));
    }

    wp_redirect($redirect_to);
    exit();
}
 
function site_user_user_session($session = false)
{
    $token = wp_get_session_token();
    if ($token) {
        $manager = WP_Session_Tokens::get_instance(get_current_user_id());
        if (is_array($session)) {
            $manager->update($token, $session);
        } else {
            return $manager->get($token);
        }
    }

    return false;
}

function site_user_session_get($key = '', $clean = false)
{
    $key = 'site_user_' . $key;

    $session = site_user_user_session();

    $value = isset($session[$key]) ? $session[$key] : '';

    if ($clean) {
        unset($session[$key]);
        site_user_user_session($session);
    }

    return $value;
}

function site_user_session_update($key = '', $value = '')
{
    $key = 'site_user_' . $key;

    $session = site_user_user_session();

    $session[$key] = $value;

    site_user_user_session($session);
}
