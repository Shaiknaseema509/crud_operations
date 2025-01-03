<?php
include_once("includes/config.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $query = "SELECT `id`, `name`, `email`, `phone`, `status` FROM `excel_import` WHERE `id` = $id";
    $result = mysqli_query($mysqli, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row); // Return data as JSON
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}
?>
