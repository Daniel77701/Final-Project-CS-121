<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require 'database.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];

    $db = new Database();
    $conn = $db->getConnection();
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Email not found");
    }
    
    // Generate reset token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Store reset token in database
    $stmt = $conn->prepare("UPDATE students SET reset_token = ?, reset_expires = ? WHERE email = ?");
    $stmt->bind_param("sss", $token, $expires, $email);
    $stmt->execute();
    
    // Send reset email
    $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;
    $to = $email;
    $subject = "Password Reset Request";
    $message = "Click the following link to reset your password: " . $resetLink;
    $headers = "From: noreply@yourwebsite.com";
    
    mail($to, $subject, $message, $headers);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Reset link sent successfully'
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} 