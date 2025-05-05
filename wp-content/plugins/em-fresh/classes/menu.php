<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Menu
 */

class EM_Menu extends EF_Default
{
    protected $table = 'em_menu';

    protected $option_name = 'em_menu_create_table';

    protected $table_ver = '1.0';

    /**
     * Constructor: setups filters and actions
     *
     * @since 1.0
     *
     */
    function __construct()
    {
        parent::__construct();

        add_action('deleted_table_{$this->table}_item', array($this, 'auto_delete_by_menu'), 10, 3);
    }

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
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
            'last_used'     => '',
            'created'       => '',
            'created_at'    => 0,
            'modified'      => '',
            'modified_at'   => 0,
        );

        return $fields;
    }

    function get_filters()
    {
        $filters = array(
            'name'      => 'LIKE',
            'status'    => '=',
            'type'      => '=',
            'note'      => 'LIKE',
        );

        return $filters;
    }

    function get_rules($action = '')
    {
        $rules = array(
            'name' => 'required',
            'status' => 'required',
            'type' => 'required',
        );

        if ($action == 'add') {}

        return $rules;
    }
    
    function get_upload_dir()
    {
        $upload_dir = wp_upload_dir();

        $folder = 'em-menu';

        $upload_dir['baseurl'] .= '/'. $folder;
        $upload_dir['basedir'] .= '/'. $folder;

        if(is_dir($upload_dir['basedir']) == false) {
            @mkdir($upload_dir['basedir'], 0755);
        }

        return $upload_dir;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            $upload_dir = $this->get_upload_dir();

            $setting_fields = [
                'status',
                'type',
                'ingredient',
                'group',
                'tag',
            ];

            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'image') {
                    $item['image_url'] = $value != '' ? $upload_dir['baseurl'] . '/' . ltrim($value, '/') : '';
                    $item['image_path'] = $value != '' ? $upload_dir['basedir'] . '/' . ltrim($value, '/') : '';
                } else if ($key == 'created_at') {
                    $item['created_author'] = get_the_author_meta('display_name', $value);
                } else if ($key == 'modified_at') {
                    $item['modified_author'] = get_the_author_meta('display_name', $value);
                } else if (in_array($key, $setting_fields)) {
                    $labels = $this->get_setting($key);

                    if($key == 'tag') {
                        $key_list = [];

                        $values = array_map('trim', explode(',', $value));
                        
                        foreach($values as $value) {
                            $key_list[$value] = isset($labels[$value]) ? $labels[$value] : '';
                        }

                        $item[$key . '_list'] = $key_list;
                    } else {
                        $item[$key . '_name'] = $value !='' && isset($labels[$value]) ? $labels[$value] : '';
                    }
                }
            }
        }

        return $item;
    }

    function get_select($args = [])
    {
        $list = [
            'Chọn món'
        ];

        $args['orderby'] = "name ASC";

        $items = $this->get_items($args);

        if(count($items) > 0) {
            foreach($items as $item) {
                $list[$item['id']] = $item['name'];
            }
        }

        return $list;
    }

    function get_setting($field = '')
    {
        global $em_menu_options;

        if(empty($em_menu_options)) {
            $em_menu_options = em_admin_get_setting('em_menu_options');
        }

        $list = [];
        
        if(isset($em_menu_options[$field]) && !empty($em_menu_options[$field]['values'])) {
            $values = $em_menu_options[$field]['values'];

            foreach($values as $value) {
                $key = sanitize_title($value);

                $list[$key] = $value;
            }
        }

        return $list;
    }

    function auto_delete_by_menu($id = 0, $deleted = false, $item = [])
    {
        if($id > 0 && $deleted && !empty($item['image_path']) && file_exists($item['image_path'])) {
            chmod($item['image_path'], 0777);

            @unlink($item['image_path']);
        }
    }
}

global $em_menu;

$em_menu = new EM_Menu();
