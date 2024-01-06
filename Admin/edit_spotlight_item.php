<?php
include 'inc/header.php';
Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
    echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
    echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);

$host = "localhost";
$dbname = "db_admin";
$username = "root";
$password = "";

try {
    // Create a new PDO connection
    $your_pdo_connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $your_pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error
    error_log("PDO Error: " . $e->getMessage());

    // Set appropriate HTTP status code
    http_response_code(500);

    // Echo the error message
    echo 'Error during PDO operation.';
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editTitle']) && isset($_POST['editDescription']) && isset($_POST['itemId'])) {
    // Handle form data from the form
    $itemId = $_POST['itemId'];
    $editTitle = $_POST['editTitle'];
    $editDescription = $_POST['editDescription'];

    try {
        $stmt = $your_pdo_connection->prepare("UPDATE spotlight SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$editTitle, $editDescription, $itemId]);

        // Redirect to spotlight_content.php after successful update
        header('Location: spotlight_content.php');
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log("Exception: " . $e->getMessage());

        // Set appropriate HTTP status code
        http_response_code(500);

        // Echo the error message
        echo 'Exception during processing: ' . $e->getMessage();
        exit;
    }
}
?>
