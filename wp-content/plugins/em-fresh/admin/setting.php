<?php

defined('ABSPATH') or die();

function em_admin_setting_init()
{
    $fields = [
        'em_notes' => __('Product Notes', 'em'),
        'em_menu_options' => __('Menu Options', 'em'),
        // 'em_menu_ingredients' => __('Menu Ingredients', 'em'),
        // 'em_menu_groups' => __('Menu Groups', 'em'),
        // 'em_menu_statuses' => __('Menu Statuses', 'em'),
        // 'em_menu_types' => __('Menu Types', 'em'),
        // 'em_menu_tags' => __('Menu Tags', 'em'),
    ];

    foreach($fields as $name => $label) {
        /**
         * field: em_notes
         */
        register_setting(
            'reading',
            $name
        );

        add_settings_field(
            $name,
            $label,
            function ($args) {
                extract($args);

                echo '<textarea id="'.$name.'" rows="5" name="'.$name.'" class="large-text code">' . get_option($name) . '</textarea>';
            },
            'reading',
            'default',
            array('name' => $name, 'label' => $label)
        );
        // End `em_notes`
    }
}
add_action('admin_init', 'em_admin_setting_init');

function em_admin_get_setting($field = '', $type = '')
{
    $value = get_option($field);

    if($field == 'em_notes' || $type == 'list_notes') {
        return em_admin_get_notes($value);
    }

    if($type == 'options') {
        $list = [];

        $rows = explode("\n", $value);

        foreach($rows as $row) {
            if(str_contains($row, ':')) {
                list($name, $value) = array_map('trim', explode(':', $row));

                $list[$name] = $value;
            }
        }

        $value = $list;
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

            $list[ $name ] = [
                'name' => $name,
                'values' => array_map('trim', explode(',', trim($values)))
            ];
        }
    }

    return $list;
}