<?php

//require_once("connect.php"); 
date_default_timezone_set('Asia/Calcutta'); 

error_reporting(0);
include_once("includes/config.php");  


?>
<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
   <link rel="stylesheet"  type="text/css" href="stylesheet/style.css">
   
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 
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
<form action="insert.php" method="post">


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
    <label for="inputtrimister" class="col-sm-5 col-form-label">Trimister</label>
       <div class="col-sm-7">
         <select   id="trimister">
            <option value="" id="trimister_id" selected>SELECT</option>
              <?php
                $records = mysqli_query($conn, "SELECT `trimister_id`,`trimister` FROM `m_trimister`"); 
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
      <label for="inputsubrisktype" class="col-sm-5 col-form-label">Sub-Risk Type</label>
      <div class="col-sm-7">
        <input type="text" name="subrisktype" id="subrisktype" class="form-control" id="inputsubrisktype" required>
      </div>
    </div>
   </div> 

   <div class="col-sm-12">
        <div class="riskfactorremarks d-flex">
          <label for="comment" class="col-form-label">Risk Factor Remarks</label>
    <div class="textarea">
    <textarea class="form-control"  id="riskremarks" name="riskremarks" rows="2" required></textarea>
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
       //$conn = mysqli_connect("172.16.2.43","emri","emri","ecd");
        $query = "SELECT * FROM m_trimister1 ";
        $query_run=mysqli_query($conn,$query);
        if(mysqli_num_rows($query_run) > 0)
        foreach($query_run as $trims)
        {
        ?>
        <li class="list-group-item">
      <input class="form-check-input" type="checkbox" name="trimslist[]" value="<?= $trims['trimister_1']; ?>" required/> 
      <label class="form-check-label" for="Checkbox" ><?= $trims['trimister_1']?></label>
        </li>
       <?php
    }
?>
        
  </ul>
                </div>
<div class="trim2">
  
</div>
<div class="trim3"></div>

         
              </div>
<div class="comment-box">
 <div class="row">
   <div class="col-md-6">
       <label for="comment">NUTRITION COUNSELLING</label>
    <textarea class="form-control" id="remarks" name="nutrition" rows="6"required ></textarea>
  </div>
  <div class="col-md-6">
       <label for="comment">RISK FACTOR CONSELLING</label>
    <textarea class="form-control"  id="remarks" name="riskfactor" rows="6" required></textarea>
  </div>
  </div>

  <div class="row">
  <div class="col-md-6">
  <div class="row pt-3">
  <div class="col-4 pt-2">
       <label for="comment">No Response Remarks</label>
  </div>
  <div class="col-8">
    <textarea class="form-control"  id="noresponse_remarks" name="noresponse_remarks" rows="2"required></textarea>
  </div>
  </div>
  </div>
  </div>
  <div class="btns">
     
      <!-- <button type="submit"  name="submit" class="btn-2" onclick='return submits();' >SAVE</button>
        <button class="btn-1" type="button" style="margin-top:10px">BACK</button>  -->
  

       <button type="submit" name="submit"class="btn btn-success"  onclick='return submits();'>Submit </button>
        <button type="button" class="btn btn-danger" onclick='return close();'>Terminate</button> 
  </div>
   </div>
  </div>
 </div>
</div>
</form>
</div>   

</body>
</html>
