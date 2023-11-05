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




// Initialize the form_submissions session variable if not already set
if (!isset($_SESSION['form_submissions'])) {
    $_SESSION['form_submissions'] = 0;
}

// Verify the form token and process form submission
if (isset($_POST['token']) && $_POST['token'] === $_SESSION['form_token']) {
    

	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_project_type = $_POST['project_type'];
	//$u_staff_id = $_POST['staff_id'];

	$msg = "";

	  $insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name,u_email, u_phone, u_project_type) VALUES ('$u_card','$u_f_name','$u_l_name','$u_email','$u_phone','$u_project_type')";
  	$run_data = mysqli_query($con,$insert_data);
    if ($run_data) {
        $added = true;
        $_SESSION['form_submissions'] = 0;
        
    } else {
        echo "Error: " . $insert_data . "<br>" . mysqli_error($con);
    }

  	if($run_data){
		  $added = true;
  	}else{

  		echo "Data not insert";
  	}
	}


        // Check if form submissions limit is reached


        // Process the form data here

        // Redirect the user after processing the form
        header("Location: index.php");
        exit();
?>