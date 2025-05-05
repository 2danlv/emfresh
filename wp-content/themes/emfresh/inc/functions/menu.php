<?php 

function site_menu_save_data()
{
    global $em_menu;

    // if (!empty($_POST['save_menu']) && wp_verify_nonce($_POST['save_menu'], "menunonce")) 
    if (!empty($_POST['save_menu']))
    {
        $data = wp_unslash($_POST);

        $menu_default = [
            'name' => '',
            'name_en' => '',
            'image' => '',
            'status' => '',
            'type' => '',
            'ingredient' => '',
            'group' => '',
            'tag' => '',
            'note' => '',
            'cooking_times' => '',
            'last_used' => '',
        ];

        $menu_data = shortcode_atts($menu_default, $data);

        $updated = false;

        $menu_id = isset($data['menu_id']) ? intval($data['menu_id']) : 0;

        if(!empty($data['tags']) && is_array($data['tags'])) {
            $menu_data['tag'] = implode(',', $data['tags']);
        }

        if($menu_id == 0) {
            $response = em_api_request('menu/add', $menu_data);
            if ($response['code'] == 200) {
                $menu_id = $em_menu->insert($menu_data);
                $updated = true;
            }
        } else {
            $menu_data['id'] = $menu_id;

            $response = em_api_request('menu/update', $menu_data);
            if ($response['code'] == 200) {
                $updated = true;
            }
        }

        if($menu_id > 0) {
            if (!empty($_FILES['media']) && !empty($_FILES['media']['tmp_name'])) {
                $upload_dir = $em_menu->get_upload_dir();

                $parts = explode('.', $_FILES['media']['name']);

                $filename = $menu_id . '-menu.' . end($parts);

                if (copy($_FILES['media']['tmp_name'], $upload_dir['basedir'] . '/' . $filename)) {
                    $item = $em_menu->get_item($menu_id);
                    if(!empty($item['image_path'])) {
                        @unlink($item['image_path']);
                    }

                    $em_menu->update_field($menu_id, 'image', $filename);
                }
            }
        }

        $query_args = [
            'menu_id' => $menu_id,
            'expires' => time() + 3,
        ];

        if ($updated) {
            $query_args['message'] = 'Menu+success';
        } else {
            $query_args['message'] = 'Menu+fail';
        }

        // site_response_json($query_args);

        wp_redirect(add_query_arg($query_args, site_menu_edit_link()));
        exit();
    }
}
add_action('wp', 'site_menu_save_data');


function site_menu_list_link()
{
    return get_permalink(186);
}

function site_menu_edit_link()
{
    return get_permalink(188);
}