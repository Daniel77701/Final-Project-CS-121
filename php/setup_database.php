<?php
require_once 'database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Create students table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        sr_code varchar(20) NOT NULL,
        mobile_number varchar(15) NOT NULL,
        password varchar(255) NOT NULL,
        UNIQUE KEY unique_email (email),
        UNIQUE KEY unique_sr_code (sr_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    echo "Students table created successfully\n";
    
} catch(PDOException $e) {
    error_log("Setup failed: " . $e->getMessage());
    die("Setup failed. Check error log for details.");
} 