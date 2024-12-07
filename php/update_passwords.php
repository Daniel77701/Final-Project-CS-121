<?php
require_once 'database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Get all users with plaintext passwords
    $stmt = $db->prepare("SELECT id, password FROM students");
    $stmt->execute();
    
    while ($student = $stmt->fetch()) {
        // Check if password is not already hashed
        if (strlen($student['password']) < 60) { // Hashed passwords are 60+ characters
            $hashed = password_hash($student['password'], PASSWORD_DEFAULT);
            
            // Update the password
            $update = $db->prepare("UPDATE students SET password = ? WHERE id = ?");
            $update->execute([$hashed, $student['id']]);
            
            echo "Updated password for student ID: " . $student['id'] . "\n";
        }
    }
    
    echo "Password update complete\n";
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "Database error occurred. Please check the error log.\n";
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "An error occurred. Please check the error log.\n";
} 