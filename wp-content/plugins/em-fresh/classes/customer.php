<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Customer
 */

class EM_Customer extends EF_Default
{
    protected $table = 'em_customer';

    protected $option_name = 'em_customer_create_table';

    protected $table_ver = '1.1';

    function create_table()
    {
        global $wpdb;

        $table_name = $this->get_tbl_name();

        $sql = "DROP TABLE IF EXISTS `{$table_name}`;
        CREATE TABLE `{$table_name}` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `fullname` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
            `nickname` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `phone` text COLLATE utf8mb4_general_ci,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `status` tinyint(1) NOT NULL DEFAULT '1',
            `gender` tinyint(1) NOT NULL DEFAULT '0',
            `tag` tinyint(1) NOT NULL DEFAULT '1',
            `note` text COLLATE utf8mb4_general_ci,
            `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
            `point` int NOT NULL DEFAULT '0',
            `parent` bigint NOT NULL DEFAULT '0',
            `created` datetime DEFAULT NULL,
            `created_at` bigint DEFAULT NULL,
            `modified` datetime DEFAULT NULL,
            `modified_at` bigint DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        update_option($this->option_name, $this->table_ver);

        return $wpdb->query($sql);
    }

    // Save history
    function update($data = [])
    {
        $id = isset($data['id']) ? intval($data['id']) : 0;
        if ($id == 0) return false;

        $history = $this->get_item($id);

        $updated = parent::update($data);

        if ($updated) {
            // add history
            unset($history['id']);

            $history['parent'] = $id;

            $this->insert($history);
        }

        return $updated;
    }

    // Only administrator can delete
    function delete($id = 0)
    {
        global $wpdb;

        if ($this->can_delete() == false) {
            return false;
        }

        if (is_array($this->author->roles) == false || in_array('administrator', $this->author->roles) == false) {
            return false;
        }

        $deleted = parent::delete($id);

        if ($deleted != false) {
            // delete history
            $wpdb->delete($this->get_tbl_name(), ['parent' => $id], ['%d']);
        }

        return $deleted;
    }

    function get_items($args = [], $type = 'list')
    {
        global $wpdb;

        $table_customer = $this->get_tbl_name();
        $table_location = $wpdb->prefix . 'em_location';
        $tbl_prefix = 'customer.';

        extract(shortcode_atts(array(
            'orderby'   => $tbl_prefix . 'id DESC',
            'paged'     => 1,
            'offset'    => 0,
            'limit'     => 20,
        ), $args));

        $wheres = $this->get_where($args, $tbl_prefix);

        // Location
        $location_wheres = $this->get_where($args, 'location.');

        $query = " SELECT * FROM $table_customer AS customer ";

        if (count($location_wheres) > 0) {
            $wheres = array_merge($wheres, $location_wheres);

            $query .= " JOIN $table_location AS location ON location.customer_id = customer.id ";
        }

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        $query .= " ORDER BY $orderby ";

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

    function count($args = [])
    {
        global $wpdb;

        $table_customer = $this->get_tbl_name();
        $table_location = $wpdb->prefix . 'em_location';
        $tbl_prefix = 'customer.';

        $wheres = $this->get_where($args, $tbl_prefix);

        // Location
        $location_wheres = $this->get_where($args, 'location.');

        $query = " SELECT count(*) FROM $table_customer AS customer ";

        if (count($location_wheres) > 0) {
            $wheres = array_merge($wheres, $location_wheres);

            $query .= " JOIN $table_location AS location ON location.customer_id = customer.id ";
        }

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        return (int) $wpdb->get_var($query);
    }

    function get_statistic($column = '', $args = [])
    {
        global $wpdb;

        $table_location = $wpdb->prefix . 'em_location';
        $tbl_prefix = 'customer.';

        $wheres = $this->get_where($args, $tbl_prefix);

        // Location
        $location_wheres = $this->get_where($args, 'location.');

        $query = sprintf(" SELECT %s`%s`, count(*) AS total FROM %s AS customer ", $tbl_prefix, $column, $this->get_tbl_name());

        if (count($location_wheres) > 0) {
            $wheres = array_merge($wheres, $location_wheres);

            $query .= " JOIN $table_location AS location ON location.customer_id = customer.id ";
        }

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        $query .= sprintf(" GROUP BY %s`%s` ", $tbl_prefix, $column);

        $list = $wpdb->get_results($query, ARRAY_A);

        return $list;
    }

    function exists($args = [])
    {
        global $wpdb;

        $wheres = $this->get_where($args, '');

        $query = " SELECT count(*) FROM " . $this->get_tbl_name();

        if (count($wheres) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }

        $count = (int) $wpdb->get_var($query);

        return $count > 0;
    }

    function get_where($args = [], $tbl_prefix = 'customer.')
    {
        $wheres = [];

        if ($tbl_prefix == 'location.') {
            $filters = [
                'address'   => 'LIKE',
                'ward'      => '=',
                'district'  => '=',
                'city'      => '=',
            ];
        } else {
            extract(shortcode_atts(array(
                'parent'    => 0,
            ), $args));

            $wheres[] = "{$tbl_prefix}`parent` = $parent";

            $filters = [
                'fullname'  => 'LIKE',
                'phone'     => '=',
                'point'     => '=',
                'status'    => '=',
            ];

            $date_filters = [
                'date'      => '%Y-%m-%d',
                'day'       => '%d',
                'month'     => '%m',
                'year'      => '%Y',
                'week'      => '%u', // Monday is the first day of the week; 
            ];

            foreach ($date_filters as $name => $format) {
                if (!empty($args[$name])) {
                    $value = sanitize_text_field($args[$name]);
                    
                    $wheres[] =  "DATE_FORMAT({$tbl_prefix}`created`, '$format') = '$value'";
                }
            }
        }

        foreach ($filters as $name => $rule) {
            if (!empty($args[$name])) {
                $value = sanitize_text_field($args[$name]);

                if ($rule == 'LIKE') {
                    $wheres[] = "{$tbl_prefix}`$name` LIKE '%{$value}%'";
                } else {
                    $wheres[] = "{$tbl_prefix}`$name` = '$value'";
                }
            }
        }

        return $wheres;
    }

    function get_fields()
    {
        $fields = array(
            'fullname'      => '',
            'nickname'      => '',
            'phone'         => '',
            'active'        => 1,
            'status'        => 1,
            'gender'        => 0,
            'note'          => '',
            'tag'           => 0,
            'address'       => '',
            'point'         => 0,
            'parent'        => 0,
            'created'       => '',
            'created_at'    => 0,
            'modified'      => '',
            'modified_at'   => 0,
        );

        return $fields;
    }

    function get_rules($action = '')
    {
        $rules = array(
            'fullname'      => 'required',
            'phone'         => 'phone',
            'status'        => 'min:1,max:3',
            'gender'        => 'min:1,max:3',
            'tag'           => 'min:1,max:5',
        );

        if ($action == 'add') {
            $rules['phone'] = 'phone:exists';
        }

        return $rules;
    }

    function get_genders($key = 0)
    {
        $list = [
            1 => 'nam',
            2 => 'nữ',
            3 => 'không có thông tin'
        ];

        if ($key > 0) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_statuses($key = 0)
    {
        $list = [
            1 => 'đặt đơn',
            2 => 'dí món',
            3 => 'chưa rõ'
        ];

        if ($key > 0) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_tags($key = 0)
    {
        $list = [
            1 => 'thân thiết',
            2 => 'ăn nhóm',
            3 => 'khách có bệnh lý',
            4 => 'khách hãm',
            5 => 'bảo lưu'
        ];

        if ($key > 0) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_actives($key = 0)
    {
        $list = [
            0 => 'inactive',
            1 => 'active'
        ];

        if ($key > 0) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    /**
     * 
     * @params $data array fields
     * @params $type string [list, detail]
     * 
     * @return $data array fields
     */
    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'gender') {
                    $item['gender_name'] = ucwords($this->get_genders($value));
                } else if ($key == 'status') {
                    $item['status_name'] = ucwords($this->get_statuses($value));
                } else if ($key == 'tag') {
                    $item['tag_name'] = ucwords($this->get_tags($value));
                } else if ($key == 'active') {
                    $item['active_name'] = ucwords($this->get_actives($value));
                }
            }
        }

        return parent::filter_item($item, $type);
    }

    function get_history($id = 0)
    {
        if ($id == 0) return [];

        return $this->get_items(['parent' => $id, 'limit' => 30000]);
    }

    function get_model($id = 0)
    {
        $fields = array(
            'fullname'      => 'text',
            'phone'         => 'text',
            'status'        => 'number',
            'gender'        => 'number',
            'note'          => 'textarea',
            'tag'           => 'number',
            'address'       => 'textarea',
        );

        $rules = $this->get_rules();

        $item = [];

        if (count($_POST) > 0) {
            $item = array_map('trim', $_POST);
        } else if ($id > 0) {
            $item = (array) $this->get_item($id);
        }

        foreach ($fields as $name => $type) {
            $input = [
                'name'  => $name,
                'value' => isset($item[$name]) ? $item[$name] : '',
                'type'  => $type,
                'label' => ucwords(str_replace('_', ' ', $name)),
                'required' => isset($rules[$name]) ? 'required' : '',
            ];

            $fields[$name] = $input;
        }

        return $fields;
    }

    function action($action = '', $response = [], $args = [])
    {
        if ($action == 'history') {
            $id = isset($args['customer_id']) ? intval($args['customer_id']) : 0;
            if ($id > 0) {
                $response['data'] = $this->get_history($id);
            } else {
                $response['code'] = 400;
            }

            return $response;
        } else if ($action == 'add' || $action == 'update') {
            $errors = [];

            $validate = new EM_Validation($this);

            $rules = $this->get_rules();
            if (count($rules) > 0) {
                $errors = $validate->data($args, $rules);
            }

            if (count($errors) == 0) {
                $check_phone_exists = false;

                if ($action == 'update') {
                    $id = isset($args['id']) ? intval($args['id']) : 0;
                    if ($id > 0 && ($item = $this->get_item($id)) && isset($item['phone'])) {
                        if ($item['phone'] != $args['phone']) {
                            $check_phone_exists = true;
                        }
                    } else {
                        $errors['id'] = 'Dữ liệu rỗng';
                    }
                } else {
                    $check_phone_exists = true;
                }

                if ($check_phone_exists) {
                    $error = $validate->item($args['phone'], 'phone', 'exists');
                    if ($error != '') {
                        $errors['phone'] = $error;
                    }
                }
            }

            if (count($errors) > 0) {
                $response = ['code' => 400, 'data' => $errors, 'message' => 'Errors'];

                return $response;
            }
        }

        return parent::action($action, $response, $args);
    }
}

global $em_customer;

$em_customer = new EM_Customer();