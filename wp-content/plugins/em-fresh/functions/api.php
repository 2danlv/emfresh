<?php

defined('ABSPATH') or die();

function em_api_init()
{
    add_rewrite_rule(
        "api/([^/]+)/([^/]+)/?$",
        'index.php?api_name=$matches[1]&api_action=$matches[2]',
        'top'
    );

    // add_rewrite_rule(
    //     "api/([^/]+)/?$",
    //     'index.php?api_name=$matches[1]',
    //     'top'
    // );

    add_rewrite_rule(
        "swagger/?$",
        'index.php?api_name=swagger',
        'top'
    );
}
add_action('init', 'em_api_init');

function em_api_add_query_vars($vars)
{
    $vars[] = 'api_name';
    $vars[] = 'api_action';

    return $vars;
}
add_filter('query_vars', 'em_api_add_query_vars');

function em_api_get_response($args = [])
{
    $response = shortcode_atts([
        'code' => 200,
        'message' => ''
    ], $args);

    extract($response);

    if($message == '') {
        if($code == 200) {
            $message = 'Success';
        } else {
            $message = 'Error';
        }

        $response['message'] = $message;
    }

    foreach(['data', 'total'] as $name) {
        if(isset($args[$name])) {
            $response[$name] = $args[$name];
        }    
    }

    return $response;
}

function em_api_wp_route($wp)
{
    if(empty($wp->query_vars['api_name'])) return;
    $name = $wp->query_vars['api_name'];

    if(empty($wp->query_vars['api_action'])) {
        $response = ['code' => 400];
    } else {
        $response = ['code' => 200];

        $action  = $wp->query_vars['api_action'];

        $emClass = em_api_get_class($name);
    
        if(empty($emClass)) {
            $response = ['code' => 400, 'message' => 'No Action'];
        } else {
            $response = $emClass->api($action, $response);
        }

        // $response['route_name'] = $name . '/' . $action;
    }

    $response = em_api_get_response($response);

    header('Content-type: application/json');
    echo wp_json_encode($response);
    exit();
}
add_action('wp', 'em_api_wp_route');

function em_api_get_class($name = '')
{
    $emClass = null;

    if ($name != '') {
        $key = 'em_' . $name;

        global $$key;

        if(isset($$key)) {
            $emClass = $$key;
        }
    }

    return $emClass;
}

function em_api_request($route = '', $args = [])
{
    $route = str_replace('api/', '', $route);

    list($name, $action) = explode('/', $route);

    $emClass = em_api_get_class($name);
    
    if(empty($emClass)) {
        $response = ['code' => 400, 'message' => 'No Action'];
    } else {
        $response = ['code' => 200];

        $response = $emClass->action($action, $response, $args);
    }

    return em_api_get_response($response);
}