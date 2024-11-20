<?php

function site_comment_submiting()
{
    if (isset($_GET['pin-id']) && isset($_GET['pin-token'])) {
        $data = wp_unslash($_GET);

        if (!wp_verify_nonce($data['pin-token'], 'pintoken')) {
            return;
        }

        $comment_ID = (int) $data['pin-id'];
        $comment_current = get_comment($comment_ID);

        $comments = get_comments(array(
            'type' => 'customer',
            'status' => 'any',
            'post_id' => $comment_current->comment_post_ID,
            'order' => 'DESC',
            'parent' => 0,
        ));

        foreach ($comments as $comment) {
            update_comment_meta($comment->comment_ID, 'pin', $comment->comment_ID == $comment_ID ? 1 : 0);
        }

        site_comment_log($comment_current, 'Ghim');

        $page_url = esc_url(remove_query_arg(['pin-id', 'pin-token']));

        $json = array('code' => 200, 'message' => 'Pin success', 'tab' => 'note');

        wp_safe_redirect(add_query_arg($json, $page_url));
        exit;
    }

    if (isset($_GET['comtoken']) && isset($_GET['delete_comment'])) {
        $data = wp_unslash($_GET);

        $comment_ID = isset($data['delete_comment']) ? intval($data['delete_comment']) : 0;

        if (wp_verify_nonce($data['comtoken'], 'comtoken') && $comment_ID > 0) {
            $json = site_comment_delete([
                'comment_ID' => $comment_ID
            ]);

            update_comment_meta($comment_ID, 'pin', 0);
        } else {
            $json = array('code' => 403, 'message' => 'Lỗi phiên');
        }

        $json['expire'] = time() + 5;
        $json['message'] = site_base64_encode($json['message']);
        $json['tab'] = 'note';

        $page_url = esc_url(remove_query_arg(['delete_comment', 'comtoken']));

        wp_safe_redirect(add_query_arg($json, $page_url));
        exit;
    }

    if (empty($_POST['comtoken'])) return;

    $data = wp_unslash($_POST);

    if (wp_verify_nonce($data['comtoken'], 'comtoken')) {
        $comment_ID = isset($data['comment_ID']) ? intval($data['comment_ID']) : 0;
        if ($comment_ID > 0) {
            $json = site_comment_update($data);
        } else {
            $json = site_comment_add($data);
        }

        if (!empty($data['ajax_i'])) {
            die(json_encode($json));
            exit;
        }

        $pagenum_link = html_entity_decode(get_pagenum_link());

        $json['expire'] = time() + 5;
        $json['message'] = site_base64_encode($json['message']);
        $json['tab'] = 'note';
        
        wp_safe_redirect(add_query_arg($json, $pagenum_link));
        exit;
    }
}
add_action('wp', 'site_comment_submiting');

function site_comment_deleted_table_em_customer_item($comment_post_ID)
{
    $comments = get_comments(array(
        'type' => 'customer',
        'status' => 'any',
        'post_id' => $comment_post_ID,
        'order' => 'DESC',
        'parent' => 0,
    ));

    foreach ($comments as $comment) {
        wp_delete_comment($comment->comment_ID, true);
    }
}
add_action("deleted_table_em_customer_item", 'site_comment_deleted_table_em_customer_item');

function site_comment_log($comment, $action = '')
{
    global $em_log;

    if (isset($em_log) && is_object($comment)) {

        $log_content = sprintf('<span class="memo">Ghi chú</span><span class="note-detail">%s</span>', $comment->comment_content);

        // Log update
        $em_log->insert([
            'action'        => $action,
            'module'        => 'em_customer',
            'module_id'     => $comment->comment_post_ID,
            'content'       => $log_content
        ]);
    }
}

function site_comment_update($data)
{
    $comment_ID = isset($data['comment_ID']) ? intval($data['comment_ID']) : 0;

    $comment_data = $data;
    $comment_data['comment_parent'] = $comment_ID;
    $comment_data['comment_ID'] = 0;
    site_comment_add($comment_data);

    $comment = wp_update_comment([
        'comment_ID' => $comment_ID,
        'comment_content' => $data['comment'],
    ]);

    if (is_wp_error($comment)) {
        $message = 'Cập nhật bình luận không thành công';

        $error = (int) $comment->get_error_data();
        if (! empty($error)) {
            $message = $comment->get_error_message();
        }

        $json = array('code' => 403, 'message' => $message);
    } else {
        update_comment_meta($comment_ID, 'status', 'Cập nhật');

        site_comment_log(get_comment($comment_ID), 'Cập nhật');

        $json = array('code' => 200, 'message' => 'Cập nhật bình luận thành công');
    }

    return $json;
}

function site_comment_can_edit($comment_ID = 0)
{
    $comment = get_comment($comment_ID);
    if (empty($comment->user_id)) {
        return false;
    }

    $user = wp_get_current_user();
    if (empty($user->ID) || $user->ID != $comment->user_id) {
        return false;
    }

    return true;
}

function site_comment_get_delete_link($comment_ID = 0)
{
    if (site_comment_can_edit($comment_ID) == false) {
        return '#';
    }

    $pagenum_link = html_entity_decode(get_pagenum_link());
    // $url_parts    = explode('?', $pagenum_link);

    $page_url = esc_url(remove_query_arg(['code', 'message', 'expire'], $pagenum_link));

    $url = add_query_arg([
        'delete_comment' => $comment_ID,
        'comtoken' => wp_create_nonce('comtoken'),
    ], $page_url);

    return $url;
}

function site_comment_get_pin_link($comment_ID = 0)
{
    $pagenum_link = html_entity_decode(get_pagenum_link());

    $page_url = esc_url(remove_query_arg(['code', 'message', 'expire'], $pagenum_link));

    $url = add_query_arg([
        'pin-id' => $comment_ID,
        'pin-token' => wp_create_nonce('pintoken'),
    ], $page_url);

    return $url;
}

function site_comment_delete($data)
{
    $comment_ID = intval($data['comment_ID']);

    $comment = wp_update_comment([
        'comment_ID' => $comment_ID,
        'comment_approved' => 0,
    ]);

    if (is_wp_error($comment)) {
        $message = 'Xóa bình luận không thành công';

        $error = (int) $comment->get_error_data();
        if (! empty($error)) {
            $message = $comment->get_error_message();
        }

        $json = array('code' => 403, 'message' => $message);
    } else {
        // update_comment_meta($comment_ID, 'status', 'Xóa');
        update_comment_meta($comment_ID, 'delete_by', get_current_user_id());
        update_comment_meta($comment_ID, 'delete_at', current_time('mysql'));

        site_comment_log(get_comment($comment_ID), 'Xóa');

        $json = array('code' => 200, 'message' => 'Xóa bình luận thành công');
    }

    return $json;
}

function site_comment_add($data)
{
    $data['comment_type'] = 'customer';

    // $comment = wp_handle_comment_submission($data);

    $comment = site_handle_comment_submission($data);
    if (is_wp_error($comment)) {
        $message = 'Bình luận không thành công';

        $error = (int) $comment->get_error_data();
        if (! empty($error)) {
            $message = $comment->get_error_message();
        }

        $json = array('code' => 403, 'message' => $message);
    } else {
        site_comment_log($comment, 'Tạo');

        $json = array('code' => 200, 'message' => 'Bình luận thành công');
    }

    return $json;
}

function site_handle_comment_submission($comment_data = [])
{
    $comment_post_id      = 0;
    $comment_author       = '';
    $comment_author_email = '';
    $comment_author_url   = '';
    $comment_content      = '';
    $comment_parent       = 0;
    $user_id              = 0;

    if (isset($comment_data['comment_post_ID'])) {
        $comment_post_id = (int) $comment_data['comment_post_ID'];
    }
    if (isset($comment_data['author']) && is_string($comment_data['author'])) {
        $comment_author = trim(strip_tags($comment_data['author']));
    }
    if (isset($comment_data['email']) && is_string($comment_data['email'])) {
        $comment_author_email = trim($comment_data['email']);
    }
    if (isset($comment_data['url']) && is_string($comment_data['url'])) {
        $comment_author_url = trim($comment_data['url']);
    }
    if (isset($comment_data['comment']) && is_string($comment_data['comment'])) {
        $comment_content = trim($comment_data['comment']);
    }
    if (isset($comment_data['comment_parent'])) {
        $comment_parent = (int) $comment_data['comment_parent'];
    }

    /*
    $post = get_post( $comment_post_id );
	if ( empty( $post->comment_status ) ) { 
		do_action( 'comment_id_not_found', $comment_post_id );
		return new WP_Error( 'comment_id_not_found' );
	}
    */

    // If the user is logged in.
    $user = wp_get_current_user();
    if ($user->exists()) {
        if (empty($user->display_name)) {
            $user->display_name = $user->user_login;
        }

        $comment_author       = $user->display_name;
        $comment_author_email = $user->user_email;
        $comment_author_url   = $user->user_url;
        $user_id              = $user->ID;

        if (current_user_can('unfiltered_html')) {
            if (
                ! isset($comment_data['_wp_unfiltered_html_comment'])
                || ! wp_verify_nonce($comment_data['_wp_unfiltered_html_comment'], 'unfiltered-html-comment_' . $comment_post_id)
            ) {
                kses_remove_filters(); // Start with a clean slate.
                kses_init_filters();   // Set up the filters.
                remove_filter('pre_comment_content', 'wp_filter_post_kses');
                add_filter('pre_comment_content', 'wp_filter_kses');
            }
        }
    } else {
        if (get_option('comment_registration')) {
            return new WP_Error('not_logged_in', __('Sorry, you must be logged in to comment.'), 403);
        }
    }

    $comment_type = 'comment';
    if (!empty($comment_data['comment_type'])) {
        $comment_type = $comment_data['comment_type'];
    }

    if (get_option('require_name_email') && ! $user->exists()) {
        if ('' == $comment_author_email || '' == $comment_author) {
            return new WP_Error('require_name_email', __('<strong>Error:</strong> Please fill the required fields.'), 200);
        } elseif (! is_email($comment_author_email)) {
            return new WP_Error('require_valid_email', __('<strong>Error:</strong> Please enter a valid email address.'), 200);
        }
    }

    $commentdata = array(
        'comment_post_ID' => $comment_post_id,
    );

    $commentdata += compact(
        'comment_author',
        'comment_author_email',
        'comment_author_url',
        'comment_content',
        'comment_type',
        'comment_parent',
        'user_id'
    );

    /**
     * Filters whether an empty comment should be allowed.
     *
     * @since 5.1.0
     *
     * @param bool  $allow_empty_comment Whether to allow empty comments. Default false.
     * @param array $commentdata         Array of comment data to be sent to wp_insert_comment().
     */
    $allow_empty_comment = apply_filters('allow_empty_comment', false, $commentdata);
    if ('' === $comment_content && ! $allow_empty_comment) {
        return new WP_Error('require_valid_comment', __('<strong>Error:</strong> Please type your comment text.'), 200);
    }

    $check_max_lengths = wp_check_comment_data_max_lengths($commentdata);
    if (is_wp_error($check_max_lengths)) {
        return $check_max_lengths;
    }

    $comment_id = wp_new_comment(wp_slash($commentdata), true);
    if (is_wp_error($comment_id)) {
        return $comment_id;
    }

    if (! $comment_id) {
        return new WP_Error('comment_save_error', __('<strong>Error:</strong> The comment could not be saved. Please try again later.'), 500);
    }

    return get_comment($comment_id);
}
