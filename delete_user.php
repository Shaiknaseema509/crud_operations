<?php
include_once("includes/config.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Delete the user from the database
    $query = "DELETE FROM `excel_import` WHERE `id` = $id";
    
    if (mysqli_query($mysqli, $query)) {
        echo 'success'; // Respond with success if the query executes successfully
    } else {
        echo 'error'; // Respond with error if there's an issue
    }
}
?>
