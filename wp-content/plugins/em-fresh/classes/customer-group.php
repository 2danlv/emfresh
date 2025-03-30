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

    function update_list($group_id = 0, $customers = [])
    {
        $count = 0;

        // Sort by order
        $n = count($customers);
        for($i = 1; $i < $n - 1; $i++) {
            for($j = 2; $j < $n; $j++) {
                if($customers[$j]['order'] < $customers[$i]['order']) {
                    $tmp = $customers[$j];
                    $customers[$j] = $customers[$i];
                    $customers[$i] = $tmp;
                }
            }
        }

        $customer_groups = $this->get_items([
            'group_id' => $group_id,
            'orderby' => 'id ASC',
        ]);

        foreach ($customers as $customer) {
            if (empty($customer['id'])) continue;

            $group_data = shortcode_atts([
                'bag' => 0,
                'order' => $count + 1
            ], $customer);

            $group_data['customer_id'] = $customer['id'];

            if (!empty($customer_groups[$count])) {
                $group_data['id'] = $customer_groups[$count]['id'];

                $this->update($group_data);
            } else {
                $group_data['group_id'] = $group_id;
                
                $this->insert($group_data);
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
