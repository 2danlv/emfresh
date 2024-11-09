<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Log
 */

class EM_Log extends EF_Default
{
    protected $table = 'em_log';

    protected $option_name = 'em_log_create_table';

    protected $table_ver = '1.0';

    /**
     * Constructor: setups filters and actions
     *
     * @since 1.0
     *
     */
    // function __construct()
    // {
    //     parent::__construct();

    //     add_action('inserted_em_table_item', array($this, 'inserted_em_table_item'), 10, 3);
    //     add_filter('update_em_table_item', array($this, 'update_em_table_item'), 10, 3);
    //     add_action('updated_em_table_item', array($this, 'updated_em_table_item'), 10, 3);
    //     add_action('delete_em_table_item', array($this, 'delete_em_table_item'), 10, 3);
    //     add_action('deleted_em_table_item', array($this, 'deleted_em_table_item'), 10, 3);
    // }

    function create_table()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . $this->table;

        $sql = "DROP TABLE IF EXISTS `{$table_name}`;
        CREATE TABLE `{$table_name}` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `title` varchar(500) NOT NULL,
            `action` varchar(10) NOT NULL,
            `module` varchar(20) NOT NULL,
            `description` text NOT NULL DEFAULT '',
            `data` text NOT NULL,
            `created` datetime DEFAULT '0000-00-00 00:00:00',
            `created_at` bigint(20) DEFAULT 0,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        update_option($this->option_name, $this->table_ver);

        return $wpdb->query($sql);
    }

    function get_fields()
    {
        $fields = array(
            'action'        => '',
            'module'        => '',
            'module_id'     => 0,
            'content'       => '',
            'created'       => '',
            'created_at'    => 0,
        );

        return $fields;
    }

    function get_rules($action = '')
    {
        $rules = array(
            'action'        => 'required',
            'module'        => 'required',
        );

        return $rules;
    }

    function get_data($table_name = '', $data = [])
    {
        $log_data = $this->get_fields();

        $log_data['module'] = $table_name;

        $customer_id = (int) $data['id'];

        if ($table_name != 'em_customer') {
            $customer_id = (int) $data['customer_id'];
        }

        $log_data['customer_id'] = $customer_id;

        return $log_data;
    }

    function get_table_item($table_name = '', $id = 0)
    {
        global $wpdb, $em_log_old;

        $key = sprintf('%s-%s', $table_name, $id);

        if (empty($em_log_old[$key])) {
            $query = $wpdb->prepare("SELECT * FROM %i WHERE id = %s", $wpdb->prefix . $table_name, $id);

            $item = $wpdb->get_row($query, ARRAY_A);

            $em_log_old[$key] = $this->get_item_by($id, $table_name);
        }

        return $em_log_old[$key];
    }

    function insert($data = [])
    {
        global $wpdb;

        $fields = $this->get_fields();

        $data = shortcode_atts($fields, $data);

        if (isset($data['created']) && $data['created'] == '') {
            $data['created'] = current_time('mysql');
        }

        if (isset($data['created_at']) && $data['created_at'] == 0) {
            $data['created_at'] = $this->author_id;
        }

        $type = array_map(function () {
            return '%s';
        }, $fields);

        $wpdb->insert(
            $this->get_tbl_name(),
            $data,
            $type
        );

        return $wpdb->insert_id;
    }

    function inserted_em_table_item($insert_id = 0, $data = [], $table_name = '')
    {
        if ($this->table == $table_name) return $insert_id;

        $log_data = $this->get_data($table_name, $data);

        $log_data['action'] = 'Tạo';

        $this->insert($log_data);
    }

    function update_em_table_item($data = [], $id = 0, $table_name = '')
    {
        if ($this->table != $table_name) {
            $this->get_table_item($table_name, $id);
        }

        return $data;
    }

    function updated_em_table_item($data = [], $id = 0, $table_name = '')
    {
        if ($this->table == $table_name) return $data;

        $log_data = $this->get_data($table_name, $data);

        $log_data['action'] = 'Cập nhật';

        $this->insert($log_data);
    }

    function delete_em_table_item($id = 0, $table_name = '')
    {
        if ($this->table != $table_name) {
            $this->get_table_item($table_name, $id);
        }
    }

    function deleted_em_table_item($id = 0, $deleted = false, $table_name = '')
    {
        if ($this->table == $table_name || $deleted == false) return $deleted;

        $old = $this->get_table_item($table_name, $id);

        $log_data = $this->get_data($table_name, $old);

        $log_data['action'] = 'Xóa';

        $this->insert($log_data);
    }
}

global $em_log;

$em_log = new EM_Log();
