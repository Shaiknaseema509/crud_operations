<?php

//require_once("connect.php"); 
date_default_timezone_set('Asia/Calcutta'); 

//error_reporting(0);
include_once("includes/config.php");  

$current_time= date('Y-m-d H:i:s');
$dbString = "[RESPONSE] ".print_r($_POST,1);
logs($dbString,"test");
//echo "dfstfgtreterw";
if((isset($_POST['callid'])) && ($_POST['source'] == 'intialsubmit'))
{

    $callid=$_POST['callid'];
	//logs($callid,"test");
    $timeofcall=$_POST['timeofcall'];
    echo $timeofcall;
	//logs($timeofcall,"test");
    $agentid=$_POST['agentid'];
	//logs($agentid);
    $callername =$_POST['callername'];
    //$convoxID =$_POST['convoxID'];
    $alternatenumber=$_POST['alternatenumber'];
    $agentid=$_POST['$agent_id'];	
    $tehsil_name =$_POST['tehsil_name'];
    $district_name =$_POST['district_name'];
    $gender_name =$_POST['gender_name'];
    $years =$_POST['years'];
    //$months =$_POST['months'];
    $cityvillage =$_POST['cityvillage'];
    $landremarks=$_POST['landremarks'];
    $no_ofweeks=$_POST['no_ofweeks'];
    $visitinghospital_name =$_POST['visitinghospital_name'];
    $trimister=$_POST['trimister'];
    $suggestedhospital_name=$_POST['suggestedhospital_name'];
    $risktype_name=$_POST['risktype_name'];
    $subrisktype=$_POST['subrisktype'];
    $riskremarks=$_POST['riskremarks'];
    $trimister_1=$_POST['trimister_1'];
    $trimister_3=$_POST['trimister_3'];
    $trimister_2=$_POST['trimister_2'];
    // if(isset($_POST['trimslist1'])){
    // $trimslist1=$_POST['trimslist1'];
    //  $chkstr1=implode(",", $trimslist1);
    // }
    // elseif(isset($_POST['trimslist2'])){
    // $trimslist2=$_POST['trimslist2'];
    // $chkstr2=implode(",", $trimslist2);
    // }
    // elseif(isset($_POST['trimslist3'])){
    // $trimslist3=$_POST['trimslist3'];
    // $chkstr3=implode(",", $trimslist3);
    // }

    /*if($trimister == 1)
    {
        $trimval1 = $trimslist1;
    }else if($trimister == 2)
    {
        $trimval2 = $trimslist2;
    }else ($trimister == 3)
    {
        $trimval3 = $trimslist3;
    }*/


    $nutrition=$_POST['nutrition'];
    $riskfactor=$_POST['riskfactor'];
$append_cond=null;
    if($trimister == 1){
        $append_cond = 'DATE_ADD(NOW(),INTERVAL 30 DAY)';
    }else if($trimister == 2){
        $append_cond = 'DATE_ADD(NOW(),INTERVAL 30 DAY)';
    }else{
        $append_cond = 'DATE_ADD(NOW(),INTERVAL 7 DAY)';
    }
    
    echo $append_cond;


    $mysqli->query("CALL inscallinfo($callid, CONCAT(CURRENT_DATE,' ',CURRENT_TIME), ' $agentid',
    '$alternatenumber',CONCAT(CURRENT_DATE,' ',CURRENT_TIME), '123')");
 	#$dbstring ="CALL inscallinfo($callid, CONCAT(CURRENT_DATE,' ',CURRENT_TIME), '$agentid','$alternatenumber',CONCAT(CURRENT_DATE,' ',CURRENT_TIME), '".$_POST['convoxid']."')";
	$dbstring ="CALL inscallinfo($callid, CONCAT(CURRENT_DATE,' ',CURRENT_TIME), '$agentid',
	'$alternatenumber',CONCAT(CURRENT_DATE,' ',CURRENT_TIME), '123')";

	$str_arr = array('source' => "intialsubmit",'data' => $dbstring,'current_time'=>"$current_time");

	$dbString = "[RESPONSE] ".print_r($str_arr,1);
	$script_name = "popupup.php";
	logs($dbString,$script_name);
	logs($_POST['convoxid'],$script_name);


	//$str_arr = array('source' => "intialsubmit",'data' => $dbstring,'current_time'=>"$current_time");

	//$dbString = "[RESPONSE] ".print_r($str_arr,1);
	
	//logs($dbString,$script_name);
    // $mysqli1= "INSERT INTO ecdtable (callid,timeofcall,agentid,callername,alternatenumber,tehsil_name,district_name,gender_name,years,cityvillage,
    // landremarks,no_ofweeks,visitinghospital_name,trimister,suggestedhospital_name,risktype_name,subrisktype,riskremarks,
	// trimister_1,trimister_2,trimister_3,nutrition,riskfactor,callbacktime) 
    // VALUES ($callid,'$timeofcall','$agentid','$callername','$alternatenumber','$tehsil_name','$district_name','$gender_name','$years','$cityvillage'
    // ,'$landremarks','$no_ofweeks','$visitinghospital_name','$trimister','$suggestedhospital_name','$risktype_name','$subrisktype',
    // '$riskremarks','$trimister_1','$trimister_2','$trimister_3','$nutrition','$riskfactor', $append_cond)";
//exit();
$sp_inser_query= "CALL ecd_data ('$callid','$timeofcall','$agentid','$callername','$alternatenumber','$tehsil_name','$district_name','$gender_name','$years','$cityvillage','$landremarks','$no_ofweeks','$visitinghospital_name','$trimister','$suggestedhospital_name','$risktype_name','$subrisktype','$riskremarks','$trimister_1','$trimister_2','$trimister_3','$nutrition','$riskfactor',$append_cond)";


#echo "CALL ecd_data ('$callid','$timeofcall','$agentid','$callername','$alternatenumber','$tehsil_name','$district_name','$gender_name','$years','$cityvillage','$landremarks','$no_ofweeks','$visitinghospital_name','$trimister','$suggestedhospital_name','$risktype_name','$subrisktype','$riskremarks','$trimister_1','$trimister_2','$trimister_3','$nutrition','$riskfactor','$append_cond')";

echo $sp_inser_query;
logs($sp_inser_query,$script_name);

$mysqli5 ="update ecdtable set call_endtime= NOW() where callid ='".$callid."'";
logs($mysqli5,$script_name);

$mysqli2= "UPDATE patient SET status=3,isactive =0 WHERE callid='".$callid."'";
logs($mysqli2,$script_name);

    if(mysqli_query($mysqli,$sp_inser_query))
    {
		
        echo "data stored in a database successfully.";        
               } 
               else
               {
        echo  mysqli_error($mysqli);
    }

    if(mysqli_query($mysqli,$mysqli2))
    {
        echo "Status Changed successfully.";        
       } 
         else
       {
        echo  mysqli_error($mysqli);
		}
}


if((isset($_POST['callid'])) && ($_POST['source'] == 'closesubmit'))
{
    $callid=$_POST['callid'];
	$notresponseremarks=$_POST['notresponseremarks'];
	$agentid=$_POST['agentid'];	
	
    $mysqli3= "UPDATE patient SET call_time=NOW(),status=2,callback=2,isactive =0,notresponseremarks='".$notresponseremarks."',agentid='".$agentid."',callback_time=DATE_ADD(NOW(),INTERVAL 30 MINUTE) WHERE callid='".$callid."'";
    
    if(mysqli_query($mysqli,$mysqli3)){
        //logs($mysqli3);
        $get_query = "select callid from patient where callid='".$callid."'";
        #echo $get_query;
        if(mysqli_query($mysqli,$get_query)){
            $select_sp="CALL callback_data($callid)";
           if(mysqli_query($mysqli,$select_sp))
            {
                logs($select_sp);	
            }
            #$mysqli4="INSERT INTO callback (`callid`,`callback_time`)VALUES($callid,DATE_ADD(NOW(),INTERVAL 30 MINUTE))";
        }
    }
}
if((isset($_POST['callid'])) && ($_POST['source'] == 'caseclosesubmit'))
{

    #echo $_POST['callid'];exit();
    $callid=$_POST['callid'];
	$caseclose_name=$_POST['caseclose_name'];
	$agentid=$_POST['agentid'];
	
	$temp_query ="select callid from patient where callid='".$callid."'";
	$qu = mysqli_query($mysqli,$temp_query);
    $norows = mysqli_num_rows($qu);
	
	if($norows >=0)
	{
				
		echo $mysqli6_update= "UPDATE patient SET call_time=NOW(), status=4, isactive =0, caseclose_name='".$caseclose_name."',agentid='".$agentid."' WHERE callid='".$callid."'";
		$update = mysqli_query($mysqli,$mysqli6_update);
		
		echo $mysqli7="INSERT INTO caseclose (`callid`,`caseclose_name`,`caseclose_time`)VALUES($callid,'$caseclose_name',now())";
        if(mysqli_query($mysqli,$mysqli7))
		{			
			 echo "Case closed successfully.";		   
		}
		
        #$mysqli7="CALL caseclose_data($callid);";
		//$mysqli7="INSERT INTO caseclose (`callid`,`caseclose_name`,`caseclose_time`)VALUES($callid,'$caseclose_name',now())";
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






// function logs($dbString,$script_name)
// {
//  //$script_name = "terminate.php";
//  $log_path ="log/".date("Y-m")."/".date("Y-m-d")."/";
//  #system("mkdir($log_path,0777,TRUE)");

//  if(isset($log_pat)){
//     mkdir($log_path,0777,TRUE);
//  $log_file = $log_path.$script_name."_".date("Y-m-d").".log";
//  if(file_exists($log_file))
//    {
//      $LOGFILE_HANDLE = fopen($log_file,"a");
//    }
//  else
//   {
//      $LOGFILE_HANDLE = fopen($log_file,"w");
//   }

//  chmod($log_file,0755);
//  $log_date = date("Y-m-d H:i:s");
//  fwrite($LOGFILE_HANDLE,"$log_date : $dbString\n\n");
//  fclose($LOGFILE_HANDLE);
//  $dbString="";
//  $script_name="";
//  }
 
// }




?>