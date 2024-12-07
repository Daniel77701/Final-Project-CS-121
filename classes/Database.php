<?php
class Database {
    protected $conn;  // Changed from private to protected so child classes can access it
    
    public function __construct() {
        $host = "localhost";
        $user = "root";
        $pwd = "";
        $dbName = "db_scholarshiptracker";

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public function getConnection() {
        return $this->conn;
    }
} 