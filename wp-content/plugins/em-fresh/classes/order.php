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

    function insert($data = [])
    {
        $insert_id = parent::insert($data);

        if($insert_id > 0) {
            $this->update([
                'id' => $insert_id,
                'order_number' => $this->get_order_number($insert_id),
            ]);
        }

        return $insert_id;
    }

    function get_fields()
    {
        $fields = array(
            'order_number'  => '',
            'customer_id'   => 0,
            'location_id'   => 0,
            'status'        => 0,
            'ship_days'     => 0,
            'ship_amount'   => 0,
            'total_amount'  => 0,
            'discount'      => 0,
            'note'          => '',
            'item_name'     => '',
            'type_name'     => '',
            'payment_method' => '',
            'payment_status' => 0,
            'order_status'  => 0,
            'order_type'    => '',
            'params'        => '',
            'total'         => 0,
            'paid'          => 0,
            'remaining_amount' => 0,
            'created'       => '',
            'created_at'    => 0,
            'modified'      => '',
            'modified_at'   => 0,
        );

        return $fields;
    }

    function get_filters()
    {
        return [
            'customer_id' => ''
        ];
    }

    function get_rules($action = '')
    {
        $rules = array();

        if($action == 'add') {
            $rules = array(
                'customer_id'   => 'required',
            );
        }

        return $rules;
    }

    function get_statuses($key = null)
    {
        $list = [
            1 => "Đang dùng",
            2 => "Hoàn tất",
            3 => "Bảo lưu",
        ];

        if ($key != null) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_order_statuses($key = null)
    {
        $list = [
            1 => "Đặt đơn",
            2 => "Chưa rõ",
            3 => "Dí món",
            4 => "Rỗng",
        ];

        if ($key != null) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_payment_statuses($key = null)
    {
        $list = [
            1 => "Rồi",
            2 => "Chưa",
            // 3 => "COD",
            3 => "1 Phần"
        ];

        if ($key != null) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_payment_methods($key = null)
    {
        $list = [
            1 => "Chuyển khoản",
            2 => "COD",
        ];

        if ($key != null) {
            return isset($list[$key]) ? $list[$key] : '';
        }

        return $list;
    }

    function get_order_number($id = 0)
    {
        $prefix = '0000';

        $max = strlen($prefix);

        $i = (int) $id;

        $number = ($i - 1) % 9999 + 1;

        $n = strlen($number);

        if($n == $max) {
            return $number;
        }

        return substr($prefix, 0, $max - $n) . substr($number, 0, $n);
    }
    
    function get_params($id = 0, $field = '')
    {
        $params = [];

        $item = $this->get_item($id);

        if(!empty($item['id'])) {
            $params = (array) unserialize($item['params']);
        }

        return $params;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            global $em_customer, $em_order_item, $em_location;

            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'status') {
                    $item['status_name'] = $this->get_statuses($value);
                } else if ($key == 'order_status') {
                    $item['order_status_name'] = $this->get_order_statuses($value);
                } else if ($key == 'payment_status') {
                    $item['payment_status_name'] = $this->get_payment_statuses($value);
                } else if ($key == 'payment_method') {
                    $item['payment_method_name'] = $this->get_payment_methods($value);
                } else if ($key == 'remaining_amount') {
                    $total = intval($item['ship_amount'] + $item['total_amount']);
                    
                    if($value == 0) {
                        $item['remaining_amount'] = $total;
                    }

                    $today = current_time('Y-m-d');
                    $used_value = 0;

                    if($total > 0) {
                        $order_items = $em_order_item->get_items([
                            'order_id' => $item['id'],
                            'min_date' => $today,
                        ]);

                        foreach($order_items as $order_item) {
                            $date_start = $order_item['date_start'];

                            if($date_start < $today) {
                                $day_count = intval((strtotime($today) - strtotime($date_start)) / DAY_IN_SECONDS) + 1;

                                $used_value += intval($order_item['amount'] / $order_item['days']) * $day_count;
                            }
                        }
                    }

                    $item['used_value'] = $used_value;
                    $item['remaining_value'] = $total - $used_value;
                } else if ($key == 'paid') {
                    // if($value == 0) {
                    //     $total = intval($item['ship_amount'] + $item['total_amount']);
                    
                    //     $item['paid'] = $total - intval($item['remaining_amount']);
                    // }
                } else if ($key == 'location_id') {
                    $item['location_name'] = $em_location->get_fullname($value);
                } else if ($key == 'customer_id') {
                    $customer = $em_customer->get_item($value);

                    $item['customer_name'] = $customer && isset($customer['customer_name']) ? $customer['customer_name'] : '';
                    $item['phone'] = $customer && isset($customer['phone']) ? $customer['phone'] : '';
                }
            }
        } else {
            $item = $data;
        }

        return parent::filter_item($item, $type);
    }

    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        if ($deleted == true && $id > 0) {
            $items = $this->get_items(['customer_id' => $id]);

            foreach($items as $item) {
                $this->delete($item['id']);
            }
        }
    }
}

global $em_order;

$em_order = new EM_Order();