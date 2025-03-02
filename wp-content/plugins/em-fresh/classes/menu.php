<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Menu
 */

class EM_Menu extends EF_Default
{
    protected $table = 'em_menu';

    protected $option_name = 'em_menu_create_table';

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

global $em_menu;

$em_menu = new EM_Menu();
