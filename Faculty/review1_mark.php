<?php
include('config.php'); // Include your database connection file or establish the connection here

$s_no = $_GET['s_no']; // Assuming 's_no' is the parameter in the URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the marks from the form
    $us_m1 = $_POST['us_m1'];
    $us_m2 = $_POST['us_m2'];
    $us_m3 = $_POST['us_m3'];
    $us_m4 = $_POST['us_m4'];

    // Calculate the total
    $us_tot = $us_m1 + $us_m2 + $us_m3 + $us_m4;

    // Update the database with the new marks and total
    $update_query = "UPDATE review1 SET s_m1 = '$us_m1', s_m2 = '$us_m2', s_m3 = '$us_m3', s_m4 = '$us_m4', s_tot = '$us_tot' WHERE s_no = '$s_no'";

    if (mysqli_query($con, $update_query)) {
        header('location:review1.php');
    } else {
        echo "Error updating marks: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    echo "Invalid request";
}
?>
