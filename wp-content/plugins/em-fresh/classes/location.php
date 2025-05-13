<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Location
 */

class EM_Location extends EF_Default
{
    protected $table = 'em_location';

    protected $option_name = 'em_location_create_table';

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

        add_action('deleted_table_em_customer_item', array($this, 'auto_delete_by_customer'), 10, 2);
    }

    function create_table()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . $this->table;

        $sql = "DROP TABLE IF EXISTS `{$table_name}`;
        CREATE TABLE `{$table_name}` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `customer_id` bigint NOT NULL,
            `address` text COLLATE utf8mb4_general_ci NOT NULL,
            `ward` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `district` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `note_shipper` text COLLATE utf8mb4_general_ci DEFAULT NULL,
            `note_admin` text COLLATE utf8mb4_general_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        update_option($this->option_name, $this->table_ver);

        return $wpdb->query($sql);
    }

    function get_where($args = [])
    {
        extract(shortcode_atts(array(
            'customer_id' => 0,
        ), $args));

        $wheres = [
            "`customer_id` = '$customer_id'"
        ];

        $filters = [
            'active'    => '',
            'address'   => 'LIKE',
            'ward'      => '',
            'district'  => '',
            'city'      => '',
        ];

        foreach ($filters as $name => $rule) {
            if (!empty($args[$name])) {
                $value = sanitize_text_field($args[$name]);

                if ($rule == 'LIKE') {
                    $wheres[] = "`$name` LIKE '%{$value}%'";
                } else {
                    $wheres[] = "`$name` = '$value'";
                }
            }
        }

        return $wheres;
    }

    function get_fields()
    {
        $fields = array(
            'customer_id'   => 0,
            'active'        => 0,
            'address'       => '',
            'ward'          => '',
            'district'      => '',
            'city'          => '',
            'note_shipper'  => '',
            'note_admin'    => '',
        );

        return $fields;
    }

    function get_rules($action = '')
    {
        $rules = array(
            'customer_id'   => 'required',
            'address'       => 'required',
            'ward'          => 'required',
            'district'      => 'required',
            'city'          => 'required',
        );

        return $rules;
    }

    function get_items($args = [])
    {
        global $em_customer_group, $em_group;
        
        $list = parent::get_items($args);

        if(count($list) > 0) {
            $first = $list[0];

            $group = $em_group->get_fields();

            if(!empty($first['customer_id'])) {
                $group_id = (int) $em_customer_group->get_field_by('group_id', ['customer_id' => $first['customer_id']]);
                $group_data = $group_id > 0 ? $em_group->get_item($group_id) : [];
                if(!empty($group_data['location_id'])) {
                    $group = $group_data;
                }
            }

            $group_count = 0;

            foreach($list as $i => $item) {
                $item['group_id'] = 0;
                $item['group_name'] = '';

                if($item['id'] == $group['location_id']) {
                    $item['group_id'] = $group['id'];
                    $item['group_name'] = $group['name'];

                    $group_count++;
                }

                $list[$i] = $item;
            }

            if($group_count == 0 && !empty($group['id'])) {
                $item = $this->get_item($group['location_id']);

                $item['group_id'] = $group['id'];
                $item['group_name'] = $group['name'];

                $list = array_merge([$item], $list);
            }
        }

        return $list;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'id') {
                    $item['location_name'] = $this->get_fullname($data);
                }
            }
        }

        if ($type == 'list') {
            return $item;
        }

        return $item;
    }

    function get_fullname($item)
    {
        $data = [];

        if(is_numeric($item) && $item > 0) {
            $item = $this->get_item($item);
        }

        if(!empty($item['id'])) {
            $fields = array(
                'address',
                'ward',
                'district',
            );

            foreach($fields as $key) {
                if(!empty($item[$key])) {
                    $data[$key] = $item[$key];
                }
            }
        }
        
        return implode(', ', $data);
    }

    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['customer_id' => $id], ['%d']);
        }
    }
}

global $em_location;

$em_location = new EM_Location();
