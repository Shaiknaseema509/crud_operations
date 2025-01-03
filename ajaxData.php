<?php 
// Include the database config file 
// error_reporting(0);
// mysqli=mysqli_connect("172.16.2.43", "emri", "emri", "ecd");
		

// if(mysqli === false){
// 	die("ERROR: Could not connect. ". mysqli_connect_error());
// }

date_default_timezone_set('Asia/Calcutta'); 

error_reporting(0);
include_once("includes/config.php");  
		
$current_time= date('Y-m-d H:i:s');
$dbString = "[RESPONSE] ".print_r($_POST,1);
logs($dbString,"chkbx");
 
if(!empty($_POST["trimister_id"])){ 
    // Fetch state data based on the specific trimister
	if($_POST["trimister_id"] == 'T1')
		{
		#echo $query = "SELECT `trimister1_id`,`trimister_1` FROM `m_trimister1` WHERE `trimister_id`=".$_POST["trimister_id"]."  AND `is_active` = 1"; 
		
		$query = "SELECT `trimister1_id`,`trimister_1` FROM `m_trimister1`  WHERE `is_active` = 1";
		//echo $query;
		$result = mysqli_query($mysqli,$query);
		 logs($query,"chkbx");
       
		 if($result->num_rows > 0){ 
			echo'<div class="row trimister-header"><div class="calldetailsheader" ><h6>TIMISTER WISE GUIDELINES - TRIMISTER 1</h6></div></div>';
        while($row = mysqli_fetch_array($result))
		
		{               
			echo ' 
			<ul style="margin-bottom: 0;">
			<li class="list-group-item">
			<input class="form-check-input" type="checkbox" name="trimslist1[]" value="'.$row['trimister_1'].'"> 
			<label class="form-check-label" for="Checkbox" >'.$row['trimister_1'].'</label>
			</li></ul>';
        } 
    }else{ 
		//echo $query;
        echo '<option value="">Trimister Data not available</option>'; 
    } 
	}else if($_POST["trimister_id"] == 'T2'){
		$query = "SELECT `trimister2_id`,`trimister_2` FROM `m_trimister2`  WHERE `is_active` = 1";
		$result = mysqli_query($mysqli,$query);
		 if($result->num_rows > 0){ 
			echo'<div class="row trimister-header"><div class="calldetailsheader" ><h6>TIMISTER WISE GUIDELINES - TRIMISTER 2</h6></div></div>';
        while($row = mysqli_fetch_array($result)){  
           echo '	<ul style="margin-bottom: 0;">
		   <li class="list-group-item">
		   <input class="form-check-input" type="checkbox" name="trimslist2[]" value="'.$row['trimister_2'].'"> 
		   <label class="form-check-label" for="Checkbox" >'.$row['trimister_2'].'</label>
		   </li></ul>';
        } 
		}else{ 
			echo '<option value="">Trimister Data not available</option>'; 
		} 
	}else if($_POST["trimister_id"] == 'T3')
	{
		$query = "SELECT `trimister3_id`,`trimister_3` FROM `m_trimister3`  WHERE `is_active` = 1";
		$result = mysqli_query($mysqli,$query);
		 if($result->num_rows > 0){ 
			echo'<div class="row trimister-header"><div class="calldetailsheader" ><h6>TIMISTER WISE GUIDELINES - TRIMISTER 3</h6></div></div>';
         while($row = mysqli_fetch_array($result)){ 
             echo '	<ul style="margin-bottom: 0;">
			 <li class="list-group-item">
			 <input class="form-check-input" type="checkbox" name="trimslist3[]" value="'.$row['trimister_3'].'"> 
			 <label class="form-check-label" for="Checkbox" >'.$row['trimister_3'].'</label>
			 </li></ul>';
			} 
		}else{ 
        echo '<option value="">Trimister Data not available</option>'; 
		} 
	}    
	
	 
   
} 


function logs($dbString,$script_name)
{
 //$script_name = "terminate.php";
 $log_path ="log/".date("Y-m")."/".date("Y-m-d")."/";
 #system("mkdir($log_path,0777,TRUE)");
 mkdir($log_path,0777,TRUE);
 $log_file = $log_path.$script_name."_".date("Y-m-d").".log";
 if(file_exists($log_file))
   {
     $LOGFILE_HANDLE = fopen($log_file,"a");
   }
 else
  {
     $LOGFILE_HANDLE = fopen($log_file,"w");
  }

 chmod($log_file,0755);
 $log_date = date("Y-m-d H:i:s");
 fwrite($LOGFILE_HANDLE,"$log_date : $dbString\n\n");
 fclose($LOGFILE_HANDLE);
 $dbString="";
 $script_name="";
}
?>