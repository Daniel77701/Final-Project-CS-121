<?php
require_once 'database.php';

function updateStudentsTable() {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Update table structure one statement at a time
        $statements = [
            "ALTER TABLE students MODIFY COLUMN id int(11) NOT NULL AUTO_INCREMENT",
            "ALTER TABLE students MODIFY COLUMN name varchar(100) NOT NULL",
            "ALTER TABLE students MODIFY COLUMN email varchar(100) NOT NULL",
            "ALTER TABLE students MODIFY COLUMN sr_code varchar(20) NOT NULL",
            "ALTER TABLE students MODIFY COLUMN mobile_number varchar(15) NOT NULL",
            "ALTER TABLE students MODIFY COLUMN password varchar(255) NOT NULL"
        ];
        
        foreach ($statements as $sql) {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        
        // Add unique constraints if they don't exist
        try {
            $stmt = $db->prepare("ALTER TABLE students ADD UNIQUE KEY unique_email (email)");
            $stmt->execute();
        } catch (PDOException $e) {
            // Ignore if constraint already exists
        }
        
        try {
            $stmt = $db->prepare("ALTER TABLE students ADD UNIQUE KEY unique_sr_code (sr_code)");
            $stmt->execute();
        } catch (PDOException $e) {
            // Ignore if constraint already exists
        }
        
        return true;
    } catch(PDOException $e) {
        error_log("Schema update error: " . $e->getMessage());
        return false;
    }
} 