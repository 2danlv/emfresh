<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Order
 */

class EM_Order extends EF_Default
{
    protected $table = 'em_order';

    protected $option_name = 'em_order_create_table';

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
            `location_id` bigint NOT NULL,
            `status` tinyint(1) NOT NULL DEFAULT '1',
            `note` text,
            `created` datetime DEFAULT '0000-00-00 00:00:00',
            `created_at` bigint DEFAULT '0',
            `modified` datetime DEFAULT '0000-00-00 00:00:00',
            `modified_at` bigint DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

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
            'location_id'   => 0,
            'status'        => 0,
            'note'          => '',
        );

        return $fields;
    }

    function get_rules($action = '')
    {
        $rules = array(
            'customer_id'   => 'required',
            'location_id'   => 'required',
            'status'        => 'required',
        );

        return $rules;
    }

    function get_statuses($key = null)
    {
        $list = [
            1 => "Rồi",
            2 => "Chưa",
            3 => "COD",
            4 => "1 Phần"
        ];

        if ($key != null) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['customer_id' => $id], ['%d']);
        }
    }
}

global $em_order;

$em_order = new EM_Order();
