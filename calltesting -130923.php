<?php

//require_once("connect.php"); 
date_default_timezone_set('Asia/Calcutta'); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Private-Network: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

error_reporting(0);
include_once("includes/config.php");  

$callid = $_POST["cid"];
$query = "UPDATE patient SET isactive=1 WHERE callid ='".$callid."'";
$rows = mysqli_query($mysqli,$query);
$phone = $_POST["phone"];
$agent_id= $_POST["agent_id"];
$convoxid = $_POST["convoxid"]; 
$process = ""; 
$host_ip = "192.168.25.14";
if($agent_id=='') $agent_id='TEST';
if($phone == '') $phone='';
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
  <!--<script type="text/javascript" src="js/mock.js"></script>-->
  <script>
  function cde()
  {
	  var notresponseremarks = $('#notresponseremarks').val();
//alert(notresponseremarks);	
  $.post("inscallinfo.php",{
	callid:$('#callid').val(),
	agentid:'<?=$agent_id;?>',	
  notresponseremarks:notresponseremarks,
	source:'closesubmit'
	},	
	 function(){		
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid=<?=$convoxid;?>");
		//alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid=<?=$convoxid;?>");
window.location.href = "ecd_view.php"
		});
  }
function abc()
{
	//alert(333);
	
	 var callername = $('#callername').val();
		var tehsil_name = $('#tehsil_name').val();
		var district_name = $('#district_name').val();
		var gender_name = $('#gender_name').val();
		var years = $('#years').val();
		var cityvillage = $('#cityvillage').val();
		var landremarks = $('#landremarks').val();
		var no_ofweeks = $('#no_ofweeks').val();
		var trimister = $('#trimister').val();
		var risktype_name = $('#risktype_name').val();
		var visitinghospital_name = $('#visitinghospital_name').val();
		var suggestedhospital_name = $('#suggestedhospital_name').val();
		var subrisktype = $('#subrisktype').val();
		var riskremarks = $('#riskremarks').val();
		var trimister_1=$('#trimister_1').val();
		var nutrition = $('#nutrition').val();
		var riskfactor = $('#riskfactor').val();
		var checkboxes = document.getElementsByName('trimslist1[]');
		var vals1 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals1 += ","+checkboxes[i].value;
				}
			}
			if (vals1) vals1 = vals1.substring(1);

			var trimister1 = vals1;

			
			var checkboxes = document.getElementsByName('trimslist2[]');
			var vals2 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals2 += ","+(checkboxes[i].value).trim();
				}
			}
			
			if (vals2) vals2= vals2.substring(1);

			var trimister2 = vals2;
			

			var checkboxes = document.getElementsByName('trimslist3[]');
			var vals3 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals3 += ","+checkboxes[i].value;
				}
			}
			if (vals3) vals3= vals3.substring(1);

			var trimister3 = vals3;
             
	  $.post("inscallinfo.php",
	  {
		callid:$('#callid').val(),
		alternatenumber:$('#alternatenumber').val(),
		agentid:"test",	
		callername:callername,
		tehsil_name:tehsil_name,
		district_name:district_name,
		gender_name:gender_name,
		years:years,
		cityvillage:cityvillage,
		landremarks:landremarks,
		no_ofweeks:no_ofweeks,
		trimister:trimister,
		risktype_name:risktype_name,
		visitinghospital_name:visitinghospital_name,
		suggestedhospital_name:suggestedhospital_name,
		subrisktype:subrisktype,
		riskremarks:riskremarks,
		trimister_1:trimister1,
		trimister_2:trimister2,
		trimister_3:trimister3,
		nutrition:nutrition,
		riskfactor:riskfactor,
		source:'intialsubmit'
	}
	, function(){		
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid=<?=$convoxid;?>");
		alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid=<?=$convoxid;?>");
window.location.href = "ecd_view.php"
		});
		 endcall();
}

    </script>
</head>

<body>
  
    <div class="container">
<form method="post">
<div class="container-callfeilds">
<div class="row call-header">
  <div class="calldetailsheader">
<h6>CALL DETAILS</h6>
  </div>
</div>  
<div class="details">
  <div class="row grey-bg">
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="incident" class="col-sm-4 col-form-label">Incident ID</label>
    <div class="col-sm-8">
    <!-- <input type="text" class="form-control" name="incident_id" id="incident_id" disabled> -->
    <input type="text" value="<?=$_POST["cid"];?>" id="callid" name="callid" disabled >
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="timeofcall" class="col-sm-4 col-form-label">Time of Call</label>
    <div class="col-sm-8">
    <input type="text"  value="<?=$_POST["timeofcall"];?>"  name="timeofcall" class="form-control" id="timeofcall" disabled >
            <?php 
            date_default_timezone_set('Asia/Calcutta'); 
            ?>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputcallername" class="col-sm-4 col-form-label">Caller Name</label>
    <div class="col-sm-8">
    <input type="text" name="callername" id="callername" value="<?=$_POST["patient"];?>" class="form-control" disabled >
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputalternatenumber" class="col-sm-4 col-form-label">Caller Number</label>
    <div class="col-sm-8 d-flex">
    <input type="tel"  name="alternatenumber" class="form-control" value="<?=$_POST["phone"];?>" id="alternatenumber"  maxlength='11' required  >
    <button type="button" class="dailnumber" name="call" id="call" value="Call" ><i class="bi bi-telephone-outbound"></i></button>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputtehsil" class="col-sm-4 col-form-label">Tehsil</label>
    <div class="col-sm-8">
    <select name="tehsil_name" id="tehsil_name" class="form-select"  >
            <option value="" id="">SELECT</option>
             <?php
               $records = mysqli_query($mysqli, "SELECT tehsil_name From m_tehsil");  
               while($row = mysqli_fetch_array($records))
               {
                 echo "<option value='". $row['tehsil_name'] ."'>" .$row['tehsil_name'] ."</option>"; 
               }   
             ?>
           </select>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputdistrict" class="col-sm-4 col-form-label">District</label>
    <div class="col-sm-8">
    <select name="district_name"  id="district_name" class="form-select"  >
             <option value="" id="">SELECT</option>
             <?php
               $records = mysqli_query($mysqli, "SELECT district_name From m_district");  
                while($row = mysqli_fetch_array($records))
                {
                 echo "<option value='". $row['district_name'] ."'>" .$row['district_name'] ."</option>"; 
                 }   
              ?>
            </select>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputgender" class="col-sm-4 col-form-label">Gender</label>
    <div class="col-sm-8">
    <select name="gender_name" id="gender_name" class="form-select" >
              <option value="" id="">SELECT</option>
               <?php
                $records = mysqli_query($mysqli, "SELECT gender_name From m_gender");  
                 while($row = mysqli_fetch_array($records))
                 {
                  echo "<option value='". $row['gender_name'] ."'>" .$row['gender_name'] ."</option>"; 
                  }   
                 ?> 
             </select>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="age" class="col-sm-4 col-form-label">Age:</label>
    <div class="col-sm-8">
 
	<input  type="text" id="years" name="years" class="form-control" value="<?=$_POST["age"];?>" disabled >
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputcityvillage" class="col-sm-4 col-form-label">City/Village</label>
    <div class="col-sm-8">
    <input  type="text" id="cityvillage" name="cityvillage" class="form-control"  >
    </div>
    </div>
    </div>
    <div class="col-sm-12">
    <div class="landmark d-flex">
    <label for="comment" class="col-form-label">Landmark Remarks</label>
    <div class="textarea">
    <input type="text" class="form-control" id="landremarks" name="landremarks" value="<?=$_POST["address"];?>" rows="2"  style="height: 55px;" disabled />
    </div>
       </div>
    </div>
  </div>
</div>
</div>

<div class="container-callfields" >
   <div class="row call-header" >
        <div class="calldetailsheader" >
          <h6>EARLY CHILDHOOD DEVELOPMENT</h6>
        </div>       
    </div>


 <div class="details">
   <div class="row grey-bg">

  <div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputweekspofpregency" class="col-sm-5 col-form-label">Weeks of Pregency</label>
       <div class="col-sm-7">
         <select name="no_ofweeks" id="no_ofweeks" class="form-select"  >
            <option value="" id="">SELECT</option>
             <?php
               $records = mysqli_query($mysqli, "SELECT no_ofweeks From m_weeksofpregnancy");  
               while($row = mysqli_fetch_array($records))
               {
                 echo "<option value='". $row['no_ofweeks'] ."'>" .$row['no_ofweeks'] ."</option>";  
               }   
             ?> 
           </select>
       </div>
     </div>
   </div>

  <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputtrimister" class="col-sm-5 col-form-label">Trimister</label>
       <div class="col-sm-7">
         <select  name="trimister" id="trimister" class="form-select">
            <option value="" id="trimister_id">SELECT</option>
              <?php
                $records = mysqli_query($mysqli, "SELECT `trimister_id`,`trimister` FROM `m_trimister`"); 
                while($row = mysqli_fetch_array($records))
                 {
                  echo "<option value='". $row['trimister_id'] ."'>" .$row['trimister'] ."</option>";  
                 }   
               ?>
           </select>
       </div>
     </div>
   </div>


   <div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputrisktype" class="col-sm-5 col-form-label">Risk Type</label>
       <div class="col-sm-7">
         <select name="risktype_name" id="risktype_name" class="form-select" >
           <option value="" id="">SELECT</option>
             <?php
              $records = mysqli_query($mysqli, "SELECT risktype_name From m_risktype");  
              while($row = mysqli_fetch_array($records))
               {
                 echo "<option value='". $row['risktype_name'] ."'>" .$row['risktype_name'] ."</option>";  
                }   
              ?>  
           </select>
       </div>
     </div>
   </div>

  <div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputvistinghospital" class="col-sm-5 col-form-label">Visiting Hospital</label>
       <div class="col-sm-7">
         <select name="visitinghospital_name" id="visitinghospital_name" class="form-select" >
            <option value="" id="">SELECT</option>
              <?php
                 $records = mysqli_query($mysqli, "SELECT visitinghospital_name From m_visitinghospital");  
                 while($row = mysqli_fetch_array($records))
                 {
                   echo "<option value='". $row['visitinghospital_name'] ."'>" .$row['visitinghospital_name'] ."</option>";  
                 }   
               ?>
           </select>
       </div>
     </div>
   </div>


<div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputsuggestedhospital" class="col-sm-5 col-form-label">Suggested Hospital</label>
       <div class="col-sm-7">
          <select name="suggestedhospital_name" id="suggestedhospital_name" class="form-select" >
            <option value="" id="">SELECT</option>
              <?php
                $records = mysqli_query($mysqli, "SELECT suggestedhospital_name From m_suggestedhospital");  
                 while($row = mysqli_fetch_array($records))
                  {
                   echo "<option value='". $row['suggestedhospital_name'] ."'>" .$row['suggestedhospital_name'] ."</option>"; 
                  }   
               ?>
           </select>
       </div>
     </div>
   </div>


   <div class="col-sm-4">
    <div class="mb-2 row">
      <label for="inputsubrisktype" class="col-sm-5 col-form-label">Sub-Risk Type</label>
      <div class="col-sm-7">
        <input type="text" name="subrisktype" id="subrisktype" class="form-control" id="inputsubrisktype" >
      </div>
    </div>
   </div> 

   <div class="col-sm-12">
<div class="riskfactorremarks d-flex">
    <label for="comment" class="col-form-label">Risk Factor Remarks</label>
    <div class="textarea">
    <textarea class="form-control"  id="riskremarks" name="riskremarks" rows="2" ></textarea>
       </div>
</div>
  </div>
  </div>
</div>
</div>


<div class="container-callfeilds">

    <div class="details">
  <div class="row grey-bg">
        <div class="col-md-12">
        <div class="trim1"> 
        <div class="row trimister-header" >
        <div class="calldetailsheader" >
        <h6>TIMISTER WISE GUIDELINES</h6>
        </div>       
    </div>
        <ul>
        <?php
       //$mysqli = mysqli_connect("172.16.2.43","emri","emri","ecd");
        $query = "SELECT * FROM m_trimister1 ";
        $query_run=mysqli_query($mysqli,$query);
        if(mysqli_num_rows($query_run) > 0)
        foreach($query_run as $trims)
        {
        ?>
        <li class="list-group-item">
      <input class="form-check-input" type="checkbox" name="trimslist[]" value="<?= $trims['trimister_1']; ?>"/> 
      <label class="form-check-label" for="Checkbox" ><?= $trims['trimister_1']?></label>
        </li>
       <?php
    }
?>
        
  </ul>
                </div>
<div class="trim2"></div>
<div class="trim3"></div>
         
              </div>
              <div class="comment-box">
 <div class="row">
   <div class="col-md-6">
       <label for="comment">NUTRITION COUNSELLING</label>
    <textarea class="form-control" id="nutrition" name="nutrition" rows="6" ></textarea>
  </div>
  <div class="col-md-6">
       <label for="comment">RISK FACTOR CONSELLING</label>
    <textarea class="form-control"  id="riskfactor" name="riskfactor" rows="6"></textarea>
  </div>
  </div>

  <div class="row">
  <div class="col-md-6 mt-2">
  <div class="row">
  <div class="col-6">
       <label for="comment">Not Response Remarks</label>
  </div>
  <div class="col-6">
    <textarea class="form-control"  id="notresponseremarks" name="notresponseremarks" rows="2"></textarea>
  </div>
  </div>
  </div>
  </div>
  <div class="btns">
     
      <!-- <button type="submit"  name="submit" class="btn-2" onclick='return submits();' >SAVE</button>
        <button class="btn-1" type="button" style="margin-top:10px">BACK</button>  -->
  

       <button type="button" name="submit" id="btn" onclick="abc();" class="btn btn-success">Submit </button>
       <button type="button" name="button" onclick="cde();" class="btn btn-danger">Call Back</button>  
  </div>
   </div>
  </div>
 </div>
</div>
</form>
</div>


<script>

function submits()
{
		var callername = $('#callername').val();
		var tehsil_name = $('#tehsil_name').val();
		var district_name = $('#district_name').val();
		var gender_name = $('#gender_name').val();
		var years = $('#years').val();
		var cityvillage = $('#cityvillage').val();
		var landremarks = $('#landremarks').val();
		var no_ofweeks = $('#no_ofweeks').val();
		var trimister = $('#trimister').val();
		var risktype_name = $('#risktype_name').val();
		var visitinghospital_name = $('#visitinghospital_name').val();
		var suggestedhospital_name = $('#suggestedhospital_name').val();
		var subrisktype = $('#subrisktype').val();
		var riskremarks = $('#riskremarks').val();
		var trimister_1=$('#trimister_1').val();
		var nutrition = $('#nutrition').val();
		var riskfactor = $('#riskfactor').val();
		var checkboxes = document.getElementsByName('trimslist1[]');
		var vals1 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals1 += ","+checkboxes[i].value;
				}
			}
			if (vals1) vals1 = vals1.substring(1);

			var trimister1 = vals1;

			//alert("hi "+vals2)
			var checkboxes = document.getElementsByName('trimslist2[]');
			var vals2 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals2 += ","+(checkboxes[i].value).trim();
				}
			}
			//alert("hi "+vals2);
			if (vals2) vals2= vals2.substring(1);

			var trimister2 = vals2;
			//alert("hi "+vals2)

			var checkboxes = document.getElementsByName('trimslist3[]');
			var vals3 = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals3 += ","+checkboxes[i].value;
				}
			}
			if (vals3) vals3= vals3.substring(1);

			var trimister3 = vals3;
             //alert("hi "+vals3)

	  $.post("inscallinfo.php",
	  {

		callid:$('#callid').val(),
		alternatenumber:$('#alternatenumber').val(),
		agentid:'<?=$agent_id;?>',	
		callername:callername,
		tehsil_name:tehsil_name,
		district_name:district_name,
		gender_name:gender_name,
		years:years,
		cityvillage:cityvillage,
		landremarks:landremarks,
		no_ofweeks:no_ofweeks,
		trimister:trimister,
		risktype_name:risktype_name,
		visitinghospital_name:visitinghospital_name,
		suggestedhospital_name:suggestedhospital_name,
		subrisktype:subrisktype,
		riskremarks:riskremarks,
		trimister_1:trimister1,
		trimister_2:trimister2,
		trimister_3:trimister3,
		nutrition:nutrition,
		riskfactor:riskfactor,
		source:'intialsubmit'
	} );
 endcall();
window.location.href = "ecd_view.php"
}

function endcall()
	{
		var _convoxid=$convoxid;
		var _phonenumber=$phone;
		var _agentid=$agent_id;
		if(_convoxid!="" & _phonenumber="")
		{
		//alert('end call initiated successfully');
			$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=_agentid;?>&mobile_number=<?=_phonenumber;?>&convoxid=<?=_convoxid;?>");
			//alert('end call closed successfully');
			alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=_agentid;?>&mobile_number=<?=_phonenumber;?>&convoxid=<?=_convoxid;?>");
		}
		else{
			alert("something went wrong while end call, please contact adminsitration");
		}
	}

function saveCloseRemarks()
{
var notresponseremarks = $('#notresponseremarks').val();
//alert(notresponseremarks);	
  $.post("inscallinfo.php",{
	callid:$('#callid').val(),
	agentid:'<?=$agent_id;?>',	
  notresponseremarks:notresponseremarks,
	source:'closesubmit'
	},	
	)
	 endcall();
window.location.href = "ecd_view.php"
}
function endcall()
	{
		//alert('end call initiated successfully');
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>");
		//alert('end call closed successfully');
		alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>");
	}


function outboundcall()
 {
 alert("Hi");
        // var AgentID = "<?=$agent_id;?>";
        // var phone_number = document.getElementById("alternatenumber").innerHTML; 
		
	// if(phone_number)
	 // {
        	// //var call_url = "http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number+"&mother_id="+mother_id+"&hospital_id="+hosp_id+"&district_id="+dist_id+"&visit_id="+visit_id;
        	// var call_url = "http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number; 
			// alert("call_url",+call_url);
	 // }
	// else
	 // {
		// //alert("Please call ");
		// return false;
	 // }
        // alert(call_url);//return false; 
        // postURL(call_url,"false"); 
		var AgentID = "<?=$agent_id;?>";
		var phone_number = document.getElementById("alternatenumber").innerHTML; 
		var ConVoxClick_to_call_url ="http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number; 
        $.ajax({
            url: ConVoxClick_to_call_url,  //the page containing php script
            type: "post",    //request type,
           // dataType: 'json',
			//data: {ACTION:"CALL",user:AgentID,phone_number:phone_number}
           // data: {registration: "success", callrefernce: "xyz",$convoxid, email: "abc@gmail.com"},
            success:function(result)
			{
				//alert('Result:'+ result);
				//Response : {"PHONE_NUMBER":"9989593026","PROCESS":"ECD_process","CONVOXID":"78517"}
				var respdata= Json.parse(result);
				//alert('Result:'+ result);
            // <?$convoxid;?> =  respdata.CONVOXID;
			// <?=$process;?> =respdata.PROCESS;
            }
        });
		
 }

</script>

</body>
</html>