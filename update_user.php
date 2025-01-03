<?php
include_once("includes/config.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];

    $query = "UPDATE `excel_import` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `status` = '$status' WHERE `id` = $id";
    
    if (mysqli_query($mysqli, $query)) {
        echo 'success'; // Respond with success
    } else {
        echo 'error'; // Respond with error
    }
}
?>
