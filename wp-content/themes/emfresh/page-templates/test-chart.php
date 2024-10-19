<?php

/**
 * Template Name: Testing chart
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


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