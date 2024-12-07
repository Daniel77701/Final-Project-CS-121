<?php
require_once 'config.php';

if (isset($_GET['notification_id'])) {
    $conn = new mysqli("localhost", "root", "", "db_scholarshiptracker");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $conn->real_escape_string($_GET['notification_id']);
    $query = "SELECT * FROM admin_notifications WHERE id = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Notification not found']);
    }

    $conn->close();
}
?> 