<?php

function site_user_submits()
{
    if (!empty($_POST['logtoken'])) {
        site_user_submit_login();
    }

    if (!empty($_GET['logout']) && $_GET['logout'] > 0 && get_current_user_id() > 0) {
        wp_logout();
    }
}
add_action('wp', 'site_user_submits');

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
