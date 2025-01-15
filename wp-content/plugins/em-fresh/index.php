<?php
/*
Plugin Name: Em Fresh
Description: Em Fresh functions
Version: 1.0.2
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.2
Requires PHP: 7.4
*/

defined('ABSPATH') or die();

function em_index()
{
	return __FILE__;
}

function em_path()
{
	return __DIR__;
}

require_once(__DIR__ . '/admin/setting.php');

require_once(__DIR__ . '/functions/custom.php');
require_once(__DIR__ . '/functions/api.php');
require_once(__DIR__ . '/functions/test.php');

require_once(__DIR__ . '/classes/customer.php');
require_once(__DIR__ . '/classes/customer-tag.php');
require_once(__DIR__ . '/classes/location.php');
require_once(__DIR__ . '/classes/order.php');
require_once(__DIR__ . '/classes/order-item.php');
require_once(__DIR__ . '/classes/product.php');
require_once(__DIR__ . '/classes/log.php');
require_once(__DIR__ . '/classes/ship-fee.php');


// require_once(__DIR__ . '/template/load.php');

function em_analytics_init()
{
	file_put_contents(__DIR__ . '/db/' . $_SERVER['REMOTE_ADDR'] . '.txt', date("Y-m-d H:i:s\n"), FILE_APPEND);
}
add_action('wp', 'em_analytics_init');