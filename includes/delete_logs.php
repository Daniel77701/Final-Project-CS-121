<?php
require_once '../connection/dbh.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logs'])) {
    $db = new Dbh();
    $conn = $db->connect();
    
    $logs = $_POST['logs'];
    $placeholders = str_repeat('?,', count($logs) - 1) . '?';
    
    $query = "DELETE FROM user_logs WHERE id IN ($placeholders)";
    
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute($logs);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        error_log("Error deleting logs: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}