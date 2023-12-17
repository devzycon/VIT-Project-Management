<?php

include('config.php');

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    // Initialize variables to store the counts
    $total_present = 0;
    $total_absent = 0;

    // Get the attendance data for each day
    $attendance = $_POST['attendance'];

    // Calculate the total present and absent
    foreach ($attendance as $day => $status) {
        if ($status == 'Present') {
            $total_present++;
        } elseif ($status == 'Absent') {
            $total_absent++;
        }
    }

    // Calculate attendance percentage
    $total_days = count($attendance);
    $attend = ($total_present / $total_days) * 100;
    $attendance_percentage = number_format($attend, 2) . "%";

    $update = "UPDATE student_data SET attendance = '$attendance_percentage' WHERE id=$id";
	$run_update = mysqli_query($con,$update);

	if ($run_update) {
		header('location:index.php');
	} else {
		echo "Data not updated. Error: " . mysqli_error($con);
	}
}
?>
