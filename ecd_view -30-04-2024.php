<?php
date_default_timezone_set('Asia/Calcutta'); 
error_reporting(0);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Private-Network: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

include_once("includes/config.php");  

//echo "<pre>".print_r($_REQUEST,1)."</pre>";
//echo "<pre>".print_r($_POST,1)."</pre>";
//$phone = $_REQUEST["mobile_number"];

$phone = $_POST["alternatenumber"];
#echo $phone;
$agent_id= $_REQUEST["agent_id"];
#echo $agent_id;
$convoxid = ""; 
$process = ""; 
$host_ip = "192.168.25.14";
//echo logged in agent: .$agent_id;




#$callid = $_POST["cid"];
#echo $query = "UPDATE patient SET isactive=1 WHERE callid ='".$callid."'";
#$rows = mysqli_query($mysqli,$query);
//$phone = $_POST["phone"];

#$agent_id= $_POST["agent_id"];
//$convoxid = $_POST["convoxid"]; 
//$convoxid =0; 
//$process = ""; 
//$host_ip = "192.168.25.14";
//if($agent_id=='') $agent_id='TEST';
//if($convoxid=='') $convoxid='78517';
if($phone == '') $phone='';



if (isset($_GET['page_no']) && $_GET['page_no']!="") {
  $page_no = $_GET['page_no'];
  } else {
      $page_no = 1;
      }

$total_records_per_page = 100;

$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

#$query_count = "SELECT COUNT(*) As total_records FROM patient WHERE STATUS IN (1,2) AND callback = 2";

$query_count = "SELECT COUNT(*) AS total_row_count
FROM((SELECT
    pa.callid AS callid,
    ecd.actualtimeofcall,
    ecd.ecdcallback,
    MAX(pa.callback_time) AS callback_time,
    MAX(pa.timeofcall) AS timeofcall,
    pa.hospital AS hospital,
    pa.patient AS patient,
    pa.age AS age,
    pa.address AS address,
    pa.phone AS phone,
    pa.diagnosis AS diagnosis,
    DATE(pa.EDD) AS EDD,
    DATE(pa.LMP) AS LMP,
    va.Trimester AS Trimester,
    va.NextVisitDate AS NextVisitDate 
FROM
    patient pa
LEFT JOIN (
    SELECT callid, MAX(timeofcall) AS actualtimeofcall,
    MAX(callbacktime) AS ecdcallback, callbacktime 
    FROM ecdtable  
    GROUP BY callid
) AS ecd ON pa.callid = ecd.callid
LEFT JOIN 
    view_patient AS va ON pa.callid = va.callid    
WHERE
    pa.STATUS IN (1, 2)
    AND pa.callback = 2  
GROUP BY pa.callid LIMIT $offset, $total_records_per_page
)
UNION
(
SELECT
    pa.callid AS callid,
    ecd.actualtimeofcall,
    ecd.ecdcallback,
    MAX(pa.callback_time) AS callback_time,
    MAX(pa.timeofcall) AS timeofcall,
    pa.hospital AS hospital,
    pa.patient AS patient,
    pa.age AS age,
    pa.address AS address,
    pa.phone AS phone,
    pa.diagnosis AS diagnosis,
    DATE(pa.EDD) AS EDD,
    DATE(pa.LMP) AS LMP,
    va.Trimester AS Trimester,
    va.NextVisitDate AS NextVisitDate 
FROM
    patient pa
LEFT JOIN (
    SELECT callid, MAX(timeofcall) AS actualtimeofcall,
    MAX(callbacktime) AS ecdcallback, callbacktime 
    FROM ecdtable  
    GROUP BY callid
) AS ecd ON pa.callid = ecd.callid
LEFT JOIN 
    view_patient AS va ON pa.callid = va.callid    
WHERE
    pa.STATUS = 3 
    AND DATE(ecd.ecdcallback) = DATE(NOW())
GROUP BY pa.callid
)
ORDER BY callback_time) AS tot";

$result_count = mysqli_query($mysqli,$query_count);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_row_count'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total pages minus 1

//echo $start_from;
//$query = "SELECT * FROM patient WHERE STATUS = 1 AND callback = 2 LIMIT $start_from, $num_per_page";

#SELECT * FROM patient WHERE STATUS = 1 AND callback = 2 UNION SELECT *FROM `patient` WHERE STATUS = 2 AND TIMESTAMPDIFF(MINUTE,`callback_time`,NOW()) >=0 ORDER BY callback_time DESC LIMIT $offset, $total_records_per_page

#$query="SELECT * FROM patient WHERE STATUS = 1 AND callback = 2 UNION SELECT *FROM `patient` WHERE STATUS = 2 AND TIMESTAMPDIFF(MINUTE,`callback_time`,NOW()) >=0 ORDER BY callback_time DESC LIMIT $offset, $total_records_per_page";

# $query = "SELECT * FROM patient WHERE STATUS IN (1,2,3) AND callback = 2  ORDER BY callback_time DESC LIMIT $offset, $total_records_per_page";

#SELECT * FROM patient WHERE STATUS IN (1,2,3) AND callback = 2 ORDER BY callback_time 

#echo $query = "SELECT * FROM patient pa LEFT JOIN view_patient AS va ON pa.callid=va.callid WHERE DATE(NOW()) = DATE(va.NextVisitDate) GROUP BY va.callid ORDER BY pa.callback_time DESC LIMIT $offset, $total_records_per_page";

#WHERE DATE(NOW()) = DATE(va.NextVisitDate)

#$query ="SELECT * FROM patient pa LEFT JOIN view_patient AS va ON pa.callid=va.callid WHERE pa.STATUS IN (1,2) AND pa.callback = 2 and TIMESTAMPDIFF(MINUTE,pa.callback_time,NOW()) >=0 and va.NextVisitDate IS NOT NULL GROUP BY va.callid  ORDER BY pa.callback_time DESC LIMIT $offset, $total_records_per_page";

#AND va.NextVisitDate IS NOT NULL

/*
$query ="SELECT ecd.timeofcall AS actualtimeofcall, DATE(ecd.callbacktime) AS ecdcallback, pa.callid AS callid,pa.callback_time AS callback_time, pa.timeofcall AS timeofcall,
pa.hospital AS hospital,pa.patient AS patient, pa.age AS age,pa.address AS address,pa.phone AS phone,pa.diagnosis AS diagnosis,
pa.EDD AS EDD, pa.LMP AS LMP, va.Trimester AS Trimester, va.NextVisitDate AS NextVisitDate 
FROM patient pa LEFT JOIN view_patient AS va ON pa.callid=va.callid LEFT JOIN ecdtable AS ecd ON pa.callid=ecd.callid 
WHERE pa.STATUS IN (1,2,3) AND pa.callback = 2 
AND TIMESTAMPDIFF(MINUTE,ecd.callbacktime,NOW()) >=0 
-- group by pa.callid
ORDER BY ecd.callbacktime DESC LIMIT $offset, $total_records_per_page";
*/

/*$query ="SELECT
    pa.callid AS callid,
    ecd. actualtimeofcall,
    ecd.ecd_status,
    DATE(ecd. ecdcallback)ecdcallback,
    MAX(pa.callback_time) AS callback_time,
    MAX(pa.timeofcall) AS timeofcall,
    pa.hospital AS hospital,pa.patient AS patient,
pa.age AS age,pa.address AS address,pa.phone AS phone,pa.diagnosis AS diagnosis,DATE(pa.EDD) AS EDD, DATE(pa.LMP) AS LMP, 
va.Trimester AS Trimester, va.NextVisitDate AS NextVisitDate 
FROM
    patient pa
LEFT JOIN (SELECT callid, ecd_status,MAX(timeofcall)`actualtimeofcall`,
    MAX(callbacktime)`ecdcallback` ,callbacktime FROM
    ecdtable WHERE  ecd_status !=1 GROUP BY callid)AS ecd ON pa.callid = ecd.callid
LEFT JOIN 
    view_patient AS va ON pa.callid = va.callid    
WHERE
    pa.STATUS IN (1,2,3)
    AND pa.callback = 2 
 -- and ecd.ecd_status !=1
GROUP BY
    pa.callid
ORDER BY
    MAX(ecd.callbacktime) DESC, pa.callid
LIMIT $offset, $total_records_per_page";
*/
$query =" (SELECT
    pa.callid AS callid,
    ecd.actualtimeofcall,
    ecd.ecdcallback,
    MAX(pa.callback_time) AS callback_time,
    MAX(pa.timeofcall) AS timeofcall,
    pa.hospital AS hospital,
    pa.patient AS patient,
    pa.age AS age,
    pa.address AS address,
    pa.phone AS phone,
    pa.diagnosis AS diagnosis,
    DATE(pa.EDD) AS EDD,
    DATE(pa.LMP) AS LMP,
    va.Trimester AS Trimester,
    va.NextVisitDate AS NextVisitDate,
	pa.isactive	as isactive
FROM
    patient pa
LEFT JOIN (
    SELECT callid, MAX(timeofcall) AS actualtimeofcall,
    MAX(callbacktime) AS ecdcallback, callbacktime 
    FROM ecdtable  
    GROUP BY callid
) AS ecd ON pa.callid = ecd.callid
LEFT JOIN 
    view_patient AS va ON pa.callid = va.callid    
WHERE
    pa.STATUS IN (1, 2)
    AND pa.callback = 2  
GROUP BY pa.callid LIMIT $offset, $total_records_per_page
)
UNION
(
SELECT
    pa.callid AS callid,
    ecd.actualtimeofcall,
    ecd.ecdcallback,
    MAX(pa.callback_time) AS callback_time,
    MAX(pa.timeofcall) AS timeofcall,
    pa.hospital AS hospital,
    pa.patient AS patient,
    pa.age AS age,
    pa.address AS address,
    pa.phone AS phone,
    pa.diagnosis AS diagnosis,
    DATE(pa.EDD) AS EDD,
    DATE(pa.LMP) AS LMP,
    va.Trimester AS Trimester,
    va.NextVisitDate AS NextVisitDate,
	pa.isactive	as isactive
FROM
    patient pa
LEFT JOIN (
    SELECT callid, MAX(timeofcall) AS actualtimeofcall,
    MAX(callbacktime) AS ecdcallback, callbacktime 
    FROM ecdtable  
    GROUP BY callid
) AS ecd ON pa.callid = ecd.callid
LEFT JOIN 
    view_patient AS va ON pa.callid = va.callid    
WHERE
    pa.STATUS = 3 
    AND DATE(ecd.ecdcallback) = DATE(NOW())
GROUP BY pa.callid
)
ORDER BY callback_time DESC LIMIT $offset, $total_records_per_page  ";
$rows = mysqli_query($mysqli,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>104 ECD</title>

<link rel="stylesheet"  type="text/css" href="css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<style>
  .no-bg{
    background-color: initial !important;
    background: none;
  border: 0px;
}
  </style>
</head>
<body>
<?php include("includes/header.php");?>
   <div class="container">
    <div class="box">
     
        <div class="ecdheader">
           <h6>ECD PATIENT LIST</h6>
          </div>        
          <div class="patientdata">
       <table class="table table-striped table-hover" id="">
        <thead>
        <tr>
          <!-- <th>S.No</th> -->
                  <th>Incident Id</th>
                  <th>Call Time</th>
                  <th>Call Back Time</th>
                  <th>Trimister</th>
                  <th>NextVisitDate</th>
                  <th>Name of the Hospital</th>
                  <th>Name of the Patient</th>
                  <th>Age</th>
                  <th>Address</th>
                  <th>Phone No</th>
                  <th>Diagnosis with Gravida/para status</th>
                  <th>LMP</th>
                 <!--<th>Pregnancy weeks</th>-->
			            <th>EDD</th>
			            <th style="display:none;">Is Active</th>
                  <th></th>
                  <th></th>
           </tr>
           </thead>
		
		<tbody>

    <?php
while($result=mysqli_fetch_assoc($rows))
{

  //$i++;
?>
    
    <tr>

      <td><?php echo $result["callid"];?></td>
      <td ><?php echo $result["timeofcall"] ?></td>
      <td ><?php if(isset($result["callback_time"]) &&  !empty($result["callback_time"]) && $result["callback_time"] != '0000-00-00 00:00:00')
        echo $result["callback_time"]; else echo 'N/A'; ?></td>
      <td><?php echo $result["Trimester"] ?></td>
      <td><?php echo $result["NextVisitDate"] ?></td>
      <td><?php echo $result["hospital"] ?></td>
      <td><?php echo $result["patient"] ?></td>
      <td><?php echo $result["age"] ?></td>
      <td><?php echo $result["address"] ?></td>
      <td><?php echo $result["phone"] ?></td>
      <td><?php echo $result["diagnosis"] ?></td>
      <td style="display:none;"><?php echo $result["isactive"] ?></td>
      <td><?php echo $result["LMP"] ?></td>
      <!--<td><?php //echo $result["weeks"] ?></td>-->
      <td><?php echo $result["EDD"] ?> <input type="hidden" id="isactive<?=$result['callid'];?>" value="<?php echo $result["isactive"] ?>" /></td>
	 
    <td><span><img src='img/view-icon.png'></span>

    <a type="button" class="btn-call viewPatient" data-callid="<?=$result['callid'];?>" data-bs-toggle="modal" data-bs-target="#viewPatient">VIEW</a></td>
    <td class=""><span><img src="img/call-iocn.png"></span>
<a type="button" class="btn-call actionView isactive<?=$result['callid'];?>" data-callid="<?=$result['callid'];?>"   data-agent_id="<? echo $agent_id;?>" data-trimesterVal="<?=$result['Trimester'];?>" data-bs-toggle="modal" data-bs-target="#myModal">ACTION</a></td>
</tr>
    </tbody>
<?php
}
?>
       </table>
       </div>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;' class="d-flex justify-content-between">
<div>
<strong class="p-3">Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>
<ul class="pagination">
<?php if($page_no > 1){
echo "<li><a class='btn btn-danger' href='?page_no=1'>First</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a class="btn btn-danger" <?php if($page_no > 1){
echo "href='?page_no=$previous_page'"; echo "|";
} ?>>< Previous</a>
</li>
    
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a class="btn btn-success" <?php if($page_no < $total_no_of_pages) {
echo "href='?page_no=$next_page'"; echo "|";
} ?>>Next ></a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href='?page_no=$total_no_of_pages' class='btn btn-danger'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>
</div>
 </div>
</div>



<div class="modal fade" id="approveMerchant" tabindex="-1" role="dialog" aria-labelledby="disableMerchantTitle" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">       
<div class="modal-content" style="padding:10px;">
         

    <div class="container">
<form class="application" autocomplete="off" method="post" id="create-client" >
<div class="container-callfeilds">
<div class="row call-header">
  <div class="calldetailsheader d-flex justify-content-between" style="padding: 2px;">
   <input type="hidden" id="convoxidValue" />
   <?php $_SERVER['REQUEST_URI']; ?>
<div><h6 class="p-2">CALL DETAILS</h6></div>

<div>
<input  type="hidden" id="pop_phone" name="" class="form-control pop_phone" value=""></div>
<a href="javascript:void(0);" class="btn btn-success" style="" onclick="return showHistory();" >
<i class="bi bi-telephone-forward"></i>
</a>
</div>
	

  </div>
</div>  
<div class="details">
  <div class="row grey-bg">
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="incident" class="col-sm-4 col-form-label">Incident ID</label>
    <div class="col-sm-8">
    <div class="form-group">
      <input type="text" class="form-control" name="callid" id="callid" disabled >
</div>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="timeofcall" class="col-sm-4 col-form-label">Time of Call</label>
    <div class="col-sm-8">
    <input type="text"  value="<?=date('Y-m-d H:i:s');?>"  name="timeofcall" class="form-control" id="timeofcall" disabled >
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
    <div class="form-group">
    <input name="patient" class="form-control"  id="patient" type="text" >
</div>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputalternatenumber" class="col-sm-4 col-form-label">Caller Number</label>
    <div class="col-sm-8 d-flex">
    <div class="form-group">
    <input type="text"  name="alternatenumber" class="form-control" id="alternatenumber" required max-length="10"></div>
	<input type="hidden"  name="" class="form-control" id="pop_agent_id" value="" >
    <button type="button" class="dailnumber" name="call" id="call" value="Call" onclick="callOrginate();" ><i class="bi bi-telephone-outbound"></i></button>
</div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputtehsil" class="col-sm-4 col-form-label">Tehsil</label>
    <div class="col-sm-8">
    <div class="form-group">
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
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputdistrict" class="col-sm-4 col-form-label">District</label>
    <div class="col-sm-8">
    <div class="form-group">
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
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputgender" class="col-sm-4 col-form-label">Gender</label>
    <div class="col-sm-8">
    <div class="form-group">
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
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="age" class="col-sm-4 col-form-label">Age:</label>
    <div class="col-sm-8">
    <div class="form-group">
	<input  type="text" id="years" name="years" class="form-control" disabled></div>
    </div>
    </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="inputcityvillage" class="col-sm-4 col-form-label">City/Village</label>
    <div class="col-sm-8">
    <div class="form-group">
    <input  type="text" id="cityvillage" name="cityvillage" class="form-control"  >
                </div>
    </div>
    </div>
    </div>
    <div class="col-sm-8">
    <div class="landmark d-flex">
    <label for="comment" class="col-form-label">Landmark Remarks</label>
    <div class="textarea">
    <div class="form-group">
    <input type="text" class="form-control" id="landremarks" name="landremarks"  rows="2"  style="height: 55px;" disabled />
                </div>  
  </div>
       </div>
    </div>
    <div class="col-sm-4">
    <div class="mb-2 row">
    <label for="lmp" class="col-sm-4 col-form-label">LMP:</label>
    <div class="col-sm-8">
    <input  type="text" id="LMP" name="LMP" class="form-control LMP"  value="">
                </div>
                <div class="col-sm-8 datepickerView">
                <div class="form-group input-group ">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-event"></i></span>
                <input type="text" name="datepicker"  class="form-control disableFuturedate" id="datepicker" >
				<button type="button" id="update" name="update" class="btn btn-success">Update</button>
                 </div>
    </div>
    
    </div>
    </div>
  </div>
</div>
</div>


<div class="show_hide">

<div class="delivered_hide">


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
       <label for="inputvistinghospital" class="col-sm-5 col-form-label">Visiting Hospital</label>
       <div class="col-sm-7">
       <div class="form-group">
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
   </div>

<div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputsuggestedhospital" class="col-sm-5 col-form-label">Suggested Hospital</label>
       <div class="col-sm-7">
       <div class="form-group">
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
   </div>
   <div class="col-sm-4">
    <div class="mb-2 row">
       <label for="inputrisktype" class="col-sm-5 col-form-label">Risk Type</label>
       <div class="col-sm-7">
       <div class="form-group">
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
   </div>
   <div class="col-sm-8">
<div class="riskfactorremarks d-flex">
    <label for="comment" class="col-form-label">Risk Factor Remarks</label>
    <div class="textarea">
    <div class="form-group">
    <textarea class="form-control"  id="riskremarks" name="riskremarks" rows="2" ></textarea>
                </div>
       </div>
</div>
  </div>
  
  <div class="col-sm-4">
    <div class="mb-2 row">
      <label for="inputsubrisktype" class="col-sm-5 col-form-label">Sub-Risk Type</label>
      <div class="col-sm-7">
      <div class="form-group">
        <input type="text" name="subrisktype" id="subrisktype" class="form-control" id="inputsubrisktype" >
                </div>
      </div>
    </div>
   </div> 
   <div class="col-sm-12">
   <div class="row comment-box">
   <div class="col-md-6">
       <label for="comment">NUTRITION COUNSELLING</label>
       <div class="form-group">
    <textarea class="form-control" id="nutrition" name="nutrition" rows="6" ></textarea>
  </div>
  </div>
	  <div class="col-md-6">
	  <label for="comment">RISK FACTOR COUNSELLING</label>
	  <div class="form-group">
	  <textarea class="form-control"  id="riskfactor" name="riskfactor" rows="6"></textarea>
	  </div>
	  </div>
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
        <div class="trim1"> </div>
        </div>
        <div class="comment-box">
    <!--<div class="row">
   <div class="col-md-6">
       <label for="comment">NUTRITION COUNSELLING</label>
       <div class="form-group">
    <textarea class="form-control" id="nutrition" name="nutrition" rows="6" ></textarea>
  </div>
  </div>
	  <div class="col-md-6">
	  <label for="comment">RISK FACTOR CONSELLING</label>
	  <div class="form-group">
	  <textarea class="form-control"  id="riskfactor" name="riskfactor" rows="6"></textarea>
	  </div>
	  </div>
	  </div>-->

  <div class="row grey-bg">
  <div class="col-md-6 mt-2">
  <div class="row grey-bg">
  <div class="col-md-6">
       <label for="comment">Not Response Remarks</label>
  </div>
  <div class="col-md-6">
  <div class="form-group">
    <textarea class="form-control"  id="notresponseremarks" name="notresponseremarks" rows="2"></textarea>
  </div>
  </div>
  </div>
  </div>

  <div class="col-md-6 mt-2">
  <div class="row grey-bg">
  <div class="col-md-6">
  <label for="comment">Case Closer Type</label>
  </div>
  <div class="col-md-6">
  <div class="form-group">
  <select name="caseclose_name" id="caseclose_name" class="form-select" >
     <option value="" id="">SELECT</option>
     <?php
      $records = mysqli_query($mysqli, "SELECT caseclose_name From m_caseclosetype");  
      while($row = mysqli_fetch_array($records))
        {
        echo "<option value='". $row['caseclose_name'] ."'>" .$row['caseclose_name'] ."</option>"; 
        }   
       ?>
   </select>
 </div>
  </div>
  </div>
  </div>
  </div>
  <div class="btns">
   <button type="button" name="submit" id="btn" onclick="actionsubmit();" class="btn btn-success">Submit </button>
   <button type="button" name="button" onclick="callbacksubmit();" class="btn btn-danger">Call Back</button> 
   <button type="button" name="close" onclick="caseclose();" class="btn btn-danger">Close</button>
       
  </div>
   </div>
  </div>
 </div>
</div>
</form>
 </div>
</div>


  
 </div>
 </div>
 </div>




 <div class="modal fade" id="showViewPatient" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

            <div class="modal-header d-block">                
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              
                <div class="alert alert-danger" style="display: none">
                    
                </div>
              </div>


      <form class="application" autocomplete="off" method="post" id="create-client" >
       <div class="modal-body">
      <div class="popuptitle" style="  text-align: left; background-color: #e01860; color: white; padding: 11px 20px; border-top-left-radius: 5px;border-top-right-radius: 5px;">
      <div class="col-12 ">
      ECD PATIENT DETAILS
      </div>
      </div>
                
      <div class="container text-center">  
         <div class="row odd-row">
            <div class="col-5"> Name of the Hospital</div>
            <div class="col-7"> <input type="text" name="hospital"  class="form-control no-bg" id="viewhospital" disabled > </div>
            </div> 
            <div class="row even-row">
             <div class="col-5 ">Name of the Patient</div>
            <div class="col-7"><input type="text" name="viewpatient"  class="form-control no-bg" id="viewpatient" disabled ></div>
             </div>
             <div class="row odd-row">
             <div class="col-5"> Age</div>
             <div class="col-7"><input type="text" name="age"  class="form-control no-bg" id="viewage" disabled ></div>
             </div>
             <div class="row even-row">
             <div class="col-5"> Address</div>
             <div class="col-7"> <input type="text" name="address"  class="form-control no-bg" id="viewaddress" disabled ></div>
             </div>
             <div class="row odd-row">
             <div class="col-5"> Phone No</div>
             <div class="col-7"><input type="text" name="phone"  class="form-control no-bg" id="viewphone" disabled ></div>
             </div>
             <div class="row even-row">
             <div class="col-5"> Diagnosis with Gravida/para status</div>
             <div class="col-7"><input type="text" name="diagnosis"  class="form-control no-bg" id="viewdiagnosis" disabled ></div>
             </div>
             <div class="row odd-row">
             <div class="col-5"> LMP</div>
             <div class="col-7"> <input type="text" name="LMP"  class="form-control no-bg" id="viewLMP" disabled ></div>
             </div>
             <div class="row even-row">
             <div class="col-5"> Pregnancy weeks</div>
             <div class="col-7"><input type="text" name="weeks"  class="form-control no-bg" id="viewweeks" disabled ></div>
             </div>
             <div class="row odd-row">
             <div class="col-5 ">EDD</div>
            <div class="col-7"><input type="text" name="EDD"  class="form-control no-bg" id="viewEDD" disabled ></div>
            </div>     
           <div class="row even-row">
           <div class="col-5 ">High Risk Factor</div>
           <div class="col-7"><input type="text" name="riskfactor"  class="form-control no-bg" id="viewriskfactor" disabled ></div>
           </div> 
           <div class="row odd-row">
             <div class="col-5 "> 1st Visit</div>
            <div class="col-7"><input type="text" name="first_visit"  class="form-control no-bg" id="viewfirst_visit" disabled ></div>
            </div>
            <div class="row even-row">
            <div class="col-5 ">2nd Visit</div>
            <div class="col-7"><input type="text" name="second_visit"  class="form-control no-bg" id="viewsecond_visit" disabled ></div>
            </div>
            <div class="row odd-row">
            <div class="col-5 "> 3rd Visit</div>
           <div class="col-7"><input type="text" name="third_visit"  class="form-control no-bg" id="viewthird_visit" disabled ></div>
           </div>
           <div class="row even-row">
           <div class="col-5 ">4th Visit</div>
           <div class="col-7"><input type="text" name="fourth_visit"  class="form-control no-bg" id="viewfourth_visit" disabled ></div>
           </div>
           <div class="row odd-row">
             <div class="col-5 "> 5th Visit</div>
            <div class="col-7"><input type="text" name="fifth_visit"  class="form-control no-bg" id="viewfifth_visit" disabled ></div>
            </div>
            <div class="row even-row">
            <div class="col-5 ">6th Visit</div>
            <div class="col-7"><input type="text" name="sixth_visit"  class="form-control no-bg" id="viewsixth_visit" disabled ></div>
            </div>
            <div class="row odd-row">
            <div class="col-5 "> 7th Visit</div>
           <div class="col-7"><input type="text" name="seventh_visit"  class="form-control no-bg" id="viewseventh_visit" disabled ></div>
           </div>
		    <div class="row odd-row">
            <div class="col-5 "> Any additional visits other than the mandatory 7 visits</div>
           <div class="col-7"><input type="text" name="additional_visit"  class="form-control no-bg" id="viewadditional_visit" disabled ></div>
           </div>
           <div class="row even-row">
            <div class="col-5 ">Type of delivery </div>
            <div class="col-7"><input type="text" name="typeof_delivery"  class="form-control no-bg" id="viewtypeof_delivery" disabled ></div>  
            </div> 
            <div class="row odd-row">
            <div class="col-5 "> Complications if any during antepartum/intrapartum/ postpartum period</div>
           <div class="col-7"><input type="text" name="complications"  class="form-control no-bg" id="viewcomplications" disabled ></div>
           </div>
            <div class="row even-row">
            <div class="col-5 "> Outcome of pregnancy</div>
           <div class="col-7"><input type="text" name="outcomeof_pregnancy"  class="form-control no-bg" id="viewoutcomeof_pregnancy" disabled ></div>
           </div>
           <div class="row odd-row">
           <div class="col-5 ">Status of newborn at the time of discharge</div>
          <div class="col-7"><input type="text" name="statusof_newborn"  class="form-control no-bg" id="viewstatusof_newborn" disabled ></div>
          </div>    
         </div>        
         </div>
              <div class="modal-footer">

              <!-- <button type="button" class="btn btn-danger close float-right" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;Close</span>
                </button> -->
              <!-- <button type="button" id="viewclose" class="btn btn-danger">Close</button> -->
              </div>
          </form>
            </div>
          </div>
        </div>
		
		
		<!-- history modal-->
		<div class="modal fade" id="showCallHistory" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="padding:10px;">

            <div class="modal-header d-block">                
               
                <div class="alert alert-danger" style="display: none">
                    
                </div>
              </div>


  
       <div class="modal-body">
      <div class="popuptitle" style="  text-align: left; background-color: #e01860; color: white; padding: 11px 20px; border-top-left-radius: 5px;border-top-right-radius: 5px;">
      <div class="col-12 ">
      Call History
      </div>
      </div>
                
      <div class="container text-center">  
         <div class="row odd-row">
             <div id="appendCallHistory"></div>
         </div>        
         </div>
              <div class="modal-footer">

              </div>
   
            </div>
          </div>
        </div>
		
		
		
    <!-- <script type="text/javascript">
    document.getElementById("viewclose").onclick = function () {
    location.href = "ecd_view.php";
    };
    </script> -->


 <script>
  function caseclose()
  {
    //alert('test');
	  var caseclose_name = $('#caseclose_name').val();
    console.log(caseclose_name);
	  var convoxidValue = $('#convoxidValue').val();
	
  $.post("inscallinfo.php",{
	callid:$('#callid').val(),
	agentid:'<?=$agent_id;?>',	
  caseclose_name:caseclose_name,
	source:'caseclosesubmit'
	},	
	 function(){	
	   
		
		 $.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
		 alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
		 
		 //return false;
       
	  location.reload("ecd_view.php");
		//window.location.href = "ecd_view.php"
		});
		
  }



  function callbacksubmit()
  {
	  var notresponseremarks = $('#notresponseremarks').val();
	      console.log(notresponseremarks);
	  var convoxidValue = $('#convoxidValue').val();
//alert(notresponseremarks);	
  $.post("inscallinfo.php",{
	callid:$('#callid').val(),
	agentid:'<?=$agent_id;?>',	
  notresponseremarks:notresponseremarks,
	source:'closesubmit'
	},	
	 function(){	
	   
		 //alert("call closed successfully..!");	
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
		alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
       
	   location.reload("ecd_view.php");
		//window.location.href = "ecd_view.php"
		});
		
  }
  
function actionsubmit()
{
	//alert(333);
	
	 var callername = $('#patient').val();
	 var timeofcall = $('#timeofcall').val();
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
		var convoxidValue = $('#convoxidValue').val();
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
		  //console.log(agentid, <?=$agent_id;?>);
		callid:$('#callid').val(),
		timeofcall:$('#timeofcall').val(),
		alternatenumber:$('#alternatenumber').val(),
		//agentid:'<?=$agent_id;?>',	
		//$convoxid:'<?=$convoxid?>',
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
            // location.reload();	
        // alert("call closed successfully..!");			
		$.post("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
		alert("http://<?=$host_ip;?>/ConVox3.0/Agent/callcontrol.php?ACTION=CLOSE&agent_id=<?=$agent_id;?>&mobile_number=<?=$phone;?>&convoxid="+convoxidValue);
      
	  location.reload("ecd_view.php");
	//window.location.href = "ecd_view.php"

		});
		
}
function callOrginate()
		{		
			//alert('Call Originate initiated');
			 var ConVoxClick_to_call_url="1234"; 
			 
			 var hostip = "<?php echo $GLOBALS['host_ip']; ?>";
			 var phonenum ="<?php echo $GLOBALS['alternatenumber']; ?>";    //9011808386
			 var phonenum = $("#alternatenumber").val();
			 var agentid = "<?php echo $GLOBALS['agent_id'];?>";
			 
			 console.log('hostip', hostip);
			 //var agentid = $("#pop_agent_id").val();
			//console.log('pop_agent_id',agentid);
			//var hostip=<?=$GLOBALS["host_ip"];?>;
			//console.log('phonenum', phonenum);
			/// alert(hostip+phonenum+agentid);
			var ConVoxClick_to_call_url = "http://" + hostip + "/ConVox3.0/Agent/bridge.php?ACTION=CALL&user=" + agentid + "&phone_number=0" + phonenum;
           //alert("thridparty" + ConVoxClick_to_call_url);
		   console.log(ConVoxClick_to_call_url);
			$.post(ConVoxClick_to_call_url, function (return_data) {
				// Process the response data
				return_data = return_data.replace(/<script>.*<\/script>/, '');
				alert('Return Data'+return_data);
				var jsonObject = JSON.parse(return_data);
				var convoxidValue = jsonObject.CONVOXID; // Extract CONVOXID directly from the JSON

				//  Display CONVOXID value in an alert
				alert('CONVOXID: ' + convoxidValue);

				// Set the extracted CONVOXID as the value of an input field with ID 'convoxidValue'
				$('#convoxidValue').val(convoxidValue);
			});			
		}


function showHistory(){
	var temp_phone= $('#pop_phone').val();
	$.post("counttoday.php",{alternatenumber: temp_phone },function(result){ 
	
	//$('.loadHistory').html(result);
	$('#showCallHistory').modal('show');
	$('#showCallHistory').modal('show');	
	$("#appendCallHistory").html(result);
	});
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='none';
	$('#light').css("display", "block");
	$('#fade').css("display", "none");
}


</script>

<script>
     $( function() {
	
	  var today = new Date();
        $('.disableFuturedate').datepicker({
            // format: 'mm-dd-yyyy',
			format: 'dd-mm-yyyy',
            autoclose:true,
            endDate: "today",
            maxDate: today
        }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });


        $('.disableFuturedate').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
            }
        });
	 
	  
    //$("#datepicker").datepicker();
    $('#modal').modal('toggle');
  });
  
  

$(document).ready(function(){

    $("#update").on("click", function(){
		//debugger;
		var datepicker = $('#datepicker').val();
		var callid = $('#callid').val();
		var key = 'updatelmp';
		console.log(datepicker, '==>', callid);
		
		  $.ajax({
                url: "update_lmp.php",
                type: "POST",
                data: {lmpdate:datepicker, callid: callid, key: key},
                error: function() {
                    //console.log("ajax error occured");
                     $(".cusSpinner").hide();
                },
                success: function(response,status,xhr) {
                  
                 // var json = $.parseJSON(response);
                  if(response == '1'){
						$('#approveMerchant').modal('hide');
				  }
				}
		  });
		 //$(".show_hide").show();
	});

  $(".actionView").on("click", function(){
    //debugger;
    var callid = $(this).attr("data-callid");
	var agentid = $(this).attr("data-agent_id");
    var trimesterVal = $(this).attr("data-trimesterVal");
	var active =  $('#isactive'+callid).val();
	console.log('active', active);
	
	$.ajax({
                url: "status_active.php",
                type: "POST",
                data: {agentid:agentid, callid: callid},
                error: function() {
                    //console.log("ajax error occured");
                     $(".cusSpinner").hide();
                },
                success: function(response,status,xhr) {
					console.log(response);
					
					if (response === "already_opened") {
						alert("HI "+agentid+ "THIS " + callid+" WAS ALREADY OPENED BY THE ANOTHER USER PLEASE PROCEED TO THE NEXT...");
						return;
					} else if(response === "update"){
						alert("HI "+agentid+ "THIS " + callid+" WAS ALREADY OPENED BY THE ANOTHER USER PLEASE PROCEED TO THE NEXT...");
						return;
					} else {
							gettrimesterData(trimesterVal);
							getRenderData(callid, agentid);
					}
				}
		  });
		  
	//alert("HI "+agent_id);
	//$query = "UPDATE patient SET isactive=1 WHERE callid ='".$callid."'";
    //$rows = mysqli_query($mysqli,$query);
	//alert("HI "+agentid+ "THIS " + callid+" WAS ALREADY OPENED BY THE ANOTHER USER PLEASE PROCEED TO THE NEXT...");
	//window.location.href = "ecd_view.php"



  });

  
  
  $(".viewPatient").on("click", function(){
    //debugger;
    var callid = $(this).attr("data-callid");
    //console.log(callid);
    showViewPatient(callid);

  });

  $(".close").on("click",function(){
        $('#showViewPatient').modal('hide');
  });

});

function getRenderData(id, agentid){
  $(".cusSpinner").show();
  //$("#pop_agent_id").val(agentid);
  
  $.ajax({
                url: "getpatient_data.php",
                type: "POST",
                data: {data:id},
                error: function() {
                    //console.log("ajax error occured");
                     $(".cusSpinner").hide();
                },
                success: function(response,status,xhr) {
                  
                  var json = $.parseJSON(response);
                  console.log(json);
                  $('#approveMerchant').modal('show');

                  if (typeof json.callid != 'undefined'){
                    $("#callid").val(json.callid);
					//$("#pop_agent_id").val(agentid);
					
                  }
				  
                  if (typeof json.patient != 'undefined'){
                    $("#patient").val(json.patient);
                  }
                  if (typeof json.phone != 'undefined'){
                    $("#alternatenumber").val(json.phone);
					$(".pop_phone").val(json.phone);
                  }
                  if (typeof json.age != 'undefined'){
                    $("#years").val(json.age);
                  }
                  if (typeof json.address != 'undefined'){
                    $("#landremarks").val(json.address);
                  }

                  $(".LMP").removeAttr('style');
                  $("#datepicker").val('');
                  if (typeof json.LMP != 'undefined'){
                    let tempValue= json.LMP;
                    //console.log('check>>>>>>>',tempValue, tempValue.length);                     
                    if(tempValue.trim().length == 0){
                      //debugger;
					    $(".show_hide").hide();
                      $(".LMP").css("display", "none");                      
                      $(".datepickerView").css("display", "block");
                    }else if(tempValue.trim().length >= 0){
                      //console.log(tempValue.trim().length);
                      $(".datepickerView").css("display", "none");
                      //$(".datepickerView").removeAttr("style");
                      $("#LMP").prop("display", true);
                      $("#LMP").val(json.LMP);
					  //$(".show_hide").show();
                    }
                    
              
                  }
                
                }
            });
}
function showViewPatient(id){
  //console.log('showViewPatient',id)
  $(".cusSpinner").show();
  $.ajax({
                url: "getpatient_data.php",
                type: "POST",
                data: {data:id},
                error: function() {
                    //console.log("ajax error occured");
                     $(".cusSpinner").hide();
                },
                success: function(response,status,xhr) {
                  
                  var json = $.parseJSON(response);
                  //console.log(json);
                  $('#showViewPatient').modal('show');
                  if (typeof json.hospital != 'undefined'){
                    $("#viewhospital").val(json.hospital);
                  }
                  if (typeof json.patient != 'undefined'){
                    //console.log('patient',json.patient);
                    $("#viewpatient").val(json.patient);
                  }
                  if (typeof json.age != 'undefined'){
                    //console.log(json.age);
                    $("#viewage").val(json.age);
                  }  
                  if (typeof json.address != 'undefined'){
                    //console.log(json.address);
                    $("#viewaddress").val(json.address);
                  }  
                  if (typeof json.phone != 'undefined'){
                    //console.log(json.phone);
                    $("#viewphone").val(json.phone);
                  }  
                  if (typeof json.diagnosis != 'undefined'){
                    //console.log(json.diagnosis);
                    $("#viewdiagnosis").val(json.diagnosis);
                  }
                  if (typeof json.LMP != 'undefined'){
                    //console.log(json.LMP);
                    $("#viewLMP").val(json.LMP);
                  }         
                  if (typeof json.weeks != 'undefined'){
                    //console.log(json.weeks);
                    $("#viewweeks").val(json.weeks);
                  }    
                  if (typeof json.EDD != 'undefined'){
                    //console.log(json.EDD);
                    $("#viewEDD").val(json.EDD);
                  }
                  if (typeof json.riskfactor != 'undefined'){
                   // console.log(json.riskfactor);
                    $("#viewriskfactor").val(json.riskfactor);
                  }
                  if (typeof json.first_visit != 'undefined'){
                    //console.log(json.first_visit);
                    $("#viewfirst_visit").val(json.first_visit);
                  }
                  if (typeof json.second_visit != 'undefined'){
                    //console.log(json.second_visit);
                    $("#viewsecond_visit").val(json.second_visit);
                  }
                  if (typeof json.third_visit != 'undefined'){
                    //console.log(json.third_visit);
                    $("#viewthird_visit").val(json.third_visit);
                  }
                  if (typeof json.fourth_visit != 'undefined'){
                    //console.log(json.fourth_visit);
                    $("#viewfourth_visit").val(json.fourth_visit);
                  }
                  if (typeof json.fifth_visit != 'undefined'){
                   // console.log(json.fifth_visit);
                    $("#viewfifth_visit").val(json.fifth_visit);
                  }
                  if (typeof json.sixth_visit != 'undefined'){
                   // console.log(json.sixth_visit);
                    $("#viewsixth_visit").val(json.sixth_visit);
                  }
                  if (typeof json.seventh_visit != 'undefined'){
                    //console.log(json.seventh_visit);
                    $("#viewseventh_visit").val(json.seventh_visit);
                  }
                  if (typeof json.additional_visit != 'undefined'){
                    //console.log(json.additional_visit);
                    $("#viewadditional_visit").val(json.additional_visit);
                  }
                  if (typeof json.typeof_delivery != 'undefined'){
                    //console.log(json.typeof_delivery);
                    $("#viewtypeof_delivery").val(json.typeof_delivery);
                  }
                  if (typeof json.complications != 'undefined'){
                    //console.log(json.complications);
                    $("#viewcomplications").val(json.complications);
                  }
                  if (typeof json.outcomeof_pregnancy != 'undefined'){
                    //console.log(json.outcomeof_pregnancy);
                    $("#viewoutcomeof_pregnancy").val(json.outcomeof_pregnancy);
                  }
                  if (typeof json.statusof_newborn != 'undefined'){
                    //console.log(json.statusof_newborn);
                    $("#viewstatusof_newborn").val(json.statusof_newborn);
                  }
                  
                  
              }
            });
}

function gettrimesterData(data){
console.log('gettrimesterData',data);
if( data == 'Delivered'){
	$(".delivered_hide").css('display', 'none');
}else{
	$(".delivered_hide").css('display', 'block');
}

//debugger;
$.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'trimister_id='+data,
                success:function(html){
                 //console.log('backed',html);

                 $('.trim1').html(html);
                }
            }); 

}
</script>






</body>
</html>