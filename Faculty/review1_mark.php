<?php
include('config.php'); // Include your database connection file or establish the connection here

$REG_NO = $_GET['REG_NO']; // Assuming 's_no' is the parameter in the URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the marks from the form
    $us_m1 = $_POST['us_m1'];
    $us_m2 = $_POST['us_m2'];
    $us_m3 = $_POST['us_m3'];
    $us_m4 = $_POST['us_m4'];

    // Calculate the total
    $us_tot = $us_m1 + $us_m2 + $us_m3 + $us_m4;

    // Update the database with the new marks and total
    $update_query = "UPDATE student_table SET s_m1 = '$us_m1', s_m2 = '$us_m2', s_m3 = '$us_m3', s_m4 = '$us_m4', s_tot = '$us_tot' WHERE REG_NO = '$REG_NO'";

    if (mysqli_query($connection, $update_query)) {
        header('location:review1.php');
    } else {
        echo "Error updating marks: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    echo "Invalid request";
}
?>