<?php 
//require_once("connect.php"); 
include_once("includes/config.php");

    $sql = "CALL auto_insert_update_test()"; #CALL sp

    $result = mysqli_query($mysqli, $sql);

    $subcategories = array();

    while ($row = mysqli_fetch_array($result)) {
        $subcategories[] = $row;
    }

    echo json_encode($subcategories);
	
	mysqli_free_result($result);

	mysqli_close($mysqli);

?> 