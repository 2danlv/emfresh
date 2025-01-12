<?php
/*
Plugin Name: Em Fresh
Description: Em Fresh functions
Version: 1.0.1
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

require_once('functions/custom.php');

require_once('classes/customer.php');
require_once('classes/customer-tag.php');
require_once('classes/location.php');
require_once('classes/order.php'); 
require_once('classes/log.php');

require_once('functions/api.php');
require_once('functions/test.php');


require_once('template/load.php');
