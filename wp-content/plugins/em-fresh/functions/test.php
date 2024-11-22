<?php

function em_test_init()
{
    if (isset($_GET['dev'])) {
        // @ob_start();

        $name = isset($_GET['name']) ? trim($_GET['name']) : '';

        if($name == 'location') {
            em_test_location();
        } else {
            $name = 'customer';
            
            em_test_customer();
        }

        // wp_die('<h1>Test - ' . $name . '</h1>' . ob_get_clean());

        exit();
    }
}
add_action('wp', 'em_test_init');

function em_test_customer()
{
    $dev = trim($_GET['dev']);

    $id = isset($_GET['id']) ? trim($_GET['id']) : '';

    if ($dev == 'update' || $dev == 'add') {
        $data = [
            'fullname'      => 'Nguyen Van A',
            'phone'         => '09' . rand(10000000, 99999999),
            'status'        => '1', //rand(1, 3),
            'gender'        => '1', //rand(1, 3),
            'note'          => '', //'Note ' . rand(1, 9),
            'tag'           => '5', //rand(1, 5),
            'point'         => '0', // rand(1, 3),
            'address'       => sprintf('%d Le Loi, P%d, Q%d', rand(1, 300), rand(1, 10), rand(1, 2)),
        ];

        if ($dev == 'add') {
            $response = em_api_request('customer/add', $data);
        } else {
            $data['id'] = $id;

            $response = em_api_request('customer/update', $data);
        }

        $response[$dev . '-data'] = $data;
        em_test_print_response($response);
    } else if ($dev == 'item') {
        $data = [
            'id' => $id
        ];
        $response = em_api_request('customer/item', $data);

        $response[$dev . '-id'] = $id;
        em_test_print_response($response);
    } else if ($dev == 'delete') {
				 if(strpos($id, '-')>-1) {
							list($start, $stop) = explode('-', $id);
							for($i = $start; $i <= $stop; $i++){
									$response = em_api_request('customer/delete', ['id' => $i]);
							}
				 } else {
        $data = [
            'id' => $id
        ];
        $response = em_api_request('customer/delete', $data);
        }
				

        $response[$dev . '-id'] = $id;
        em_test_print_response($response);
    } else if ($dev == 'history') {
        $response = em_api_request('customer/history', ['customer_id' => $id]);

        $response['dev'] = $dev;
        em_test_print_response($response);
    } else if ($dev == 'update-active') {
        global $wpdb, $em_customer, $em_location;

        $query = $wpdb->prepare("SELECT id,nickname FROM %i", $em_customer->get_tbl_name());

        $list = $wpdb->get_results($query, ARRAY_A);

        foreach($list as $customer) {
            $locations = $em_location->get_items([
                'customer_id' => $customer['id'],
                'limit' => -1,
                'orderby' => 'id ASC',
            ]);

            if(count($locations) > 0) {
                $active = 0;
                
                foreach($locations as $location) {
                    if($location['active'] == 1) {
                        $active = 1;
                        break;
                    }
                }

                if($active == 0) {
                    $em_location->update([
                        'active' => 1,
                        'id' => $locations[0]['id']
                    ]);
                }
            }
        }
        
        $response = [
            'dev' => $dev,
            'list' => $list,
        ];
        em_test_print_response($response);
    } else {
            
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $list_args = [
            'limit' => $limit  < 1 ? 10 : $limit, 
            'paged' => $paged < 1 ? 1 : $paged
        ];

        $filters = [
            'fullname',
            'phone',
            'point',
            'status',
            'address',
            'ward',
            'district',
            'city',
        ];

        foreach($filters as $name) {
            if(!empty($_GET[$name])) {
                $list_args[$name] = sanitize_text_field($_GET[$name]);
            }
        }

        em_test_print_response(['filters' => $list_args]);

        $response = em_api_request('customer/list', $list_args);

        $response['dev'] = $dev;
        em_test_print_response($response);
    }
}

function em_test_location()
{
    $dev = trim($_GET['dev']);

    $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
    if($customer_id == 0) {
        em_test_print_response(['code' => 400, 'message' => 'required: customer_id > 0 (add, update)']);
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 1;

    if ($dev == 'update' || $dev == 'add') {
        $data = [
            'address'   => sprintf('%d DC', rand(1, 300)),
            'ward'      => 'P' . rand(1, 10),
            'district'  => 'Q' . rand(1, 10),
            'city'      => 'TP.'. rand(1, 60),
        ];

        if ($dev == 'add') {
            $data['customer_id'] = $customer_id;

            $response = em_api_request('location/add', $data);
        } else {
            $data['id'] = $id;

            $response = em_api_request('location/update', $data);
        }

        $response[$dev . '-data'] = $data;
        em_test_print_response($response);
    } else if ($dev == 'item') {
        $data['id'] = $id;

        $response = em_api_request('location/item', $data);

        $response[$dev . '-id'] = $id;
        em_test_print_response($response);
    } else if ($dev == 'delete') {
        $data['id'] = $id;

        $response = em_api_request('location/delete', $data);

        $response[$dev . '-id'] = $id;
        em_test_print_response($response);
    } else {
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $response = em_api_request('location/list', [
            'customer_id' => $customer_id,
            'limit' => $limit  < 1 ? 10 : $limit,
            'paged' => $paged < 1 ? 1 : $paged
        ]);
        
        $response['dev'] = $dev;
        em_test_print_response($response);
    }
}

function em_test_print_response($response)
{
    echo '<pre>';
    var_export($response);
    echo '</pre>';
}

/*

SELECT * FROM `wp_em_log` WHERE module_id IN (SELECT id FROM `wp_em_customer`);

DELETE FROM `wp_em_log` WHERE module_id NOT IN (SELECT id FROM `wp_em_customer`);

SELECT `module` FROM `wp_em_log` GROUP BY `module`;

*/