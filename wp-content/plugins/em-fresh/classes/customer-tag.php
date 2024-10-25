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
}

global $em_customer_tag;

$em_customer_tag = new EM_Customer_Tag();
