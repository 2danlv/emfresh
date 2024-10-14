<?php
/*
 * return $response
 */
if ($return == 'response') :
    $response = [
        'code' => 200,
        'data' => [], // list, item
        'message' => 'Success',
    ];

    $response = [
        'code' => 400,
        'data' => [], // errors
        'message' => 'Error',
    ];
endif;

/*
 * request customer
 */
if ($class == 'customer') :
    // lấy danh sách customer
    $customer_filter = [
        'fullname'  => '',
        'phone' => '',
        'point' => '',
        'status' => 0,
        'paged' => 1,
        'limit' => 10,
    ];
    $response = em_api_request('customer/list', $customer_filter);

    // lấy danh sách customer theo field của location 
    $location_filter = [
        'address' => '',
        'ward' => '',
        'district' => 'Quận 1',
        'city' => '',
    ];
    $response = em_api_request('customer/list', $location_filter);

    // lấy 1 customer
    $customer_filter = [
        'id' => 1
    ];
    $response = em_api_request('customer/item', $customer_filter);

    // thêm data cho customer
    $customer_data = [
        'fullname'      => '',
        'phone'         => '',
        'status'        => 1,
        'gender'        => 0,
        'note'          => '',
        'tag'           => 0,
        'address'       => '',
    ];
    $response = em_api_request('customer/add', $customer_data);


    // cập nhật data cho customer
    $customer_data = [
        'id'            => 1,
        'fullname'      => '',
        'phone'         => '',
        'status'        => 1,
        'gender'        => 0,
        'note'          => '',
        'tag'           => 0,
        'address'       => '',
    ];
    $response = em_api_request('customer/update', $customer_data);


    // xóa customer
    $customer_data = [
        'id' => 1
    ];
    $response = em_api_request('customer/delete', $customer_filter);

    // lấy danh sách customer history
    $customer_filter = [
        'customer_id' => 1
    ];
    $response = em_api_request('customer/history', $customer_filter);

endif;

/*
 * request location
 */
if ($class == 'location') :
    // lấy danh sách location
    $location_filter = [
        'customer_id' => 1,
        'paged' => 1,
        'limit' => 10,
    ];
    $response = em_api_request('location/list', $location_filter);

    // lấy 1 location
    $location_filter = [
        'id' => 1
    ];
    $response = em_api_request('location/item', $location_filter);

    // thêm data cho location
    $location_data = [
        'customer_id'   => 0,
        'address'       => '',
        'ward'          => '',
        'district'      => '',
        'city'          => '',
    ];
    $response = em_api_request('location/add', $location_data);

    // cập nhật data cho location
    $location_data = [
        'id'            => 1,
        'address'       => '',
        'ward'          => '',
        'district'      => '',
        'city'          => '',
    ];
    $response = em_api_request('location/update', $location_data);

    // xóa location
    $location_data = [
        'id' => 1
    ];
    $response = em_api_request('location/delete', $location_filter);

endif;
