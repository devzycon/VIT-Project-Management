<?php
include('config.php');
$REG_NO = $_GET['REG_NO'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database connection already established ($connection)
     // Include your database connection file

    // Get the REG_NO and attendance_select values from the form
    $us_attendance = $_POST['us_attendance'];
    

    // Update the attendance in the student_table
    $update_query = "UPDATE student_table_2 SET s_attendance = '$us_attendance' WHERE REG_NO = '$REG_NO'";


$result = mysqli_query($connection, $update_query);
if ($result) {
    header('location: review2.php');
} else {
    echo "Error updating marks: " . mysqli_error($connection);
}

    // Close the database connection
    mysqli_close($connection);
} else {
    echo "Invalid request";
}
?>
