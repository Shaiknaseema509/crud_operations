<!DOCTYPE html>
<html lang="en">
<head>
   <!--required metatags-->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>104 Admin</title>
 <!--bootstrap 5 css-->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
 <!--external css-->
 <link href="css/style.css" rel="stylesheet"  type="text/css">
</head>

<body>
   <div class="header">  <!--header div-->
      <div class="d-flex">     <!--1st div-->
        <div class="104logo">    <!--1st sub div-->
          <img src="img/104-logo.png" alt="104logo">
        </div>
       <div class="goalogo">
        <img src="img/goa-gov-icon.png" alt="goalogo">
       </div>
      </div>
     
       <div class="headertext"> <!--2nd sub div-->
        EARLY CHILDHOOD DEVELOPMENT  (ECD)
       </div>
      
       <div class="emrilogo">   <!--3rd sub div-->
        <img src="img/emri-logo.png" alt="emrilogo">
       </div>
     </div>
<!--admin login-->

   <div class="maindiv">
    <div class="welcome" >  <!--admin welcome div-->
      ADMIN <span>LOGIN</span>
     </div>


 <!--exel whole box-->

 <div class="excelitems">
  <div class="adminicon">  
      <img src="img/admin.png" alt="admin">
  </div>
<div calss="container square-box">
 <div class="excel-box">  
<div class="excelicon"> 
<img src="img/excel.png" alt="excel">
 </div>   

<div class="excelbutton">
  <form action="" method="POST" enctype="multipart/form-data">
  <label for="file-upload" class="custom-file-upload">
    <img src="img/upload.png" width="16px" alt="upload" style="margin-bottom: 4px;"> UPLOAD EXCEL SHEET <span>HERE</span>
  </label>
  <input id="file-upload" type="file" name="excel"/>
  <input type="submit" name="submit">
  </form>
</div>
<div class="view-row">
    <a href="copyadmin.php">view the file</a>
</div>
</div>
</div>
</div>

 <!--exel whole box-->
 <!-- <div class="excelitems">
  <div class="adminicon">  
      <img src="img/admin.png" alt="admin">
  </div>

  <div calss="container square-box">
  <div class="excel-box">  
 <div class="excelicon"> 
    <img src="img/excel.png" alt="excel">
 </div>   

 <div class="excelbutton">  
  <form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="excel">
	<input type="submit" name="submit">
  <a href="copyadmin.php">View the file</a>
</form> 




</div>
</div>
</div>
</div> -->
<?php
if(isset($_FILES['excel']['name'])){
	$con=mysqli_connect("172.16.2.43","emri","emri","ecd");
	include "xlsx.php";
	if($con){
		$excel=SimpleXLSX::parse($_FILES['excel']['tmp_name']);
		echo "<pre>";	
    //print_r( $excel->rowsEx() );
    //$sheetData = $excel->getActiveSheet()->toArray(null,true,true,true);
   //echo count($sheetData);
	//	print_r($excel->dimension(2));
	//	print_r($excel->sheetNames());
        for ($sheet=0; $sheet < sizeof($excel->sheetNames()) ; $sheet++) { 
        $rowcol=$excel->dimension($sheet);
      //  echo "rows ".$sheet->getHighestDataRow();
        $i=0;
        if($rowcol[0]!=1 &&$rowcol[1]!=1){
		foreach ($excel->rows($sheet) as $key => $row) {
			//print_r($row);
			$q="";
			foreach ($row as $key => $cell) {
				//print_r($cell);echo "<br>";
				if($i==0){
					$q.=$cell. " varchar(50),";
				}else{
					$q.="'".$cell. "',";
				}
			}
			// if($i==0){
			// 	$query="CREATE table ".$excel->sheetName($sheet)." (".rtrim($q,",").");";
			// }else{
			// 	$query="INSERT INTO ".$excel->sheetName($sheet)." values (".rtrim($q,",").");";
			// }

      //$status = 1 

      $query="INSERT INTO patient (`hospital`, `patient`,`age`,`address`,`phone`,`diagnosis`,`LMP`,`weeks`,`pstatus`,`callback`) 
      values (".rtrim($q,",").",'1','2');";
			//echo $query;
      logs($dbString,$query);
		//	echo $query;
			if(mysqli_query($con,$query))
			{
		//		echo "true";
			}
			echo "<br>";
			$i++;
		}
	}
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

</div>
</div>

</body>
</html>