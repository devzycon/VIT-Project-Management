<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// database connection
include ("config.php");
$username = $_SESSION['username'];

$sql = "SELECT faculty_id FROM users WHERE username = ?";
if ($stmt = mysqli_prepare($con, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $faculty_id);

        if (mysqli_stmt_fetch($stmt)) {
            // Store faculty_id in the session
            $_SESSION['faculty_id'] = $faculty_id;

            mysqli_stmt_close($stmt);

            // Get 'PAT' count
            $sql = "SELECT COUNT(*) AS patCount FROM student_data WHERE u_project_type = 'PAT' AND faculty_id = ?";
            
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $faculty_id); // Assuming faculty_id is an integer

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $patCount);

                    if (mysqli_stmt_fetch($stmt)) {
                        $_SESSION['patCount'] = $patCount;
                    } else {
                        echo "Failed to fetch 'PAT' count.";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error executing the statement: " . mysqli_error($con);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($con);
            }

            $added = false;

            if (isset($_POST['submit'])) {
                // Your existing code here

                $u_card = $_POST['card_no'];
                $u_f_name = $_POST['user_first_name'];
                $u_l_name = $_POST['user_last_name'];
                $u_email = $_POST['user_email'];
                $u_phone = $_POST['user_phone'];
                $u_project_type = isset($u_project_type) ? $u_project_type : ""; 
                $u_review_0 = $_POST['review_0'];
                $u_review_1 = $_POST['review_1'];
                $u_review_2 = $_POST['review_2'];
                $project_name = $_POST['projectName'];
                $u_attendance = $_POST['attendance'];
                $no_of_present = $_POST['no_of_present'];
                

                if ($u_project_type == 'PAT') {
                  // Initialize the count if it doesn't exist
                  if (!isset($_SESSION['patCount'])) {
                      $_SESSION['patCount'] = 0;
                  }

                  // Increment the count
                  $_SESSION['patCount']++;
              } 
                // Your existing code here
            }

            $_SESSION['form_token'] = bin2hex(random_bytes(32));
        } else {
            echo "Failed to fetch faculty_id.";
        }
    } else {
        echo "Error executing the statement: " . mysqli_error($con);
    }
} else {
    echo "Error preparing statement: " . mysqli_error($con);
}
              ?>





<!-- MODAL BUG 
 ISSUE:


-->

<!DOCTYPE html>
<html>
<head>
	<title>Student Management Operation</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="jquery.js"></script>
    <script src="auto_logout.js"></script>

    <style>
      body
        {
        
        background-repeat: no-repeat;
        background-size: 75%;
        }
      .small-textbox {
          width: 50px; 
          margin-left: 200px;
      }
      .marks-align {
          
      }
      .custom-container{
        margin-top: 60px;
      }
      #heade{
        background-color: #2865b0;
        height: 50px !important;
        padding: 0;
      }
      #vit{
        color: white;
        font-size: 30px;
        padding: 0;
        margin: 0;
      }
      .student-details{
        margin-top: 3%;
        margin-left: 40%;
        margin-bottom: 4%;
      }
    </style>

</head>
<body>
<div id="heade">
   
   <center>
     <h1 id="vit"><b>Btech Capstone Project</b></h1>
     </center>
     
<div>
	<div class="container custom-container">
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



      <div class="flex-column justify-content-center student-details">
          <strong class="h2 align-self-center primaryTextColor1 fw-bold text-center"><b>Student Details</b></strong>
      </div>

	<a href="logout.php" class="btn btn-danger"><i class="fa fa-lock lo"></i> Logout</a>
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
        <th class="text-center" scope="col">Email ID</th>
		<th class="text-center" scope="col">Project Type</th>
        <!-- <th class="text-center" scope="col">View</th> -->
        <!-- Added 3 new columns review 0 , 1 and 2 -->
        <th class="text-center" scope="col">Review 0</th>
        <th class="text-center" scope="col">Review 1</th>
        <th class="text-center" scope="col">Review 2</th>
        <th class="text-center" scope="col">Edit</th>
        <th class="text-center" scope="col">Project Name</th>
        <th class="text-center" scope="col">Attendance</th>
        <th class="text-center" scope="col">Enter Attendance</th>
        <!-- <th class="text-center" scope="col">Delete</th> -->
    </tr>
</thead>

			<?php

        	$get_data = "SELECT * FROM student_data WHERE `faculty_id`=$faculty_id order by 1 desc";
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
                $u_email = $row['u_email'];
				        $u_project_type = $row['u_project_type'];
                $u_review_0 = $row['review_0'];
                $project_name = $row['project_name'];
                $u_attendance = $row['attendance'];
                $no_of_present = $row['no_of_present'];
                // $u_review_0 = isset($_POST['review_0']) ? $_POST['review_0'] : "";
                // $u_review_1 = isset($_POST['review_1']) ? $_POST['review_1'] : ""; CAN BE TAKEN CARE OF LATER.
                // $u_review_2 = isset($_POST['review_2']) ? $_POST['review_2'] : "";
                $buttonDisabled = empty($u_review_0) ? '' : 'disabled';
                $textboxDisabled = empty($u_review_0) ? '' : 'disabled';
                $start_date = strtotime('2023-12-19');
                $current_date = time();
                $days_difference = floor(($current_date - $start_date) / (60 * 60 * 24));
                if ($days_difference == 0) {
                $days_difference = 1;
                }
                $week_count = ceil($days_difference / 6);
        		

        		echo "
				<tr>
				<td class='text-center' id='serial'>$sl</td>
				<td class='text-left'>$u_f_name   $u_l_name</td>
				<td class='text-left'>$u_card</td>
				<td class='text-left'>$u_phone</td>
        <td class='text-center'>$u_email</td>
				<td class='text-center'>$u_project_type</td>
                <td class='text-center'>
					<span>
					    <button class='btn btn-primary view-button' data-toggle='modal' type='button' id='submitBtn' data-target='#view$id'>View</button>
					</span>
                    <div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Student $sl <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <div class='container' id='profile'> 
                                    <div class='row'>
                                    <div class='col-md-5 offset-md-2'>
                                    <table class='table table-bordered table-striped table-hover custom-table'>
                                    <thead>
                                        <tr>
                                            <th class='text-center' scope='col'>Student Name</th>
                                            <th class='text-center' scope='col'>Register Number</th>
                                            <th class='text-center' scope='col'>Phone Number</th>
                                            <th class='text-center' scope='col'>Email ID</th>
                                            <th class='text-center' scope='col'>Project Type</th>
                                            <th class='text-center' scope='col'>Project Name</th>
                                        </tr>
                                    </thead>
                                      <tr>
                                        <td class='text-left'>$u_f_name   $u_l_name</td>
                                        <td class='text-left'>$u_card</td>
                                        <td class='text-left'>$u_phone</td>
                                                <td class='text-center'>$u_email</td>
                                        <td class='text-center'>$u_project_type</td>
                                        <td class='text-center'>$project_name</td>
                                      </tr>
                                    </table>
                                    <div class='marks-align'>
                                      <form action='review0.php?id=$id' id='reviewForm' method='post' enctype='multipart/form-data'>
                                        Enter Marks:<br>
                                        <label for='u_review_0'><b>Problem Statement / Objective / Solution (5 marks)</b></label>
                                        <input type='number' class='form-control small-textbox' id='u_review_0' name='u_review_0' value='$u_review_0' width=5px min='0' max='5' id='checkm' required $textboxDisabled><br>
                                        <input type='submit' name='submit' id='submitB' class='btn btn-info btn-large' value='Submit' $buttonDisabled><br><br> 
                                      </form>
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
				</td>
                <td class='text-center'>-NA-</td>
                <td class='text-center'>-NA-</td>
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>
					</span>
                    <div id='edit$id' class='modal fade' role='dialog'>
    <div class='modal-dialog'>
  
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
               <button type='button' class='close' data-dismiss='modal'>&times;</button>
               <h4 class='modal-title text-center'>Edit your Data</h4> 
        </div>
  
        <div class='modal-body'>
          <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>
  
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='inputEmail4'>Student Id.</label>
          <input type='text' class='form-control' name='card_no' placeholder='Enter 12-digit Student Id.' maxlength='12' value='$u_card' required>
          </div>
          <div class='form-group col-md-6'>
          <label for='inputPassword4'>Mobile No.</label>
          <input type='phone' class='form-control' name='user_phone' placeholder='Enter 10-digit Mobile no.' maxlength='10' value='$u_phone' required>
          </div>
          </div>
          
          
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='firstname'>First Name</label>
          <input type='text' class='form-control' name='user_first_name' placeholder='Enter First Name' value='$u_f_name'>
          </div>
          <div class='form-group col-md-6'>
          <label for='lastname'>Last Name</label>
          <input type='text' class='form-control' name='user_last_name' placeholder='Enter Last Name' value='$u_l_name'>
          </div>
          </div>
          
      
          
          
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='email'>Email Id</label>
          <input type='email' class='form-control' name='user_email' placeholder='Enter Email id' value='$u_email'>
          </div>
          <div class='form-group col-md-6'>
          <label for='project_type'>Project Type:</label>
          <select id='project_type' name='project_type' class='form-control'>
              <option value='In House' <?php echo ($u_project_type == 'In House') ? 'selected' : ''; ?>>In House</option>
              <option value='PAT' <?php echo ($u_project_type == 'PAT') ? 'selected' : ''; ?>>PAT</option>
              </select>
              <div class='form-row'>
              <div class='form-group col-md-12'>
                  <label for='project_name'>Project Name</label>
                  <input type='text' class='form-control' name='project_name' placeholder='Enter Project Name' value='$project_name'>
              </div>
          </div>
          </div>
          </div>
          </div>
       
      
              
               <div class='modal-footer'>
               <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
           </div>
  
  
          </form>
        </div>
  
      </div>
  
    </div>
  </div>
				</td> 
        <td class='text-center'>$project_name</td>
        <td class='text-center' id='attendanceCell$id'>$u_attendance</td>

<td class='text-center'>
  <span>
    <button class='btn btn-primary view-button' data-toggle='modal' type='button' data-target='#viewatt$id'>Enter</button>
  </span>
  <div class='modal fade' id='viewatt$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
   <div class='modal-dialog modal-lg'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h5 class='modal-title' id='exampleModalLabel'>Student $sl <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>
                  </div>
                  <div class='modal-body'>
                      <div class='container' id='profile'> 
                          <div class='row'>
                          <div class='col-md-5 offset-md-2'>
                          <h2><b>WEEK $week_count</b></h2><br>
                          <form id='attendForm$id' action='attend.php?id=$id' method='post' enctype='multipart/form-data'>
                          <table class='table table-bordered table-striped table-hover custom-table'>
                              <tr>
                                <th>DAY</th>
                                <th>Attendance</th>
                              </tr>
                              <tr>
                                <td>Monday</td>
                                <td>
                                  <select name='attendance[Monday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Tuesday</td>
                                <td>
                                  <select name='attendance[Tuesday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Wednesday</td>
                                <td>
                                  <select name='attendance[Wednesday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Thursday</td>
                                <td>
                                  <select name='attendance[Thursday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Friday</td>
                                <td>
                                  <select name='attendance[Friday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Saturday</td>
                                <td>
                                  <select name='attendance[Saturday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Sunday</td>
                                <td>
                                  <select name='attendance[Sunday]' class='form-control' >
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                  </select>
                                </td>
                              </tr>
                            </table>
                            <div class='modal-footer'>
                            <input type='button' name='submit' class='btn btn-info btn-large' value='Calculate' onclick='submitForm($id)'>

        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
      </div>
    </form>
                        </div>
                      </div>   
                  </div>
              </div>
          </div>
          </div>
        </td>
			</tr>
        		";
            

        	}
           
        	    ?> 

<!-- Add the following script at the end of your HTML file -->
<!-- Add the following script at the end of your HTML file -->
<!-- Add the following script at the end of your HTML file -->
<!-- Add the following script at the end of your HTML file -->

<script>
  function submitForm(id) {
    var form = $('#attendForm' + id);

    $.ajax({
      type: form.attr('method'),
      url: form.attr('action'),
      data: form.serialize() + '&submit=1',
      dataType: 'json',
      success: function(response) {
        console.log(response); // Log the entire response object for debugging
        if (response.success) {
          alert('Attendance updated successfully');
          console.log('Updating attendance cell:', '#attendanceCell' + id);
          $('#attendanceCell' + id).html(response.newAttendance);
        } else {
          alert('Error updating attendance: ' + response.message);
        }
      },
      error: function(error) {
        console.error('AJAX Error:', error);
        alert('An error occurred while submitting the form.');
      }
    });
  }
</script>










<script type="text/javascript">
    var slValue = <?php echo $sl; ?>;
    if (slValue >= 5) {
        // If slValue is greater than 5, disable the button
        document.getElementById("submitBtn").disabled = true;
        // Optionally, you can display an alert message
    }
</script>



<table class="table table-bordered table-striped table-hover" id="myTable">
<thead>
    <tr>
        <th class="text-center" scope="col" id="serial">S.L</th>
        <th class="text-center" scope="col">Student Name</th>
        <th class="text-center" scope="col">Register Number</th>
        <th class="text-center" scope="col">Phone Number</th>
        <!-- Remove the following line for the Staff ID column -->
        <!-- <th class="text-center" scope="col">Staff Id</th> -->
        <th class="text-center" scope="col">Email ID</th>
		<th class="text-center" scope="col">Project Type</th>
        <!-- <th class="text-center" scope="col">View</th> -->
        <!-- Added 3 new columns review 0 , 1 and 2 -->
        <th class="text-center" scope="col">Review 0</th>
        <th class="text-center" scope="col">Review 1</th>
        <th class="text-center" scope="col">Review 2</th>
        <th class="text-center" scope="col">Edit</th>
        <th class="text-center" scope="col">Project Name</th>
        <!-- <th class="text-center" scope="col">Delete</th> -->
    </tr>
</thead>

			<?php

        	$get_data = "SELECT * FROM student_data WHERE `faculty_id`=$faculty_id  and `u_project_type`='pat'order by 1 desc";
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
                $u_email = $row['u_email'];
				        $u_project_type = $row['u_project_type'];
                $project_name = $row['project_name'];
                // $u_review_0 = isset($_POST['review_0']) ? $_POST['review_0'] : "";
                // $u_review_1 = isset($_POST['review_1']) ? $_POST['review_1'] : ""; CAN BE TAKEN CARE OF LATER.
                // $u_review_2 = isset($_POST['review_2']) ? $_POST['review_2'] : "";
                $u_review_0 = $row['review_0'];
                $buttonDisabled = empty($u_review_0) ? '' : 'disabled';
                $textboxDisabled = empty($u_review_0) ? '' : 'disabled';
        		

        		echo "
            <tr>
            <td class='text-center' id='serial'>$sl</td>
            <td class='text-left'>$u_f_name   $u_l_name</td>
            <td class='text-left'>$u_card</td>
            <td class='text-left'>$u_phone</td>
            <td class='text-center'>$u_email</td>
            <td class='text-center'>$u_project_type</td>
                    <td class='text-center'>
              <span>
                  <button class='btn btn-primary view-button' data-toggle='modal' type='button' id='submitBtn' data-target='#view$id'>View</button>
              </span>
                        <div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Student $sl <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <div class='container' id='profile'> 
                                        <div class='row'>
                                        <div class='col-md-5 offset-md-2'>
                                        <table class='table table-bordered table-striped table-hover custom-table'>
                                        <thead>
                                            <tr>
                                                <th class='text-center' scope='col'>Student Name</th>
                                                <th class='text-center' scope='col'>Register Number</th>
                                                <th class='text-center' scope='col'>Phone Number</th>
                                                <th class='text-center' scope='col'>Email ID</th>
                                                <th class='text-center' scope='col'>Project Type</th>
                                                <th class='text-center' scope='col'>Project Name</th>
                                            </tr>
                                        </thead>
                                          <tr>
                                            <td class='text-left'>$u_f_name   $u_l_name</td>
                                            <td class='text-left'>$u_card</td>
                                            <td class='text-left'>$u_phone</td>
                                                    <td class='text-center'>$u_email</td>
                                            <td class='text-center'>$u_project_type</td>
                                            <td class='text-center'>$project_name</td>
                                          </tr>
                                        </table>
                                        <div class='marks-align'>
                                          <form action='review0.php?id=$id' id='reviewForm' method='post' enctype='multipart/form-data'>
                                            Enter Marks:<br>
                                            <label for='u_review_0'><b>Problem Statement / Objective / Solution (5 marks)</b></label>
                                            <input type='number' class='form-control small-textbox' id='u_review_0' name='u_review_0' value='$u_review_0' width=5px min='0' max='5' id='checkm' required $textboxDisabled><br>
                                            <input type='submit' name='submit' id='submitB' class='btn btn-info btn-large' value='Submit' $buttonDisabled><br><br> 
                                          </form>
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
            </td>
                    <td class='text-center'>-NA-</td>
                    <td class='text-center'>-NA-</td>
            <td class='text-center'>
              <span>
              <a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>
              </span>
                        <div id='edit$id' class='modal fade' role='dialog'>
        <div class='modal-dialog'>
      
          <!-- Modal content-->
          <div class='modal-content'>
            <div class='modal-header'>
                   <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   <h4 class='modal-title text-center'>Edit your Data</h4> 
            </div>
      
            <div class='modal-body'>
              <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>
      
              <div class='form-row'>
              <div class='form-group col-md-6'>
              <label for='inputEmail4'>Student Id.</label>
              <input type='text' class='form-control' name='card_no' placeholder='Enter 12-digit Student Id.' maxlength='12' value='$u_card' required>
              </div>
              <div class='form-group col-md-6'>
              <label for='inputPassword4'>Mobile No.</label>
              <input type='phone' class='form-control' name='user_phone' placeholder='Enter 10-digit Mobile no.' maxlength='10' value='$u_phone' required>
              </div>
              </div>
              
              
              <div class='form-row'>
              <div class='form-group col-md-6'>
              <label for='firstname'>First Name</label>
              <input type='text' class='form-control' name='user_first_name' placeholder='Enter First Name' value='$u_f_name'>
              </div>
              <div class='form-group col-md-6'>
              <label for='lastname'>Last Name</label>
              <input type='text' class='form-control' name='user_last_name' placeholder='Enter Last Name' value='$u_l_name'>
              </div>
              </div>
              
          
              
              
              <div class='form-row'>
              <div class='form-group col-md-6'>
              <label for='email'>Email Id</label>
              <input type='email' class='form-control' name='user_email' placeholder='Enter Email id' value='$u_email'>
              </div>
              <div class='form-group col-md-6'>
              <label for='project_type'>Project Type:</label>
              <select id='project_type' name='project_type' class='form-control'>
                  <option value='In House' <?php echo ($u_project_type == 'In House') ? 'selected' : ''; ?>>In House</option>
                  <option value='PAT' <?php echo ($u_project_type == 'PAT') ? 'selected' : ''; ?>>PAT</option>
                  </select>
                  <div class='form-row'>
                  <div class='form-group col-md-12'>
                      <label for='project_name'>Project Name</label>
                      <input type='text' class='form-control' name='project_name' placeholder='Enter Project Name' value='$project_name'>
                  </div>
              </div>
              </div>
              </div>
              </div>
           
          
                  
                   <div class='modal-footer'>
                   <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
                   <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
               </div>
      
      
              </form>
            </div>
      
          </div>
      
        </div>
      </div>
            </td> 
            <td class='text-center'>$project_name</td>
          </tr>
        		";
            

        	}
           
        	    ?> 

  




			
			
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
<input type="tel" class="form-control" name="user_phone" placeholder="Enter 10-digit Mobile no." maxlength="10" pattern="\d{10}" title="Please enter a 10-digit mobile number" required>
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
<?php
// Your PHP code to define $u_project_type
$u_project_type = isset($u_project_type) ? $u_project_type : "Select"; // Set to a default value if not set
?>

<div class="form-group col-md-6">
<label for="email">Project Type</label>
<select id="projectType" name="project_type" class="form-control" onchange="updateDropdown()">
    <option value="" <?php echo ($u_project_type == '') ? 'selected' : ''; ?> disabled>Select</option>
    <option value="In House" <?php echo ($u_project_type == 'In House') ? 'selected' : ''; ?>>In House</option>
    <option value="PAT" <?php echo ($u_project_type == 'PAT') ? 'selected' : ''; ?>>PAT</option>
</select>

</div>


</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="project_name">Project Name</label>
        <input type="text" class="form-control" name="projectName" placeholder="Enter Project Name">
    </div>
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

<script>
   var patCount = <?php echo isset($_SESSION['patCount']) ? $_SESSION['patCount'] : 0; ?>;

function updateDropdown() {
    var projectTypeSelect = document.getElementById('projectType');
    var patOption = projectTypeSelect.querySelector('option[value="PAT"]');

    if (patCount >= 2) {
        patOption.style.display = 'none';
        projectTypeSelect.value = 'In House';
    } else {
        patOption.style.display = '';
    }
}

// Call the function when patCount reaches 2
if (patCount >= 2) {
    updateDropdown();
}

</script>



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
<div class="form-group col-md-2">
<label for="project_type">Project Type:</label>
        <select id="project_type" name="project_type" class="form-control">
            <option value="In House">In House</option>
			<option value="PAT">PAT</option>

</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="project_name">Project Name</label>
        <input type="text" class="form-control" name="projectName" placeholder="Enter Project Name">
    </div>
</div>
            
        	
        	
			
        </form>
      </div>
      <div class="modal-footer">
      <input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>










<!----edit Data--->

<?php
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con, $get_data);

while ($row = mysqli_fetch_array($run_data)) {
    $id = $row['id'];
    $card = $row['u_card'];
    $name = $row['u_f_name'];
    $name2 = $row['u_l_name'];
    $email = $row['u_email'];
    $phone = $row['u_phone'];
    $project = $row['u_project_type'];
    echo "
    <div id='edit$id' class='modal fade' role='dialog'>
    <div class='modal-dialog'>
  
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
               <button type='button' class='close' data-dismiss='modal'>&times;</button>
               <h4 class='modal-title text-center'>Edit your Data</h4> 
        </div>
  
        <div class='modal-body'>
          <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>
  
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='inputEmail4'>Student Id.</label>
          <input type='text' class='form-control' name='card_no' placeholder='Enter 12-digit Student Id.' maxlength='12' value='$card' required>
          </div>
          <div class='form-group col-md-6'>
          <label for='inputPassword4'>Mobile No.</label>
          <input type='phone' class='form-control' name='user_phone' placeholder='Enter 10-digit Mobile no.' maxlength='10' value='$phone' required>
          </div>
          </div>
          
          
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='firstname'>First Name</label>
          <input type='text' class='form-control' name='user_first_name' placeholder='Enter First Name' value='$name'>
          </div>
          <div class='form-group col-md-6'>
          <label for='lastname'>Last Name</label>
          <input type='text' class='form-control' name='user_last_name' placeholder='Enter Last Name' value='$name2'>
          </div>
          </div>
          
      
          
          
          <div class='form-row'>
          <div class='form-group col-md-6'>
          <label for='email'>Email Id</label>
          <input type='email' class='form-control' name='user_email' placeholder='Enter Email id' value='$email'>
          </div>
          <div class='form-group col-md-6'>
          <label for='project_type'>Project Type:</label>
          <select id='project_type' name='project_type' class='form-control'>
              <option value='In House' <?php echo ($project == 'In House') ? 'selected' : ''; ?>>In House</option>
              <option value='PAT' <?php echo ($project == 'PAT') ? 'selected' : ''; ?>>PAT</option>
              </select>
          </div>
          </div>
          </div>
       
      
              
               <div class='modal-footer'>
               <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
           </div>
  
  
          </form>
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