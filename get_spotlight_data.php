<?php

include 'Admin/classes/spotlight.php';

$host = "localhost";
$dbname = "db_admin";
$username = "root";
$password = "";

try {
    $your_pdo_connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $your_pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    http_response_code(500);
    echo 'Error during PDO operation.';
    exit;
}

$spotlight = new Spotlight($your_pdo_connection);
$spotlightData = $spotlight->selectAllSpotlightData();

// Return the spotlight data as JSON
header('Content-Type: application/json');
echo json_encode($spotlightData);
