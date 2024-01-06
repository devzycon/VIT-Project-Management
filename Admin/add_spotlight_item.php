<?php
include 'inc/header.php';
Session::CheckSession();

$host = "localhost";
$dbname = "db_admin";
$username = "root";
$password = "";

try {
    $your_pdo_connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $your_pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connection succesfull";
} catch (PDOException $e) {
    // Log the error
    error_log("PDO Error: " . $e->getMessage());

    // Set appropriate HTTP status code
    http_response_code(500);

    // Echo the error message
    echo json_encode(['success' => false, 'message' => 'Error during PDO operation.']);
    exit;
}

$spotlight = new Spotlight($your_pdo_connection);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    echo "data received";
    try {
        $insertedId = $spotlight->insertSpotlightItem($title, $description);
        echo json_encode(['success' => true, 'message' => 'Item added successfully']);
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log("Exception: " . $e->getMessage());

        // Set appropriate HTTP status code
        http_response_code(500);

        // Echo the error message
        echo json_encode(['success' => false, 'message' => 'Exception during processing.']);
        exit;
    }
} else {
    // If the form data is not present, return an error response
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}
?>
