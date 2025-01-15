<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Ship_Fee
 */

class EM_Ship_Fee extends EF_Default
{
    protected $table = 'em_ship_fee';

    protected $option_name = 'em_ship_fee_create_table';

    protected $table_ver = '1.0';    

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'district'  => '',
            'ward'      => '',
            'price'     => 0,
        );

        return $fields;
    }

    function get_price($ward = '', $district = '')
    {
        $value = (int) $this->get_field_by(array(
            'district'  => $district,
            'ward'      => $ward
        ));

        if($value > 0) {
            return $value;
        }

        return (int) $this->get_field_by(array(
            'district'  => $district,
            'ward'      => ''
        ));
    }
}

global $em_ship_fee;

$em_ship_fee = new EM_Ship_Fee();
