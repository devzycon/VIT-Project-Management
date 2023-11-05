<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// database connection
include('config.php');

$added = false;


//Add  new student code 

if(isset($_POST['submit'])){
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_project_type = $_POST['project_type'];
    $u_review_0 = $_POST['review_0']; //added three new variables
    $u_review_1 = $_POST['review_1'];
    $u_review_2 = $_POST['review_2'];
	//$u_staff_id = $_POST['staff_id'];

	$msg = "";

        //changed query to add review0,1 and 2
	  $insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name,u_email, u_phone, u_project_type, u_review_0, u_review_1, u_review_2) VALUES ('$u_card','$u_f_name','$u_l_name','$u_email','$u_phone','$u_project_type',  '$u_review_0', '$u_review_1', '$u_review_2')";
  	$run_data = mysqli_query($con,$insert_data);
    if ($run_data) {
        $added = true;
    } else {
        echo "Error: " . $insert_data . "<br>" . mysqli_error($con);
    }

  	if($run_data){
		  $added = true;
  	}else{

  		echo "Data not insert";
  	}

}
$_SESSION['form_token'] = bin2hex(random_bytes(32));
?>







<!DOCTYPE html>
<html>
<head>
	<title>Student Crud Operation</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
</head>
<body>

	<div class="container">
<!-- <a href="https://lexacademy.in" target="_blank"><img src="https://codingcush.com/uploads/logo/logo_61b79976c34f5.png" alt="" width="350px" ></a><br><hr> -->

<!-- adding alert notification  -->
<?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
	}

?>





	<a href="logout.php" class="btn btn-success"><i class="fa fa-lock"></i> Logout</a>
	<button class="btn btn-success" type="button" data-toggle="modal" id="submitBtn" data-target="#myModal">
  <i class="fa fa-plus"></i> Add New Student
  </button>
  <!-- <a href="export.php" class="btn btn-success pull-right"><i class="fa fa-download"></i> Export Data</a> -->
  <hr>
		<table class="table table-bordered table-striped table-hover" id="myTable">
<thead>
    <tr>
        <th class="text-center" scope="col" id="serial">S.L</th>
        <th class="text-center" scope="col">Student Name</th>
        <th class="text-center" scope="col">Register Number</th>
        <th class="text-center" scope="col">Phone Number</th>
        <!-- Remove the following line for the Staff ID column -->
        <!-- <th class="text-center" scope="col">Staff Id</th> -->
		<th class="text-center" scope="col">Project Type</th>
        <!-- <th class="text-center" scope="col">View</th> -->
        <!-- Added 3 new columns review 0 , 1 and 2 -->
        <th class="text-center" scope="col">Review 0</th>
        <th class="text-center" scope="col">Review 1</th>
        <th class="text-center" scope="col">Review 2</th>
        <th class="text-center" scope="col">Edit</th>
        <!-- <th class="text-center" scope="col">Delete</th> -->
    </tr>
</thead>

			<?php

        	$get_data = "SELECT * FROM student_data order by 1 desc";
        	$run_data = mysqli_query($con,$get_data);
			$i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
				$sl = ++$i;
				$id = $row['id'];
				$u_card = $row['u_card'];
				$u_f_name = $row['u_f_name'];
				$u_l_name = $row['u_l_name'];
				$u_phone = $row['u_phone'];
				//$u_staff_id = $row['staff_id'];
				$u_project_type = $row['u_project_type'];
                // display values in the table from the database of review 0, 1 and 2 (values are null now because database has no column as review 0 , 1 and 2) 
                $u_review_0 = isset($_POST['review_0']) ? $_POST['review_0'] : "";
                $u_review_1 = isset($_POST['review_1']) ? $_POST['review_1'] : "";
                $u_review_2 = isset($_POST['review_2']) ? $_POST['review_2'] : "";
        		//$image = $row['image'];

        		echo "

				<tr>
				<td class='text-center' id='serial'>$sl</td>
				<td class='text-left'>$u_f_name   $u_l_name</td>
				<td class='text-left'>$u_card</td>
				<td class='text-left'>$u_phone</td>
				<td class='text-center'>$u_project_type</td>
                <td class='text-center'>
					<span>
					    <button class='btn btn-primary view-button' data-toggle='modal' type='button' id='submitBtn' data-target='#myModal2'>View</button>
					</span>
				</td>
                <td class='text-center'>-NA-</td>
                <td class='text-center'>-NA-</td>
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>
					</span>
				</td> 
			</tr>
            
            
        		";
            

        	}
           
        	    ?> 
    
<script type="text/javascript">
    var slValue = <?php echo $sl; ?>;
    if (slValue >= 5) {
        // If slValue is greater than 5, disable the button
        document.getElementById("submitBtn").disabled = true;
        // Optionally, you can display an alert message
        alert("You have reached the maximum limit of form submissions (5 times).");
    }
</script>

			
			
		</table>
		<!-- <form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export Data" />
    </form> -->
	</div>


	<!---Add in modal---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<!-- <center><img src="https://codingcush.com/uploads/logo/logo_61b79976c34f5.png" width="300px" height="80px" alt=""></center> -->
    
      </div>
      <div class="modal-body">
      <?php


        ?>
        <form method="POST" enctype="multipart/form-data" action="process_form.php">
        <input type="hidden" name="token" value="<?php echo $_SESSION['form_token']; ?>">
			
			<!-- This is test for New Card Activate Form  -->
			<!-- This is Address with email id  -->
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">Student Id.</label>
<input type="text" class="form-control" name="card_no" placeholder="Enter 12-digit Student Id." maxlength="12" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No.</label>
<input type="text" class="form-control" name="user_phone" placeholder="Enter 10-digit Mobile no." maxlength="10" required >
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="firstname">First Name</label>
<input type="text" class="form-control" name="user_first_name" placeholder="Enter First Name">
</div>
<div class="form-group col-md-6">
<label for="lastname">Last Name</label>
<input type="text" class="form-control" name="user_last_name" placeholder="Enter Last Name">
</div>
</div>



<div class="form-row" style="color: skyblue;">
<div class="form-group col-md-6">
<label for="email">Email Id</label>
<input type="email" class="form-control" name="user_email" placeholder="Enter Email id">
</div>
<div class="form-group col-md-6">
<label for="project_type">Project Type:</label>
        <select id="project_type" name="project_type" class="form-control">
            <option value="In House">In House</option>
			<option value="PAT">PAT</option>

</div>

            
        	 <input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
        	
			
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- my model 2 -->

<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<!-- <center><img src="https://codingcush.com/uploads/logo/logo_61b79976c34f5.png" width="300px" height="80px" alt=""></center> -->
    
      </div>
      <div class="modal-body">
      <?php


        ?>
        <form method="POST" enctype="multipart/form-data" action="process_form.php">
        <input type="hidden" name="token" value="<?php echo $_SESSION['form_token']; ?>">
			
			<!-- This is test for New Card Activate Form  -->
			<!-- This is Address with email id  -->
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">Student Id.</label>
<input type="text" class="form-control" name="card_no" placeholder="Enter 12-digit Student Id." maxlength="12" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No.</label>
<input type="text" class="form-control" name="user_phone" placeholder="Enter 10-digit Mobile no." maxlength="10" required >
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="firstname">First Name</label>
<input type="text" class="form-control" name="user_first_name" placeholder="Enter First Name">
</div>
<div class="form-group col-md-6">
<label for="lastname">Last Name</label>
<input type="text" class="form-control" name="user_last_name" placeholder="Enter Last Name">
</div>
</div>



<div class="form-row" style="color: skyblue;">
<div class="form-group col-md-6">
<label for="email">Email Id</label>
<input type="email" class="form-control" name="user_email" placeholder="Enter Email id">
</div>
<div class="form-group col-md-6">
<label for="project_type">Project Type:</label>
        <select id="project_type" name="project_type" class="form-control">
            <option value="In House">In House</option>
			<option value="PAT">PAT</option>

</div>

            
        	 <input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
        	
			
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!------DELETE modal---->




<!-- Modal -->

<?php
/*
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Are you want to sure??</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Delete</a>
      </div>
      
    </div>

  </div>
</div>


	";
	
}

*/
?>


<!-- View modal  -->
<?php 

// <!-- profile modal start -->
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con, $get_data);

while ($row = mysqli_fetch_array($run_data)) {
    $u_card = $row['u_card'];
    $u_f_name = $row['u_f_name'];
    $u_l_name = $row['u_l_name'];
    $u_email = $row['u_email'];
    $u_phone = $row['u_phone'];
    $u_project_type = $row['u_project_type'];
    $u_project_type = $row['u_project_type'];
    //$image = $row['image'];
    $id = $row['id']; // Assuming 'id' is the primary key of your student_data table

    echo "
        <div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Profile <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class='container' id='profile'> 
                            <div class='row'>
                                <div class='col-sm-4 col-md-2'>
                                    <i class='fa fa-id-card' aria-hidden='true'></i> $u_card<br>
                                    <i class='fa fa-phone' aria-hidden='true'></i> $u_phone  <br>
                                    Project Type: $u_project_type
                                </div>
                                <div class='col-sm-3 col-md-6'>
                                    <h3 class='text-primary'>$u_f_name $u_l_name</h3>
                                    <p class='text-secondary'>
                                        <i class='fa fa-envelope-o' aria-hidden='true'></i> $u_email
                                        <br />
                                    </p>
                                    <!-- Split button -->
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div> 
    ";


}






// <!-- profile modal end -->


?>



<!----edit Data--->

<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con, $get_data);

while ($row = mysqli_fetch_array($run_data)) {
    $id = $row['id']; // Assuming 'id' is the primary key of your student_data table
    $u_card = $row['u_card'];
    $u_f_name = $row['u_f_name'];
    $u_l_name = $row['u_l_name'];
    $u_email = $row['u_email'];
    $u_phone = $row['u_phone'];
    $u_project_type = $row['u_project_type'];

    echo "
        <div id='edit$id' class='modal fade' role='dialog'>
            <div class='modal-dialog'>

                <!-- Modal content-->
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <h4 class='modal-title text-center'>Edit Student Data</h4> 
                    </div>

                    <div class='modal-body'>
                        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>
                            <!-- Your form fields here, pre-filled with student data -->
                        </form>
                    </div>

                    <div class='modal-footer'>
                        <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    </div>
                </div>

            </div>
        </div>
    ";
}




?>



<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

</body>
</html>
