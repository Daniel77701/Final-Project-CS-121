<?php
header('Content-Type: application/json');
require_once 'database.php';
require_once 'schema_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if (!$db) {
            throw new Exception("Database connection failed");
        }
        
        // Update schema if needed
        if (!updateStudentsTable()) {
            throw new Exception("Schema update failed");
        }
        
        // Get and sanitize POST data
        $name = trim($_POST['name'] ?? '');
        $email = trim(strtolower($_POST['email'] ?? '')); 
        $sr_code = trim($_POST['sr_code'] ?? '');
        $mobile_number = trim($_POST['mobile_number'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validate input
        $errors = [];
        
        // Basic validations
        if (empty($name)) $errors[] = "Name is required";
        if (empty($email)) $errors[] = "Email is required";
        if (empty($sr_code)) $errors[] = "SR-Code is required";
        if (empty($mobile_number)) $errors[] = "Mobile number is required";
        if (empty($password)) $errors[] = "Password is required";
        
        // Format validations
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        if (!empty($sr_code) && !preg_match('/^\d{2}-\d{5}$/', $sr_code)) {
            $errors[] = "SR-Code must be in format XX-XXXXX (e.g., 23-29031)";
        }
        
        if (!empty($mobile_number) && !preg_match('/^[0-9]{11}$/', $mobile_number)) {
            $errors[] = "Mobile number must be 11 digits";
        }
        
        if (!empty($password)) {
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match";
            }
        }
        
        if (!empty($errors)) {
            throw new Exception(implode("\n", $errors));
        }
        
        // Check for existing email
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if ($result['count'] > 0) {
            throw new Exception("Email already registered");
        }
        
        // Check for existing SR-code
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM students WHERE sr_code = ?");
        $stmt->execute([$sr_code]);
        $result = $stmt->fetch();
        if ($result['count'] > 0) {
            throw new Exception("SR-Code already registered");
        }
        
        // Insert student
        $stmt = $db->prepare("
            INSERT INTO students (name, email, sr_code, mobile_number, password) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        if (!$stmt->execute([$name, $email, $sr_code, $mobile_number, $password])) {
            throw new Exception("Failed to register user");
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful! You can now login.'
        ]);
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error occurred. Please try again later.'
        ]);
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
} 