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
        add_action('deleted_table_em_group_item', array($this, 'auto_delete_by_group'), 10, 2);
    }

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'group_id' => 0,
            'customer_id' => 0,
            'bag' => 0,
            'order' => 0,
        );

        return $fields;
    }

    function get_filters()
    {
        $filters = [
            'group_id' => '=',
            'customer_id' => '=',
            'bag' => '=',
        ];

        return $filters;
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
    
    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['customer_id' => $id], ['%d']);
        }
    }

    function auto_delete_by_group($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['group_id' => $id], ['%d']);
        }
    }
}

global $em_customer_group;

$em_customer_group = new EM_Customer_Group();
