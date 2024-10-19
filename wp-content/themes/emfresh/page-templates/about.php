<?php
/**
* Template Name: About
*
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/

get_header();
// Start the Loop.
// while ( have_posts() ) : the_post();
$customer_filter = [
    'paged' => 1,
    'limit' => 10,
];
$response = em_api_request('customer/list', $customer_filter);
// var_dump($response);
if (isset($response['data']) && is_array($response['data'])) {
    // Loop through the data array and print each entry
    foreach ($response['data'] as $record) {
        if (is_array($record)) { // Check if each record is an array
            echo "ID: " . $record['id'] . "\n";
            echo "Full Name: " . $record['fullname'] . "\n";
            echo "Phone: " . $record['phone'] . "\n";
            echo "Status: " . $record['status'] . " (" . $record['status_name'] . ")\n";
            echo "Gender: " . $record['gender_name'] . "\n";
            echo "Tag: " . $record['tag_name'] . "\n";
            echo "Note: " . $record['note'] . "\n";
            echo "Address: " . $record['address'] . "\n";
            echo "Points: " . $record['point'] . "\n";
            echo "Created: " . $record['created'] . "\n";
            echo "Modified: " . $record['modified'] . "\n";
            echo "-------------------------------------\n";
        } else {
            echo "Invalid record format.\n";
        }
    }
} else {
    echo "No valid data found.\n";
}
?>

<?php
// endwhile;
get_footer();
