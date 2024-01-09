
<?php
$host = "localhost";
$user = "root";
// password for remote sql
$password = ""; 
$database = "admission";

$connection = mysqli_connect($host, $user, $password, $database);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
