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
           
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $faculty_id); // Assuming faculty_id is an integer

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $patCount);

                    if (mysqli_stmt_fetch($stmt)) {
                        $_SESSION['patCount'] = $patCount;
                    } else {
                        //echo "Failed to fetch 'PAT' count.";
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

                $s_no = $_POST['s_no'];
                $s_pgm = $_POST['s_pgm'];
                $s_regno = $_POST['s_regno'];
                $s_name = $_POST['s_name'];
                $s_erp = $_POST['s_erp'];
                $s_guide = $_POST['s_guide'];
                $s_panelno = $_POST['s_panelno'];
                $s_facultyrev = $_POST['s_facultyrev'];
                $s_m1 = $_POST['s_m1'];
                $s_m2 = $_POST['s_m2'];
                $s_m3 = $_POST['s_m3'];
                $s_m4 = $_POST['s_m4'];
                $s_tot = $_POST['s_tot'];
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
      
    .center-table {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    #table_mark{
        
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
        <th class="text-center" scope="col" id="serial">S.NO</th>
        <th class="text-center" scope="col">PGM</th>
        <th class="text-center" scope="col">REG NO</th>
        <th class="text-center" scope="col">STUDENT NAME</th>
        <!-- Remove the following line for the Staff ID column -->
        <!-- <th class="text-center" scope="col">Staff Id</th> -->
        <th class="text-center" scope="col">ERP ID</th>
		<th class="text-center" scope="col">GUIDE NAME</th>
        <th class="text-center" scope="col">PANEL NO</th>
        <th class="text-center" scope="col">FACULTY REVIEWERS</th>
        <!-- <th class="text-center" scope="col">View</th> -->
        <!-- Added 3 new columns review 0 , 1 and 2 -->
        <th class="text-center" scope="col">MARKS</th>
        <!-- <th class="text-center" scope="col">Delete</th> -->
    </tr>
</thead>

			<?php

        	$get_data = "SELECT * FROM review1";
        	$run_data = mysqli_query($con,$get_data);
			    $i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
                $s_no = $row['s_no'];
                $s_pgm = $row['s_pgm'];
                $s_regno = $row['s_regno'];
                $s_name = $row['s_name'];
                $s_erp = $row['s_erp'];
                $s_guide = $row['s_guide'];
                $s_panelno = $row['s_panelno'];
                $s_facultyrev = $row['s_facultyrev'];
                $s_m1 = $row['s_m1'];
                $s_m2 = $row['s_m2'];
                $s_m3 = $row['s_m3'];
                $s_m4 = $row['s_m4'];
                $s_tot = $row['s_tot'];
                
        		

        		echo "
				<tr>
				<td class='text-center' id='serial'>$s_no</td>
				<td class='text-left'>$s_pgm</td>
				<td class='text-left'>$s_regno</td>
				<td class='text-left'>$s_name</td>
                <td class='text-center'>$s_erp</td>
				<td class='text-center'>$s_guide</td>
                <td class='text-center'>$s_panelno</td>
                <td class='text-center'>$s_facultyrev</td>
                <td class='text-center'>
					<span>
					    <button class='btn btn-primary view-button' data-toggle='modal' type='button' id='submitBtn' data-target='#rev1$s_no'>View</button>
					</span>
                    <div class='modal fade' id='rev1$s_no' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Student $s_no <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <div class='container' id='profile'> 
                                    <div class='row'>
                                    <div class='col-md-5 offset-md-2' style = 'padding = 50px'>
                                    <form action='review1_mark.php?s_no=$s_no' id='reviewForm' method='post' enctype='multipart/form-data'>
                                    <table class='table table-bordered table-striped table-hover custom-table '>
                                    <thead>
                                        <tr >
                                            <th class='text-center' scope='col'>Review 1</th>
                                            <th class='text-center' scope='col'>Knowledge on Research Domain</th>
                                            <th class='text-center' scope='col'>Literature Review</th>
                                            <th class='text-center' scope='col'>Proper Identification</th>
                                            <th class='text-center' scope='col'>Presentation Skills</th>
                                            <th class='text-center' scope='col'>Total</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                    <td class='text-left'>MARKS</td>
                                    
                                        <td class='text-left'>
                                            <input type='number' id='us_m1' name='us_m1' value='$s_m1' width=1px min='0' max='5' required><br>
                                        </td>
                                        <td class='text-left'>
                                            <input type='number' id='us_m2' name='us_m2' value='$s_m2' width=1px min='0' max='5' required><br>
                                        </td>
                                        <td class='text-center'>
                                            <input type='number' id='us_m3' name='us_m3' value='$s_m3' width=1px min='0' max='5' required><br>
                                        </td>
                                        <td class='text-center'>
                                            <input type='number' id='us_m4' name='us_m4' value='$s_m4' width=1px min='0' max='5' required><br>
                                        </td>
                                        <td class='text-center'>
                                            $s_tot
                                           
                                        </td>
                                    
                                </tr>
                                    </table>
                                    <input type='submit' name='submit' id='submitB' class='btn btn-info btn-large' value='Submit'>
                                </form>
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
			</tr>

            
        		";
            

        	}

            
           
        	    ?>

                