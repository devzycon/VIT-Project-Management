<!-- student_details_page.php -->

<?php
// Include your database connection file
include("config.php");

// Your SQL query
$sql = "
    SELECT u.faculty_id, u.username, st.REG_NO, st.STUDENT_NAME
    FROM users u
    JOIN faculty_table fd ON u.faculty_id = fd.faculty_id
    JOIN student_table st ON fd.PANELNO = st.PANEL_NO
    WHERE u.faculty_id IS NOT NULL AND fd.faculty_id IS NOT NULL AND st.PANEL_NO IS NOT NULL;
";

// Execute the query
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if ($result === false) {
    echo "Error in query: " . mysqli_error($connection);
} else {
    // Display the student details in a table
    echo "<table border='1'>";
    echo "<tr><th>Faculty ID</th><th>Username</th><th>Register Number</th><th>Student Name</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['faculty_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['REG_NO'] . "</td>";
        echo "<td>" . $row['STUDENT_NAME'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Close the database connection
mysqli_close($connection);
?>
