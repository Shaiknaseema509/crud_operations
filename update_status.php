<?php
include_once("includes/config.php");

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    // Update the user status in the database
    $query = "UPDATE `excel_import` SET `status` = '$status' WHERE `id` = $id";
    
    if (mysqli_query($mysqli, $query)) {
        echo 'success'; // Respond with success if the query executes successfully
    } else {
        echo 'error'; // Respond with error if there's an issue
    }
}
?>
