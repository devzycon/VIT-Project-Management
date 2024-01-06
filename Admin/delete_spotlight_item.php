<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemId'])) {
    $host = "localhost";
    $dbname = "db_admin";
    $username = "root";
    $password = "";

    try {
        $your_pdo_connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $your_pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitize and validate the input
        $itemId = filter_var($_POST['itemId'], FILTER_VALIDATE_INT);

        if ($itemId !== false) {
            // Prepare and execute the SQL statement to delete the item
            $stmt = $your_pdo_connection->prepare("DELETE FROM spotlight WHERE id = :itemId");
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->execute();

            // Check if the deletion was successful
            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Item not found or could not be deleted.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid item ID.']);
        }
    } catch (PDOException $e) {
        // Log the error
        error_log("PDO Error: " . $e->getMessage());

        // Set appropriate HTTP status code
        http_response_code(500);

        // Echo the error message
        echo json_encode(['status' => 'error', 'message' => 'Error during PDO operation.']);
    }
} else {
    // Handle invalid request method
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

?>
