<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Customer_Tag
 */

class EM_Customer_Tag extends EF_Default
{
    protected $table = 'em_customer_tag';

    protected $option_name = 'em_customer_tag_create_table';

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
            `tag` tinyint(1) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB;";

        update_option($this->option_name, $this->table_ver);

        return $wpdb->query($sql);
    }

    function get_fields()
    {
        $fields = array(
            'tag_id' => 0,
            'customer_id' => 0,
        );

        return $fields;
    }

    function get_where($args = [])
    {
        $wheres = [];

        $filters = [
            // 'address'   => 'LIKE',
            'tag_id' => '=',
            'customer_id' => '=',
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

            $item = $data;

            $item['name'] = $em_customer->get_tags($item['tag_id']);
        }

        return parent::filter_item($item, $type);
    }

    function update_list($customer_id = 0, $tag_ids = [])
    {
        global $em_customer;
        
        $count = 0;

        $customer_tags = $this->get_items(['customer_id' => $customer_id]);
        $list_tags = array_keys($em_customer->get_tags());

        foreach ($tag_ids as $i => $tag_id) {
            $tag_id = (int) $tag_id;
            if ($tag_id == 0 || in_array($tag_id, $list_tags) == false) continue;

            if (isset($customer_tags[$i])) {
                $this->update([
                    'tag_id' => $tag_id,
                    'id' => $customer_tags[$i]['id']
                ]);
            } else {
                $this->insert([
                    'tag_id' => $tag_id,
                    'customer_id' => $customer_id
                ]);
            }

            $count++;
        }

        for ($i = $count; $i < count($customer_tags); $i++) {
            $this->delete($customer_tags[$i]['id']);
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

global $em_customer_tag;

$em_customer_tag = new EM_Customer_Tag();
