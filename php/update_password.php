<?php
session_start();
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['username']) && isset($data['newPassword'])) {
            $username = $data['username'];
            $plainPassword = $data['newPassword']; // Store the password as plain text
            
            // Update the password for the specific student
            $sql = "UPDATE students SET password = ? WHERE name = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$plainPassword, $username])) {
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Student not found']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update password']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required data']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn = null;
?> 