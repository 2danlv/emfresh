<?php

defined('ABSPATH') or die();

function em_admin_setting_init()
{
    /**
     * field: em_notes
     */
    register_setting(
        'reading',
        'em_notes'
    );

    add_settings_field(
        'em_notes',
        __('List notes', 'em'),
        function ($args) {
            extract($args);

            echo '<textarea id="'.$name.'" rows="5" name="'.$name.'" class="large-text code">' . get_option($name) . '</textarea>';
        },
        'reading',
        'default',
        array('name' => 'em_notes')
    );
    // End `em_notes`
}
add_action('admin_init', 'em_admin_setting_init');

function em_admin_get_setting($field = '')
{
    $value = get_option($field);

    if($field == 'em_notes') {
        return em_admin_get_notes($value);
    }

    return $value;
}

function em_admin_get_notes($value = '')
{
    $list = [];

    $rows = explode("\n", $value);

    foreach($rows as $row) {
        if(str_contains($row, ':')) {
            list($name, $values) = array_map('trim', explode(':', $row));

            $list[ sanitize_title($name) ] = [
                'name' => $name,
                'values' => array_map('trim', explode(',', trim($values)))
            ];
        }
    }

    return $list;
}