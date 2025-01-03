<?php
// fetch_user_details.php
include("includes/config.php");

if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Query the database for user details
    $query = "SELECT id, name, email, phone, status FROM excel_import WHERE id = '$userId'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);  // Return the user data as a JSON response
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}
?>
