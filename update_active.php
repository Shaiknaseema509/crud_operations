<?php 
//require_once("connect.php"); 
include_once("includes/config.php"); 

if(isset($_POST['callid']) && isset($_POST['agentid']))
{
    $callid= $_POST['callid'];
	$agentid= $_POST['agentid'];
	
    #$sql = "SELECT * FROM patient WHERE callid IN (SELECT callid FROM ecdtable AS ecd WHERE callid = ".$getcallid.")";

    $sql = "UPDATE patient SET isactive=1, agentid='".$agentid."' WHERE callid ='".$callid;

    $result = mysqli_query($mysqli, $sql);

    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
}

#printf ("%s (%s)\n", $row["Lastname"], $row["Age"]);

// Free result set
mysqli_free_result($result);

mysqli_close($mysqli);

?> 