<?php
require_once "dbh.classes.php";

class DatabaseSetup extends Dbh {
    public function createFaqsTable() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS faqs (
                id INT PRIMARY KEY AUTO_INCREMENT,
                question TEXT NOT NULL,
                answer TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            $this->connect()->exec($sql);
            echo "FAQs table created successfully in db_scholarshiptracker database";
        } catch(PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
        }
    }
}

$setup = new DatabaseSetup();
$setup->createFaqsTable(); 