<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Order_Item
 */

class EM_Order_Item extends EF_Default
{
    protected $table = 'em_order_item';

    protected $option_name = 'em_order_item_create_table';

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

        add_action('deleted_table_em_order_item', array($this, 'auto_delete_by_order'), 10, 2);
    }

    function create_table()
    {
        return '';
    }

    function get_fields()
    {
        $fields = array(
            'order_id'      => 0,
            'ship_price'    => 0,
            'product_id'    => 0,
            'product_price' => 0,
            'type'          => '',
            'auto_choose'   => 0,
            'days'          => 0,
            'date_start'    => '',
            'date_stop'     => '',
            'quantity'      => 0,
            'amount'        => 0,
            'meal_number'   => 0,
            'note'          => '',
            'meal_plan'     => '',
            'meal_plan_reserve' => '',
            'meal_select'   => '',
            'meal_select_1' => '',
            'meal_select_2' => '',
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
            'order_id' => ''
        ];
    }

    function get_rules($action = '')
    {
        $rules = array(
            // 'order_id'      => 'required',
            // 'type'          => 'required',
            // 'days'          => 'required',
            // 'date_start'    => 'required',
            // 'quantity'      => 'required',
            // 'amount'        => 'required',
        );

        return $rules;
    }

    function get_where($args = [])
    {
        $wheres = parent::get_where($args);

        if (isset($args['min_date'])) {
            $value = sanitize_text_field($args['min_date']);

            $wheres[] = "DATE_FORMAT(`date_start`, '%Y-%m-%d') >= '$value'";
        }

        if (isset($args['max_date'])) {
            $value = sanitize_text_field($args['max_date']);

            $wheres[] = "DATE_FORMAT(`date_stop`, '%Y-%m-%d') <= '$value'";
        }

        return $wheres;
    }

    function get_product($id = 0, $field = '')
    {
        global $em_product;

        $item = $em_product->get_item($id);

        if (!empty($item['id'])) {
            return isset($item[$field]) ? $item[$field] : '';
        }

        return $item;
    }

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'product_id') {
                    $item['product_name'] = $this->get_product($value, 'name');
                } else if($key == 'note'){
                    $item['note_list'] = em_admin_get_notes($value);
                }
            }
        }

        return parent::filter_item($item, $type);
    }

    function get_meal_plan($item = [])
    {
        if (is_numeric($item)) {
            $item  = $this->get_item($item);
        }

        if (empty($item['id'])) {
            return [];
        }
        
        $list = [];

        $date_start = $item['date_start'];
        $date_stop  = $item['date_stop'];

        if($date_start == '0000-00-00' || $date_stop == '0000-00-00') {
            return [];
        }

        $list = [];

        if ($item['meal_plan'] != '') {
            $list = (array) json_decode($item['meal_plan'], true);
        }

        if (count($list) == 0 && $item['quantity'] >= $item['days']) {
            // $meal_number = $item['meal_number'];

            // tinh theo so phan an va so ngay
            $meal_number = intval($item['quantity'] / $item['days']);
            $balance = $item['quantity'] - $meal_number * $item['days'];

            while ($date_start <= $date_stop) {
                $time = strtotime($date_start);

                // 'Sun', 'Sat'
                if (!in_array(date('w', $time), [0, 6])) {
                    $plus = 0;

                    if($balance > 0) {
                        $plus = 1;
                        $balance--;
                    }

                    $list[$date_start] = $meal_number + $plus;
                }

                $date_start = date('Y-m-d', $time + DAY_IN_SECONDS);
            }
        }

        return $list;
    }

    function get_meal_select($item = [], $number = 0)
    {
        if (is_numeric($item)) {
            $item  = $this->get_item($item);
        }

        if (empty($item['id']) || $number > 2) {
            return [];
        }
        
        $meal_plans  = $this->get_meal_plan($item);

        if (count($meal_plans) == 0) {
            return [];
        }
        
        $list = [];

        $max_meal_number = 0;
        
        foreach($meal_plans as $meal_number) {
            if($max_meal_number < $meal_number) {
                $max_meal_number = $meal_number;
            }
        }

        $key = 'meal_select' . ($number > 0 ? '_' . $number : '');

        if (!empty($item[$key])) {
            $list = (array) json_decode($item[$key], true);

            foreach($list as $day => $meal_select) {
                for($i = count($meal_select); $i < $max_meal_number; $i++) {
                    $meal_select[$i] = 0;
                }

                $list[$day] = $meal_select;
            }
        }

        if(count($list) == 0) {
            foreach($meal_plans as $day => $meal_number) {
                $meal_select = [];
                $value = [];

                if(isset($list[$day])) {
                    $value = $list[$day];
                }

                for($i = 0; $i < $max_meal_number; $i++) {
                    $meal_select[$i] = isset($value[$i]) ? $value[$i] : 0;
                }

                $list[$day] = $meal_select;
            }
        }

        return $list;
    }

    function auto_delete_by_order($id = 0, $deleted = false)
    {
        global $wpdb;

        if ($deleted == true && $id > 0) {
            $wpdb->delete($wpdb->prefix . $this->table, ['order_id' => $id], ['%d']);
        }
    }
}

global $em_order_item;

$em_order_item = new EM_Order_Item();
