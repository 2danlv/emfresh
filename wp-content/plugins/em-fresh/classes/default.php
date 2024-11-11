<?php
defined('ABSPATH') or die();

require_once 'validation.php';

/**
 * @package EM_Default
 */

class EF_Default
{
    protected $table = '';

    protected $option_name = '';

    protected $table_ver = '1.1';

    protected $author_id = 0;

    protected $author;

    /**
     * Constructor: setups filters and actions
     *
     * @since 1.0
     *
     */
    function __construct()
    {
        add_action('admin_init', array($this, 'admin_init'));
        add_action('init', array($this, 'init'));
    }

    function init()
    {
        $user = wp_get_current_user();
        if (isset($user->ID)) {
            $this->author = $user;
            $this->author_id = (int) $user->ID;
        }
    }

    function admin_init()
    {
        if ($this->table == '' || $this->option_name == '') return;

        $user = wp_get_current_user();
        if (! in_array('administrator', $user->roles) || get_option($this->option_name) == $this->table_ver) {
            return;
        }

        $key = 'customer_manager_create_table';
        $check = isset($_GET[$key]) ? $_GET[$key] : '';
        if ($check == $this->table) {
            return $this->create_table();
        }

        add_settings_field(
            $key . '_' . $this->table,
            __('Table ' . $this->table),
            function () {
                echo '<a href="' . add_query_arg(['customer_manager_create_table' => $this->table]) . '">Create Table</a>';
            },
            'reading',
            'default',
            array()
        );
    }

    function get_tbl_name()
    {
        global $wpdb;

        return $wpdb->prefix . $this->table;
    }

    /*
     * Create a table
     */
    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'title'         => '',
            'content'       => '',
            'created'       => '',
            'created_at'    => 0,
            'modified'      => '',
            'modified_at'   => 0,
        );

        return $fields;
    }

    function get_rules($action = '')
    {
        return [];
    }

    function insert($data = [])
    {
        if ($this->can_insert() == false) {
            return false;
        }

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

        $data = apply_filters("insert_table_{$this->table}_item", $data);

        $wpdb->insert(
            $this->get_tbl_name(),
            $data,
            $type
        );

        do_action("inserted_table_{$this->table}_item", $wpdb->insert_id, $data);

        do_action("inserted_em_table_item", $wpdb->insert_id, $data, $this->table);

        return $wpdb->insert_id;
    }

    function can_insert()
    {
        if ($this->author_id > 0) {
            return true;
        }

        return true;
    }

    function update($data = [])
    {
        $id = isset($data['id']) ? intval($data['id']) : 0;
        if ($id == 0) return false;

        if ($this->can_update() == false) {
            return false;
        }

        global $wpdb;

        $fields = $this->get_fields();

        $em_data = em_get_data_fields($data, $fields);

        unset($em_data['id']);
        unset($em_data['created']);
        unset($em_data['created_at']);

        if (isset($fields['modified'])) {
            $em_data['modified'] = current_time('mysql');
        }

        if (isset($fields['modified_at'])) {
            $em_data['modified_at'] = $this->author_id;
        }

        $type = array_map(function () {
            return '%s';
        }, $fields);

        $em_data = apply_filters("update_table_{$this->table}_item", $em_data, $id);

        $em_data = apply_filters("update_em_table_item", $em_data, $id, $this->table);

        $updated = $wpdb->update(
            $this->get_tbl_name(),
            $em_data,
            array('id' => $id),
            $type,
            array('%d'),
        );

        do_action("updated_table_{$this->table}_item", $em_data, $id);

        do_action("updated_em_table_item", $em_data, $id, $this->table);

        return $updated;
    }

    function update_field($id = 0, $name = '', $value = '')
    {
        global $wpdb;
    
        return $wpdb->update(
            $this->get_tbl_name(),
            array($name => $value),
            array('id' => $id),
            array('%s'),
            array('%d'),
        );
    }

    function can_update()
    {
        if ($this->author_id > 0) {
            return true;
        }

        return true;
    }

    function delete($id = 0)
    {
        global $wpdb;

        if ($this->can_delete() == false) {
            return false;
        }

        do_action("delete_table_{$this->table}_item", $id);

        do_action("delete_em_table_item", $id, $this->table);

        $deleted = $wpdb->delete($this->get_tbl_name(), ['id' => $id], ['%d']);

        do_action("deleted_table_{$this->table}_item", $id, $deleted);

        do_action("deleted_em_table_item", $id, $deleted, $this->table);

        return $deleted;
    }

    function can_delete()
    {
        if ($this->author_id > 0) {
            return true;
        }

        return true;
    }

    function get_items($args = [])
    {
        global $wpdb;

        extract(shortcode_atts(array(
            'orderby'   => 'id DESC',
            'paged'     => 1,
            'offset'    => 0,
            'limit'     => 20,
        ), $args));

        $query = $wpdb->prepare("SELECT * FROM %i ", $this->get_tbl_name());

        $wheres = $this->get_where($args);

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        $query .= sprintf(" ORDER BY %s ", $orderby);

        if ($limit > 0) {
            if ($offset == 0 && $paged > 1) {
                $offset = ($paged - 1) * $limit;
            }

            $query .= sprintf(" LIMIT %d OFFSET %d", $limit, $offset);
        }

        $list = $wpdb->get_results($query, ARRAY_A);

        foreach ($list as $i => $item) {
            $list[$i] = $this->filter_item($item, 'list');
        }

        return $list;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'created_at') {
                    $item['created_author'] = get_the_author_meta('display_name', $value);
                } else if ($key == 'modified_at') {
                    $item['modified_author'] = get_the_author_meta('display_name', $value);
                }
            }
        }

        if ($type == 'list') {
            return $item;
        }

        return $item;
    }

    function count($args = [])
    {
        global $wpdb;

        $query = "SELECT count(*) FROM " . $this->get_tbl_name();

        $wheres = $this->get_where($args);

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        return (int) $wpdb->get_var($query);
    }

    function get_statistic($column = '', $args = [])
    {
        global $wpdb;

        $query = sprintf(" SELECT %s, count(*) AS total ", $column)
                ." FROM %i ";

        $wheres = $this->get_where($args);

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        $query .= sprintf(" GROUP BY %s ", $column);

        echo $query = $wpdb->prepare($query, $this->get_tbl_name());
        
        $list = $wpdb->get_results($query);

        return $list;
    }

    function get_item($id = 0)
    {
        global $wpdb;

        $query = "SELECT * FROM %i WHERE id = %s";

        $item = $wpdb->get_row($wpdb->prepare($query, $this->get_tbl_name(), $id), ARRAY_A);

        return is_array($item) ? $this->filter_item($item, 'detail') : [];
    }

    function get_where($args = [])
    {
        $wheres = [];

        foreach ($args as $name => $value) {
            if ($value != '') {
                $wheres[] = "`$name` = '$value'";
            }
        }

        return $wheres;
    }

    function submit($post = [])
    {
        $validate = new EM_Validation();

        $data = shortcode_atts($this->get_fields(), $post);

        $action = 'add';

        $id = isset($post['id']) ? intval($post['id']) : 0;
        if ($id > 0) {
            $action = 'update';
        }

        $rules = $this->get_rules($action);
        if (count($rules) > 0) {
            $errors = $validate->data($data, $rules);
            if (count($errors) > 0) {
                return $errors;
            }
        }

        $result = '';

        $id = isset($post['id']) ? intval($post['id']) : 0;
        if ($id > 0) {
            $data['id'] = $id;

            $result = $this->update($data) ? 'Updated' : 'Update fail';
        } else {
            $result = $this->insert($data) ? 'Inserted' : 'Insert fail';
        }

        return $result;
    }

    function api($action = '', $response = [])
    {
        if ($action == 'list' || $action == 'item') {
            $args = $_GET;
        } else {
            $args = $_POST;
        }

        return $this->action($action, $response, $args);
    }

    function action($action = '', $response = [], $args = [])
    {
        $errors = [];

        if ($action == 'list') {
            $response['total']  = $this->count($args);
            $response['data']   = $this->get_items($args);
        } else if ($action == 'item') {
            $id = isset($args['id']) ? intval($args['id']) : 0;
            if ($id > 0) {
                $response['data'] = $this->get_item($id);
            } else {
                $response['code'] = 400;
            }
        } else if ($action == 'add' || $action == 'update') {

            $rules = $this->get_rules($action);
            if (count($rules) > 0) {
                $validate = new EM_Validation($this);

                $errors = $validate->data($args, $rules);
            }

            if (count($errors) == 0) {
                if ($action == 'update') {
                    $id = isset($args['id']) ? intval($args['id']) : 0;
                    if ($id == 0 || $this->update($args) == false) {
                        $response['code'] = 400;
                    }
                } else {
                    $insert_id = (int) $this->insert($args);
                    if ($insert_id > 0) {
                        $response['data'] = ['insert_id' => $insert_id];
                    } else {
                        $response['code'] = 400;
                    }
                }
            }
        } else if ($action == 'delete') {
            $id = isset($args['id']) ? intval($args['id']) : 0;
            if ($id == 0 || $this->delete($id) == false) {
                $response['code'] = 400;
            }
        } else {
            $response = ['code' => 400, 'message' => 'Bad route'];
        }

        if (count($errors) > 0) {
            $response = ['code' => 400, 'data' => $errors, 'message' => 'Errors'];
        }

        return $response;
    }
}
