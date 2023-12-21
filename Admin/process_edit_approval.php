<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'inc/header.php';
Session::CheckSession();
$sId = Session::get('roleid');

header('Content-Type: application/json');

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($sId === '1') {
        try {
            $database = new Database();
            $link = $database->pdo;

            // Enable detailed error handling
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $student_id = $_POST['student_id'];

            // Begin transaction
            $link->beginTransaction();

            // Perform your database operations here
            $stmt = $link->prepare("UPDATE admission.student_data SET approval_status = 1, edit_request_status = 0 WHERE u_card = :student_id");
            $stmt->bindParam(':student_id', $student_id);

            if ($stmt->execute()) {
                // Commit the transaction
                $link->commit();
                $response = ['success' => true, 'message' => 'Request Approved'];
            } else {
                // Rollback the transaction
                $link->rollBack();
                $errorInfo = $stmt->errorInfo();
                $response = ['success' => false, 'message' => 'Update failed. SQL Error: ' . $errorInfo[2]];
            }

            // Output JSON response
            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle PDO connection error
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            echo json_encode($response);
        }
    } else {
        $response = ['success' => false, 'message' => 'Unauthorized access.'];
        echo json_encode($response);
    }
} else {
    // It's not an AJAX request, handle UI update or redirection
    // You can add additional logic here if needed
    header("Location: edit_requests.php");
    exit();
}
?>
