<?php session_start(); 
error_reporting(0);
require_once("dbconnect_emri_102.php"); 
//echo "<pre>".print_r($_REQUEST,1)."</pre>";

$agent_id = $_REQUEST["agent_id"];

$district_id = "";
$district_name = "";

$Query = "SELECT DistrictId, DistrictName FROM AgentDistrict WHERE AgentID='".$agent_id."';";
$Result = mysql_query($Query);
while($Row = mysql_fetch_array($Result))
 {
        $district_id .= $Row["DistrictId"].",";
        $district_name .= $Row["DistrictName"].",";
 }

$district_id = substr($district_id,0,-1);
$district_name = substr($district_name,0,-1);

if($_SESSION['dis']) $district_id=$_SESSION['dis'];
if($_SESSION['hos']) $hos=$_SESSION['hos'];

if($hos =='') $hos=49;

?>

<html>
<head>
	<title>102</title>
	<style>
	body { width: 1220px; margin: 0 auto; 
	background-color: #fff; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif   
	}
	.childclass{display:none}
	.hover14 figure {
	position: relative;
	}
	.error_valid{ color:red;}
	.hover14 figure::before {
	position: absolute;
	top: 0;
	left: -105%;
	z-index: 2;
	display: block;
	content: '';
	width: 50%;
	height: 100%;
	background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
	background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
	-webkit-transform: skewX(-25deg);
	transform: skewX(-25deg);
	}
	.hover14 figure:hover::before {
	-webkit-animation: shine .75s;
	animation: shine .75s;
	}
	@-webkit-keyframes shine {
	100% {
		left: 125%;
	}
	}
	@keyframes shine {
	100% {
		left: 125%;
	}
	}
	
	input[type="text"]
	{
	border: 0;
	border-bottom: 1px solid red;
	outline: 0;
	background:none
	}

	select option[val="1"]{
	background: rgba(100,100,100,0.3);
	}

	select option[val="2"]{
	background: rgba(200,200,200,0.3);
	}
	input[type=text], textarea,select,button {
	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
	outline: none;
	box-shadow: 0 0 5px rgba(88, 253, 208, 1);
	padding: 3px 0px 3px 3px;
	margin: 5px 1px 3px 0px;
	border: 1px solid #DDDDDD;
	}
 
	input[type=text]:focus, textarea:focus {
  	box-shadow: 0 0 5px #0973ec;
  	padding: 3px 0px 3px 3px;
  	margin: 5px 1px 3px 0px;
  	border: 1px solid rgba(81, 203, 238, 1);
	}
	.phone_number_display{display:none;}
	.filed_1{ width:20%; float:left}
	.filed_2{ width:98.5% !important; float:left !important}
	.filed_5{ width:28.5% !important; float:left !important; height:50%; overflow-y:scroll;}
	.filed_15{ width:19.5% !important; float:left !important; height:50%}
	.filed_115{ width:34.5% !important; float:left !important; height:50%; overflow-y:scroll;}
	.filed_6{ width:25% !important; float:right !important}
	fieldset{ font-size:13px; border:1px solid black; color:red;}
	.CallID{ color: #0489c8; font-size:18px}
	.modal {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	z-index: 1; /* Sit on top */
	padding-top: 100px; /* Location of the box */
	left: 0;
	top: 0;
	width: 100%; /* Full width */
	height: 100%; /* Full height */
	overflow: auto; /* Enable scroll if needed */
	background-color: rgb(0,0,0); /* Fallback color */
	background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	background-color: #fefefe;
	margin: auto;
	padding: 20px;
	border: 1px solid #888;
	width: 80%;
	}

	/* The Close Button */
	.close {
	color: #aaaaaa;
	float: right;
	font-size: 28px;
	font-weight: bold;
	}

	.close:hover,
	.close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
	}

	/* The alert message box */
	.alert { top:0px;
	padding: 20px;
	background-color: #f44336; /* Red */
	color: white;
	position:fixed; display:none;
	width:83%;
	margin-bottom: 15px;
	}

	/* The close button */
	.closebtn {
	margin-left: 15px;
	color: white;
	font-weight: bold;
	float: right;
	font-size: 22px;
	line-height: 20px;
	cursor: pointer;
	transition: 0.3s;
	}

	/* When moving the mouse over the close button */
	.closebtn:hover {
	color: black;
	}
	</style>

	<script src="js/jquery-1.10.2.min.js"></script>
</head>
<body onload="return GetDMV();">  
	<table style=" background: rgba(0, 0, 0, 0) url('img/header-BlueSky.jpg') repeat scroll 0 0; float: left; width: 100%">
	<tr><td><img src="img/gvk-emri.jpg" /></td>
	<td align='right' style='text-align:right'>  
			<img src="img/Seal_of_Telangana.png" style="border-radius: 20px; height: 100px;padding: 10px;" /></td>
	</tr>
	</table>
	 
	<div style="clear:both">&nbsp;</div>
	
	<div class="alert">
		<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
		<div class='alert_content'></div>
	</div>
  
	<fieldset class='filed_2'>
		<legend>Hospital Details:</legend>
		<table cellpadding='5' cellspacing='5'>
		<tr>
			<td>District Name </td>
			<td>
			
			<select name='district_name' id='district_name' onChange='GetDIS();'>
			<option value=''>--Select District--</option>
			 <?php 
			$district_name = "SELECT DistrictID, DistrictName from district ORDER BY DistrictName DESC;";
			$district_name_result = mysql_query($district_name);
			while($district_name_details = mysql_fetch_array($district_name_result))
			 {?>
				<option <?php if($district_id == $district_name_details["DistrictID"]) echo 'selected="selected"';?>  value='<?=$district_name_details["DistrictID"];?>' ><?=$district_name_details["DistrictName"];?> </option>
			 <?php }?>					
			</select>
			
			</td>
			
			
			
			<td>Hospital Name </td>
			<td id="sel_dis"><select name='hospital_name' id='hospital_name' onChange='GetDMV();'>
			<option value=''>--Select Hospital--</option>
			<?php
			$date = date('Y-m-d', strtotime(' +2 day'));
			if($district_id !='')
				$hospital_name = "SELECT HospitalId, HospitalName, DistrictId, COUNT(*) AS C FROM DailyVisits WHERE Date='".$date."' AND DistrictId IN (".$district_id.") AND (`RescheduleTime` IS NULL OR `RescheduleTime`<NOW())  GROUP BY HospitalId ORDER BY C DESC;";
			/*else if($hos !='')
				$hospital_name = "SELECT HospitalId, HospitalName, DistrictId, COUNT(*) AS C FROM DailyVisits WHERE Date='".$date."' AND DistrictId IN (".$district_id.") AND (`RescheduleTime` IS NULL OR `RescheduleTime`<NOW())  GROUP BY HospitalId ORDER BY C DESC;";*/
			else
				$hospital_name = "SELECT HospitalId, HospitalName, DistrictId, COUNT(*) AS C FROM DailyVisits WHERE Date='".$date."' AND (`RescheduleTime` IS NULL OR RescheduleTime < NOW())  GROUP BY HospitalId ORDER BY C DESC;";

			 
			$hospital_name_result = mysql_query($hospital_name);
			while($hospital_name_details = mysql_fetch_array($hospital_name_result))
			 {?>
				<option <?php if($hos == $hospital_name_details["HospitalId"]) echo 'selected="selected"';?> value='<?=$hospital_name_details["HospitalId"];?>~<?=$hospital_name_details["DistrictId"];?>' ><?=$hospital_name_details["HospitalName"];?> (<?=$hospital_name_details["C"];?>) </option>
			 <?php }?>					
			</select>
				<?php //echo $hospital_name;?>
			</td> 
		</tr>
		</table>

		<table cellpadding='5' cellspacing='5'>
		<tr>
                        <td>District <span class='error_valid'> *</span></td>
                        <td> <select class="" id='district' name='district' style="width:200px" >
                        <option value=''>--Select District--</option>
                        </select></td>
                        <td colspan=4></td><td colspan=4></td><td>Division Name <span class='error_valid'> *</span></td>
                        <td>  <select class="" id='division_name' name='division_name' style="width:200px" >

                                <option value=''>--Select Division--</option>
                        </select></td> 
		</tr>
		</table>
	</fieldset>

	<fieldset class='filed_5' >
		<legend> Beneficiary Details : </legend>
			<table class='tableStyleClass' border=0 cellPadding=2 cellSpacing=2 align=left style='width:70%;'>
                        <th><tr><td align=right>Phone No.:</td><td id="phone_num"></td><button type="button" class="btn-success" name="call" id="call" value="Call" onclick="callMother();">Call <span >&nbsp;</span> </button></tr></th>
			<th><tr></tr></th>
                        <th><tr><td align=right>Mother ID:</td><td id="mother_id"></td><input type="hidden" name="visit_id" id="visit_id"></tr></th>
						
			<th class="childclass"><tr></tr></th>
                        <th class="childclass"><tr><td align=right>Child ID:</td><td id="childIDsHtml"></td></tr></th>
						
			<th><tr></tr></th>
                        <th><tr><td align=right>Mother Name:</td><td id="mother_name"></td></tr></th>
			<th><tr></tr></th>
                        <th><tr><td align=right>Aadhar No.:</td><td id="aadhar_num"></td></tr></th>
			<th><tr></tr></th>
                        <th><tr><td align=right>Age:</td><td id="age"></td></tr></th>
			<th><tr></tr></th>
                        <th><tr><td align=right>Address:</td><td id="address"></td></tr></th>
			</table>
	</fieldset>
	<!--
<script src="https://maps.googleapis.com/maps/api/js"></script>
 <script>
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        ['gvk emri,IN', 17.572858,78.4963515]
    ];
google.maps.event.addDomListener(document.getElementById('hospital_name'), 'change', function(evt) {
     var hosp_name_details = document.getElementById("hospital_name").value.split("~");
		var hosp_id = hosp_name_details[0];
		var dist_id = hosp_name_details[1];
	 $.post('get_outbound_details_map.php',{DistID:dist_id,HospID:hosp_id},function(data){
		var latlong = data.split('@@@#@@@');
		
	 for( i = 0; i < latlong.length; i++ ) {
		 // alert(latlong[i]);
		 var latlongdata = latlong[i].split(',');		 
		// alert(latlongdata[0]);
		 var marker = new google.maps.Marker({
		position: {
        lat: parseFloat(latlongdata[0]),
        lng: parseFloat(latlongdata[1])
      },
		map: map
		}); 
	 }
	 });
  });
                      
    // Info window content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>Brooklyn Museum</h3>' +
        '<p>The Brooklyn Museum is an art museum located in the New York City borough of Brooklyn.</p>' + '</div>']
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}
/*
google.maps.event.addDomListener(document.getElementById('addMarkerBtnId'), 'click', function(evt) {
    var marker = new google.maps.Marker({
      position: {
        lat: parseFloat(17.5590023),
        lng: parseFloat(78.4912828)
      },
      map: map
    });
  });
*/
// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script> 
-->


	<fieldset class='filed_15'>
                <legend>Distance Map :</legend>
                <table align='center' cellpadding='5' cellspacing='5'>
			<tr>
				<td id="use2map"><div id="mapCanvas"  style="width:340px;height:250px" class=''  ></div>	</td>
			</tr>	
                </table>

	</fieldset>

	
	<fieldset class='filed_115'>
		<legend>Visit Details :</legend>
                        <div id="visit_details">
                        </div>
	</fieldset>
	<div style='clear:both'></div>

	<div id="myModal" class="modal">
		<div class="modal-content">
		<span class="close">×</span>
		<table>
		<tr>
			<td><input type='text' id="mother_id" placeholder='Enter Mother ID' ></td>
			<td><input type='text' id="aadhar_id" placeholder='Enter Aadhar Number' ></td>
			<td><input type='text' id="mobile_no" placeholder='Enter Contact Number' ></td>
			<td></td>
			<td><input type='button' onclick="return checklist();" value='Find' ></td>
			<input type='hidden' id='ben_id_no' />
			<td></td>
			<td></td>
		</tr>
			
		<tr>
			<td  id="ben_list" colspan='7'></td>
		</tr>			
		</table>
		</div>
	</div>
	</div>
</body>
</html>

<script src="main_validation.js"></script>

<script src="js/moment-with-locales.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" src="css/bootstrap-datetimepicker.css" />
<link href="css/bootstrap.css" rel="stylesheet" />
	
 <script type="text/javascript">
$(function () {
	$('.followup_time_picker').datetimepicker();
	//setTimeOut(function(){GetDMV();},1000);
});
		
</script>
<script type="text/javascript">
function GetDIS()
{
	var ID = $('#district_name').val();
	var xmlHttp = newHttpObject();

        if(xmlHttp)
         {
		var callQuery = "ACTION=GetHospDetail&district_id="+ID;
		//alert(callQuery);//return false;
		xmlHttp.open("POST","get_outbound_out_details.php",true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.send(callQuery);
		xmlHttp.onreadystatechange=function()
		 {
			if (xmlHttp.readyState==4 && xmlHttp.status==200)
			 {
				var Response = null;
				Response = xmlHttp.responseText;
				document.getElementById("sel_dis").innerHTML=Response;
				 
			 }
		 }
	 }	
	delete xmlHttp;
}
function GetMotherDetail(VisitID)
 {
	var xmlHttp = newHttpObject();

        if(xmlHttp)
         {
		var callQuery = "ACTION=GetMotherDetail&visit_id="+VisitID;
		//alert(callQuery);//return false;
		xmlHttp.open("POST","get_outbound_details.php",true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.send(callQuery);
		xmlHttp.onreadystatechange=function()
		 {
			if (xmlHttp.readyState==4 && xmlHttp.status==200)
			 {
				var Response = null;
				Response = xmlHttp.responseText;
				//alert(Response);
				var ResponseArry=Response.split("$$");
	                	var arrylen=ResponseArry.length;
				
				if(ResponseArry[0]) 
				document.getElementById("phone_num").innerHTML=ResponseArry[0];
				else
				document.getElementById("phone_num").innerHTML="";
				if(ResponseArry[1]) 
				document.getElementById("mother_id").innerHTML=ResponseArry[1];
				else
				document.getElementById("mother_id").innerHTML="";
				if(ResponseArry[2]) 
				document.getElementById("mother_name").innerHTML=ResponseArry[2];
				else
				document.getElementById("mother_name").innerHTML="";
				if(ResponseArry[3]) 
				document.getElementById("aadhar_num").innerHTML=ResponseArry[3];
				else
				document.getElementById("aadhar_num").innerHTML="";
				if(ResponseArry[4]) 
				document.getElementById("age").innerHTML=ResponseArry[4];
				else
				document.getElementById("age").innerHTML="";
				if(ResponseArry[5]) 
				document.getElementById("address").innerHTML=ResponseArry[5];
				else
				document.getElementById("address").innerHTML="";
				document.getElementById("visit_id").value=VisitID;
				
				var childIDs = $('#childid_'+VisitID).val();
				if(childIDs != '')
				{
					$('#childIDsHtml').html(childIDs);
					$('.childclass').show();
				}
				else
				{
					$('.childclass').hide();
				}
			 }
		 }
	 }	
	delete xmlHttp;
 }

function GetDMV()
 {
	var xmlHttp = newHttpObject();

        if(xmlHttp)
         {
		var hosp_name_details = document.getElementById("hospital_name").value.split("~");
		var hosp_id = hosp_name_details[0];
		var dist_id = hosp_name_details[1];
		var callQuery = "ACTION=GETDMV&DistID="+dist_id+"&HospID="+hosp_id;
		//alert(callQuery);//return false;
		xmlHttp.open("POST","get_outbound_out_details.php",true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.send(callQuery);
		xmlHttp.onreadystatechange=function()
		 {
			if (xmlHttp.readyState==4 && xmlHttp.status==200)
			 {
				var Response = null;
				Response = xmlHttp.responseText;
				//alert(Response);
				var ResponseArry=Response.split("$$");
	                	var arrylen=ResponseArry.length;
				if(ResponseArry[0]) 
				document.getElementById("district").innerHTML=ResponseArry[0];
				if(ResponseArry[1]) 
				document.getElementById("division_name").innerHTML=ResponseArry[1];
				if(ResponseArry[2]) 
				document.getElementById("visit_details").innerHTML=ResponseArry[2];
                                document.getElementById("phone_num").innerHTML="";
                                document.getElementById("mother_id").innerHTML="";
                                document.getElementById("mother_name").innerHTML="";
                                document.getElementById("aadhar_num").innerHTML="";
                                document.getElementById("age").innerHTML="";
                                document.getElementById("address").innerHTML="";
                                document.getElementById("visit_id").innerHTML="";			 
                 	 
			 }
		 }
	 }	
	delete xmlHttp;
 }

function callMother()
 {
        var AgentID = "<?=$agent_id;?>";

	var hosp_name_details = document.getElementById("hospital_name").value.split("~");
        var hosp_id = hosp_name_details[0];
        var dist_id = hosp_name_details[1];

        var phone_number = document.getElementById("phone_num").innerHTML; 
        var mother_id = document.getElementById("mother_id").innerHTML; 
        var visit_id = document.getElementById("visit_id").value; 
	if(phone_number)
	 {
        	var end_call_url = "http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number+"&mother_id="+mother_id+"&hospital_id="+hosp_id+"&district_id="+dist_id+"&visit_id="+visit_id;
	 }
	else
	 {
		alert("Please Select Visit Detail. ");
		return false;
	 }
        //alert(end_call_url);//return false; 
        postURL(end_call_url,"false");  
 }

setInterval(function() { document.getElementsByClassName("alert_content")[0].innerHTML = "";document.getElementsByClassName('alert')[0].style.display = 'none';},20000);

</script>
