<?php

class Database {
    protected $host = "localhost";
    protected $db_name = "db_scholarshiptracker";
    protected $username = "root";
    protected $password = "";
    private static $instance = null;
    private $conn = null;

    // Private constructor for singleton pattern
    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if ($this->conn->connect_error) {
                error_log("Database Connection Error: " . $this->conn->connect_error);
                throw new Exception("Connection failed. Please try again later.");
            }
            
            // Set charset to UTF-8
            $this->conn->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Connection failed. Please try again later.");
        }
    }

    // Singleton pattern implementation
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialize
    private function __wakeup() {}

    // Clean up connection when object is destroyed
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?> 