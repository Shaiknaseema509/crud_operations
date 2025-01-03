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

$phone = $_POST["alternatenumber"];
$agent_id= $_REQUEST["agent_id"];
$convoxid = ""; 
$process = ""; 
$host_ip = "192.168.25.14";

if($phone == '') $phone='';



if (isset($_GET['page_no']) && $_GET['page_no']!="") {
  $page_no = $_GET['page_no'];
  } else {
      $page_no = 1;
      }

$total_records_per_page = 10;

$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$query ="SELECT `id`,`name`,`email`,`phone`,`status` FROM `excel_import`  LIMIT $offset, $total_records_per_page ";
$rows = mysqli_query($mysqli,$query);
$result_count = mysqli_query($mysqli,$rows);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_row_count'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;
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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script> <!-- Include xlsx -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
<style>
  .no-bg{
    background-color: initial !important;
    background: none;
  border: 0px;
}
.modal-body .form-group {
  margin-bottom: 15px; /* Space between each group */
}

.modal-body .modal-label {
  display: block; /* Ensure label is a block element */
  font-weight: bold;
  margin-bottom: 5px; /* Space between label and input field */
}

.modal-body input {
  width: 100%; /* Ensure inputs take the full width of the container */
}

  </style>
  <script>

function FilterkeyWord_all_table() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search_input_all");
  filter = input.value.toUpperCase();
  table = document.getElementById("order_data");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[4];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


$(document).ready(function() {
    $('#exportBtn').click(function() {
        // Hide the columns with the buttons (assuming buttons are in columns 5, 6, and 7)
        var table = $('#order_data');
        
        // Remove the buttons in the cells of the last 3 columns (Update, Change Status, Delete)
        table.find('tr').each(function() {
            // Remove buttons or any HTML element inside the cells of these columns
            $(this).find('td').eq(5).empty(); // Remove content in the "Update" column
            $(this).find('td').eq(6).empty(); // Remove content in the "Change Status" column
            $(this).find('td').eq(7).empty(); // Remove content in the "Delete" column
        });

        // Convert the table to a workbook (excluding the empty columns)
        var workbook = XLSX.utils.table_to_book(table[0], {sheet: "Sheet1"});

        // Export to Excel file
        XLSX.writeFile(workbook, 'LMS_data.xlsx');

        // (Optional) After exporting, you can restore the table if needed
        table.find('tr').each(function() {
            // Restore the original content in the columns, if needed
            $(this).find('td').eq(5).html('Update'); // Restore "Update" button content
            $(this).find('td').eq(6).html('Change Status'); // Restore "Change Status" button content
            $(this).find('td').eq(7).html('Delete'); // Restore "Delete" button content
        });
    });
});





  </script>
</head>
<body>
<?php include("includes/header.php");?>
<?php 
if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = 2;

// Get total records count
$query_count = "SELECT COUNT(*) AS total_row_count FROM `excel_import`";
$result_count = mysqli_query($mysqli, $query_count);
$total_records = mysqli_fetch_assoc($result_count)['total_row_count'];

$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; 

$query = "SELECT `id`, `name`, `email`, `phone`, `status` FROM `excel_import` LIMIT $offset, $total_records_per_page";
$rows = mysqli_query($mysqli, $query);
?>

<div class="container">
    <div class="box" style="padding: 8px;">
        <div class="ecdheader">
            <span>LMS List</span>
            <input type="text" id="search_input_all" style="width:30%; float: right;" onkeyup="FilterkeyWord_all_table()" placeholder="Search by status.." class="form-control">
            <!-- Add this button above your table -->
            <button id="exportBtn" class="btn btn-success" style="padding: 4px; float: right; margin-right: 11px;">Export to Excel</button>
        </div>      
          
        <div class="patientdata">
            <table class="table table-striped table-hover" id="order_data">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    while($result = mysqli_fetch_assoc($rows)) {
                    ?>
                        <tr>
                            <td><?php echo $result["id"];?></td>
                            <td><?php echo $result["name"];?></td>
                            <td><?php echo $result["email"];?></td>
                            <td><?php echo $result["phone"];?></td>
                            <td><?php echo $result["status"];?></td>
                            <td>
                                <span><img src='img/view-icon.png'></span>
                                <a type="button" class="btn-call viewPatients" data-callid="<?=$result['id'];?>" data-bs-toggle="modal" data-bs-target="#viewPatients">VIEW</a>
                            </td>
                            <td>
                                <span><img src='img/view-icon.png'></span>
                                <a type="button" class="btn-call viewPatient" data-callid="<?=$result['id'];?>" data-bs-toggle="modal" data-bs-target="#viewPatient">UPDATE</a>
                            </td>
                            <td class="">
                                <span><img src="img/call-iocn.png" style="width: 20px; height: 18px;"></span>
                                <a type="button" class="btn-call changeStatus" data-callid="<?=$result['id'];?>" data-bs-toggle="modal" data-bs-target="#changeStatusModal">Change Status</a>
                            </td>
                            <td class="">
                                <span><img src="img/delete.png" style="width: 20px; height: 18px;"></span>
                                <a type="button" class="btn-call deleteUser" data-callid="<?=$result['id'];?>" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">DELETE</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div style="padding: 10px 20px 0px; border-top: dotted 1px #CCC;" class="d-flex justify-content-between">
            <div>
                <strong class="p-3">Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
            </div>
            <ul class="pagination">
                <?php if ($page_no > 1) { ?>
                    <li><a class="btn btn-danger" href="?page_no=1">First</a></li>
                <?php } ?>

                <li <?php if ($page_no <= 1) { echo "class='disabled'"; } ?>>
                    <a class="btn btn-danger" <?php if ($page_no > 1) { echo "href='?page_no=$previous_page'"; } ?>>&lt; Previous</a>
                </li>

                <li <?php if ($page_no >= $total_no_of_pages) { echo "class='disabled'"; } ?>>
                    <a class="btn btn-success" <?php if ($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next &gt;</a>
                </li>

                <?php if ($page_no < $total_no_of_pages) { ?>
                    <li><a href="?page_no=<?php echo $total_no_of_pages; ?>" class="btn btn-danger">Last &rsaquo;&rsaquo;</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

         
 <!-- Modal -->
<div class="modal fade" id="viewPatient" tabindex="-1" aria-labelledby="viewPatientLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="viewhospital" class="modal-label">Name</label>
          <input type="text" name="hospital" class="form-control"  oninput="allowAlphabets(event)" id="viewhospital" required >
        </div>
        
        <div class="form-group">
          <label for="viewpatient" class="modal-label">Email (only @gmail.com):</label>
          <input type="text" name="viewpatient"  class="form-control" id="viewpatient" required>
        </div>
        
        <div class="form-group">
          <label for="viewphone" class="modal-label">Phone</label>
          <input type="text" name="phone" class="form-control" id="viewphone" maxlength=10 >
        </div>

        <div class="form-group">
          <label for="viewdiagnosis" class="modal-label">Status</label>
          <input type="text" name="status" class="form-control" id="viewdiagnosis">
        </div>
		<!--<div class="form-group">
          <label for="viewriskfactor" class="modal-label">Date</label>
          <input type="text" name="status" class="form-control" id="viewriskfactor">
        </div>-->
      </div>

      <div class="modal-footer">
        <button type="button" id="viewclose" class="btn btn-danger">Update Details</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form to show the user data and status dropdown -->
        <div class="form-group">
          <label for="changeName" class="modal-label">Name</label>
          <input type="text" name="changeName" class="form-control" id="changeName" disabled>
        </div>

        <div class="form-group">
          <label for="changeEmail" class="modal-label">Email</label>
          <input type="text" name="changeEmail" class="form-control" id="changeEmail" disabled>
        </div>

        <div class="form-group">
          <label for="changePhone" class="modal-label">Phone</label>
          <input type="text" name="changePhone" class="form-control" id="changePhone" disabled>
        </div>

        <div class="form-group">
          <label for="changeStatus" class="modal-label">Status</label>
          <select name="changeStatus" id="changeStatus" class="form-control">
            <option value="New">New</option>
            <option value="InProgress">In Progress</option>
            <option value="Resolved">Resolved</option>
          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="saveStatusBtn" class="btn btn-success">Save Status</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for viewing user details -->
<div class="modal fade" id="viewPatients" tabindex="-1" aria-labelledby="viewPatientLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewPatientLabel">View User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="viewUserForm">
          <div class="mb-3">
            <label for="viewName" class="form-label">Name</label>
            <input type="text" id="viewName" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label for="viewEmail" class="form-label">Email</label>
            <input type="email" id="viewEmail" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label for="viewPhone" class="form-label">Phone</label>
            <input type="text" id="viewPhone" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label for="viewStatus" class="form-label">Status</label>
            <input type="text" id="viewStatus" class="form-control" readonly>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

function allowAlphabets(event) {
    // Get the input field value
    let inputValue = event.target.value;
    
    // Replace anything that is not a letter (A-Z, a-z) or a space with an empty string
    let sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');

    // Set the sanitized value back to the input field
    event.target.value = sanitizedValue;
}


 
</script>

<!-- Script to handle modal opening and data population -->
<script>
$(document).ready(function () {
    // When the "UPDATE" button is clicked
    $('.viewPatient').click(function () {
        var id = $(this).data('callid');  // Get the user ID from the data attribute

        // AJAX request to fetch user data
        $.ajax({
            url: 'get_user_data.php',  // Fetch user data from the server
            type: 'POST',
            data: { id: id },
            success: function (response) {
                var user = JSON.parse(response);

                if (user.error) {
                    alert(user.error);
                } else {
                    // Set values in the modal fields
                    $('#viewhospital').val(user.name);
                    $('#viewpatient').val(user.email);
                    $('#viewphone').val(user.phone);
                    $('#viewdiagnosis').val(user.status);

                    // Store the user ID in the modal
                    $('#viewPatient').data('userid', user.id);

                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById('viewPatient'));
                    modal.show();
                }
            }
        });
    });

    // When the "Update Details" button is clicked
    $('#viewclose').click(function () {
        var id = $('#viewPatient').data('userid');  // Get the user ID
        var name = $('#viewhospital').val();
        var email = $('#viewpatient').val();
        var phone = $('#viewphone').val();
        var status = $('#viewdiagnosis').val();

        // AJAX request to update the user data
        $.ajax({
            url: 'update_user.php',
            type: 'POST',
            data: {
                id: id,
                name: name,
                email: email,
                phone: phone,
                status: status
            },
            success: function (response) {
                if (response === 'success') {
                    alert('Data updated successfully');
                    location.reload();  // Reload the page to see changes
                } else {
                    alert('Error updating data');
                }
            }
        });
    });
});


$(document).ready(function () {
    // When the DELETE button is clicked
    $('.deleteUser').click(function () {
        var id = $(this).data('callid');  // Get the user ID from the data attribute
        
        // Store the ID in a global variable or in the modal
        $('#deleteConfirmationModal').data('userid', id);
    });

    // When the "Delete" button in the confirmation modal is clicked
    $('#confirmDelete').click(function () {
        var id = $('#deleteConfirmationModal').data('userid');  // Get the user ID stored earlier
        
        // AJAX request to delete the user
        $.ajax({
            url: 'delete_user.php',  // Send request to the delete PHP file
            type: 'POST',
            data: { id: id },
            success: function (response) {
                if (response === 'success') {
                    // Remove the row from the table dynamically
                    $('a[data-callid="'+id+'"]').closest('tr').remove();
                    
                    // Close the modal
                    $('#deleteConfirmationModal').modal('hide');
                    
                    alert('Record deleted successfully');
                } else {
                    alert('Error deleting record');
                }
            }
        });
    });
});

$(document).ready(function () {
    // When the "Change Status" button is clicked
    $('.changeStatus').click(function () {
        var id = $(this).data('callid');  // Get the user ID from the data attribute
        
        // AJAX request to fetch the current user data
        $.ajax({
            url: 'get_user_data.php',  // Fetch user data based on the ID
            type: 'POST',
            data: { id: id },
            success: function (response) {
                var user = JSON.parse(response);

                // Populate the modal fields
                $('#changeName').val(user.name);
                $('#changeEmail').val(user.email);
                $('#changePhone').val(user.phone);
                $('#changeStatus').val(user.status);  // Set the current status in the dropdown

                // Store the user ID in a hidden variable or in the modal
                $('#changeStatusModal').data('userid', id);

                // Open the modal
                var modal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
                modal.show();
            }
        });
    });

    // When the "Save Status" button is clicked
    $('#saveStatusBtn').click(function () {
        var id = $('#changeStatusModal').data('userid');  // Get the user ID from the modal
        var status = $('#changeStatus').val();  // Get the selected status
        
        // AJAX request to update the status
        $.ajax({
            url: 'update_status.php',  // PHP file to update the status
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function (response) {
                if (response === 'success') {
                    alert('Status updated successfully');
                    
                    // Optionally, update the table row dynamically to reflect the new status
                    $('a[data-callid="'+id+'"]').closest('tr').find('.statusCell').text(status);  // Update status cell in the row
                    
                    // Close the modal
                    $('#changeStatusModal').modal('hide');
					location.reload(); 
                } else {
                    alert('Error updating status');
                }
            }
        });
    });
});

// Assuming you are using jQuery for simplicity

$(document).ready(function(){
  // When the VIEW button is clicked
  $(".viewPatients").click(function(){
    var userId = $(this).data('callid');  // Get the user ID from the clicked button

    // Perform an AJAX request to fetch the user details
    $.ajax({
      url: 'fetch_user_details.php',  // This script should fetch the user details based on ID
      type: 'POST',
      data: {id: userId},
      success: function(response){
        // Assuming the response is in JSON format
        var user = JSON.parse(response);

        // Populate the modal fields with the user data
        $("#viewName").val(user.name);
        $("#viewEmail").val(user.email);
        $("#viewPhone").val(user.phone);
        $("#viewStatus").val(user.status);
      },
      error: function(){
        alert("Error fetching user details");
      }
    });
  });
});

</script>
</body>
</html>