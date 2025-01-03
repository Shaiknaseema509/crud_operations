<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trimister = $_POST["sel_val"];


    $servername = "192.168.25.14";
    $username = "emri";
    $password = "emri";
    $dbname = "ecd";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = '';
    if($trimister == 1){
        $sql = "SELECT trimister1_id,trimister_1 as trimister FROM m_trimister1 WHERE trimister_id = $trimister";
    }else if ($trimister == 2){
        $sql = "SELECT trimister2_id, trimister_2 as trimister FROM m_trimister2 WHERE trimister_id = $trimister";
    } else if ($trimister == 3){
        $sql = "SELECT trimister3_id, trimister_3 as trimister FROM m_trimister3 WHERE trimister_id = $trimister";
    }    

    $result = $conn->query($sql);

    $subcategories = array();

    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    // Return subcategories as JSON
    echo json_encode($subcategories);

    $conn->close();
}

?>