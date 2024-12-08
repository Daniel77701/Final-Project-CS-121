<?php
require_once 'config.php';

if (isset($_POST['feedback_id'])) {
    $conn = new mysqli("localhost", "root", "", "db_scholarshiptracker");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $notification_id = $conn->real_escape_string($_POST['feedback_id']);
    
    // Update notification status
    $query = "UPDATE admin_notifications SET is_read = 1 WHERE id = '$notification_id'";
    $conn->query($query);
    $conn->close();
    
    echo json_encode(['success' => true]);
}
?> 