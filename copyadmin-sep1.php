<?php
date_default_timezone_set('Asia/Calcutta'); 
error_reporting(0);
include_once("includes/config.php");  

if(isset($_GET['page']))
{
  $page = $_GET['page'];
}else{
  $page = 1;
}

$num_per_page = 05;
$start_from = ($page-1)*05;

//echo $start_from;
//exit();

$query = "SELECT * FROM patient WHERE STATUS = 1 AND callback = 2 LIMIT $start_from, $num_per_page";
$rows = mysqli_query($mysqli,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>104 Admin</title>

<link rel="stylesheet"  type="text/css" href="css/style.css">
<link rel="stylesheet"  type="text/css" href="css/modal.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

</head>
<body>
<?php include("includes/header.php");?>
   <div class="container">
    <div class="box">
     
        <div class="ecdheader">
           <h6>ECD PATIENT LIST</h6>
          </div>        
          <div class="patientdata" style="height:370px">
       <table class="table table-striped table-hover">
        <thead>
        <tr>
          <!-- <th>S.No</th> -->
              <th>Incident Id</th>
              <th>Call Time</th>
              <th>Call Back Time</th>
             <th>Name of the Hospital</th>
             <th>Name of the Patient</th>
             <th>Age</th>
             <th>Address</th>
             <th>Phone No</th>
             <th>Diagnosis with Gravida/para status</th>
             <th>LMP</th>
             <th>Pregnancy weeks</th>
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
    <!-- <td><?=$i;?></td> -->
    <td><?php echo $result["callid"];?></td>
      <td ><?php echo $result["timeofcall"] ?></td>
      <td ><?php echo $result["callback_time"] ?></td>
    <td><?php echo $result["hospital"] ?></td>
    <td><?php echo $result["patient"] ?></td>
    <td><?php echo $result["age"] ?></td>
    <td><?php echo $result["address"] ?></td>
    <td><?php echo $result["phone"] ?></td>
    <td><?php echo $result["diagnosis"] ?></td>
    <td><?php echo $result["LMP"] ?></td>
    <td><?php echo $result["weeks"] ?></td>

    <input type='hidden' id="callid_<?=$result['callid'];?>" value="<?=$result['callid'];?>" />
    <input type='hidden' id="timeofcall_<?=$result['callid'];?>" value="<?=$result['timeofcall'];?>" />
    <input type='hidden' id="hospital_<?=$result['callid'];?>" value="<?=$result['hospital'];?>" />
    <input type='hidden' id="patient_<?=$result['callid'];?>" value="<?=$result['patient'];?>" />
    <input type='hidden' id="age_<?=$result['callid'];?>" value="<?=$result['age'];?>" />
    <input type='hidden' id="address_<?=$result['callid'];?>" value="<?=$result['address'];?>" />
    <input type='hidden' id="phone_<?=$result['callid'];?>" value="<?=$result['phone'];?>" />
    <input type='hidden' id="diagnosis_<?=$result['callid'];?>" value="<?=$result['diagnosis'];?>" />
    <input type='hidden' id="LMP_<?=$result['callid'];?>" value="<?=$result['LMP'];?>" />
    <input type='hidden' id="weeks_<?=$result['callid'];?>" value="<?=$result['weeks'];?>" />

    <td><span><img src='img/view-icon.png'></span>
    <a type='button' data-callid="<?=$result['callid'];?>"  class='custmmyBtn' id="custmmyBtn">VIEW</a></td>
	
    <td class=""><span><img src="img/call-iocn.png"></span>
     <a type="button" class="btn-call" data-callid="<?=$result['callid'];?>" data-bs-toggle="modal" data-bs-target="#myModal">ACTION</a></td>
</tr>
    </tbody>
<?php
}
?>
       </table>
       </div>
       <div class="text-center">
       <?php
   
       $pr_query = "SELECT * FROM patient";
       $pr_result = mysqli_query($mysqli,$pr_query);
       $total_records = mysqli_num_rows($pr_result);
      // echo $total_records;

      //$total_page = $total_records/$num_per_page;
      $total_page = ceil($total_records/$num_per_page);
      //echo $total_page;
      

      if($page>1)
      {
        echo "<a href='copyadmin.php?page=".($page-1)."' class='btn btn-danger custm-btn'>Previous</a>";
      }

      for($i=1; $i<$total_page; $i++)
      {
        echo "<a href='copyadmin.php?page=".$i."' class='btn btn-primary custm-btn'>$i</a>";
      }

      if($i>$page)
      {
        echo "<a href='copyadmin.php?page=".($page+1)."' class='btn btn-danger custm-btn'>Next</a>";
      }

       ?>

      </div>
      </div>
</div>





<!-- The Modal for Action Button start -->

<!-- The Modal -->
<div id="custmmyModal" class="custm-modal">

  <!-- Modal content -->
  <div class="custm-modal-content">
    <div id="question_result"></div>
    <span class="custm-close btn btn-danger">Close</span>
  </div>
</div>
<!-- The Modal for Action Button start -->


<!-- The Modal for Action Button start -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div> -->

      <!-- Modal body -->
      <div class="modal-body">
       <div id="question_result"></div>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div> -->

    </div>
  </div>
</div>
<!-- The Modal for Action Button end -->



<script>

var modal = document.getElementById('custmmyModal');
var span = document.getElementsByClassName("custm-close")[0];

$('body').on('click','.custmmyBtn',function(){ 
    modal.style.display = "block";

	var cid =$(this).data('callid');
  
  var hospital = $('#hospital_'+cid).val();
  var patient = $('#patient_'+cid).val();
  var age = $('#age_'+cid).val();
  var address = $('#address_'+cid).val();
  var phone = $('#phone_'+cid).val();
  var diagnosis = $('#diagnosis_'+cid).val();
  var LMP = $('#LMP_'+cid).val();
  var weeks = $('#weeks_'+cid).val();
	
	$.post( "selectcheck.php", {que:1, cid:cid,hospital:hospital,patient:patient,age:age,address:address,phone:phone,diagnosis:diagnosis,LMP:LMP,weeks:weeks },function(return_data){ $("#question_result").html(return_data); });
});
span.onclick = function() {
    modal.style.display = "none";
}
$('body').on('click','.close',function(){modal.style.display = "none"; });
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}






$('.btn-call').on('click',function(){
  var cid =$(this).data('callid');
  var phone = $('#phone_'+cid).val();
  var timeofcall = $('#timeofcall_'+cid).val();
  //alert(cid)

  $('.modal-body').load('calltesting.php',{que:1, cid:cid,phone:phone,timeofcall:timeofcall},function(){
      $('#myModal').modal({show:true});
  });
});
   
</script>
</body>
</html>