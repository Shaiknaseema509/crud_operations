<?php 

include_once("includes/config.php"); 

if(isset($_POST['data']))
{
    $getcallid= $_POST['data'];

    $sql = "SELECT * FROM excel_import WHERE id = ".$getcallid;

    $result = mysqli_query($mysqli, $sql);

    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
}

mysqli_free_result($result);

mysqli_close($mysqli);

?> 