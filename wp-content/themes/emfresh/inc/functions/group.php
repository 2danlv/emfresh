<?php

function site_group_submit()
{
    global $em_group, $em_customer_group;

    if (!empty($_POST['save_group'])) {

        $group_default = [
            'name' => '',
            'phone' => '',
            'location_id' => 0,
            'note' => '',
        ];

        $data = wp_unslash($_POST);
        
        $errors = [];

        $group_data = shortcode_atts($group_default, $data);

        $group_id = isset($data['group_id']) ? intval($data['group_id']) : 0;

        if($group_id == 0) {
            $response = em_api_request('group/add', $group_data);
            if ($response['code'] == 200) {
                $group_id = $response['data']['insert_id'];
            }
        } else {
            $group_data['id'] = $group_id;

            $response = em_api_request('group/update', $group_data);
        }

        if($group_id > 0) {
            $customers = isset($data['customers']) ? (array) $data['customers'] : [];

            $em_customer_group->update_list($group_id, $customers);
        }

        $query_args = [
            'group_id' => $group_id,
            'expires' => time() + 3,
        ];

        if (count($errors) > 0) {
            $query_args['message'] = 'Errors';
        } else {
            $query_args['message'] = 'Success';
        }

        wp_redirect(add_query_arg($query_args, site_group_edit_link()));
        exit();
    }
}
add_action('wp', 'site_group_submit');

function site_group_list_link()
{
    return get_permalink(156);
}

function site_group_edit_link()
{
    return get_permalink(160);
}