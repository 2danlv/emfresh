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

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'name'  => '',
            'name_en' => '',
            'status' => '',
            'type' => '',
            'ingredient' => '',
            'group' => '',
            'tag' => '',
            'note'  => '',
            'cooking_times'  => '',
            'last_used'  => '',
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
            'name'  => 'LIKE',
            'type'  => '=',
            'note'  => 'LIKE',
        );

        return $filters;
    }
    
    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            $setting_fields = [
                'status',
                'type',
                'ingredient',
                'group',
                'tag',
            ];

            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'created_at') {
                    $item['created_author'] = get_the_author_meta('display_name', $value);
                } else if ($key == 'modified_at') {
                    $item['modified_author'] = get_the_author_meta('display_name', $value);
                } else if (in_array($key, $setting_fields)) {
                    $labels = $this->get_setting($key);

                    $item[$key . '_name'] = $value !='' && isset($labels[$value]) ? $labels[$value] : '';
                }
            }
        }

        if ($type == 'list') {
            return $item;
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
        $menu_options = em_admin_get_setting('em_menu_options', 'list_note');

        $list = [];
        
        if(isset($menu_options[$field]) && !empty($menu_options[$field]['values'])) {
            $values = $menu_options[$field]['values'];

            foreach($values as $value) {
                $key = sanitize_title($value);

                $list[$key] = $value;
            }
        }

        return $list;
    }
}

global $em_menu;

$em_menu = new EM_Menu();
