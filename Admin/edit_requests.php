<?php
session_start();
include('inc/header.php');
require_once 'lib/Database.php';

// Include the database connection


// Fetch student data
 //$get_data = "SELECT * FROM student_data";
//$run_data = mysqli_query($con, $get_data);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Student Management System</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
</head>
<body>

	<div class="container">

	<h1>Edit Requests </h1>
  
  
    <?php
        $database = new Database();
        $link = $database->pdo;
        $query = "SELECT * FROM admission.student_data WHERE  edit_request_status = TRUE ";
        $result = $link->query($query);
    ?>

  
  <hr>
  <table class="table table-bordered table-striped table-hover" id="myTable">
    <thead>
        <tr>
            <th class="text-center" scope="col" id="serial">S.L</th>
            <th class="text-center" scope="col">Student Name</th>
            <th class="text-center" scope="col">Register Number</th>
            <th class="text-center" scope="col">Edit Requests</th>
        </tr>
    </thead>

    <?php while($eachStudent = $result->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td class='text-center' id='serial'><?php echo $eachStudent['id'];?></td>
            <td class='text-left'><?php echo $eachStudent['u_card'];?></td> 
            <td class='text-left'> <?php echo $eachStudent['u_f_name'];?> <?php echo $eachStudent['u_l_name'];?></td>
            <td class='text-center'>
                <form  action="process_edit_approval.php" method='post' class='edit-request-form'>
                    <input type='hidden' name='student_id' value='<?php echo $eachStudent['u_card'];?>'>
                    <button type='submit' class='btn btn-success edit-request-button' name='approve_request'>
                        Approve
                    </button>
                    <button type='submit' class='btn btn-danger edit-request-button' name='deny_request'>
                        Deny
                    </button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
  $(document).ready(function () {
    $('.edit-request-form').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        // Get the form data
        var formData = $(this).serialize();

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: 'process_edit_approval.php',
            data: formData,
            dataType: 'json', // Corrected data type with quotes
            success: function (response) {
                // Handle the response
                console.log(response);

                // You can update the UI or perform other actions based on the response
                if (response.success) {
                    alert('Request Approved successfully!');
                } else {
                    alert('Error approving request: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.log('AJAX request failed:', status, error);
            }
        });
    });
});



</script>


       
    </div>
</body>
</html>