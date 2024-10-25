<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(isset($_GET['abs'])) {

    $data = [
        'nickname'      => 'nick name',
        'fullname'      => 'full name',
        'phone'         => '0848555802',
        'status'        => 1,
        'gender'        => 3,
        'note'          => 'note',
        'tag'           => 1,
        'point'         => 0
    ];

    $em_data = array_intersect([
        'id' => 1,
        'status' => 3,
        'date' => 3,
        'esd' => 3,
    ], $data);

    // $response = em_api_request('customer/add', $data);
    
    var_export($em_data);

    // var_export($response);
    
    die();
    exit();
}


$genders = site_statistic_get_customer('gender', []);
$tags = site_statistic_get_customer('tag', []);
$statuses = site_statistic_get_customer('status', []);

?>
<h3>Gioi tinh</h3>
<ul>
    <?php 
        foreach($genders as $item) {
            echo "<li>{$item['name']} : {$item['total']}</li>";
        } 
    ?>
</ul>
<h3>Phân loại</h3>
<ul>
    <?php 
        foreach($tags as $item) {
            echo "<li>{$item['name']} : {$item['total']}</li>";
        } 
    ?>
</ul>
<h3>Trạng thái</h3>
<ul>
    <?php 
        foreach($statuses as $item) {
            echo "<li>{$item['name']} : {$item['total']}</li>";
        } 
    ?>
</ul>
<?php


$date_filters = [
    'date'      => '2024-10-13',
    'day'       => 13,
    'month'     => 10,
    'year'      => 2024,
    'week'      => 32,
];


echo '<pre>';

$genders = site_statistic_get_customer('gender', ['date'    => '2024-10-13']);
var_export($genders);
$genders = site_statistic_get_customer('gender', ['day'     => 13]);
var_export($genders);
$genders = site_statistic_get_customer('gender', ['month'   => 10]);
var_export($genders);
$genders = site_statistic_get_customer('gender', ['year'    => 2024]);
var_export($genders);
$genders = site_statistic_get_customer('gender', ['week'    => 32]);
var_export($genders);

echo '</pre>';