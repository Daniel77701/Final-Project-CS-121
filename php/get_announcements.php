<?php
include 'config.php';

try {
    if (!$conn) {
        throw new Exception("Database connection not established");
    }

    $query = "SELECT id, subject, announcement, date_posted FROM announcements ORDER BY date_posted DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $announcements = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $announcements[] = $row;
    }
    
    echo json_encode(['success' => true, 'announcements' => $announcements]);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn = null;
?> 