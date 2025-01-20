<?php
/*
Plugin Name: Customer Management
Description: Manage customer records with CRUD operations in WordPress.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

// Create a menu item in the WordPress admin
add_action('admin_menu', 'customer_management_menu');
function customer_management_menu() {
    add_menu_page(
        'Customer Management',
        'Customers',
        'manage_options',
        'customer-management',
        'customer_management_page',
        'dashicons-groups',
        25
    );
}

// Main plugin page
function customer_management_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'em_customer';

    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    switch ($action) {
        case 'add':
            customer_management_form();
            break;
        case 'edit':
            customer_management_form($id);
            break;
        case 'delete':
            customer_management_delete($id);
            customer_management_list();
            break;
        default:
            customer_management_list();
            break;
    }
}

// Display a list of customers with pagination
function customer_management_list() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'em_customer';
    $items_per_page = 10;
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($page - 1) * $items_per_page;

    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $customers = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $items_per_page");

    echo '<div class="wrap">';
    echo '<h1>Customer Management <a href="?page=customer-management&action=add" class="page-title-action">Add New</a></h1>';

    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Full Name</th><th>Nickname</th><th>Phone</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    foreach ($customers as $customer) {
        echo '<tr>';
        echo '<td>' . esc_html($customer->id) . '</td>';
        echo '<td>' . esc_html($customer->fullname) . '</td>';
        echo '<td>' . esc_html($customer->nickname) . '</td>';
        echo '<td>' . esc_html($customer->phone) . '</td>';
        echo '<td>';
        echo '<a href="?page=customer-management&action=edit&id=' . intval($customer->id) . '">Edit</a> | ';
        echo '<a href="?page=customer-management&action=delete&id=' . intval($customer->id) . '" onclick="return confirm(\'Are you sure you want to delete this item?\')">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    // Pagination
    $total_pages = ceil($total_items / $items_per_page);
    echo '<div class="tablenav"><div class="pagination-links">';
    echo paginate_links(array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $total_pages,
        'current' => $page
    ));
    echo '</div></div>';
    echo '</div>';
}

// Form for adding/editing customers
function customer_management_form($id = 0) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'em_customer';

    // Initialize data
    $customer = $id ? $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)) : null;

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = array(
            'fullname' => sanitize_text_field($_POST['fullname']),
            'nickname' => sanitize_text_field($_POST['nickname']),
            'customer_name' => sanitize_text_field($_POST['customer_name']),
            'phone' => sanitize_text_field($_POST['phone']),
            'active' => isset($_POST['active']) ? 1 : 0,
            'status' => isset($_POST['status']) ? 1 : 0,
            'gender' => isset($_POST['gender']) ? 1 : 0,
            'tag' => isset($_POST['tag']) ? 1 : 0,
            'order_payment_status' => isset($_POST['order_payment_status']) ? 1 : 0,
            'note' => sanitize_textarea_field($_POST['note']),
            'note_shipping' => sanitize_textarea_field($_POST['note_shipping']),
            'note_cook' => sanitize_textarea_field($_POST['note_cook']),
            'point' => intval($_POST['point']),
            'parent' => intval($_POST['parent']),
            'created' => current_time('mysql'),
            'modified' => current_time('mysql')
        );

        if ($id) {
            $wpdb->update($table_name, $data, array('id' => $id));
            echo '<div class="notice notice-success"><p>Customer updated successfully.</p></div>';
        } else {
            $wpdb->insert($table_name, $data);
            echo '<div class="notice notice-success"><p>Customer added successfully.</p></div>';
        }

        echo '<a href="?page=customer-management">Back to list</a>';
        return;
    }

    // Display form
    echo '<div class="wrap">';
    echo '<h1>' . ($id ? 'Edit' : 'Add') . ' Customer</h1>';
    echo '<form method="post">';
    echo '<table class="form-table">';
    echo '<tr><th>Full Name</th><td><input type="text" name="fullname" value="' . esc_attr($customer->fullname ?? '') . '" class="regular-text"></td></tr>';
    echo '<tr><th>Nickname</th><td><input type="text" name="nickname" value="' . esc_attr($customer->nickname ?? '') . '" class="regular-text"></td></tr>';
    echo '<tr><th>Phone</th><td><input type="text" name="phone" value="' . esc_attr($customer->phone ?? '') . '" class="regular-text"></td></tr>';
    echo '<tr><th>Note</th><td><textarea name="note" class="large-text">' . esc_textarea($customer->note ?? '') . '</textarea></td></tr>';
    echo '<tr><td><input type="submit" value="Save" class="button button-primary"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</div>';
}

// Delete a customer
function customer_management_delete($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'em_customer';
    $wpdb->delete($table_name, array('id' => $id));
    echo '<div class="notice notice-success"><p>Customer deleted successfully.</p></div>';
}

function my_plugin_enqueue_styles() {
    // Tải file CSS từ thư mục plugin
    wp_enqueue_style(
        'my-plugin-paging-style', // Tên duy nhất cho CSS
        plugin_dir_url(__FILE__) . 'paging-style.css', // Đường dẫn đến file CSS
        array(), // Không phụ thuộc vào các CSS khác
        '1.0' // Phiên bản của CSS
    );
}
if (is_admin()) {
    add_action('admin_enqueue_scripts', 'my_plugin_enqueue_styles');
}