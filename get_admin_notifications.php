<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    $conn = new mysqli("localhost", "root", "", "db_scholarshiptracker");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get unread notifications
    $query = "SELECT * FROM admin_notifications 
              WHERE is_read = 0 
              ORDER BY timestamp DESC";
              
    $result = $conn->query($query);
    $notifications = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'message' => $row['message'],
                'timestamp' => $row['timestamp']
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'notifications' => $notifications
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn->close();
?> 