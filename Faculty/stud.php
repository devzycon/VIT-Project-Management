<?php
// Include your database connection file
include("config.php");

// Check if faculty ID is stored in the session
session_start();
if (!isset($_SESSION["faculty_id"])) {
    echo "Faculty ID not found in the session. Please log in.";
    exit;
}

// Get faculty ID from the session
$faculty_id = $_SESSION["faculty_id"];

// Your SQL query with placeholders to prevent SQL injection
$sql = "
    SELECT u.faculty_id, u.username, st.REG_NO, st.STUDENT_NAME
    FROM users u
    JOIN faculty_table fd ON u.faculty_id = fd.faculty_id
    JOIN student_table st ON fd.PANELNO = st.PANEL_NO
    WHERE u.faculty_id = ? AND fd.faculty_id = ? AND st.PANEL_NO IS NOT NULL;
";

// Prepare the query
$stmt = mysqli_prepare($connection, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "is", $faculty_id, $faculty_id);

// Execute the query
$result = mysqli_stmt_execute($stmt);

// Check if the query was successful
if ($result === false) {
    echo "Error in query: " . mysqli_error($connection);
} else {
    // Display the student details in a table
    echo "<table border='1'>";
    echo "<tr><th>Faculty ID</th><th>Username</th><th>Register Number</th><th>Student Name</th></tr>";

    // Fetch the result
    mysqli_stmt_bind_result($stmt, $faculty_id, $username, $reg_no, $student_name);

    while (mysqli_stmt_fetch($stmt)) {
        echo "<tr>";
        echo "<td>" . $faculty_id . "</td>";
        echo "<td>" . $username . "</td>";
        echo "<td>" . $reg_no . "</td>";
        echo "<td>" . $student_name . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connection);
?>
