<?php
session_start();
require_once '../config/db_connect.php';

try {
    // Get user data from localStorage via AJAX
    $postData = file_get_contents('php://input');
    $userData = json_decode($postData, true);
    
    if (!$userData || empty($userData['name'])) {
        throw new Exception("User data not found");
    }

    $userName = $userData['name'];

    // Simplified query to only get status from scholarship_request table
    $query = "SELECT status, name FROM scholarship_request WHERE name = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $userName);
    
    if (!$stmt->execute()) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = strtolower($row['status']);
        
        switch($status) {
            case 'approved':
                $message = "Congratulations! Your scholarship has been approved!";
                break;
            case 'disapproved':
            case 'not approved':
                $message = "Your scholarship application was not approved.";
                break;
            case 'pending':
                $message = "Your scholarship application is pending review.";
                break;
            default:
                $message = "Current status: " . htmlspecialchars($status);
        }
    } else {
        $message = "No scholarship application found for: " . htmlspecialchars($userName);
    }

} catch (Exception $e) {
    error_log("Scholarship status error: " . $e->getMessage());
    $message = "Error checking scholarship status: " . $e->getMessage();
}

echo $message;
?> 