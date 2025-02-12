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

        if ($insert_id > 0) {
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
            'customer_name_2nd' => '',
            'location_id'   => 0,
            'status'        => 0,
            'ship_days'     => 0,
            'ship_amount'   => 0,
            'total_amount'  => 0,
            'total_quantity'  => 0,
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
            'date_start'    => '',
            'date_stop'     => '',
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

        if ($action == 'add') {
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

        if ($n == $max) {
            return $number;
        }

        return substr($prefix, 0, $max - $n) . substr($number, 0, $n);
    }

    function get_params($id = 0, $field = '')
    {
        $params = [];

        $item = $this->get_item($id);

        if (!empty($item['id'])) {
            $params = (array) unserialize($item['params']);
        }

        return $params;
    }

    function get_ships($item = [])
    {
        if (is_numeric($item)) {
            $item  = $this->get_item($item);
        }

        if (empty($item['id'])) {
            return [];
        }

        $default_params = [
            'loop' => '',
            'calendar' => '',
            'days' => [],
            'location_id' => 0,
            'location_name' => '',
            'note_shipper' => '',
            'note_admin' => '',
        ];

        $order_ships = [];

        if (!empty($item['params'])) {
            $data_params = unserialize($item['params']);

            if (isset($data_params['ship'])) {
                $list_ship = $data_params['ship'];

                if (isset($list_ship['location_id'])) {
                    $order_ships[] = shortcode_atts($default_params, $list_ship);
                } else if (count($list_ship) > 0 && isset($list_ship[0]['location_id'])) {
                    foreach ($list_ship as $item) {
                        $order_ships[] = shortcode_atts($default_params, $item);
                    }
                }
            }
        }

        if (count($order_ships) == 0) {
            $order_ships[] = $default_params;
        } else {
            global $em_location;

            $today = current_time('Y-m-d');

            foreach ($order_ships as $i => $ship) {
                if(!empty($ship['calendar']) && $ship['calendar'] <= $today) {
                    unset($order_ships[$i]);
                    continue;
                }

                if(empty($ship['location_id']) && empty($ship['location_name'])) {
                    unset($order_ships[$i]);
                    continue;
                }

                if (empty($ship['location_name']) && $ship['location_id'] > 0) {
                    $ship['location_name'] = $em_location->get_fullname($ship['location_id']);

                    $order_ships[$i] = $ship;
                }
            }
        }

        return $order_ships;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            global $em_customer, $em_order_item, $em_location;

            $today = current_time('Y-m-d');

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

                    if ($value == 0) {
                        $item['remaining_amount'] = $total;
                    }

                    $used_value = 0;

                    if ($total > 0 && isset($item['id'])) {
                        $order_items = $em_order_item->get_items([
                            'order_id' => $item['id'],
                        ]);

                        foreach ($order_items as $order_item) {
                            $date_start = $order_item['date_start'];

                            if ($date_start < $today) {
                                $day_count = $this->count_days($order_item);

                                $used_value += intval($order_item['amount'] / $order_item['days']) * $day_count;
                            }
                        }
                    }

                    $item['used_value'] = $used_value;
                    $item['remaining_value'] = $total - $used_value;
                } else if ($key == 'date_start') {
                    if ($value == '0000-00-00' && isset($item['id'])) {
                        $order_items = $em_order_item->get_items([
                            'order_id' => $item['id'],
                            'limit' => 1,
                            'orderby' => 'date_start ASC'
                        ]);

                        if (isset($order_items[0]['date_start'])) {
                            $value = $item[$key] = $order_items[0]['date_start'];

                            $this->update([
                                'date_start' => $value
                            ], ['id' => $item['id']]);
                        }
                    }
                } else if ($key == 'date_stop') {
                    if ($value == '0000-00-00' && isset($item['id'])) {
                        $order_items = $em_order_item->get_items([
                            'order_id' => $item['id'],
                            'limit' => 1,
                            'orderby' => 'date_stop DESC'
                        ]);

                        if (isset($order_items[0]['date_stop'])) {
                            $value = $item[$key] = $order_items[0]['date_stop'];

                            $this->update([
                                'date_stop' => $value
                            ], ['id' => $item['id']]);
                        }
                    }
                } else if ($key == 'location_id') {
                    $location = $em_location->get_item($value);

                    $item['location_name'] = $em_location->get_fullname($location);
                    $item['note_shipper'] = $location && isset($location['note_shipper']) ? $location['note_shipper'] : '';
                    $item['note_admin'] = $location && isset($location['note_admin']) ? $location['note_admin'] : '';
                } else if ($key == 'customer_id') {
                    $customer = $em_customer->get_item($value);
                    
                    $item['customer_name'] = $customer && isset($customer['customer_name']) ? $customer['customer_name'] : '';
                    $item['phone'] = $customer && isset($customer['phone']) ? $customer['phone'] : '';
                } else if ($key == 'total_quantity' && $value == 0 && isset($item['id'])) {
                    $order_items = $em_order_item->get_items([
                        'order_id' => $item['id'],
                        'limit' => -1,
                    ]);

                    foreach($order_items as $order_item) {
                        $value += $order_item['quantity'];
                    }

                    $item[$key] = $value;

                    $this->update([
                        'total_quantity' => $value
                    ], ['id' => $item['id']]);
                }
            }

            if ($item['status'] == 1 && $today > $item['date_stop']) {
                $status = 2;

                $item['status'] = $status;
                $item['status_name'] = $this->get_statuses($status);
            }
        } else {
            $item = $data;
        }

        return parent::filter_item($item, $type);
    }

    function get_where($args = [])
    {
        $wheres = parent::get_where($args);

        if(!empty($args['check_date_start'])) {
            $wheres[] = sprintf("`date_start` <= '%s'", $args['check_date_start']);
            $wheres[] = "`date_start` <> '0000-00-00'";
        }

        if(!empty($args['check_date_stop'])) {
            $wheres[] = sprintf("`date_stop` >= '%s'", $args['check_date_stop']);
            $wheres[] = "`date_stop` <> '0000-00-00'";
        }

        return $wheres;
    }

    function count_days($item = [])
    {
        $date_start = $item['date_start'];
        $date_stop = $item['date_stop'];
        $today = current_time('Y-m-d');

        $count = 0;

        while ($date_start < $today && $date_start <= $date_stop) {
            $time_next = strtotime($date_start) + DAY_IN_SECONDS;

            $date_start = date('Y-m-d', $time_next);

            if (in_array(date('D', $time_next), ['Sun', 'Sat'])) {
                continue;
            }

            $count++;
        }

        return $count;
    }

    function auto_delete_by_customer($id = 0, $deleted = false)
    {
        if ($deleted == true && $id > 0) {
            $items = $this->get_items(['customer_id' => $id]);

            foreach ($items as $item) {
                $this->delete($item['id']);
            }
        }
    }
}

global $em_order;

$em_order = new EM_Order();
