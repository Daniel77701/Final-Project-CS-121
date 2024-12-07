<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if (!$db) {
            throw new Exception("Database connection failed");
        }
        
        // Get and sanitize POST data
        $name = trim($_POST['name'] ?? '');
        $email = trim(strtolower($_POST['email'] ?? '')); 
        $password = $_POST['pwd'] ?? '';

        // Check credentials
        $stmt = $db->prepare("SELECT * FROM students WHERE (email = ? OR sr_code = ?) AND name = ?");
        $stmt->execute([$email, $email, $name]);
        $student = $stmt->fetch();
        
        if ($student && $password === $student['password']) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'sr_code' => $student['sr_code']
                ]
            ]);
        } else {
            throw new Exception("Invalid credentials");
        }
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ]);
        exit;
    }
} 