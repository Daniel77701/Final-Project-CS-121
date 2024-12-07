<?php
session_start();
require_once '../connection/dbh.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $db = new Dbh();
        $conn = $db->connect();
        
        // Delete the feedback
        $query = "DELETE FROM feedbacks WHERE id = ?";
        $stmt = $conn->prepare($query);
        $success = $stmt->execute([$_POST['id']]);
        
        if ($success) {
            header("Location: ../Admin/feedback.php?delete=success");
        } else {
            header("Location: ../Admin/feedback.php?delete=error");
        }
    } catch (Exception $e) {
        error_log("Error deleting feedback: " . $e->getMessage());
        header("Location: ../Admin/feedback.php?delete=error");
    }
    exit();
} else {
    header("Location: ../Admin/feedback.php");
    exit();
} 