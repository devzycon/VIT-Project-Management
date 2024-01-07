<?php
include('config.php');

$id = $_GET['id'];

if (isset($_POST['submit'])) {

    $start_date = strtotime('2023-12-19');
    $current_date = time();
    $days_difference = floor(($current_date - $start_date) / (60 * 60 * 24));
    if ($days_difference == 0) {
        $days_difference = 1;
    }
    $week_count = ceil($days_difference / 6);
    $total_days = $week_count * 7;
    $initial_attendance = $total_days - 7;


    // Get the current value of no_of_present from the database
    $get_no_of_present_query = "SELECT no_of_present, attendance, no_of_absent FROM student_data WHERE id=$id";
    $result = mysqli_query($con, $get_no_of_present_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $no_of_present = $row['no_of_present'];
        $no_of_absent = $row['no_of_absent'];
        $attendance_percentage = $row['attendance'];
    } else {
        // Handle the error if the query fails
        $response = array('success' => false, 'message' => 'Error fetching current value of no_of_present: ' . mysqli_error($con));
        echo json_encode($response);
        exit;
    }

    // Convert attendance percentage to decimal
    $decimal_attendance = floatval($attendance_percentage) / 100;
    $initial_days = $no_of_present + $no_of_absent;

    // Check the condition for initial attendance calculation
    if ($initial_attendance != $initial_days) {
        // Calculate initial_percentage
        $initial_percentage = $initial_attendance * $decimal_attendance;

        // Calculate absent with initial percentage - 7
        $absent = $initial_attendance - $initial_percentage ;

        // Update no_of_present with initial_attendance
        $update_no_of_present_query = "UPDATE student_data SET no_of_present = $initial_percentage,no_of_absent = '$absent' WHERE id=$id";
        $run_update_no_of_present = mysqli_query($con, $update_no_of_present_query);

        if (!$run_update_no_of_present) {
            $response = array('success' => false, 'message' => 'Error updating no_of_present: ' . mysqli_error($con));
            echo json_encode($response);
            exit;
        }

        // Set no_of_present to initial_attendance
        $no_of_present = $initial_percentage;
    }

    // Get the attendance data for each day
    $attendance = $_POST['attendance'];

    // Calculate the total present and absent
    foreach ($attendance as $day => $status) {
        if ($status == 'Present') {
            $no_of_present++; // Increment $no_of_present for each 'Present' status
        }
    }

    // Calculate attendance percentage
    $attend = ($no_of_present / $total_days) * 100;
    $attendance_percentage = number_format($attend, 2) . "%";

    // Update both attendance and no_of_present in a single query
    $update = "UPDATE student_data SET attendance = '$attendance_percentage' WHERE id=$id";
    $run_update = mysqli_query($con, $update);

    if ($run_update) {
        $response = array('success' => true, 'newAttendance' => $attendance_percentage,'weekCount' => $week_count);
    } else {
        $response = array('success' => false, 'message' => 'Data not updated. Error: ' . mysqli_error($con));
    }

    echo json_encode($response);
    exit;
} else {
    echo json_encode(array('success' => false, 'message' => 'No submit data received'));
    exit;
}
?>
