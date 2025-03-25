<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Customer_Group
 */

class EM_Customer_Group extends EF_Default
{
    protected $table = 'em_customer_group';

    protected $option_name = 'em_customer_group_create_table';

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

        $table_name = $this->get_tbl_name();

        $sql = "DROP TABLE IF EXISTS `{$table_name}`;
        CREATE TABLE `{$table_name}` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `customer_id` bigint NOT NULL,
            `group_id` tinyint(1) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB;";

        update_option($this->option_name, $this->table_ver);

        return $wpdb->query($sql);
    }

    function get_fields()
    {
        $fields = array(
            'group_id' => 0,
            'customer_id' => 0,
            'bag' => 0,
        );

        return $fields;
    }

    function get_where($args = [])
    {
        $wheres = [];

        $filters = [
            'group_id' => '=',
            'customer_id' => '=',
            'bag' => '=',
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

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            global $em_customer;
            
            $customer = $em_customer->get_item($data['customer_id']);
            
            $item = array_merge($customer, $data);
        }

        return parent::filter_item($item, $type);
    }

    function update_list($group_id = 0, $customers = [])
    {
        $count = 0;

        $customer_groups = $this->get_items(['group_id' => $group_id]);

        foreach ($customers as $customer) {
            if (empty($customer['id'])) continue;

            $bag = !empty($customer['bag']) ? 1 : 0;

            if (!empty($customer_groups[$count])) {
                $this->update([
                    'customer_id' => $customer['id'],
                    'bag' => $bag,
                    'id' => $customer_groups[$count]['id']
                ]);
            } else {
                $this->insert([
                    'group_id' => $group_id,
                    'bag' => $bag,
                    'customer_id' => $customer['id']
                ]);
            }

            $count++;
        }

        for ($i = $count; $i < count($customer_groups); $i++) {
            $this->delete($customer_groups[$i]['id']);
        }

        return $count > 0;
    }
    
    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['customer_id' => $id], ['%d']);
        }
    }
}

global $em_customer_group;

$em_customer_group = new EM_Customer_Group();
