<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Product
 */

class EM_Product extends EF_Default
{
    protected $table = 'em_product';

    protected $option_name = 'em_product_create_table';

    protected $table_ver = '1.0';    

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'name'  => '',
        );

        return $fields;
    }

    function get_filters()
    {
        $filters = array(
            'name'  => 'LIKE',
        );

        return $filters;
    }
}

global $em_product;

$em_product = new EM_Product();
