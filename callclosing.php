<?php

date_default_timezone_set('Asia/Calcutta'); 

error_reporting(0);
include_once("includes/config.php");  

$phone = $_REQUEST["alternatenumber"];
$agent_id= $_REQUEST["agent_id"];
$convoxid = $_REQUEST["convoxid"]; 
$host_ip = "192.168.25.14";

?>

<script>

function submits(){
	alert("hi");
	
		var end_call_url = "http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>;
			//var end_call_url ="calling endcall";
			//$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>");
			$.post(end_call_url);
			postURL(end_call_url,"false");
			 alert("end_call_url",+end_call_url);
	}	

</script>


$(document).ready(function () {
$(".bin").click(function () {
var datastring = $("#Form").serialize();
$.ajax({
type: "POST",
url: "https://httpbin.org/post",
data: datastring,
dataType: "json",
success: function (data) {
var obj = JSON.stringify(data);
$(".result").append(
'</textarea></li><li class="list-group-item active">Result</li><li class="list-group-item">Name: ' +
data["form"]["name"] +
'</li><li class="list-group-item">Email: ' +
data["form"]["email"] +
'</li><li class="list-group-item">Gender: ' +
data["form"]["multiple"] +
'</li><li class="list-group-item">Comments: ' +
data["form"]["text"] +
"</li></ul></div>"
);
},
error: function () {
$(".result").append("Error occured");
},
});
});
});

