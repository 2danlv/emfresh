<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

// $mysqli = new mysqli("localhost", 'shop', 'k!em$NOW81', 'shop');
$mysqli = new mysqli("localhost", 'root', '', 'emfresh');


if (isset($_POST['user_phone'])) {
    $phone = $_POST['user_phone'];

    $checkdata = "SELECT phone FROM wp_em_customer WHERE phone='$phone' AND parent = 0 ";

    $query = mysqli_query($mysqli, $checkdata);

    if (mysqli_num_rows($query) > 0) {
        echo "Số điện thoại đã tồn tại!";
    } else {
        echo "OK";
    }
    exit();
}

