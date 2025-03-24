<?php
defined('ABSPATH') or die();

require_once 'default.php';

/**
 * @package EM_Group
 */

class EM_Group extends EF_Default
{
    protected $table = 'em_group';

    protected $option_name = 'em_group_create_table';

    protected $table_ver = '1.0';

    function create_table()
    {
        return;
    }

    function get_fields()
    {
        $fields = array(
            'name'          => '',
            'phone'         => '',
            'location_id'   => 0,
            'note'          => '',
            'created'       => '',
            'created_at'    => 0,
            'modified'      => '',
            'modified_at'   => 0,
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

    function filter_item($data = [], $type = '')
    {
        $item = [];

        if (is_array($data)) {
            global $em_location;

            foreach ($data as $key => $value) {
                $item[$key] = $value;

                if ($key == 'location_id') {
                    $location = $em_location->get_item($value);

                    $item['location_name'] = $em_location->get_fullname($location);
                }
            }
        } else {
            $item = $data;
        }

        return parent::filter_item($item, $type);
    }
}

global $em_group;

$em_group = new EM_Group();
