<?php
require_once 'database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Create students table matching your structure
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL UNIQUE,
        sr_code varchar(100) NOT NULL UNIQUE,
        mobile_number varchar(15) NOT NULL,
        password varchar(255) NOT NULL,
        PRIMARY KEY (id)
    )";
    
    $db->exec($sql);
    echo "Students table created successfully\n";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
} 