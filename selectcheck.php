<html>
<link rel="stylesheet"  type="text/css" href="stylesheet/style.css">
</html>
 
<?php

include_once("includes/config.php"); 

?> 

<div class="popuptitle" style="  text-align: left; background-color: #e01860; color: white; padding: 11px 20px; border-top-left-radius: 5px;border-top-right-radius: 5px;">
    <div class="col-12 ">
      LMS DETAILS cbggf
    </div>
    </div>  
    <div class="container text-center">  
         <div class="row odd-row">
            <div class="col-5"> Name</div>
            <div class="col-7"> <?=$_POST["name"];?> </div>
            </div> 
				<div class="row even-row">
				 <div class="col-5 ">Email</div>
				 <div class="col-7"><?=$_POST["email"];?></div>
				 </div>
					 <div class="row odd-row">
					   <div class="col-5"> Phone</div>
					    <div class="col-7"><?=$_POST["phone"];?></div>
					 </div>
						 <div class="row even-row">
						    <div class="col-5"> Status</div>
						    <div class="col-7"> <?=$_POST["status"];?></div>
						 </div>
             
    </div>

	  
	  
	  
	  
 
		