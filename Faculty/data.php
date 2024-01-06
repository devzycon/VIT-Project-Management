<!-- display_students.php -->

<?php
// Include your database connection file
include ("config.php");


// Your SQL query
$sql = "
    SELECT u.faculty_id, u.username, st.REG_NO, st.STUDENT_NAME
    FROM users u
    JOIN faculty_data fd ON u.faculty_id = fd.faculty_id
    JOIN student_table st ON fd.PANELNO = st.PANEL_NO
    WHERE u.faculty_id IS NOT NULL AND fd.faculty_id IS NOT NULL AND st.PANEL_NO IS NOT NULL;
";

// Execute the query
$result = mysqli_query($con, $sql);

// Check if the query was successful
if ($result) {
    // Display the student details
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Faculty ID: " . $row['faculty_id'] . "<br>";
        echo "Username: " . $row['username'] . "<br>";
        echo "Register Number: " . $row['REG_NO'] . "<br>";
        echo "Student Name: " . $row['STUDENT_NAME'] . "<br>";
        echo "<br>";
    }
} else {
    echo "Error in query: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
