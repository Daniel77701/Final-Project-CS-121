<?php
session_start();
require_once 'connection/dbh.classes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new Dbh();
        $conn = $db->connect();

        // Get form data and sanitize
        $message = trim($_POST['message'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $scholarship = trim($_POST['scholarship'] ?? '1');

        // Validate required fields
        if (empty($message)) {
            throw new Exception("Message is required");
        }
        if (empty($email)) {
            throw new Exception("Email is required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Debug log
        error_log("Attempting to insert feedback with data: " . print_r($_POST, true));

        // Insert into feedbacks table with only required fields
        $feedbackQuery = "INSERT INTO feedbacks (message, email, created_at) 
                         VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($feedbackQuery);
        
        if (!$stmt->execute([$message, $email])) {
            throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
        }

        // Create notification for admin
        $notificationQuery = "INSERT INTO admin_notifications 
                            (title, message, type, link, timestamp, is_read) 
                            VALUES (?, ?, 'feedback', 'feedback.php', NOW(), 0)";
        $notificationTitle = "New Feedback Received";
        $notificationMessage = "New feedback from $email: " . substr($message, 0, 100) . 
                             (strlen($message) > 100 ? '...' : '');
        
        $stmt = $conn->prepare($notificationQuery);
        if (!$stmt->execute([$notificationTitle, $notificationMessage])) {
            // Log notification error but don't throw exception
            error_log("Failed to create notification: " . implode(" ", $stmt->errorInfo()));
        }

        // Send success response
        echo json_encode([
            'success' => true,
            'message' => 'Feedback submitted successfully!'
        ]);

    } catch (Exception $e) {
        // Log the detailed error
        error_log("Feedback Error: " . $e->getMessage());
        
        // Send error response with actual error message (you may want to remove this in production)
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?> 