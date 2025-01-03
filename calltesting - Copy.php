<?php

//require_once("connect.php"); 
date_default_timezone_set('Asia/Calcutta'); 

error_reporting(0);
include_once("includes/config.php");  

$callid = $_POST["cid"];

$query = "UPDATE patient SET isactive=1 WHERE callid ='".$callid."'";
$rows = mysqli_query($mysqli,$query);

$phone = $_REQUEST["alternatenumber"];
$agent_id= $_REQUEST["agent_id"];
$convoxid = $_REQUEST["convoxid"]; 
$host_ip = "192.168.25.14";

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
  <!--<script type="text/javascript" src="js/mock.js"></script>-->
  <script>

$(document).ready(function() {
    if($('.modal-body').length) {
       
   
        
        $(document).on('change keypress select', 'select[id="trimister"]', function(){
          var $option = $(this).find('option:selected');
          var value = $option.val();//to get content of "value" attrib
    var text = $option.text();//to get <option>Text</option> content
         //   gj = $(this).val();
       //     ts = $('#trimister :selected').text();
            //alert(value+"  "+text);
//////////////////////////////////////////////////////////////////////////////////
var trimister = value;
       
        if (trimister.length != 0) {
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'trimister_id='+trimister,
                success:function(html){
                 
                    if(trimister ==1){
                      $('.trim2').hide();
                     $('trim3').hide();
                     $('.trim1').show()
                    $('.trim1').html(html);
                     
                    }
                    else if(trimister ==2){
                    
                        $('.trim1').hide();
                        $('.trim3').hide();
                       $('.trim2').show();
                       $('.trim2').html(html);
                  }
                    else if(trimister ==3){
                     
                        $('.trim1').hide();
                        $('.trim3').show();
                        $('.trim2').hide();
                        $('.trim3').html(html);
                  }
                }
            }); 
        }
////////////////////////////////////////////////////////////////////////////////
            
           
        });
       
    }
});
  


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
    <input type="text" value="<?=$_POST["cid"];?>" id="callid" name="callid" >
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="timeofcall" class="col-sm-4 col-form-label">Time of Call</label>
    <div class="col-sm-8">
    <input type="text"  value="<?=$_POST["timeofcall"];?>"  name="timeofcall" class="form-control" id="timeofcall">
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
    <input type="text" name="callername" id="callername" class="form-control">
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputalternatenumber" class="col-sm-4 col-form-label">Caller Number</label>
    <div class="col-sm-8 d-flex">
    <input type="tel"  name="alternatenumber" class="form-control" value="<?=$_POST["phone"];?>" id="alternatenumber"  maxlength='10' required  >
    <button type="button" class="dailnumber" name="call" id="call" value="Call" onclick="outboundcall();"><i class="bi bi-telephone-outbound"></i></button>
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
    <select  class="form-select" name="years" id="years" >
                 <option value="" id="">years</option>
                  <?php
                    $records = mysqli_query($mysqli, "SELECT years From m_years"); 
                    while($row = mysqli_fetch_array($records))
                     {
                       echo "<option value='". $row['years'] ."'>" .$row['years'] ."</option>";  
                       }   
                  ?>
                </select>
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
    <textarea class="form-control" id="landremarks" name="landremarks" rows="2" ></textarea>
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
  

       <button type="button" name="submit" onclick="return submits();" id="btn" class="btn btn-success">Submit </button>
       <button type="button" name="button" onclick="return saveCloseRemarks();" class="btn btn-danger">Call Back</button>  
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
	
// $.ajax({
    // url: 'http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>',
    // type: 'POST',
    // data: jQuery.param({ agent_id: "agent_id", mobile_number : "alternatenumber"}) ,
    // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    // success: function (response) {
        // alert(response.status);
    // },
    // error: function () {
        // alert("error");
    // }
// });	
 endcall();
window.location.href = "copyadmin.php"
}

function endcall()
	{
		//alert('end call initiated successfully');
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>");
		alert('end call closed successfully');
		alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$alternatenumber;?>&convoxid=<?=$convoxid;?>");
	}

function saveCloseRemarks()
{
var notresponseremarks = $('#notresponseremarks').val();
alert(notresponseremarks);	
  $.post("inscallinfo.php",{
	callid:$('#callid').val(),
	agentid:'<?=$agent_id;?>',	
  notresponseremarks:notresponseremarks,
	source:'closesubmit'
	},	
	)
window.location.href = "copyadmin.php"
}


function outboundcall()
 {
	// alert("Hi");
        var AgentID = "<?=$agent_id;?>";
        var phone_number = document.getElementById("alternatenumber").innerHTML; 
		
	if(phone_number)
	 {
        	//var call_url = "http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number+"&mother_id="+mother_id+"&hospital_id="+hosp_id+"&district_id="+dist_id+"&visit_id="+visit_id;
        	var call_url = "http://<?=$GLOBALS["host_ip"];?>/ConVox3.0/Agent/bridge.php?ACTION=CALL&user="+AgentID+"&phone_number="+phone_number; 
			alert("call_url",+call_url);
	 }
	else
	 {
		//alert("Please call ");
		return false;
	 }
        alert(call_url);//return false; 
        postURL(call_url,"false");  
 }

</script>

</body>
</html>