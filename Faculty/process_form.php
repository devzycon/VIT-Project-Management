<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include database configuration
include('config.php');

// Initialize variables
$added = false;
$faculty_id = $_SESSION['faculty_id'];

// Verify the form token and process form submission
if (isset($_POST['token']) && $_POST['token'] === $_SESSION['form_token']) {
    // Retrieve form data
    $u_card = $_POST['card_no'];
    $u_f_name = $_POST['user_first_name'];
    $u_l_name = $_POST['user_last_name'];
    $u_email = $_POST['user_email'];
    $u_phone = $_POST['user_phone'];
    $u_project_type = $_POST['project_type'];
    $project_name = $_POST['projectName'];  
   

    // Insert data into the database
    $insert_data = "INSERT INTO student_data(faculty_id, u_card, u_f_name, u_l_name, u_email, u_phone, u_project_type,project_name) VALUES ('$faculty_id','$u_card','$u_f_name','$u_l_name','$u_email','$u_phone','$u_project_type','$project_name')";

    $run_data = mysqli_query($con, $insert_data);

    $response = array('status' => 'success', 'message' => 'Form submitted successfully');

    if ($run_data) {
        $added = true;
        $_SESSION['form_submissions'] = 0;
    } else {
        echo "Error: " . $insert_data . "<br>" . mysqli_error($con);
    }
    
    
    if ($added) {
        $response = array('status' => 'success', 'message' => 'Form submitted successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Error submitting form');
    }
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // Output JSON response only for AJAX requests
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Redirect for non-AJAX requests
        header("Location: index.php");
        exit();
    }
}
?>
