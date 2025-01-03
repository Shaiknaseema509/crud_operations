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
      <div class="headertext"> <!--2nd sub div-->
        LEAD MANAGEMENT SYSTEM  (LMS)
       </div>
   </div>
   
<!--admin login-->

   <div class="maindiv">
    <div class="welcome" >  
      ADMIN <span>LOGIN</span>
     </div>
<!--admin welcome div-->

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
    <img src="img/EMRI GREEN HEALTH SERVICES logo.jpg" width="16px" alt="upload" style="margin-bottom: 4px;"> UPLOAD EXCEL SHEET <span>HERE</span>
  </label>
  <input id="file-upload" type="file" name="excel"/>
  <input type="submit" name="submit">
  </form>
</div>
<div class="view-row">
    <a href="ecd_view.php">view the file</a>
</div>
</div>
</div>
</div>


<?php
if(isset($_FILES['excel']['name'])){
	$con=mysqli_connect("172.16.2.43","emri","emri","ecd");
	include "xlsx.php";
	if($con){
		$excel=SimpleXLSX::parse($_FILES['excel']['tmp_name']);
		echo "<pre>";	
        for ($sheet=0; $sheet < sizeof($excel->sheetNames()) ; $sheet++) { 
        $rowcol=$excel->dimension($sheet);
        $i=0;
        if($rowcol[0]!=1 &&$rowcol[1]!=1){
		foreach ($excel->rows($sheet) as $key => $row) {
			$q="";
            $lastCellIndex = count($row) - 1; // Find the index of the last cell in the row
			foreach ($row as $key => $cell) {
				if($i==0){
					$q.=$cell. " varchar(500),";
				}else{
					$q.="'".$cell. "'";
				}
				
				// Check if it's the last cell, to avoid the trailing comma
                            if ($key != $lastCellIndex) {
                                $q .= ",";
                            }
			}
	
			$query="INSERT INTO excel_import (`name`,`email`,`phone`,`status`)
      values (" . rtrim($q, ',') . ");";

			echo $query;
			if(mysqli_query($con,$query))
			{
				echo "file uploaded successfully..!";
			}
			//echo "<br>";
			$i++;
		}
	}
		}
	}
}




?> 

</div>
</div>

</body>
</html>