
<?php
$host = "localhost";
$user = "sqladmin";
// password for remote sql
$password = "y6Z5ZKb(b3)9TgWB"; 
$database = "admission";

$connection = mysqli_connect($host, $user, $password, $database);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
