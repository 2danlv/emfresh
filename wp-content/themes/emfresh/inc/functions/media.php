<?php
defined('ABSPATH') or die();

function site_media_save_file($content = '', $filename = '', $path_dir = '')
{
    // $content = 'data:image/png;base64,iVBO==';

    if($path_dir == '') {
        $upload_dir = wp_upload_dir();

        $path_dir = $upload_dir['path'];
    }

    $ext = site_media_get_image_extension($content);
    if($ext == '') {
        return false;
    }

    $decoded = site_media_get_base64_decode($content);
    if($decoded == '') {
        return false;
    }

    if($filename == '') {
        $filename = 'media-' . time() . '.' . $ext;
    } else {
        $filename .= '-' . time() . '.' . $ext;
    }
    
    $file = $path_dir . '/' . $filename;

    file_put_contents($file, $decoded);

    return $file;
}

function site_media_get_image_extension($file_content = '')
{
    $list = explode(';', str_replace('data:', '', $file_content));

    $image_types = [
        'image/png'     => 'png',
        'image/jpeg'    => 'jpg',
        'image/gif'     => 'gif',
    ];

    return isset($image_types[$list[0]]) ? $image_types[$list[0]] : '';
}

function site_media_get_base64_decode($file_content = '')
{
    $list = explode(',', $file_content);

    if(empty($list[1]) || $list[1] == '') {
        return '';
    }

    $content = str_replace(' ', '+', $list[1]);
    $decoded = base64_decode($content);
    
    return $decoded;
}