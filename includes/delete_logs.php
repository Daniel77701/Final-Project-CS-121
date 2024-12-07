<?php
session_start();
require_once '../connection/dbh.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logs'])) {
    try {
        $db = new Dbh();
        $conn = $db->connect();
        
        $logs = $_POST['logs'];
        $placeholders = str_repeat('?,', count($logs) - 1) . '?';
        
        $query = "DELETE FROM user_logs WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($query);
        $stmt->execute($logs);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
} 