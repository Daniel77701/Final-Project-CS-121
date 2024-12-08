<?php
session_start();
require_once 'dbh.classes.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$alertId = $data['alert_id'] ?? null;

if (!$alertId) {
    echo json_encode(['success' => false, 'message' => 'Alert ID is required']);
    exit;
}

// Update alert status
$sql = "UPDATE student_alerts SET is_read = 1 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $alertId, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update alert']);
}

$stmt->close();
$conn->close(); 