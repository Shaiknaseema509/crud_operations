<?php   error_reporting(0);
include("includes/config.php");?>

<div class="datagrid">
<table class="table table-striped table-hover">
  	
    <thead>
      <tr class="table-active">
        <th>SNo</th>
        <th>Call ID</th>
        <th>Call Time</th>
        <th>Agent Id</th>
        <th>Phone Number</th>
		<th>Caller Name</th>
		<!--<th>No.of Weeks </th>-->
		<!--<th>Trimister</th>-->
		<th>Suggested Advice</th>
		<th>NextVisitDate</th>
		<th></th>	
			
        </tr>
		</thead>
		
		<tbody>
		<?php   
		$sql = "CALL getcallerhistory('".$_POST['alternatenumber']."')";
		$row=$mysqli->query($sql);
		 $i = 0;
		
		 if($row->num_rows>0){
			
		while($result = $row->fetch_assoc()){$i++; ?>
		
		 <tr>

		<td><?php echo $i; ?></td>
		<td><?php echo $result["incident_id"];?></td>
		<td><?php echo $result["timeofcall"];?></td>
		<td><?php echo $result["agent_id"];?></td>
		<td><?php echo $result["alternatenumber"];?></td>
		<td><?php echo $result["callername"];?></td>
        <td><?php echo $result["riskfactor"];?></td>
		<td><?php echo $result["callbacktime"];?></td>

		
		 </tr>
		
		<?php }}
		
		else
		{
			echo "<tr><td colspan='5' align='center' style='color:red;font-weight: bold;'>Records not found.</td></tr>";
		}
		
		
		
		?>
		
		</tbody>
		
  </table>
  

  </div>

</form>
 