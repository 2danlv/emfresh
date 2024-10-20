<?php

function em_ucwords($str)
{
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

function em_get_data_fields($data = [], $fields = [])
{
    $keys = array_keys($fields);

    $new_data = [];

    foreach($data as $key => $value) {
        if(in_array($key, $keys)) {
            $new_data[$key] = $value;
        }
    }

    return $new_data;
}