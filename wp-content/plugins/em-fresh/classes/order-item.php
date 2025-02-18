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
            'order_id'      => 'required',
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

            $wheres[] =  "DATE_FORMAT(`date_start`, 'Y-m-d') >= '$value'";
        }

        if (isset($args['max_date'])) {
            $value = sanitize_text_field($args['max_date']);

            $wheres[] =  "DATE_FORMAT(`date_stop`, 'Y-m-d') <= '$value'";
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

        if (!empty($item['id'])) {
            if($item['meal_plan'] != '') {
                $list = json_decode($item['meal_plan'], true);
            } else {
                $date_start = $item['date_start'];
                $date_stop  = $item['date_stop'];
                $meal_number = $item['meal_number'];

                $list[$date_start] = $meal_number;

                while ($date_start < $date_stop) {
                    $time_next = strtotime($date_start) + DAY_IN_SECONDS;

                    $date_start = date('Y-m-d', $time_next);

                    if (in_array(date('D', $time_next), ['Sun', 'Sat'])) {
                        continue;
                    }

                    $list[$date_start] = $meal_number;
                }

                $this->update([
                    'meal_plan' => json_encode($list)
                ], ['id' => $item['id']]);
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
