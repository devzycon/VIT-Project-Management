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

// Retrieve form data
$student_id = $_POST['student_id'];
$edit_request_status = isset($_POST['edit_request']) ? $_POST['edit_request'] : '';

// Insert data into the database
$update_query = "UPDATE student_data SET edit_request_status = TRUE WHERE u_card = '$student_id'";
$run_update = mysqli_query($con, $update_query);

// Initialize response array
$response = array();

if ($run_update) {
    $response['success'] = true;
    $response['message'] = "Edit request submitted successfully!";
    // Additional logic if needed
} else {
    $response['success'] = false;
    $response['message'] = "Error updating edit request status: " . mysqli_error($con);
}

// Check if it's an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // It's an AJAX request, send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // It's not an AJAX request, handle UI update or redirection
    if ($response['success']) {
        // Update the UI or handle any other logic
        // For example, you can use JavaScript to update the UI without a page reload
    } else {
        // Redirect the user after processing the form
        // You might want to remove this or adjust it based on your needs
        header("Location: index.php");
        exit();
    }
}
?>
