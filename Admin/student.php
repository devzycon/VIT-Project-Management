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
    
</head>
<body>

	<div class="container">

	<h1>Students List </h1>
  <!-- <a href="export.php" class="btn btn-success pull-right"><i class="fa fa-download"></i> Export Data</a> -->
  
    <?php
        $database = new Database();
        $link = $database->pdo;
        $query = "SELECT * FROM admission.student_data";
        $result = $link->query($query);
    ?>

  
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
        <!-- <th class="text-center" scope="col">Delete</th> -->
    </tr>
</thead>

            <?php while($eachStudent = $result->fetch(PDO::FETCH_ASSOC)) { ?>
        
				<tr>
				<td class='text-center' id='serial'><?php echo $eachStudent['id'];?></td>
				<td class='text-left'><?php echo $eachStudent['u_card'];?></td> 
				<td class='text-left'> <?php echo $eachStudent['u_f_name'];?> <?php echo $eachStudent['u_l_name'];?></td>
				<td class='text-left'><?php echo $eachStudent['u_phone'];?></td>
                <td class='text-center'><?php echo $eachStudent['u_email'];?></td>
				<td class='text-center'><?php echo $eachStudent['u_project_type'];?></td>
                <td class='text-center'>
					<span>
					    <button class='btn btn-primary view-button' data-toggle='modal' type='button' id='submitBtn' data-target='#view$id'>View</button>
					</span>
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
                                            <form action='review0.php?id=$id' method='post' enctype='multipart/form-data'>
                                                <i class='fa fa-id-card' aria-hidden='true'></i> $u_card<br>
                                                <i class='fa fa-phone' aria-hidden='true'></i> $u_phone  <br>
                                                Project Type: $u_project_type<br><br>
                                                Enter Marks: 
                                                <input type='text' class='form-control' name='review_0_marks' placeholder='Enter Marks.' value='$u_review_0' required>
                                                <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
                                            </form>
                                        </div>
                                        <div class='col-sm-3'>
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
		    </tr>
        <?php }?>
            
        </table>
        <form action="studentcsv.php" method="post">
            <button type="submit" name="download" class="btn btn-secondary">Download CSV</button>
        </form>
    </div>
    <div class="text-center">
              <a href="../index.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
</body>
</html>