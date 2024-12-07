<?php
session_start();
require_once 'db_connection.php';

try {
    // Simple query to get notifications
    $query = "
        SELECT 
            id,
            title,
            message,
            link,
            timestamp,
            is_read
        FROM notifications 
        ORDER BY timestamp DESC
        LIMIT 10";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'notifications' => $notifications,
        'count' => count($notifications)
    ]);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn = null;
?> 