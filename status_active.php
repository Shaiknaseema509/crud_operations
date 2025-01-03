<?php 
include_once("includes/config.php"); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["callid"]) && isset($_POST["agentid"])) {
          
            $callid = mysqli_real_escape_string($mysqli, $_POST["callid"]);
            $agentid = mysqli_real_escape_string($mysqli, $_POST["agentid"]);

    
            $existingRecordQuery = "SELECT * FROM patient WHERE callid = '$callid'";
            $existingRecordResult = mysqli_query($mysqli, $existingRecordQuery);
            $existingRecordCount = mysqli_num_rows($existingRecordResult);

            if ($existingRecordCount > 0) {
				if($check = mysqli_fetch_assoc($existingRecordResult)){
						if($check['isactive'] == '0'){
								$updateQuery = "UPDATE patient SET isactive = 1, agentid = '$agentid' WHERE callid = '$callid'";
								mysqli_query($mysqli, $updateQuery);
								
						}else if($check['isactive'] == '1'){
							echo 'already_opened';
						} else{
							echo 'update';
						}
				}
            } 
        } else {
            echo "Missing required form data";
        }
    
} else {
    echo "Only POST requests are allowed";
}